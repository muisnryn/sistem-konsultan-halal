<div x-show="openCreate"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto sm:p-6">

    <!-- BACKDROP DENGAN BLUR KABUR ELEGAN -->
    <div x-show="openCreate"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openCreate = false"
         class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-md"></div>

    <!-- MODAL CONTAINER UTAMA (CENTERED POPUP) -->
    <div x-show="openCreate"
         x-transition:enter="transform transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transform transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative w-full max-w-lg bg-white shadow-2xl rounded-[28px] border border-gray-100 overflow-hidden z-10 my-8">

        <!-- MODAL HEADER -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/80 to-white">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 shadow-sm border border-[#195A36]/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3M9 10.5a3 3 0 11-6 0 3 3 0 016 0zM3 19.5v-2a4 4 0 014-4h4a4 4 0 014 4v2" /></svg>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">Master Data</span>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight mt-0.5">Tambah Pengguna Baru</h3>
                </div>
            </div>
            <button type="button" @click="openCreate = false" class="p-2.5 text-gray-400 transition rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- MODAL BODY FORM -->
        <form action="{{ route('admin.user.store') }}" method="POST" class="px-8 py-6 space-y-4 text-xs bg-gray-50/20 max-h-[75vh] overflow-y-auto">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: Ahmad Fauzi" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" placeholder="email@domain.com" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required minlength="8" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1.5">Role / Hak Akses</label>
                    <select name="role" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] font-medium text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-sm">
                        <option value="klien">Klien</option>
                        <option value="konsultan">Konsultan</option>
                        <option value="finance">Finance</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <!-- MODAL FOOTER ACTIONS -->
            <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-100">
                <button type="button" @click="openCreate = false" class="px-6 py-3 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-6 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-md cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>

    </div>
</div>