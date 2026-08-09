<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCriteriaController extends Controller
{
    /**
     * Menampilkan daftar kriteria SPK beserta bobot dan tipenya
     */
    public function index()
    {
        $criterias = Criteria::orderBy('kode', 'asc')->get();

        // Hitung total akumulasi bobot
        $totalBobot = $criterias->sum('bobot');

        return view('admin.criteria.index', compact('criterias', 'totalBobot'));
    }

    /**
     * Memperbarui seluruh parameter kriteria SPK sekaligus (Massal/Batch)
     */
    public function updateConfig(Request $request)
    {
        // Validasi struktur array data kiriman formulir
        $request->validate([
            'criterias'                     => 'required|array',
            'criterias.*.id'                => 'required|exists:criterias,id',
            'criterias.*.bobot_persen'      => 'required|numeric|min:0|max:100',
            'criterias.*.tipe_preferensi'   => 'required|in:usual,u_shape,v_shape,level,linear,gaussian',
            'criterias.*.tren'              => 'nullable|in:max,min',
            'criterias.*.param_p'           => 'nullable|numeric|min:0',
            'criterias.*.param_q'           => 'nullable|numeric|min:0',
            'criterias.*.param_s'           => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalBobotDesimal = 0;

            foreach ($request->criterias as $item) {
                $criteria = Criteria::findOrFail($item['id']);

                // Konversi bobot dari persen (UI) ke desimal (Database) -> Contoh: 20% menjadi 0.2
                $bobotDesimal = $item['bobot_persen'] / 100;
                $totalBobotDesimal += $bobotDesimal;

                // Tentukan nilai parameter: Gunakan input kustom jika ada, atau gunakan default tipe
                $tipe = $item['tipe_preferensi'];
                $paramP = isset($item['param_p']) && $item['param_p'] !== '' ? (float) $item['param_p'] : $this->getDefaultParameter($tipe, 'p');
                $paramQ = isset($item['param_q']) && $item['param_q'] !== '' ? (float) $item['param_q'] : $this->getDefaultParameter($tipe, 'q');
                $paramS = isset($item['param_s']) && $item['param_s'] !== '' ? (float) $item['param_s'] : $this->getDefaultParameter($tipe, 's');

                $criteria->update([
                    'bobot'           => $bobotDesimal,
                    'tipe_preferensi' => $tipe,
                    'tren'            => $item['tren'] ?? $criteria->tren,
                    'param_p'         => $paramP,
                    'param_q'         => $paramQ,
                    'param_s'         => $paramS,
                ]);
            }

            DB::commit();

            // Pengecekan Akumulasi Bobot
            $persenAkhir = round($totalBobotDesimal * 100);
            if ($persenAkhir != 100) {
                return redirect()->route('admin.criteria.index')
                    ->with('warning', "Konfigurasi disimpan. Namun, total bobot saat ini adalah {$persenAkhir}%. Disarankan agar akumulasi bobot tepat 100%.");
            }

            return redirect()->route('admin.criteria.index')
                ->with('success', 'Seluruh konfigurasi parameter kriteria SPK berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
        }
    }

    /**
     * Private Helper: Menentukan nilai parameter default jika tidak diisi manual di form
     */
    private function getDefaultParameter(string $tipe, string $param): ?float
    {
        $defaults = [
            'usual'    => ['p' => null, 'q' => null, 's' => null],
            'u_shape'  => ['p' => null, 'q' => 1.00, 's' => null],
            'v_shape'  => ['p' => 2.00, 'q' => null, 's' => null],
            'level'    => ['p' => 2.00, 'q' => 1.00, 's' => null],
            'linear'   => ['p' => 2.00, 'q' => 1.00, 's' => null],
            'gaussian' => ['p' => null, 'q' => null, 's' => 0.50],
        ];

        return $defaults[$tipe][$param] ?? null;
    }
}
