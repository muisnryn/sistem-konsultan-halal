<x-app-layout>
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" 
         x-data="{ 
            openEdit: false, 
            editService: { id: '', nama_layanan: '', biaya: '', biaya_tambahan_menu: '', biaya_tambahan_outlet: '', deskripsi: '' } 
         }">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 pb-4 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wider border border-[#195A36]/10">
                        Master Data
                    </span>
                    <span class="text-xs font-semibold text-gray-400">• Konfigurasi Biaya & Add-on</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Kelola Tarif Layanan & Add-on</h1>
            </div>
        </div>

        <!-- POPUP NOTIFIKASI SUKSES (POSISI KANAN ATAS) -->
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
                class="fixed top-6 right-6 z-50 w-full max-w-sm bg-white border border-emerald-100 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-[20px] p-4 flex items-center gap-3.5 mx-4 sm:mx-0">
                
                <div class="w-10 h-10 rounded-xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0 border border-[#195A36]/10">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>

                <div class="flex-1">
                    <h5 class="text-xs font-bold text-gray-900">Berhasil!</h5>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">{{ session('success') }}</p>
                </div>

                <button @click="show = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- POPUP NOTIFIKASI ERROR / VALIDASI (POSISI KANAN ATAS) -->
        @if($errors->any())
            <div x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-8"
                class="fixed top-6 right-6 z-50 w-full max-w-sm bg-white border border-rose-100 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-[20px] p-4 flex items-center gap-3.5 mx-4 sm:mx-0">
                
                <div class="flex items-center justify-center w-10 h-10 border rounded-xl bg-rose-50 text-rose-600 shrink-0 border-rose-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <div class="flex-1">
                    <h5 class="text-xs font-bold text-gray-900">Terjadi Kesalahan</h5>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Periksa kembali form input Anda.</p>
                </div>

                <button @click="show = false" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- INFO BANNER: WILAYAH KERJA -->
        <div class="p-5 bg-gradient-to-r from-[#e8f3ec]/60 via-white to-white border border-[#195A36]/20 rounded-[22px] flex items-start gap-4 shadow-2xs">
            <div class="p-2.5 bg-[#195A36] text-white rounded-xl shrink-0 mt-0.5 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-[#195A36] uppercase tracking-wider">Ketentuan Wilayah Kerja & Akomodasi Audit</h4>
                <p class="mt-1 text-xs leading-relaxed text-gray-600">
                    Harga paket di bawah ini sudah mencakup biaya operasional untuk lokasi <strong class="font-semibold text-gray-900">Di dalam Jabodetabek</strong>. Khusus wilayah <strong class="font-semibold text-gray-900">Di luar Jabodetabek</strong>, biaya akomodasi & transportasi tim audit ditanggung oleh pihak perusahaan klien.
                </p>
            </div>
        </div>

        <!-- PRICING CARDS -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @foreach($services as $srv)
                @include('admin.master.services-partials.card', ['srv' => $srv])
            @endforeach
        </div>

        <!-- MODAL EDIT SKEMA BIAYA -->
        @include('admin.master.services-partials.modal-edit')

    </div>
</x-app-layout>