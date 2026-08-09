<div x-show="openEdit"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto sm:p-6">

    <!-- BACKDROP DENGAN BLUR ELEGAN -->
    <div x-show="openEdit"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openEdit = false"
         class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-md"></div>

    <!-- MODAL CONTAINER UTAMA (DIPERLUAS KE MAX-W-2XL) -->
    <div x-show="openEdit"
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
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0121 17.25l-5.83-5.83M15 8.25L7.5 15.75M12 4.5h7.5v7.5" />
                    </svg>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">Pembaruan Skema</span>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight mt-0.5">Edit Tarif & Konfigurasi Layanan</h3>
                </div>
            </div>
            <button type="button" @click="openEdit = false" class="p-2.5 text-gray-400 transition rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- MODAL BODY FORM (GRID SECTIONED LAYOUT) -->
        <form :action="'{{ url('admin/kelola-layanan') }}/' + editService.id" method="POST" class="px-8 py-6 space-y-5 text-xs bg-gray-50/30 max-h-[75vh] overflow-y-auto">
            @csrf
            @method('PUT')

            <!-- SECTION 1: INFORMASI UTAMA -->
            <div class="p-6 space-y-4 bg-white border border-gray-100 rounded-2xl shadow-2xs">
                <span class="text-[10px] font-bold text-[#195A36] uppercase tracking-wider block">1. Informasi Umum</span>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Kode Layanan</label>
                        <input type="text" name="kode_layanan" x-model="editService.kode_layanan" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-mono font-bold text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-gray-700 mb-1.5">Nama Layanan</label>
                        <input type="text" name="nama_layanan" x-model="editService.nama_layanan" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-medium text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Deskripsi Layanan</label>
                    <textarea name="deskripsi" x-model="editService.deskripsi" rows="2" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-medium text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs resize-none"></textarea>
                </div>
            </div>

            <!-- SECTION 2: KONFIGURASI FINANSIAL & ADD-ON -->
            <div class="p-6 space-y-4 bg-white border border-gray-100 rounded-2xl shadow-2xs">
                <span class="text-[10px] font-bold text-[#195A36] uppercase tracking-wider block">2. Konfigurasi Tarif & Add-on</span>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Harga Satuan Dasar</label>
                        <div class="relative">
                            <span class="absolute font-mono font-bold text-gray-400 left-4 top-3">Rp</span>
                            <input type="number" name="biaya" x-model="editService.biaya" min="0" step="any" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-mono font-bold text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1.5">Biaya Tambahan Menu</label>
                        <div class="relative">
                            <span class="absolute font-mono font-bold text-gray-400 left-4 top-3">Rp</span>
                            <input type="number" name="biaya_tambahan_menu" x-model="editService.biaya_tambahan_menu" min="0" step="any" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-mono font-bold text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Biaya Tambahan Outlet</label>
                    <div class="relative">
                        <span class="absolute font-mono font-bold text-gray-400 left-4 top-3">Rp</span>
                        <input type="number" name="biaya_tambahan_outlet" x-model="editService.biaya_tambahan_outlet" min="0" step="any" required class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-[14px] font-mono font-bold text-gray-900 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                    </div>
                </div>
            </div>

            <!-- MODAL FOOTER ACTIONS -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200/60">
                <button type="button" @click="openEdit = false" class="px-6 py-3 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-6 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-md cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <span>Simpan Perubahan Tarif</span>
                </button>
            </div>
        </form>

    </div>
</div>