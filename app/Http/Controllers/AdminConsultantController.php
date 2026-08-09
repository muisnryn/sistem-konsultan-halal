<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\Criteria;
use App\Models\ConsultantEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminConsultantController extends Controller
{
    /**
     * Menampilkan daftar profil konsultan pendamping
     */
    public function index()
    {
        $consultants = Consultant::with('evaluations')->latest()->get();
        return view('admin.consultant.index', compact('consultants'));
    }

    /**
     * Menyimpan data konsultan baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_konsultan'        => 'required|string|max:255',
            'sertifikasi_no'        => 'required|string|unique:consultants,sertifikasi_no',
            'domisili'              => 'required|string|max:255',
            'spesialisasi_industri' => 'required|string|max:255',
            'latitude'              => 'required|numeric|between:-90,90',
            'longitude'             => 'required|numeric|between:-180,180',
            'is_active'             => 'nullable|boolean',
        ]);

        // Default status aktif jika tidak dikirim dari form
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        DB::beginTransaction();
        try {
            // Amankan dari Mass Assignment Vulnerability
            $consultant = Consultant::create($validated);

            // Auto-inisialisasi record kriteria statis awal (C2, C3, C5, C6)
            $statisCriterias = Criteria::whereNotIn('kode', ['C1', 'C4'])->get();
            foreach ($statisCriterias as $crit) {
                ConsultantEvaluation::create([
                    'consultant_id' => $consultant->id,
                    'criteria_id'   => $crit->id,
                    'nilai'         => 0.0,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.consultant.index')
                ->with('success', 'Profil konsultan baru berhasil ditambahkan beserta inisialisasi kriteria!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan konsultan: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data profil konsultan
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_konsultan'        => 'required|string|max:255',
            'sertifikasi_no'        => 'required|string|unique:consultants,sertifikasi_no,' . $id,
            'domisili'              => 'required|string|max:255',
            'spesialisasi_industri' => 'required|string|max:255',
            'latitude'              => 'required|numeric|between:-90,90',
            'longitude'             => 'required|numeric|between:-180,180',
            'is_active'             => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $consultant = Consultant::findOrFail($id);
            $consultant->update($validated);

            DB::commit();
            return redirect()->route('admin.consultant.index')
                ->with('success', 'Update profil konsultan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil konsultan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit nilai kriteria statis (C2, C3, C5, C6)
     */
    public function editEvaluations($id)
    {
        $consultant = Consultant::with('evaluations')->findOrFail($id);

        // Hanya tampilkan kriteria yang nilainya diinput manual (Bukan C1 dan C4 yang dinamis)
        $criterias = Criteria::whereNotIn('kode', ['C1', 'C4'])->orderBy('kode', 'asc')->get();

        return view('admin.consultant.evaluations', compact('consultant', 'criterias'));
    }

    /**
     * Menyimpan matriks nilai kriteria evaluasi konsultan
     */
    public function updateEvaluations(Request $request, $id)
    {
        $consultant = Consultant::findOrFail($id);
        $criterias = Criteria::whereNotIn('kode', ['C1', 'C4'])->get();

        $rules = [];
        foreach ($criterias as $crit) {
            $rules['nilai_' . $crit->id] = 'required|numeric|min:0';
        }
        $request->validate($rules);

        DB::beginTransaction();
        try {
            foreach ($criterias as $crit) {
                ConsultantEvaluation::updateOrCreate(
                    [
                        'consultant_id' => $consultant->id,
                        'criteria_id'   => $crit->id,
                    ],
                    [
                        'nilai' => $request->input('nilai_' . $crit->id)
                    ]
                );
            }

            DB::commit();
            return redirect()->route('admin.consultant.index')
                ->with('success', 'Matriks nilai kriteria untuk ' . $consultant->nama_konsultan . ' berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui matriks nilai: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data konsultan beserta nilai evaluasinya
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $consultant = Consultant::findOrFail($id);
            $consultant->delete(); // Cascading di database akan otomatis menghapus evaluasinya

            DB::commit();
            return redirect()->route('admin.consultant.index')
                ->with('success', 'Data master konsultan telah dihapus dari sistem.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus konsultan: ' . $e->getMessage());
        }
    }
}
