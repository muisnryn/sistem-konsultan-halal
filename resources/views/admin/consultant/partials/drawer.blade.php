<div x-show="openDrawer"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto sm:p-6">

    <!-- BACKDROP DENGAN BLUR KABUR ELEGAN -->
    <div x-show="openDrawer"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openDrawer = false"
         class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-md"></div>

    <!-- MODAL CONTAINER UTAMA (CENTERED POPUP) -->
    <div x-show="openDrawer"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative w-full max-w-2xl bg-white shadow-2xl rounded-[28px] border border-gray-100 overflow-hidden z-10 my-8">

        <!-- MODAL HEADER -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/80 to-white">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 shadow-sm border border-[#195A36]/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6 0 3.375 3.375 0 016 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">Form Manajemen</span>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight mt-0.5" x-text="drawerTitle"></h3>
                </div>
            </div>
            <button type="button" @click="openDrawer = false" class="p-2.5 text-gray-400 transition rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- MODAL BODY FORM (GRID LAYOUT 2 KOLOM) -->
        <form :action="formAction" method="POST" class="px-8 py-6 space-y-5 text-xs bg-gray-50/20 max-h-[75vh] overflow-y-auto">
            @csrf
            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- NAMA KONSULTAN -->
                <div class="sm:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-1.5">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama_konsultan" x-model="consultantData.nama_konsultan" placeholder="Contoh: Dr. H. Ahmad, M.Si" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <!-- NO SERTIFIKASI -->
                <div class="sm:col-span-2">
                    <label class="block font-semibold text-gray-700 mb-1.5">No. Registrasi Sertifikasi</label>
                    <input type="text" name="sertifikasi_no" x-model="consultantData.sertifikasi_no" placeholder="REG-HALAL-2026-xxx" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-mono uppercase font-semibold text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <!-- DOMISILI -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Domisili Kota</label>
                    <input type="text" name="domisili" x-model="consultantData.domisili" placeholder="Contoh: Bandung" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <!-- SPESIALISASI -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Spesialisasi Industri</label>
                    <select name="spesialisasi_industri" x-model="consultantData.spesialisasi_industri" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                        <option value="Makanan dan Minuman">Makanan dan Minuman</option>
                        <option value="Jasa Penyediaan Makanan & Minuman">Jasa Penyediaan Makanan & Minuman</option>
                        <option value="Kosmetik dan Obat-Obatan">Kosmetik dan Obat-Obatan</option>
                        <option value="RPH / RPA">RPH / RPA</option>
                        <option value="Logistik & Distribusi">Logistik & Distribusi</option>
                        <option value="Retail">Retail</option>
                        <option value="Barang Gunaan dan Kimia">Barang Gunaan dan Kimia</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- LATITUDE -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Latitude (Haversine)</label>
                    <input type="number" step="any" name="latitude" x-model="consultantData.latitude" placeholder="-6.9174" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-mono font-semibold text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <!-- LONGITUDE -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Longitude (Haversine)</label>
                    <input type="number" step="any" name="longitude" x-model="consultantData.longitude" placeholder="107.6191" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-mono font-semibold text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <!-- STATUS AKTIF (JIKA EDIT) -->
                <template x-if="isEdit">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-gray-700 mb-1.5">Status Aktivitas SPK</label>
                        <select name="is_active" x-model="consultantData.is_active" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                            <option value="1">Aktif (Masuk Perhitungan SPK)</option>
                            <option value="0">Non-Aktif (Ditangguhkan)</option>
                        </select>
                    </div>
                </template>
            </div>

            <!-- MODAL FOOTER ACTIONS -->
            <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-100">
                <button type="button" @click="openDrawer = false" class="px-6 py-3 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-6 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-md cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <span>Simpan Profil Konsultan</span>
                </button>
            </div>
        </form>

    </div>
</div>
