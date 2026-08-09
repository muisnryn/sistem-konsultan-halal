<div x-data="{ mobileOpen: false }">

    <!-- ====================================================================
         1. BILAH SISI KIRI DESKTOP (FIXED LEFT SIDEBAR)
         ==================================================================== -->
    <aside class="fixed top-0 left-0 z-30 flex-col hidden w-64 h-screen bg-white border-r shadow-sm border-slate-200/80 lg:flex">

        <!-- BRAND LOGO HEADER -->
        <div class="flex items-center h-16 gap-3 px-6 border-b border-slate-100 shrink-0">
            <div class="flex items-center justify-center text-xs font-black text-white shadow-sm h-9 w-9 bg-[#195A36] rounded-xl">
                @if(auth()->user()->role === 'klien')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                @elseif(auth()->user()->role === 'keuangan')
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif(in_array(auth()->user()->role, ['consultant', 'konsultan']))
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    HC
                @endif
            </div>
            <div>
                <h1 class="text-xs font-black leading-none tracking-tight uppercase text-slate-900">
                    @if(auth()->user()->role === 'klien')
                        Konsultan Halal
                    @elseif(auth()->user()->role === 'keuangan')
                        Sistem Keuangan
                    @elseif(in_array(auth()->user()->role, ['consultant', 'konsultan']))
                        Halal DSS
                    @else
                        HalalCert Admin
                    @endif
                </h1>
                <span class="text-[9px] font-extrabold text-[#195A36] block mt-1 tracking-wider uppercase">
                    @if(auth()->user()->role === 'klien')
                        Portal Pelaku Usaha
                    @elseif(auth()->user()->role === 'keuangan')
                        Finance Management
                    @elseif(in_array(auth()->user()->role, ['consultant', 'konsultan']))
                        Auditor & Pendamping
                    @else
                        Decision Support System
                    @endif
                </span>
            </div>
        </div>

        <!-- MENU NAVIGASI SIDEBAR DESKTOP -->
        <nav class="flex-1 px-4 py-5 space-y-6 overflow-y-auto text-xs font-semibold sidebar-scroll">

            {{-- 1. MENU AKTOR KLIEN --}}
            @if(auth()->user()->role === 'klien')
                @php
                    $clientUnpaidCount = \App\Models\Payment::whereHas('project', function($q) {
                        $q->where('klien_id', auth()->id());
                    })->where('status_pembayaran', '!=', \App\Enums\PaymentStatus::SUCCESS)->count();
                @endphp

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('client.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Saya</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Profil & Pengajuan</span>
                    <a href="{{ route('client.profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.profile.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v3m-6 0h6" /></svg>
                        <span>Profil Perusahaan</span>
                    </a>
                    <a href="{{ route('client.project.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.project.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Pengajuan Baru</span>
                    </a>
                    <a href="{{ route('client.documents.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.documents.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <span>Dokumen Persyaratan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Sertifikasi & Progress</span>
                    <a href="{{ route('client.certification.status') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.certification.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-1-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                        <span>Status Sertifikasi</span>
                    </a>
                    <a href="{{ route('client.consultant.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.consultant.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                        <span>Penugasan Konsultan</span>
                    </a>
                    <a href="{{ route('client.certificate.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.certificate.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        <span>Sertifikat Halal Saya</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Keuangan</span>
                    <a href="{{ route('client.payment.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.payment.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                            <span>Pembayaran</span>
                        </div>
                        @if($clientUnpaidCount > 0)
                            <span class="px-2 py-0.5 text-[10px] font-extrabold text-white bg-amber-500 rounded-full animate-pulse shrink-0">
                                {{ $clientUnpaidCount }}
                            </span>
                        @endif
                    </a>
                </div>

            {{-- 2. MENU AKTOR KEUANGAN --}}
            @elseif(auth()->user()->role === 'keuangan')
                @php
                    $financePendingCount = \App\Models\Project::where('status_proyek', \App\Enums\ProjectStatus::PENGAJUAN_SUBMITTED)->count();
                @endphp

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('finance.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Keuangan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Transaksi & Invoice</span>
                    <a href="{{ route('finance.invoices.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.invoices.*') || request()->routeIs('finance.project.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <span>Penerbitan Invoice</span>
                        </div>
                        @if($financePendingCount > 0)
                            <span class="px-2 py-0.5 text-[10px] font-extrabold text-white bg-amber-500 rounded-full animate-pulse shrink-0">
                                {{ $financePendingCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('finance.payments.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.payments.*') || request()->routeIs('finance.reports.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                        <span>Monitoring Pembayaran</span>
                    </a>
                </div>

            {{-- 3. MENU AKTOR KONSULTAN --}}
            @elseif(in_array(auth()->user()->role, ['consultant', 'konsultan']))
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('consultant.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Konsultan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Operasional Audit</span>
                    <a href="{{ route('consultant.assignments.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.assignments.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        <span>Daftar Penugasan</span>
                    </a>
                    <a href="{{ route('consultant.schedules.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.schedules.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        <span>Jadwal Audit</span>
                    </a>
                    <a href="{{ route('consultant.documents.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.documents.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Validasi Dokumen</span>
                    </a>
                    <a href="{{ route('consultant.reports.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.reports.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3h7.5M8.25 6h7.5" /></svg>
                        <span>Laporan Hasil Review</span>
                    </a>
                </div>

            {{-- 4. MENU AKTOR ADMIN --}}
            @else
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Admin</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">SPK & Pendampingan</span>
                    <a href="{{ route('admin.spk.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.spk.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Plotting Konsultan (SPK)</span>
                    </a>
                    <a href="{{ route('admin.criteria.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.criteria.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg>
                        <span>Kriteria & Bobot SPK</span>
                    </a>
                </div>

                <!-- Group Kelola Data Master -->
                <div class="space-y-1" x-data="{ openMaster: true }">
                    <button @click="openMaster = !openMaster" class="w-full flex items-center justify-between px-3 py-1 text-slate-400 text-[10px] uppercase font-extrabold tracking-widest focus:outline-none">
                        <span>Kelola Data Master</span>
                        <svg class="w-3 h-3 transition-transform duration-200 transform" :class="{'rotate-180': openMaster}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="openMaster" class="pt-1 space-y-1">
                        <a href="{{ route('admin.consultant.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.consultant.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span>Data Konsultan</span>
                        </a>

                        <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.user.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span>Data Pengguna</span>
                        </a>

                        <a href="{{ route('admin.service.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.service.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Jenis Layanan</span>
                        </a>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Sertifikasi</span>
                    <a href="{{ route('admin.certificate.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.certificate.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <span>Unggah Sertifikat Halal</span>
                    </a>
                </div>
            @endif

        </nav>

        <!-- AKSI KELUAR DESKTOP -->
        <div class="p-4 border-t border-slate-100 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ====================================================================
         2. DRAWER SIDEBAR MOBILE (ANIMATED OVERLAY - DISEMPURNAKAN)
         ==================================================================== -->
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
         @click="mobileOpen = false"
         x-cloak></div>

    <aside x-show="mobileOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed top-0 left-0 z-50 flex flex-col justify-between w-64 h-full bg-white shadow-2xl lg:hidden"
           x-cloak>

        <!-- HEADER MOBILE DRAWER -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-slate-100 shrink-0">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center text-xs font-black text-white shadow-sm h-9 w-9 bg-[#195A36] rounded-xl">
                    HC
                </div>
                <div>
                    <h1 class="text-xs font-black leading-none tracking-tight uppercase text-slate-900">HalalCert Portal</h1>
                    <span class="text-[9px] font-extrabold text-[#195A36] block mt-1 tracking-wider uppercase">Navigation Menu</span>
                </div>
            </div>
            <button @click="mobileOpen = false" class="p-1.5 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- KONTEN MENU MOBILE (DISAMAKAN PERSIS DENGAN DESKTOP SIDEBAR) -->
        <nav class="flex-1 px-4 py-5 space-y-6 overflow-y-auto text-xs font-semibold sidebar-scroll">

            {{-- 1. MENU AKTOR KLIEN --}}
            @if(auth()->user()->role === 'klien')
                @php
                    $clientUnpaidCountMobile = \App\Models\Payment::whereHas('project', function($q) {
                        $q->where('klien_id', auth()->id());
                    })->where('status_pembayaran', '!=', \App\Enums\PaymentStatus::SUCCESS)->count();
                @endphp

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('client.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Saya</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Profil & Pengajuan</span>
                    <a href="{{ route('client.profile.edit') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.profile.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v3m-6 0h6" /></svg>
                        <span>Profil Perusahaan</span>
                    </a>
                    <a href="{{ route('client.project.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.project.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Pengajuan Baru</span>
                    </a>
                    <a href="{{ route('client.documents.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.documents.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <span>Dokumen Persyaratan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Sertifikasi & Progress</span>
                    <a href="{{ route('client.certification.status') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.certification.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-1-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                        <span>Status Sertifikasi</span>
                    </a>
                    <a href="{{ route('client.consultant.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.consultant.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                        <span>Penugasan Konsultan</span>
                    </a>
                    <a href="{{ route('client.certificate.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.certificate.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        <span>Sertifikat Halal Saya</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Keuangan</span>
                    <a href="{{ route('client.payment.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('client.payment.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                            <span>Pembayaran</span>
                        </div>
                        @if($clientUnpaidCountMobile > 0)
                            <span class="px-2 py-0.5 text-[10px] font-extrabold text-white bg-amber-500 rounded-full animate-pulse shrink-0">
                                {{ $clientUnpaidCountMobile }}
                            </span>
                        @endif
                    </a>
                </div>

            {{-- 2. MENU AKTOR KEUANGAN --}}
            @elseif(auth()->user()->role === 'keuangan')
                @php
                    $financePendingCountMobile = \App\Models\Project::where('status_proyek', \App\Enums\ProjectStatus::PENGAJUAN_SUBMITTED)->count();
                @endphp

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('finance.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Keuangan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Transaksi & Invoice</span>
                    <a href="{{ route('finance.invoices.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.invoices.*') || request()->routeIs('finance.project.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            <span>Penerbitan Invoice</span>
                        </div>
                        @if($financePendingCountMobile > 0)
                            <span class="px-2 py-0.5 text-[10px] font-extrabold text-white bg-amber-500 rounded-full animate-pulse shrink-0">
                                {{ $financePendingCountMobile }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('finance.payments.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('finance.payments.*') || request()->routeIs('finance.reports.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                        <span>Monitoring Pembayaran</span>
                    </a>
                </div>

            {{-- 3. MENU AKTOR KONSULTAN --}}
            @elseif(in_array(auth()->user()->role, ['consultant', 'konsultan']))
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('consultant.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Konsultan</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Operasional Audit</span>
                    <a href="{{ route('consultant.assignments.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.assignments.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        <span>Daftar Penugasan</span>
                    </a>
                    <a href="{{ route('consultant.schedules.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.schedules.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        <span>Jadwal Audit</span>
                    </a>
                    <a href="{{ route('consultant.documents.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.documents.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Validasi Dokumen</span>
                    </a>
                    <a href="{{ route('consultant.reports.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('consultant.reports.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3h7.5M8.25 6h7.5" /></svg>
                        <span>Laporan Hasil Review</span>
                    </a>
                </div>

            {{-- 4. MENU AKTOR ADMIN --}}
            @else
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Utama</span>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        <span>Dashboard Admin</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">SPK & Pendampingan</span>
                    <a href="{{ route('admin.spk.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.spk.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Plotting Konsultan (SPK)</span>
                    </a>
                    <a href="{{ route('admin.criteria.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.criteria.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg>
                        <span>Kriteria & Bobot SPK</span>
                    </a>
                </div>

                <!-- Group Kelola Data Master Mobile -->
                <div class="space-y-1" x-data="{ openMasterMobile: true }">
                    <button @click="openMasterMobile = !openMasterMobile" class="w-full flex items-center justify-between px-3 py-1 text-slate-400 text-[10px] uppercase font-extrabold tracking-widest focus:outline-none">
                        <span>Kelola Data Master</span>
                        <svg class="w-3 h-3 transition-transform duration-200 transform" :class="{'rotate-180': openMasterMobile}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <div x-show="openMasterMobile" class="pt-1 space-y-1">
                        <a href="{{ route('admin.consultant.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.consultant.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                            <span>Data Konsultan</span>
                        </a>

                        <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.user.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <span>Data Pengguna</span>
                        </a>

                        <a href="{{ route('admin.service.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.service.*') ? 'text-[#195A36] bg-[#e8f3ec] font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Jenis Layanan</span>
                        </a>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-2">Sertifikasi</span>
                    <a href="{{ route('admin.certificate.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.certificate.*') ? 'bg-[#e8f3ec] text-[#195A36] font-extrabold border-r-4 border-[#195A36]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <span>Unggah Sertifikat Halal</span>
                    </a>
                </div>
            @endif

        </nav>

        <!-- AKSI KELUAR MOBILE -->
        <div class="p-4 border-t border-slate-100 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3.5 py-2.5 text-xs font-bold text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ====================================================================
         3. BAR NAVIGASI ATAS (TOPBAR)
         ==================================================================== -->
    <header class="fixed top-0 right-0 z-20 w-full h-16 transition-all duration-300 border-b bg-white/90 backdrop-blur-md border-slate-200/80 lg:pl-64">
        <div class="flex items-center justify-between h-full px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- SISI KIRI TOPBAR -->
            <div class="flex items-center gap-3">
                <button @click="mobileOpen = !mobileOpen" class="p-2 border lg:hidden rounded-xl bg-slate-50 border-slate-200 text-slate-600 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
                <div class="hidden sm:block">
                    <span class="block text-xs font-black tracking-tight uppercase text-slate-800">
                        Sistem Pendukung Keputusan Sertifikasi Halal
                    </span>
                    <span class="text-[10px] font-semibold text-slate-400 block leading-none">
                        PT Konsultan Halal Indonesia
                    </span>
                </div>
            </div>

            <!-- SISI KANAN TOPBAR (PROFIL DROPDOWN) -->
            <div class="flex items-center gap-4">
                <div class="pl-4">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-3 p-1 text-left transition focus:outline-none group rounded-xl hover:bg-slate-50">
                                <div class="hidden text-right md:block">
                                    <div class="text-xs font-extrabold leading-none transition text-slate-900 group-hover:text-[#195A36]">
                                        {{ Auth::user()->name ?? 'Pengguna' }}
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-400 mt-1 leading-none uppercase">
                                        @if(Auth::user()->role === 'klien')
                                            {{ Auth::user()->companyProfile->nama_perusahaan ?? 'Pelaku Usaha' }}
                                        @elseif(Auth::user()->role === 'keuangan')
                                            Manajer Keuangan
                                        @elseif(in_array(Auth::user()->role, ['consultant', 'konsultan']))
                                            Konsultan Pendamping
                                        @else
                                            Administrator System
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center justify-center w-8 h-8 text-xs font-black text-white transition border shadow-sm rounded-xl bg-slate-900 border-slate-900 group-hover:bg-[#195A36] group-hover:border-[#195A36]">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'US', 0, 2)) }}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-xs font-bold text-rose-600 hover:bg-rose-50">
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

        </div>
    </header>
</div>