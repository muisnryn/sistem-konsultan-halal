<div class="flex flex-col justify-between gap-4 p-6 border-b border-gray-100 sm:p-8 sm:flex-row sm:items-center bg-gradient-to-r from-gray-50/50 via-white to-white">
    <div class="flex items-center w-full gap-2 sm:w-auto">
        <select x-model="selectedRole" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-semibold text-gray-800 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
            <option value="all">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="konsultan">Konsultan</option>
            <option value="klien">Klien</option>
            <option value="finance">Finance</option>
        </select>
    </div>

    <div class="relative w-full sm:w-80">
        <input type="text"
               x-model="searchQuery"
               placeholder="Ketik untuk mencari nama / email..."
               class="w-full pl-11 pr-8 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-medium text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
        <svg class="w-4 h-4 text-gray-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        <button x-show="searchQuery.length > 0" @click="searchQuery = ''" type="button" class="absolute right-3.5 top-3.5 text-gray-400 hover:text-gray-600">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
</div>