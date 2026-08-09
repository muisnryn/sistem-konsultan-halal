<div class="bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[28px] overflow-hidden">
    <!-- HEADER TABEL & SEARCH BAR -->
    <div class="flex flex-col justify-between gap-4 p-6 border-b border-gray-100 sm:p-8 sm:flex-row sm:items-center bg-gradient-to-r from-gray-50/50 via-white to-white">
        <div>
            <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wider inline-block mb-1.5">Database Personil</span>
            <h3 class="text-base font-bold tracking-tight text-gray-900 sm:text-lg">Daftar Alternatif Konsultan Pendamping Halal</h3>
            <p class="text-xs font-medium text-gray-500 mt-0.5">Kelola data profil, koordinat lokasi Haversine, dan matriks SPK.</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text"
                   x-model="searchQuery"
                   placeholder="Cari nama, sertifikasi, domisili..."
                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-medium text-gray-800 outline-none focus:bg-white focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        </div>
    </div>

    <!-- TABEL KONTEN UTAMA (FLUID & FIT LAYAR) -->
    <div class="w-full">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <th class="py-4 px-4 sm:px-6 w-[32%]">Konsultan & Registrasi</th>
                    <th class="py-4 px-4 w-[20%]">Domisili & Koordinat</th>
                    <th class="py-4 px-4 w-[18%]">Spesialisasi</th>
                    <th class="py-4 px-4 text-center w-[10%]">Status</th>
                    <th class="py-4 px-4 sm:px-6 text-center w-[20%]">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-xs font-medium text-gray-700 divide-y divide-gray-100/80">
                @forelse($consultants as $c)
                    @php
                        $searchText = strtolower($c->nama_konsultan . ' ' . $c->sertifikasi_no . ' ' . $c->domisili);
                    @endphp
                    <tr class="transition-all duration-200 hover:bg-[#e8f3ec]/30 group"
                        x-data="{ search: {{ json_encode($searchText) }} }"
                        x-show="searchQuery === '' || search.includes(searchQuery.toLowerCase())">

                        <!-- KOLOM 1: KONSULTAN & REGISTRASI -->
                        <td class="px-4 py-4 font-semibold text-gray-900 sm:px-6">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#e8f3ec] text-[#195A36] font-bold flex items-center justify-center shrink-0 text-xs shadow-2xs border border-[#195A36]/10 mt-0.5">
                                    {{ strtoupper(substr($c->nama_konsultan, 0, 1)) }}
                                </div>
                                <div class="space-y-0.5 min-w-0">
                                    <span class="block text-xs font-bold leading-tight text-gray-900 truncate sm:text-sm">{{ $c->nama_konsultan }}</span>
                                    <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                        <span class="text-[11px] text-gray-400 font-medium">{{ $c->no_hp ?? '-' }}</span>
                                        <span class="text-gray-300"></span>
                                        <span class="font-mono text-[10px] px-2 py-0.5 font-semibold border border-gray-200 rounded-md bg-gray-50 text-gray-600 truncate max-w-[120px]">
                                            {{ $c->sertifikasi_no }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- KOLOM 2: DOMISILI & KOORDINAT -->
                        <td class="px-4 py-4">
                            <div class="space-y-1">
                                <span class="block text-xs font-bold text-gray-800 truncate">{{ $c->domisili }}</span>
                                <div class="inline-flex items-center gap-1 font-mono text-[10px] text-gray-500 bg-gray-50 px-2 py-0.5 rounded-md border border-gray-200/80 shadow-2xs">
                                    <svg class="w-3 h-3 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                    <span class="truncate">{{ $c->latitude ?? '0' }}, {{ $c->longitude ?? '0' }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- KOLOM 3: SPESIALISASI -->
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 bg-[#e8f3ec] text-[#195A36] rounded-xl font-bold text-[10px] sm:text-[11px] border border-[#195A36]/10 shadow-2xs inline-block leading-relaxed">
                                {{ $c->spesialisasi_industri }}
                            </span>
                        </td>

                        <!-- KOLOM 4: STATUS SPK -->
                        <td class="px-4 py-4 text-center">
                            @if($c->is_active)
                                <span class="px-3 py-1 bg-emerald-50 text-[#195A36] border border-emerald-200/60 rounded-full font-bold text-[10px] sm:text-[11px] inline-flex items-center gap-1 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36] animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 text-[10px] sm:text-[11px] font-bold text-gray-500 bg-gray-100 rounded-full border border-gray-200 shadow-2xs">
                                    Non-Aktif
                                </span>
                            @endif
                        </td>

                        <!-- KOLOM 5: AKSI MANAJEMEN -->
                        <td class="px-4 py-4 text-center sm:px-6">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('admin.consultant.evaluations.edit', $c->id) }}"
                                   class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-[10px] sm:text-[11px] rounded-xl transition border border-amber-200/80 inline-flex items-center gap-1 shadow-2xs"
                                   title="Isi Nilai Parameter SPK">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                    <span class="hidden sm:inline">Nilai SPK</span>
                                </a>

                                <button type="button"
                                        @click="openEditData({{ json_encode($c) }})"
                                        class="p-1.5 sm:p-2 text-gray-400 transition rounded-xl cursor-pointer hover:text-gray-800 hover:bg-white shadow-2xs border border-transparent hover:border-gray-200"
                                        title="Edit Profil">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                </button>

                                <form action="{{ route('admin.consultant.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konsultan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 sm:p-2 text-gray-400 transition rounded-xl cursor-pointer hover:text-rose-600 hover:bg-white shadow-2xs border border-transparent hover:border-gray-200" title="Hapus">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="p-4 mb-3 text-gray-400 border border-gray-100 rounded-2xl bg-gray-50 shadow-2xs">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6 0 3.375 3.375 0 016 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">Belum Ada Data</p>
                                <p class="max-w-sm mt-1 text-xs text-gray-400">Belum ada data konsultan yang terdaftar di dalam sistem.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
