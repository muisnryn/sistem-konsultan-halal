<div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

    <!-- KARTU 1: TOTAL KONSULTAN -->
    <div class="relative p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px] flex items-center justify-between overflow-hidden transition-all duration-300 hover:shadow-md hover:border-[#195A36]/20 group">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#195A36]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <span class="block mb-1 text-xs font-bold tracking-wide text-gray-400 uppercase">Total Konsultan</span>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ count($consultants) }} <span class="text-sm font-normal text-gray-500">Personil</span></h2>
        </div>
        <div class="p-3.5 bg-[#e8f3ec] text-[#195A36] rounded-2xl shadow-sm border border-[#195A36]/10 group-hover:scale-110 transition-transform">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6 0 3.375 3.375 0 016 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        </div>
    </div>

    <!-- KARTU 2: KONSULTAN AKTIF SPK -->
    <div class="relative p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px] flex items-center justify-between overflow-hidden transition-all duration-300 hover:shadow-md hover:border-[#195A36]/20 group">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#195A36]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <span class="block mb-1 text-xs font-bold tracking-wide text-gray-400 uppercase">Konsultan Aktif (SPK)</span>
            <h2 class="text-2xl font-bold text-[#195A36] tracking-tight">{{ $consultants->where('is_active', 1)->count() }} <span class="text-sm font-normal text-gray-500">Personil</span></h2>
        </div>
        <div class="p-3.5 bg-[#e8f3ec] text-[#195A36] rounded-2xl shadow-sm border border-[#195A36]/10 group-hover:scale-110 transition-transform">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
    </div>

    <!-- KARTU 3: SPESIALISASI TERBANYAK -->
    <div class="relative p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px] flex items-center justify-between overflow-hidden transition-all duration-300 hover:shadow-md hover:border-blue-500/20 group">
        <div class="absolute top-0 left-0 w-full h-1 transition-opacity opacity-0 bg-gradient-to-r from-transparent via-blue-500/40 to-transparent group-hover:opacity-100"></div>
        <div>
            <span class="block mb-1 text-xs font-bold tracking-wide text-gray-400 uppercase">Spesialisasi Terbanyak</span>
            <h2 class="mt-1 text-xl font-bold tracking-tight text-gray-900">Makanan dan Minuman</h2>
        </div>
        <div class="p-3.5 text-blue-700 rounded-2xl bg-blue-50 shadow-sm border border-blue-100 group-hover:scale-110 transition-transform">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /></svg>
        </div>
    </div>

</div>
