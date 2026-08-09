<x-app-layout>
    <!-- Memuat Google Material Symbols Khusus untuk Kebutuhan Ikon Modul Ini -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1;
        }

        /* Kustomisasi Desain Range Slider Sesuai Tema Modern Clean UI (#195A36) */
        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #195A36;
            cursor: pointer;
            margin-top: -6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            transition: transform 0.1s ease;
        }
        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            cursor: pointer;
            background: #e8f3ec;
            border-radius: 3px;
        }
        input[type=range]:focus {
            outline: none;
        }
    </style>

    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER HALAMAN & WIDGET VALIDASI REAL-TIME -->
        <div class="flex flex-col gap-4 pb-4 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wider border border-[#195A36]/10">
                        Master Data
                    </span>
                    <span class="text-xs font-semibold text-gray-400">• Konfigurasi SPK</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Konfigurasi Kriteria SPK</h1>
                <p class="mt-1 text-xs font-medium text-gray-500">Atur bobot dan fungsi preferensi PROMETHEE untuk setiap kriteria evaluasi konsultan.</p>
            </div>

            <!-- Widget Validasi Bobot Akademik Akumulatif -->
            <div class="bg-white px-4 py-2.5 rounded-2xl border border-gray-200 shadow-2xs flex items-center space-x-4 transition-all duration-300 min-w-[150px]" id="weight-validator">
                <div class="flex-1 text-right">
                    <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider leading-none">Total Bobot</span>
                    <span class="text-lg font-bold text-[#195A36] block mt-1 leading-none font-mono" id="total-weight-display">0%</span>
                </div>
                <div class="w-8 h-8 rounded-xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 border border-[#195A36]/10" id="validator-icon">
                    <span class="text-base material-symbols-outlined">check_circle</span>
                </div>
            </div>
        </div>

        <!-- POPUP NOTIFIKASI KANAN ATAS (FLASH MESSAGES) -->
        @if(session('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 4000)"
                 x-transition:enter="transform transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transform transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 class="fixed top-6 right-6 z-50 w-full max-w-sm bg-white border border-emerald-100 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-[20px] p-4 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 border border-[#195A36]/10">
                    <span class="text-lg material-symbols-outlined">check_circle</span>
                </div>
                <div class="flex-1">
                    <h5 class="text-xs font-bold text-gray-900">Berhasil!</h5>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition cursor-pointer">
                    <span class="text-base material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transform transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transform transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 class="fixed top-6 right-6 z-50 w-full max-w-sm bg-white border border-amber-100 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-[20px] p-4 flex items-center gap-3.5">
                <div class="flex items-center justify-center w-10 h-10 border rounded-xl bg-amber-50 text-amber-600 shrink-0 border-amber-100">
                    <span class="text-lg material-symbols-outlined">warning</span>
                </div>
                <div class="flex-1">
                    <h5 class="text-xs font-bold text-gray-900">Peringatan</h5>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition cursor-pointer">
                    <span class="text-base material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transform transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transform transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-8"
                 class="fixed top-6 right-6 z-50 w-full max-w-sm bg-white border border-rose-100 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-[20px] p-4 flex items-center gap-3.5">
                <div class="flex items-center justify-center w-10 h-10 border rounded-xl bg-rose-50 text-rose-600 shrink-0 border-rose-100">
                    <span class="text-lg material-symbols-outlined">error</span>
                </div>
                <div class="flex-1">
                    <h5 class="text-xs font-bold text-gray-900">Terjadi Kesalahan</h5>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition cursor-pointer">
                    <span class="text-base material-symbols-outlined">close</span>
                </button>
            </div>
        @endif

        <!-- FORMULIR UTAMA PEMBARUAN MASSAL KONFIGURASI KRITERIA -->
        <form action="{{ route('admin.criteria.update_config') }}" method="POST" class="bg-white rounded-[28px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6 sm:p-8 space-y-8" id="spk-config-form">
            @csrf

            <!-- SYSTEM GRID DUA KOLOM DENGAN GAYA MODERN CLEAN UI -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                @foreach($criterias as $index => $crit)
                    <!-- Hidden input untuk memetakan ID kriteria ke array Controller -->
                    <input type="hidden" name="criterias[{{ $index }}][id]" value="{{ $crit->id }}">

                    <div class="criterion-card bg-gray-50/50 border border-gray-100 rounded-[22px] p-6 hover:border-[#195A36]/30 hover:bg-white hover:shadow-md transition-all duration-200 flex flex-col justify-between space-y-5">

                        <!-- Header Kartu Kriteria (Nama & Atribut Tren) -->
                        <div class="flex items-center justify-between">
                            <h3 class="flex items-center text-xs font-bold text-gray-900">
                                <!-- Pemetaan Otomatis Ikon Google Material Berdasarkan Kode Kriteria -->
                                @if($crit->kode == 'C1')
                                    <span class="material-symbols-outlined text-[#195A36] mr-2.5 text-base">factory</span>
                                @elseif($crit->kode == 'C2')
                                    <span class="material-symbols-outlined text-[#195A36] mr-2.5 text-base">history</span>
                                @elseif($crit->kode == 'C3')
                                    <span class="material-symbols-outlined text-rose-600 mr-2.5 text-base">work_history</span>
                                @elseif($crit->kode == 'C4')
                                    <span class="material-symbols-outlined text-rose-600 mr-2.5 text-base">pin_drop</span>
                                @elseif($crit->kode == 'C5')
                                    <span class="material-symbols-outlined text-[#195A36] mr-2.5 text-base">trending_up</span>
                                @else
                                    <span class="material-symbols-outlined text-[#195A36] mr-2.5 text-base">event_available</span>
                                @endif

                                <span>{{ $crit->nama_kriteria }}</span>
                            </h3>

                            <!-- Badge Karakter Arah Kriteria SPK (Benefit / Cost) -->
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $crit->tren == 'max' ? 'bg-[#e8f3ec] text-[#195A36] border border-[#195A36]/10' : 'bg-rose-50 text-rose-700 border border-rose-200/60' }}">
                                {{ $crit->tren == 'max' ? 'Benefit' : 'Cost' }}
                            </span>
                        </div>

                        <!-- Baris Input Slider Perubahan Nilai Bobot -->
                        <div class="space-y-2">
                            <label class="flex justify-between text-[11px] font-bold text-gray-500 uppercase tracking-wide">
                                <span>Bobot (Weight)</span>
                                <!-- Pengonversian dari pecahan desimal database ke satuan persen antarmuka -->
                                <span class="font-mono text-xs font-bold text-gray-900 weight-val">{{ (int)($crit->bobot * 100) }}%</span>
                            </label>
                            <input class="weight-slider w-full cursor-pointer accent-[#195A36]"
                                   name="criterias[{{ $index }}][bobot_persen]"
                                   data-criterion="{{ $crit->id }}"
                                   max="100"
                                   min="0"
                                   type="range"
                                   value="{{ (int)($crit->bobot * 100) }}">
                        </div>

                        <!-- Menu Pilihan Tipe Fungsi Preferensi Matematika PROMETHEE II -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wide">Tipe Fungsi Preferensi</label>
                            <select name="criterias[{{ $index }}][tipe_preferensi]"
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-[16px] text-xs font-semibold text-gray-900 outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition shadow-2xs">
                                <option value="usual" {{ $crit->tipe_preferensi == 'usual' ? 'selected' : '' }}>Type 1: Usual (Strict)</option>
                                <option value="u_shape" {{ $crit->tipe_preferensi == 'u_shape' ? 'selected' : '' }}>Type 2: U-Shape</option>
                                <option value="v_shape" {{ $crit->tipe_preferensi == 'v_shape' ? 'selected' : '' }}>Type 3: V-Shape</option>
                                <option value="level" {{ $crit->tipe_preferensi == 'level' ? 'selected' : '' }}>Type 4: Level</option>
                                <option value="linear" {{ $crit->tipe_preferensi == 'linear' ? 'selected' : '' }}>Type 5: Linear</option>
                                <option value="gaussian" {{ $crit->tipe_preferensi == 'gaussian' ? 'selected' : '' }}>Type 6: Gaussian</option>
                            </select>
                        </div>

                    </div>
                @endforeach

            </div>

            <!-- Panel Tombol Aksi Bawah Eksekusi -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.criteria.index') }}"
                   class="px-6 py-3 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-2xs hover:bg-gray-50">
                    Reset Default
                </a>
                <button class="px-6 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-md flex items-center gap-2 cursor-pointer"
                        id="btn-simpan"
                        type="submit">
                    <span class="text-base material-symbols-outlined">save</span>
                    <span>Simpan Konfigurasi</span>
                </button>
            </div>
        </form>

    </div>

    <!-- JAVASCRIPT VALIDATOR LOGIC ASLI STITCH (DIPELIHARA PENUH) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sliders = document.querySelectorAll('.weight-slider');
            const totalDisplay = document.getElementById('total-weight-display');
            const validatorIcon = document.getElementById('validator-icon');
            const validatorContainer = document.getElementById('weight-validator');
            const btnSimpan = document.getElementById('btn-simpan');

            function updateTotal() {
                let total = 0;
                sliders.forEach(slider => {
                    total += parseInt(slider.value);
                    const valDisplay = slider.closest('.criterion-card').querySelector('.weight-val');
                    if (valDisplay) {
                        valDisplay.textContent = slider.value + '%';
                    }
                });

                totalDisplay.textContent = total + '%';

                if (total === 100) {
                    totalDisplay.classList.remove('text-rose-600');
                    totalDisplay.classList.add('text-[#195A36]');
                    validatorIcon.className = 'w-8 h-8 rounded-xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 border border-[#195A36]/10 shadow-2xs';
                    validatorIcon.innerHTML = '<span class="text-base material-symbols-outlined">check_circle</span>';
                    validatorContainer.classList.remove('border-rose-200', 'bg-rose-50/20');
                    validatorContainer.classList.add('border-gray-200', 'bg-white');
                    btnSimpan.disabled = false;
                    btnSimpan.classList.remove('opacity-50', 'cursor-not-allowed', 'hover:bg-emerald-700');
                    btnSimpan.classList.add('cursor-pointer');
                } else {
                    totalDisplay.classList.remove('text-[#195A36]');
                    totalDisplay.classList.add('text-rose-600');
                    validatorIcon.className = 'w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100 shadow-2xs';
                    validatorIcon.innerHTML = '<span class="text-base material-symbols-outlined">warning</span>';
                    validatorContainer.classList.add('border-rose-200', 'bg-rose-50/20');
                    validatorContainer.classList.remove('border-gray-200', 'bg-white');
                    btnSimpan.disabled = true;
                    btnSimpan.classList.add('opacity-50', 'cursor-not-allowed');
                    btnSimpan.classList.remove('cursor-pointer');
                }
            }

            sliders.forEach(slider => {
                slider.addEventListener('input', updateTotal);
            });

            // Perhitungan Inisial Awal Pemuatan Halaman
            updateTotal();
        });
    </script>
</x-app-layout>