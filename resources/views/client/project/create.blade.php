<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        @if($activeProject)
            <!-- UI PROYEK AKTIF: PENGAJUAN BERHASIL DIKIRIM -->
            <div class="max-w-2xl py-6 mx-auto">
                <div class="p-8 sm:p-12 space-y-6 text-center bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">

                    <!-- Icon Status Animated -->
                    <div class="relative flex items-center justify-center w-20 h-20 mx-auto">
                        <div class="absolute inset-0 rounded-full opacity-30 bg-[#e8f3ec] animate-ping"></div>
                        <div class="flex items-center justify-center w-20 h-20 text-white rounded-full shadow-lg bg-[#195A36] shadow-[#195A36]/20">
                            <svg class="w-10 h-10 stroke-[2.2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <div>
                        <span class="inline-block px-4 py-1.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $activeProject->status_proyek->value === 'PENGAJUAN_SUBMITTED' ? 'MENUNGGU INVOICE' : str_replace('_', ' ', $activeProject->status_proyek->value) }}
                        </span>
                    </div>

                    <div class="max-w-lg mx-auto space-y-2">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            Pengajuan Berhasil Dikirim
                        </h1>
                        <p class="text-xs font-medium leading-relaxed text-gray-500 sm:text-sm">
                            Terima kasih. Pengajuan pendampingan sertifikasi Anda sedang dalam tahap verifikasi awal oleh tim admin.
                        </p>
                    </div>

                    <!-- Ringkasan Proyek Singkat -->
                    <div class="grid grid-cols-1 gap-4 p-5 text-left border border-gray-100 bg-gray-50/80 rounded-[20px] sm:grid-cols-3">
                        <div class="space-y-0.5 border-b sm:border-b-0 sm:border-r border-gray-200/60 pb-3 sm:pb-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">PAKET</span>
                            <strong class="block text-xs font-bold text-gray-900 sm:text-sm">{{ $activeProject->nama_paket }}</strong>
                        </div>
                        <div class="space-y-0.5 border-b sm:border-b-0 sm:border-r border-gray-200/60 pb-3 sm:pb-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">MEREK</span>
                            <strong class="block text-xs font-bold text-gray-900 truncate sm:text-sm">{{ $activeProject->nama_merek_dagang }}</strong>
                        </div>
                        <div class="space-y-0.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">EST. INVOICE</span>
                            <strong class="block text-xs font-mono font-bold sm:text-sm text-[#195A36]">
                                Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col items-center justify-center gap-3 pt-2 sm:flex-row">
                        <a href="{{ route('client.dashboard') }}" class="flex items-center justify-center w-full gap-2 px-6 py-3 text-xs font-bold text-white transition shadow-xs sm:w-auto bg-[#195A36] hover:bg-[#124227] rounded-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span>Kembali ke Dashboard</span>
                        </a>
                        <a href="{{ route('client.certification.status') }}" class="flex items-center justify-center w-full gap-2 px-6 py-3 text-xs font-bold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-xs sm:w-auto hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-1-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                            <span>Status Sertifikasi</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- FORM PENGAJUAN BARU -->
            <div class="flex flex-col gap-4 pb-2 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                        Layanan Pengajuan Pendampingan Sertifikasi Halal
                    </div>
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Form Pengajuan Baru</h1>
                    <p class="text-xs text-gray-500 font-medium mt-1.5">Lengkapi detail pengajuan sertifikasi untuk mendapatkan estimasi penawaran resmi.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1 text-xs font-bold tracking-wide uppercase rounded-full bg-[#e8f3ec] text-[#195A36]">
                        Paket {{ ucfirst($profile->skala_perusahaan) }}
                    </span>
                </div>
            </div>

            @if (session('success'))
                <div class="flex items-center gap-2.5 p-4 text-xs font-semibold bg-[#e8f3ec] border border-green-200/60 text-[#195A36] rounded-[20px] shadow-xs">
                    <svg class="w-4 h-4 text-[#195A36] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">
                
                <!-- KOLOM KIRI (FORM INPUT) - 8 KOLOM -->
                <div class="space-y-6 lg:col-span-8">
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Detail Pengajuan Jasa</h3>
                        </div>

                        <form action="{{ route('client.project.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Skala Perusahaan Anda</label>
                                <input type="text" id="skala_perusahaan" value="{{ $profile->skala_perusahaan }}" readonly class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-full font-bold text-[#195A36] uppercase text-xs outline-none cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Nama Merek Dagang / Produk Utama <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama_merek_dagang" value="{{ old('nama_merek_dagang') }}" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: Kripik Singkong Cap Bintang">
                                @error('nama_merek_dagang') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Jenis Pengajuan <span class="text-rose-500">*</span></label>
                                <select name="jenis_pengajuan" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer">
                                    <option value="baru" {{ old('jenis_pengajuan') == 'baru' ? 'selected' : '' }}>Pengajuan Baru</option>
                                    <option value="perpanjangan" {{ old('jenis_pengajuan') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan (Renewal)</option>
                                </select>
                                @error('jenis_pengajuan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Jumlah Menu / Item Produk <span class="text-rose-500">*</span></label>
                                    <input type="number" id="jumlah_produk" name="jumlah_produk" value="{{ old('jumlah_produk', 1) }}" min="1" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition font-mono" oninput="hitungSimulasiBiaya()">
                                    @error('jumlah_produk') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Jumlah Fasilitas Produksi / Outlet <span class="text-rose-500">*</span></label>
                                    <input type="number" id="jumlah_outlet" name="jumlah_outlet" value="{{ old('jumlah_outlet', 1) }}" min="1" required class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition font-mono" oninput="hitungSimulasiBiaya()">
                                    @error('jumlah_outlet') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="p-4 space-y-2 border border-gray-100 bg-gray-50/80 rounded-[20px]">
                                <label class="block text-xs font-bold text-gray-800">Lokasi Wilayah Kerja Operasional <span class="text-rose-500">*</span></label>
                                <div class="flex items-center pt-1 space-x-6 text-xs font-semibold text-gray-700">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="is_luar_jabodetabek" value="0" checked class="text-[#195A36] focus:ring-[#195A36] border-gray-300" onclick="changeJarak(0)">
                                        <span class="ml-2">Di dalam JABODETABEK</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="is_luar_jabodetabek" value="1" class="text-[#195A36] focus:ring-[#195A36] border-gray-300" onclick="changeJarak(1)">
                                        <span class="ml-2">Di luar JABODETABEK</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                <a href="{{ route('client.dashboard') }}" class="px-6 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-full transition shadow-xs">Batal</a>
                                <button type="submit" class="px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white font-bold text-xs rounded-full shadow-xs transition cursor-pointer flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                                    <span>Kirim Pengajuan Sekarang</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- LIVE SIMULASI BIAYA BERDASARKAN DATABASE - 4 KOLOM -->
                <div class="space-y-6 lg:col-span-4 lg:sticky lg:top-6">
                    <div class="p-6 space-y-5 text-white bg-[#124227] rounded-[24px] shadow-sm">
                        <div>
                            <div class="flex items-center justify-between pb-3 border-b border-green-800/80">
                                <h3 class="text-xs font-bold tracking-wider text-green-300 uppercase">Simulasi Anggaran Jasa</h3>
                                <span class="text-[10px] text-green-200/80 font-medium">Estimasi Otomatis</span>
                            </div>
                        </div>

                        <div class="space-y-3 text-xs font-medium">
                            <div class="flex justify-between">
                                <span class="text-green-100/80">Harga Dasar Paket:</span>
                                <span id="txt_harga_dasar" class="font-mono font-bold text-white">Rp {{ number_format($serviceType->biaya ?? 5000000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-100/80">Add-on Menu (>50):</span>
                                <span id="txt_addon_menu" class="font-mono font-bold text-amber-300">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-100/80">Add-on Outlet (>1):</span>
                                <span id="txt_addon_outlet" class="font-mono font-bold text-amber-300">Rp 0</span>
                            </div>
                            <hr class="my-2 border-green-800/80">
                            <div class="flex justify-between text-sm font-bold">
                                <span>Total Estimasi:</span>
                                <span id="txt_total" class="font-mono text-base text-green-300">Rp 0</span>
                            </div>
                        </div>

                        <div id="alert_jarak" class="hidden p-3.5 bg-amber-950/40 border border-amber-500/40 text-amber-200 rounded-[16px] text-[10px] leading-relaxed font-medium space-y-1">
                            <p class="flex items-center gap-1 font-bold text-amber-300">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                Perhatian Akomodasi:
                            </p>
                            <p>Lokasi di luar Jabodetabek memerlukan biaya transportasi & akomodasi tim audit lapangan.</p>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>

    <!-- KALKULATOR HARGA SISI FRONTEND DENGAN SKEMA WAWANCARA PERUSAHAAN -->
    <script>
        const baseCostFromDb = {{ $serviceType->biaya ?? 5000000 }};
        const menuAddonFromDb = {{ $serviceType->biaya_tambahan_menu ?? 500000 }};
        const outletAddonFromDb = {{ $serviceType->biaya_tambahan_outlet ?? 1000000 }};

        let isLuarJabodetabek = 0;

        function changeJarak(val) {
            isLuarJabodetabek = val;
            const alertBox = document.getElementById('alert_jarak');
            if (alertBox) {
                if(val === 1) alertBox.classList.remove('hidden');
                else alertBox.classList.add('hidden');
            }
            hitungSimulasiBiaya();
        }

        function hitungSimulasiBiaya() {
            const jmlProduk = parseInt(document.getElementById('jumlah_produk')?.value) || 0;
            const jmlOutlet = parseInt(document.getElementById('jumlah_outlet')?.value) || 0;

            const hargaDasar = baseCostFromDb;

            // Perhitungan Tambahan Menu (>50): Kelipatan 30 menu
            let addonMenu = 0;
            if (jmlProduk > 50) {
                let sisaMenu = jmlProduk - 50;
                let blokKelipatan = Math.ceil(sisaMenu / 30);
                addonMenu = blokKelipatan * menuAddonFromDb;
            }

            // Perhitungan Tambahan Outlet/Fasilitas (>1)
            let addonOutlet = 0;
            if (jmlOutlet > 1) {
                addonOutlet = (jmlOutlet - 1) * outletAddonFromDb;
            }

            let totalEstimasi = hargaDasar + addonMenu + addonOutlet;

            if(document.getElementById('txt_harga_dasar')) document.getElementById('txt_harga_dasar').innerText = 'Rp ' + hargaDasar.toLocaleString('id-ID');
            if(document.getElementById('txt_addon_menu')) document.getElementById('txt_addon_menu').innerText = 'Rp ' + addonMenu.toLocaleString('id-ID');
            if(document.getElementById('txt_addon_outlet')) document.getElementById('txt_addon_outlet').innerText = 'Rp ' + addonOutlet.toLocaleString('id-ID');
            if(document.getElementById('txt_total')) document.getElementById('txt_total').innerText = 'Rp ' + totalEstimasi.toLocaleString('id-ID');
        }

        document.addEventListener("DOMContentLoaded", function() {
            hitungSimulasiBiaya();
        });
    </script>
</x-app-layout>