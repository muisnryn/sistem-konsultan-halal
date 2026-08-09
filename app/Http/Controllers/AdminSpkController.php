<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consultant;
use App\Models\Criteria;
use App\Services\PrometheeService;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function tampilkanRekomendasi($id)
    {
        $project = Project::with(['klien.companyProfile'])->findOrFail($id);
        $criterias = Criteria::orderBy('kode', 'asc')->get();
        $consultants = Consultant::where('is_active', 1)->get();

        return view('admin.spk.recommend', compact('project', 'criterias', 'consultants'));
    }

    /**
     * Endpoint AJAX untuk mengeksekusi perhitungan PROMETHEE II.
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung SPK: ' . $e->getMessage()
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
                ->with('success', 'Konsultan berhasil diplotting untuk proyek ' . $project->nama_merek_dagang);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memplotting konsultan: ' . $e->getMessage());
        }
    }
}
