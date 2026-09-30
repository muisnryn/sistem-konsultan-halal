<x-app-layout>
    <!-- Assets Leaflet.js Peta Interaktif -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @php
        // Kalkulasi Persentase Kelengkapan Profil secara Dinamis (Termasuk Koordinat GPS)
        $fields = [
            'nama_perusahaan', 'pimpinan_perusahaan', 'alamat_perusahaan',
            'nama_fasilitas_produksi', 'alamat_fasilitas_produksi', 'kota_pabrik',
            'skala_perusahaan', 'status_pabrik', 'jumlah_karyawan',
            'jenis_kelompok_usaha', 'pic_nama', 'pic_jabatan',
            'pic_phone', 'pic_email', 'file_nib', 'file_npwp',
            'latitude', 'longitude'
        ];
        $filledCount = 0;
        if ($profile) {
            foreach ($fields as $field) {
                if (!empty($profile->$field)) $filledCount++;
            }
        }
        $completionPercent = count($fields) > 0 ? round(($filledCount / count($fields)) * 100) : 0;
    @endphp

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR HALAMAN -->
        <div class="flex flex-col gap-4 pb-2 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Legalitas & Operasional
                </div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Profil Perusahaan</h1>
                    @if($completionPercent == 100)
                        <span class="px-3.5 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 fill-[#195A36]" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Terverifikasi
                        </span>
                    @else
                        <span class="px-3.5 py-1 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full text-xs font-bold uppercase tracking-wide">
                            Belum Lengkap ({{ $completionPercent }}%)
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 font-medium mt-1.5">Kelola informasi legalitas dan operasional perusahaan untuk kelancaran proses sertifikasi halal.</p>
            </div>
        </div>

        <!-- NOTIFIKASI SUKSES / ERROR -->
        @if (session('success'))
            <div class="p-4 bg-[#e8f3ec] border border-green-200/60 text-[#195A36] text-xs font-semibold rounded-[20px] flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-[#195A36] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- GRID TATA LETAK UTAMA -->
            <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

                <!-- KOLOM KIRI (MAIN FORM INPUTS) - 8 KOLOM -->
                <div class="space-y-6 lg:col-span-8">

                    @if ($errors->any())
                        <div class="p-4 text-xs border bg-rose-50/80 border-rose-200 text-rose-800 rounded-[20px] space-y-1">
                            <p class="font-bold">Gagal menyimpan! Periksa kembali inputan Anda:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- KARTU 1: INFORMASI UMUM PERUSAHAAN -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Informasi Umum Perusahaan</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Nama Perusahaan <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $profile->nama_perusahaan ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: PT. Maju Barokah Sejahtera" required>
                                @error('nama_perusahaan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Pimpinan Perusahaan <span class="text-rose-500">*</span></label>
                                    <input type="text" name="pimpinan_perusahaan" value="{{ old('pimpinan_perusahaan', $profile->pimpinan_perusahaan ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Nama Pimpinan / Direktur" required>
                                    @error('pimpinan_perusahaan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Skala Perusahaan <span class="text-rose-500">*</span></label>
                                    <select name="skala_perusahaan" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer" required>
                                        <option value="">-- Pilih Skala --</option>
                                        @foreach(['kecil' => 'Kecil', 'menengah' => 'Menengah', 'besar' => 'Besar'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('skala_perusahaan', $profile->skala_perusahaan ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('skala_perusahaan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Jumlah Karyawan <span class="text-rose-500">*</span></label>
                                    <input type="number" name="jumlah_karyawan" value="{{ old('jumlah_karyawan', $profile->jumlah_karyawan ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition font-mono" placeholder="0" required min="1">
                                    @error('jumlah_karyawan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Jenis Kelompok Usaha <span class="text-rose-500">*</span></label>
                                    <select name="jenis_kelompok_usaha" id="jenis_kelompok_usaha" onchange="toggleKelompokLainnya()" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer" required>
                                        <option value="">-- Pilih Kelompok Usaha --</option>
                                        @php
                                            $optionsUsaha = [
                                                'Makanan dan Minuman',
                                                'Jasa Penyediaan Makanan & Minuman',
                                                'Kosmetik dan Obat-Obatan',
                                                'RPH / RPA',
                                                'Logistik & Distribusi',
                                                'Retail',
                                                'Barang Gunaan dan Kimia',
                                                'Lainnya'
                                            ];
                                        @endphp
                                        @foreach($optionsUsaha as $kelompok)
                                            <option value="{{ $kelompok }}" {{ old('jenis_kelompok_usaha', $profile->jenis_kelompok_usaha ?? '') == $kelompok ? 'selected' : '' }}>{{ $kelompok }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kelompok_usaha') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div id="input_lainnya_container" class="{{ old('jenis_kelompok_usaha', $profile->jenis_kelompok_usaha ?? '') == 'Lainnya' ? '' : 'hidden' }}">
                                <label class="block mb-1 text-xs font-bold text-gray-700">Sebutkan Kelompok Usaha Lainnya <span class="text-rose-500">*</span></label>
                                <input type="text" name="jenis_kelompok_usaha_lainnya" value="{{ old('jenis_kelompok_usaha_lainnya', $profile->jenis_kelompok_usaha_lainnya ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Detail jenis kelompok usaha Anda">
                                @error('jenis_kelompok_usaha_lainnya') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Alamat Kantor Pusat <span class="text-rose-500">*</span></label>
                                <textarea name="alamat_perusahaan" rows="2" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-[20px] text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Alamat lengkap kantor pusat perusahaan" required>{{ old('alamat_perusahaan', $profile->alamat_perusahaan ?? '') }}</textarea>
                                @error('alamat_perusahaan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- KARTU 2: INFORMASI FASILITAS PRODUKSI & PETA LOKASI -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H21m-9 0H3m8.25 0h.008v.008H12.25V21zm0-3h.008v.008H12.25V18zm0-3h.008v.008H12.25V15zm0-3h.008v.008H12.25V12zm0-3h.008v.008H12.25V9zm0-3h.008v.008H12.25V6z" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Informasi Fasilitas Produksi</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Nama Fasilitas Produksi <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama_fasilitas_produksi" value="{{ old('nama_fasilitas_produksi', $profile->nama_fasilitas_produksi ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: Kitchen Utama Jakarta" required>
                                @error('nama_fasilitas_produksi') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Status Pabrik <span class="text-rose-500">*</span></label>
                                    <select name="status_pabrik" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach(['milik sendiri' => 'Milik Sendiri', 'maklon' => 'Maklon', 'sewa/kontrak' => 'Sewa / Kontrak', 'lainnya' => 'Lainnya'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('status_pabrik', $profile->status_pabrik ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_pabrik') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Kapasitas Produksi <span class="text-rose-500">*</span></label>
                                    <input type="text" name="kapasitas_produksi" value="{{ old('kapasitas_produksi', $profile->kapasitas_produksi ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: 500 porsi / hari" required>
                                    @error('kapasitas_produksi') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Alamat Fasilitas Produksi <span class="text-rose-500">*</span></label>
                                <textarea name="alamat_fasilitas_produksi" rows="2" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-[20px] text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Alamat lengkap tempat produksi / pabrik" required>{{ old('alamat_fasilitas_produksi', $profile->alamat_fasilitas_produksi ?? '') }}</textarea>
                                @error('alamat_fasilitas_produksi') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-bold text-gray-700">Kota / Kabupaten Kedudukan Pabrik <span class="text-rose-500">*</span></label>
                                <input type="text" name="kota_pabrik" value="{{ old('kota_pabrik', $profile->kota_pabrik ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: Cianjur / Kota Bandung" required>
                                @error('kota_pabrik') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- PETA SPASIAL LEAFLET -->
                            <div class="pt-2 space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs font-bold text-gray-700">Titik GPS Lokasi Pabrik <span class="text-rose-500">*</span></label>
                                    <button type="button" onclick="detectCurrentLocation()" class="px-3 py-1 bg-[#e8f3ec] hover:bg-green-100 text-[#195A36] text-[10px] font-bold rounded-full transition flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3 h-3 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                        <span>Deteksi GPS Saya</span>
                                    </button>
                                </div>
                                <div id="map" class="z-0 w-full h-52 border rounded-[20px] border-gray-200 overflow-hidden shadow-inner"></div>
                                <div class="flex items-center justify-between px-4 py-2 bg-gray-50 rounded-full text-[10px] text-gray-500 font-medium border border-gray-100">
                                    <span>Koordinat Terpasang:</span>
                                    <span id="location-status" class="font-mono font-bold text-[#195A36]">
                                        {{ ($profile && $profile->latitude && $profile->longitude) ? $profile->latitude.', '.$profile->longitude : 'Belum Ditentukan (Geser Marker di Peta)' }}
                                    </span>
                                </div>
                                <!-- Default ke Titik Cianjur jika belum diisi -->
                                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $profile->latitude ?? '-6.597803') }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $profile->longitude ?? '106.799263') }}">

                                @error('latitude') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                @error('longitude') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- KARTU 3: LEGALITAS & PERPAJAKAN -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c-1.135.094-1.976 1.057-1.976 2.192V16.5A2.25 2.25 0 0012 18.75h.5m-3-13.312C10.046 5.308 10.05 5.253 10.05 5.2M9 4.108c-.469.04-.929.094-1.383.162A2.25 2.25 0 005.625 6.464v10.536A2.25 2.25 0 007.875 19.25h1.373" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Legalitas & Perpajakan</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <!-- NIB UPLOAD -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">NIB (Nomor Induk Berusaha) <span class="text-rose-500">*</span></label>
                                <input type="file" name="file_nib" accept="application/pdf" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#e8f3ec] file:text-[#195A36] hover:file:bg-green-100 transition cursor-pointer">
                                @if($profile && $profile->file_nib)
                                    <div class="flex items-center gap-1.5 pt-1 text-[10px] font-bold text-[#195A36]">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        <span>Berkas NIB Tersimpan</span>
                                        <a href="{{ Storage::url($profile->file_nib) }}" target="_blank" class="ml-auto underline text-[#195A36] hover:text-[#124227]">Lihat PDF ↗</a>
                                    </div>
                                @endif
                                @error('file_nib') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- NPWP UPLOAD -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">NPWP Perusahaan <span class="text-rose-500">*</span></label>
                                <input type="file" name="file_npwp" accept="application/pdf" class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#e8f3ec] file:text-[#195A36] hover:file:bg-green-100 transition cursor-pointer">
                                @if($profile && $profile->file_npwp)
                                    <div class="flex items-center gap-1.5 pt-1 text-[10px] font-bold text-[#195A36]">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        <span>Berkas NPWP Tersimpan</span>
                                        <a href="{{ Storage::url($profile->file_npwp) }}" target="_blank" class="ml-auto underline text-[#195A36] hover:text-[#124227]">Lihat PDF ↗</a>
                                    </div>
                                @endif
                                @error('file_npwp') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- KARTU 4: KONTAK PIC -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Kontak PIC (Person in Charge)</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Nama Lengkap PIC <span class="text-rose-500">*</span></label>
                                    <input type="text" name="pic_nama" value="{{ old('pic_nama', $profile->pic_nama ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Nama Penanggung Jawab" required>
                                    @error('pic_nama') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Jabatan <span class="text-rose-500">*</span></label>
                                    <input type="text" name="pic_jabatan" value="{{ old('pic_jabatan', $profile->pic_jabatan ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="Contoh: Manager QA / Staf" required>
                                    @error('pic_jabatan') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Nomor Telepon / WA <span class="text-rose-500">*</span></label>
                                    <input type="text" name="pic_phone" value="{{ old('pic_phone', $profile->pic_phone ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition font-mono" placeholder="08xxxxxxxxxx" required>
                                    @error('pic_phone') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block mb-1 text-xs font-bold text-gray-700">Email <span class="text-rose-500">*</span></label>
                                    <input type="email" name="pic_email" value="{{ old('pic_email', $profile->pic_email ?? '') }}" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition" placeholder="email@perusahaan.com" required>
                                    @error('pic_email') <p class="text-rose-500 text-[10px] mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI UTAMA -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('client.dashboard') }}" class="px-6 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-full transition shadow-xs">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white font-bold text-xs rounded-full shadow-xs transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </div>

                <!-- KOLOM KANAN (SIDEBAR WIDGETS) - 4 KOLOM -->
                <div class="space-y-6 lg:col-span-4 lg:sticky lg:top-6">

                    <!-- WIDGET 1: KELENGKAPAN PROFIL -->
                    <div class="relative p-6 space-y-3 overflow-hidden text-white bg-[#195A36] rounded-[24px] shadow-sm">
                        <div class="relative z-10 flex items-center justify-between">
                            <span class="text-xs font-bold tracking-wider text-green-100 uppercase">Kelengkapan Profil</span>
                            <strong class="font-mono text-xl font-extrabold text-white">{{ $completionPercent }}%</strong>
                        </div>

                        <div class="relative z-10 w-full h-2.5 overflow-hidden rounded-full bg-[#124227]">
                            <div class="h-2.5 transition-all duration-500 bg-green-300 rounded-full" style="width: {{ $completionPercent }}%;"></div>
                        </div>

                        <p class="text-[11px] text-green-100/90 leading-relaxed font-medium relative z-10 pt-1">
                            @if($completionPercent == 100)
                                ✓ Profil perusahaan Anda telah <strong>100% lengkap</strong>. Akses pengajuan sertifikasi halal baru kini telah terbuka!
                            @else
                                Lengkapi seluruh data bertanda bintang (<span class="font-bold text-rose-300">*</span>) untuk membuka menu Pengajuan Baru.
                            @endif
                        </p>

                        <div class="absolute pointer-events-none -right-6 -bottom-6 text-white/10">
                            <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-5.45 9-12V5l-9-3zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 9z"/></svg>
                        </div>
                    </div>

                    <!-- WIDGET 2: CHECKLIST PERSYARATAN VITAL -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Status Berkas Vital</h3>
                            <span class="text-[10px] text-gray-400 font-semibold">Realtime Checklist</span>
                        </div>

                        <div class="space-y-2.5 text-xs font-semibold">
                            <!-- NIB -->
                            <div class="flex items-center justify-between p-3 rounded-full {{ ($profile && $profile->file_nib) ? 'bg-[#e8f3ec] text-[#195A36]' : 'bg-gray-50 text-gray-500 border border-gray-100' }}">
                                <div class="flex items-center gap-2">
                                    @if($profile && $profile->file_nib)
                                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                        <div class="w-3.5 h-3.5 border-2 rounded-full border-gray-300"></div>
                                    @endif
                                    <span>Berkas NIB (PDF)</span>
                                </div>
                                <span class="text-[10px] font-bold {{ ($profile && $profile->file_nib) ? 'text-[#195A36]' : 'text-gray-400' }}">
                                    {{ ($profile && $profile->file_nib) ? 'Tersimpan' : 'Belum' }}
                                </span>
                            </div>

                            <!-- NPWP -->
                            <div class="flex items-center justify-between p-3 rounded-full {{ ($profile && $profile->file_npwp) ? 'bg-[#e8f3ec] text-[#195A36]' : 'bg-gray-50 text-gray-500 border border-gray-100' }}">
                                <div class="flex items-center gap-2">
                                    @if($profile && $profile->file_npwp)
                                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                        <div class="w-3.5 h-3.5 border-2 rounded-full border-gray-300"></div>
                                    @endif
                                    <span>Berkas NPWP (PDF)</span>
                                </div>
                                <span class="text-[10px] font-bold {{ ($profile && $profile->file_npwp) ? 'text-[#195A36]' : 'text-gray-400' }}">
                                    {{ ($profile && $profile->file_npwp) ? 'Tersimpan' : 'Belum' }}
                                </span>
                            </div>

                            <!-- KOORDINAT GPS PABRIK -->
                            <div class="flex items-center justify-between p-3 rounded-full {{ ($profile && $profile->latitude && $profile->longitude) ? 'bg-[#e8f3ec] text-[#195A36]' : 'bg-gray-50 text-gray-500 border border-gray-100' }}">
                                <div class="flex items-center gap-2">
                                    @if($profile && $profile->latitude && $profile->longitude)
                                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                        <div class="w-3.5 h-3.5 border-2 rounded-full border-gray-300"></div>
                                    @endif
                                    <span>Titik GPS Pabrik</span>
                                </div>
                                <span class="text-[10px] font-bold {{ ($profile && $profile->latitude && $profile->longitude) ? 'text-[#195A36]' : 'text-gray-400' }}">
                                    {{ ($profile && $profile->latitude && $profile->longitude) ? 'Terpasang' : 'Belum' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- WIDGET 3: PANDUAN TAHAPAN -->
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-4">
                        <h3 class="pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                            Tahapan Sertifikasi Halal
                        </h3>

                        <div class="space-y-3.5 text-xs">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-[#195A36] text-white font-bold text-[11px] flex items-center justify-center shrink-0">
                                    1
                                </div>
                                <div>
                                    <strong class="block text-xs text-gray-900">Isi Profil Perusahaan</strong>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5">Lengkapi profil awal dan unggah legalitas usaha Anda.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 opacity-60">
                                <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 font-bold text-[11px] flex items-center justify-center shrink-0">
                                    2
                                </div>
                                <div>
                                    <strong class="block text-xs text-gray-800">Buat Pengajuan Baru</strong>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5">Pilih jenis layanan sertifikasi dan daftarkan nama produk.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 opacity-60">
                                <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 font-bold text-[11px] flex items-center justify-center shrink-0">
                                    3
                                </div>
                                <div>
                                    <strong class="block text-xs text-gray-800">Pendampingan Konsultan</strong>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5">Sistem merekomendasikan konsultan terbaik untuk audit.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WIDGET 4: BANTUAN WA -->
                    <div class="bg-[#124227] text-white rounded-[24px] p-6 space-y-3 shadow-xs">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center justify-center text-green-300 rounded-full w-7 h-7 bg-white/10 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <strong class="text-xs font-bold text-white">Kendala Pengisian Data?</strong>
                        </div>
                        <p class="text-[11px] text-green-100/90 leading-relaxed font-medium">
                            Jika memiliki pertanyaan terkait dokumen NIB/NPWP atau lokasi pabrik, hubungi tim support kami.
                        </p>
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20HalalCert,%20saya%20butuh%20bantuan%20pengisian%20profil%20perusahaan" target="_blank" class="mt-2 w-full py-2.5 bg-white hover:bg-green-50 text-[#195A36] font-bold text-xs rounded-full transition flex items-center justify-center gap-1.5 shadow-xs">
                            <span>Chat Helpdesk via WA</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>

    <!-- LOGIKA JAVASCRIPT LEAFLET (TITIK AWAL CIANJUR) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Default ke Koordinat Cianjur jika belum terisi
            let initialLat = parseFloat(document.getElementById('latitude').value) || -6.806885;
            let initialLng = parseFloat(document.getElementById('longitude').value) || 107.142338;

            const map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

            function updatePosition(lat, lng) {
                const formattedLat = lat.toFixed(6);
                const formattedLng = lng.toFixed(6);

                document.getElementById('latitude').value = formattedLat;
                document.getElementById('longitude').value = formattedLng;
                document.getElementById('location-status').innerText = `${formattedLat}, ${formattedLng}`;
            }

            marker.on('dragend', function () {
                const position = marker.getLatLng();
                updatePosition(position.lat, position.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updatePosition(e.latlng.lat, e.latlng.lng);
            });

            window.detectCurrentLocation = function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            map.setView([lat, lng], 15);
                            marker.setLatLng([lat, lng]);
                            updatePosition(lat, lng);
                        },
                        (error) => {
                            alert('Gagal mendeteksi lokasi: Mohon izinkan akses GPS di browser Anda.');
                        }
                    );
                } else {
                    alert('Browser Anda tidak mendukung lokasi GPS.');
                }
            };
        });

        function toggleKelompokLainnya() {
            const selectBox = document.getElementById('jenis_kelompok_usaha');
            const container = document.getElementById('input_lainnya_container');

            if (selectBox.value === 'Lainnya') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
