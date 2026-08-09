<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Menunggu Sertifikat</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">
                    Daftar pengajuan yang telah disetujui dan menunggu proses unggah dokumen Sertifikat Halal dari BPJPH.
                </p>
            </div>
            <span class="px-4 py-1.5 bg-[#e8f3ec] text-[#195A36] border border-[#195A36]/20 rounded-full text-xs font-bold uppercase tracking-wide self-start sm:self-auto flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#195A36] animate-pulse"></span>
                Total Menunggu: {{ $projects->count() }}
            </span>
        </div>

        <!-- NOTIFIKASI ALERTS -->
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border shadow-sm bg-[#e8f3ec] border-[#195A36]/20 text-[#195A36] rounded-[16px]">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ session('success') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-black text-[#195A36] hover:text-gray-900">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border shadow-sm bg-rose-50 border-rose-200 text-rose-800 rounded-[16px]">
                <span>✕ {{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="font-black text-rose-600">✕</button>
            </div>
        @endif

        <!-- MAIN CARD CONTAINER -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden">

            <!-- CARD TOP FILTER BAR -->
            <div class="flex flex-row items-center justify-between gap-4 p-6 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <span class="text-xs font-bold tracking-wide text-gray-400 uppercase">STATUS:</span>
                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full font-bold text-xs border border-amber-200/60 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Berkas Final
                    </span>
                </div>
            </div>

            <!-- TABLE DAFTAR PENGAJUAN -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left whitespace-nowrap">
                    <thead>
                        <tr class="font-medium text-gray-400 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium">ID PENGAJUAN</th>
                            <th class="px-6 py-4 font-medium">NAMA KLIEN / PERUSAHAAN</th>
                            <th class="px-6 py-4 font-medium">PAKET SERTIFIKASI</th>
                            <th class="px-6 py-4 font-medium">TGL. DISETUJUI</th>
                            <th class="px-6 py-4 font-medium text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($projects as $project)
                            @php
                                $companyName = $project->klien->companyProfile->nama_perusahaan ?? $project->klien->name;
                                $cleanBrand  = $project->nama_merek_dagang;
                                $prefix      = strtoupper(substr($companyName, 0, 2));

                                $avatarBg    = str_starts_with(strtoupper($companyName), 'PT') ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-teal-50 text-teal-700 border border-teal-100';
                                $certDoc     = $project->documents->firstWhere('jenis_dokumen', 'sertifikat_halal');
                            @endphp

                            <tr class="transition-colors hover:bg-gray-50/50 group" x-data="{ openModal: false }">

                                <!-- ID PENGAJUAN -->
                                <td class="px-6 py-4 font-mono font-bold text-[#195A36]">
                                    #{{ $project->kode_registrasi }}
                                </td>

                                <!-- NAMA KLIEN / PERUSAHAAN -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full {{ $avatarBg }} font-bold flex items-center justify-center text-xs shrink-0 shadow-sm uppercase">
                                            {{ $prefix }}
                                        </div>
                                        <div>
                                            <strong class="block font-semibold text-gray-900">{{ $companyName }}</strong>
                                            <span class="text-xs text-gray-500 mt-0.5 block">{{ $cleanBrand }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- PAKET SERTIFIKASI -->
                                <td class="px-6 py-4 font-medium text-gray-600">
                                    {{ ucfirst($project->jenis_pengajuan?->value ?? $project->jenis_pengajuan ?? 'Reguler') }}
                                </td>

                                <!-- TGL. DISETUJUI -->
                                <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                    {{ $project->updated_at->translatedFormat('d M Y') }}
                                </td>

                                <!-- AKSI -->
                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                            @click="openModal = true"
                                            class="px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold shadow-sm transition inline-flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <span>{{ $certDoc ? 'Ganti File' : 'Unggah' }}</span>
                                    </button>

                                    <!-- MODAL POPUP UPLOAD FILE SERTIFIKAT HALAL -->
                                    <div x-show="openModal"
                                         x-cloak
                                         x-transition
                                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-sm">

                                        <div @click.away="openModal = false"
                                             class="w-full max-w-md p-6 space-y-5 text-left bg-white border shadow-2xl rounded-[24px] border-gray-100">

                                            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                                                <h3 class="text-sm font-bold text-gray-900">
                                                    Unggah Sertifikat Halal
                                                </h3>
                                                <button type="button" @click="openModal = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition">✕</button>
                                            </div>

                                            <div class="space-y-1.5 text-xs bg-gray-50 p-4 rounded-[16px] border border-gray-100">
                                                <p class="text-gray-500">
                                                    Pengajuan: <strong class="text-gray-900">#{{ $project->kode_registrasi }}</strong>
                                                </p>
                                                <p class="text-gray-500">
                                                    Perusahaan: <strong class="text-gray-900">{{ $companyName }}</strong>
                                                </p>
                                            </div>

                                            <form action="{{ route('admin.certificate.upload', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                                @csrf
                                                <div>
                                                    <label class="block mb-2 text-xs font-semibold text-gray-700">
                                                        Berkas Sertifikat Halal Final (PDF)
                                                    </label>
                                                    <input type="file"
                                                           name="file_sertifikat"
                                                           accept=".pdf"
                                                           required
                                                           class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#e8f3ec] file:text-[#195A36] border border-gray-200 rounded-[16px] p-2 cursor-pointer hover:border-gray-300 transition">
                                                </div>

                                                <div class="flex items-center justify-end gap-3 pt-2">
                                                    <button type="button"
                                                            @click="openModal = false"
                                                            class="px-5 py-2.5 text-xs font-semibold transition bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-full">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                            class="px-5 py-2.5 text-xs font-semibold text-white transition shadow-sm bg-[#195A36] hover:bg-[#124227] rounded-full">
                                                        Unggah Sertifikat
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 mb-3 text-gray-400 rounded-full bg-gray-50">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">Tidak Ada Antrean</p>
                                        <p class="max-w-sm mt-1 text-xs text-gray-500">Tidak ada pengajuan yang sedang menunggu sertifikat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>
