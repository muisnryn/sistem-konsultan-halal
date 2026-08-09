<div class="bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[28px] p-6 flex flex-col space-y-6 hover:shadow-lg transition-all duration-300 group">
    <div class="flex items-center justify-between">
        <span class="px-3 py-1 bg-gray-50 text-gray-600 font-mono text-[10px] font-bold rounded-lg uppercase tracking-wider border border-gray-100">
            {{ $srv->kode_layanan }}
        </span>
        <span class="text-[10px] font-bold text-[#195A36] bg-[#e8f3ec] px-2 py-0.5 rounded-full uppercase">Aktif</span>
    </div>

    <div class="space-y-1">
        <h3 class="text-base font-bold text-gray-900">{{ $srv->nama_layanan }}</h3>
        <p class="text-[11px] text-gray-500 font-medium min-h-[32px]">{{ $srv->deskripsi }}</p>
    </div>

    <div class="p-4 border border-gray-100 bg-gray-50/50 rounded-2xl">
        <span class="text-[10px] font-bold uppercase text-gray-400">Harga Dasar</span>
        <div class="flex items-baseline gap-1 mt-0.5">
            <span class="text-xl font-black text-gray-900">Rp {{ number_format($srv->biaya, 0, ',', '.') }}</span>
            <span class="text-[10px] text-gray-400">/paket</span>
        </div>
    </div>

    <div class="flex-grow space-y-2">
        <span class="text-[10px] font-bold uppercase text-gray-400">Add-on</span>
        <div class="text-[11px] font-medium space-y-1">
            <div class="flex justify-between">
                <span class="text-gray-600">Menu (>50)</span>
                <span class="font-bold text-gray-900">+{{ number_format($srv->biaya_tambahan_menu, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Outlet (>1)</span>
                <span class="font-bold text-gray-900">+{{ number_format($srv->biaya_tambahan_outlet, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <button type="button" @click="editService = {{ json_encode($srv) }}; openEdit = true" 
            class="w-full py-3 bg-[#e8f3ec] hover:bg-[#195A36] text-[#195A36] hover:text-white rounded-xl text-xs font-bold transition border border-emerald-100">
        Edit Skema Tarif
    </button>
</div>