<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consultant;
use App\Models\Criteria;
use App\Services\PrometheeService;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdminSpkController extends Controller
{
    /**
     * Menampilkan daftar proyek yang membutuhkan plotting konsultan.
     */
    public function index()
    {
        // Mengambil proyek yang statusnya siap diplotting (PAYMENT_T1_VERIFIED)
        $projects = Project::with(['klien.companyProfile'])
            ->where('status_proyek', ProjectStatus::PAYMENT_T1_VERIFIED)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.spk.index', compact('projects'));
    }

    /**
     * Menampilkan halaman proses komputasi PROMETHEE II untuk proyek tertentu.
     */
    public function tampilkanRekomendasi($id, PrometheeService $prometheeService)
    {
        $project = Project::with(['klien.companyProfile'])->findOrFail($id);
        $criterias = Criteria::orderBy('kode', 'asc')->get();
        $consultants = Consultant::where('is_active', true)->get();

        $ranking = [];
        $errorMessage = null;

        // SSR Computation: Jalankan kalkulasi SPK saat halaman pertama kali dimuat
        try {
            $ranking = $prometheeService->hitungRekomendasi($project);
        } catch (InvalidArgumentException $e) {
            $errorMessage = $e->getMessage();
        } catch (\Exception $e) {
            $errorMessage = 'Gagal melakukan kalkulasi SPK: ' . $e->getMessage();
        }

        return view('admin.spk.recommend', compact('project', 'criterias', 'consultants', 'ranking', 'errorMessage'));
    }

    /**
     * Endpoint AJAX untuk mengeksekusi perhitungan PROMETHEE II secara dinamis.
     */
    public function hitungSpkAjax($id, PrometheeService $prometheeService)
    {
        try {
            $project = Project::with(['klien.companyProfile'])->findOrFail($id);

            // Eksekusi kalkulasi PROMETHEE II
            $ranking = $prometheeService->hitungRekomendasi($project);

            return response()->json([
                'success' => true,
                'data'    => $ranking
            ], 200);

        } catch (InvalidArgumentException $e) {
            // Error Validasi Data Input (Contoh: Koordinat GPS belum terisi)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);

        } catch (\Exception $e) {
            // General Server Error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menghitung SPK: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menyimpan konsultan yang ditunjuk oleh Admin ke dalam proyek.
     */
    public function tunjukKonsultan(Request $request, $id)
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id'
        ], [
            'consultant_id.required' => 'Pilih salah satu konsultan terlebih dahulu.',
            'consultant_id.exists'   => 'Konsultan yang dipilih tidak terdaftar.',
        ]);

        $project = Project::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update konsultan_id dan ubah status_proyek menjadi CONSULTANT_ASSIGNED
            $project->update([
                'konsultan_id'  => $request->consultant_id,
                'status_proyek' => ProjectStatus::CONSULTANT_ASSIGNED,
            ]);

            DB::commit();
            return redirect()->route('admin.spk.index')
                ->with('success', 'Konsultan berhasil ditunjuk dan diplotting untuk proyek ' . $project->nama_merek_dagang);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memplotting konsultan: ' . $e->getMessage());
        }
    }
}
