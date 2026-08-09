<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
         x-data="{
            openDrawer: false,
            isEdit: false,
            drawerTitle: 'Tambah Konsultan Baru',
            formAction: '{{ route('admin.consultant.store') }}',
            searchQuery: '',
            consultantData: {
                id: null,
                nama_konsultan: '',
                sertifikasi_no: '',
                domisili: '',
                spesialisasi_industri: 'Makanan dan Minuman',
                latitude: '',
                longitude: '',
                is_active: 1
            },
            openTambah() {
                this.isEdit = false;
                this.drawerTitle = 'Tambah Konsultan Baru';
                this.formAction = '{{ route('admin.consultant.store') }}';
                this.consultantData = { id: null, nama_konsultan: '', sertifikasi_no: '', domisili: '', spesialisasi_industri: 'Makanan dan Minuman', latitude: '', longitude: '', is_active: 1 };
                this.openDrawer = true;
            },
            openEditData(data) {
                this.isEdit = true;
                this.drawerTitle = 'Edit Profil Konsultan';
                this.formAction = '/admin/kelola-konsultan/' + data.id;
                this.consultantData = { ...data };
                this.openDrawer = true;
            }
         }">

        <!-- NOTIFIKASI SUKSES / ERROR -->
        @if(session('success'))
            <div class="p-4 bg-[#e8f3ec] border border-[#195A36]/20 rounded-[16px] text-xs font-semibold text-[#195A36] flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="font-black text-[#195A36]">✕</button>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-[16px] text-xs font-semibold text-rose-800 flex items-center justify-between shadow-sm">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="font-black text-rose-600">✕</button>
            </div>
        @endif

        <!-- INCLUDE PARTIALS -->
        @include('admin.consultant.partials.header')
        @include('admin.consultant.partials.stats')
        @include('admin.consultant.partials.table')
        @include('admin.consultant.partials.drawer')

    </div>
</x-app-layout>
