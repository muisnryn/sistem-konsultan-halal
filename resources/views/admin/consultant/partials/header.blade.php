<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <div class="flex items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">
                Master Data
            </span>
            <span class="text-xs font-semibold text-gray-500">• Alternatif SPK PROMETHEE</span>
        </div>
        <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Kelola Data Konsultan</h1>
    </div>

    <button type="button" @click="openTambah()" class="px-5 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-sm font-semibold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto cursor-pointer">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        <span>Tambah Konsultan Baru</span>
    </button>
</div>
