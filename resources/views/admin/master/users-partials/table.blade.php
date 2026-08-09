<div class="overflow-x-auto">
    <table class="min-w-full text-xs text-left divide-y divide-gray-100">
        <thead class="font-bold tracking-wider uppercase bg-gray-50/80 text-gray-400 text-[11px]">
            <tr>
                <th class="px-8 py-4">Pengguna</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4 text-center">Role / Hak Akses</th>
                <th class="px-8 py-4 text-center">Aksi Manajemen</th>
            </tr>
        </thead>
        <tbody class="font-medium text-gray-700 divide-y divide-gray-100/80">
            @forelse($users as $usr)
                <tr class="transition-all duration-200 hover:bg-[#e8f3ec]/30 group"
                    x-show="matchesFilter('{{ addslashes($usr->name) }}', '{{ addslashes($usr->email) }}', '{{ $usr->role }}')">
                    <td class="px-8 py-5 font-semibold text-gray-900">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-[#e8f3ec] text-[#195A36] font-bold flex items-center justify-center shrink-0 text-xs shadow-2xs border border-[#195A36]/10">
                                {{ strtoupper(substr($usr->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $usr->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 font-mono text-gray-600">
                        <span class="px-3 py-1.5 font-semibold border border-gray-200/80 rounded-xl bg-gray-50/80 shadow-2xs">
                            {{ $usr->email }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $badgeStyle = match($usr->role) {
                                'admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'konsultan' => 'bg-emerald-50 text-[#195A36] border-emerald-200/60',
                                'klien' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'finance' => 'bg-amber-50 text-amber-700 border-amber-200',
                                default => 'bg-gray-50 text-gray-700 border-gray-200'
                            };
                        @endphp
                        <span class="px-3.5 py-1.5 border rounded-full text-[11px] font-bold uppercase inline-flex items-center gap-1.5 shadow-2xs {{ $badgeStyle }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $usr->role }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" @click="editUser = {{ json_encode($usr) }}; openEdit = true" class="p-2 text-gray-400 transition border border-transparent cursor-pointer rounded-xl hover:text-gray-800 hover:bg-white shadow-2xs hover:border-gray-200" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                            </button>

                            @if($usr->id !== auth()->id())
                                <form action="{{ route('admin.user.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 transition border border-transparent cursor-pointer rounded-xl hover:text-rose-600 hover:bg-white shadow-2xs hover:border-gray-200" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-20 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="p-4 mb-3 text-gray-400 border border-gray-100 rounded-2xl bg-gray-50 shadow-2xs">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6 0 3.375 3.375 0 016 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-900">Belum Ada Data</p>
                            <p class="max-w-sm mt-1 text-xs text-gray-400">Tidak ada data pengguna yang ditemukan di dalam sistem.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="p-6 border-t border-gray-100 bg-gray-50/50">
    {{ $users->links() }}
</div>