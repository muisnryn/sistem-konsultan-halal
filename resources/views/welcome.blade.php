<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SPK Sertifikasi Halal') }} — Halal Compliance Interface</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --primary:        #107C41;
            --primary-dark:   #0D6434;
            --primary-tint:   #E6F4EC;
            --secondary:      #0D9488;
            --secondary-dark: #0B7A70;
            --secondary-tint: #E6F5F3;
            --tertiary:       #0369A1;
            --tertiary-dark:  #035682;
            --tertiary-tint:  #E6F0F8;
            --neutral:        #64748B;
            --neutral-900:    #0F172A;
            --bg:             #F0F5FA;
            --border:         #E2E8F0;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--neutral-900);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        [x-cloak] { display: none !important; }
        ::selection { background: var(--primary); color: white; }
        *:focus-visible { outline: 2px solid var(--tertiary); outline-offset: 2px; border-radius: 4px; }

        /* ── Hover-lift micro-interaction (all cards) ── */
        .lift {
            transition: transform 0.22s cubic-bezier(.22,1,.36,1), box-shadow 0.22s cubic-bezier(.22,1,.36,1);
            will-change: transform;
        }
        .lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px -8px rgba(16,124,65,.12), 0 4px 12px -2px rgba(0,0,0,.06);
        }

        /* ── Range slider track ── */
        input[type=range] {
            -webkit-appearance: none; appearance: none;
            height: 5px; border-radius: 9999px;
            background: var(--border); cursor: pointer; width: 100%;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none; appearance: none;
            width: 18px; height: 18px; border-radius: 50%;
            background: var(--primary); border: 3px solid white;
            box-shadow: 0 0 0 1px var(--primary), 0 2px 6px rgba(16,124,65,.3);
            transition: transform .15s;
        }
        input[type=range]::-webkit-slider-thumb:hover { transform: scale(1.18); }
        input[type=range].sec::-webkit-slider-thumb { background: var(--secondary); box-shadow: 0 0 0 1px var(--secondary), 0 2px 6px rgba(13,148,136,.3); }
        input[type=range].ter::-webkit-slider-thumb { background: var(--tertiary); box-shadow: 0 0 0 1px var(--tertiary), 0 2px 6px rgba(3,105,161,.3); }

        /* ── Carousel ── */
        .testi-track {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 4px;
        }
        .testi-track::-webkit-scrollbar { display: none; }
        .testi-card {
            flex: 0 0 calc(min(340px, 90vw));
            scroll-snap-align: start;
        }

        /* ── FAQ ── */
        .faq-body {
            overflow: hidden;
            max-height: 0;
            transition: max-height .38s cubic-bezier(.22,1,.36,1), opacity .28s ease;
            opacity: 0;
        }
        .faq-item.open .faq-body { max-height: 320px; opacity: 1; }
        .faq-chevron { transition: transform .3s cubic-bezier(.22,1,.36,1); }
        .faq-item.open .faq-chevron { transform: rotate(180deg); }

        /* ── CTA gradient ── */
        .cta-bg {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 45%, var(--secondary) 100%);
        }

        /* ── Comparison table ── */
        .comp-old  { color: #EF4444; }
        .comp-new  { color: var(--primary); }

        /* ── Scroll indicator dots ── */
        .dot { width:8px; height:8px; border-radius:50%; background: var(--border); transition: background .2s, transform .2s; cursor: pointer; }
        .dot.active { background: var(--primary); transform: scale(1.25); }

        /* ── Section spacing helpers ── */
        section { position: relative; }

        /* ── Stat counter ── */
        .stat-num { font-variant-numeric: tabular-nums; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            html { scroll-behavior: auto !important; }
            .lift:hover { transform: none; box-shadow: none; }
        }
    </style>
</head>
<body>

<!-- ======================================================================
     1. NAVBAR
     ====================================================================== -->
<nav
    x-data="{ mobileMenu: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 24"
    :class="scrolled ? 'bg-white/90 border-slate-200 backdrop-blur-md shadow-sm' : 'bg-transparent border-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b"
>
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-[var(--primary)] text-white flex items-center justify-center shadow-md shadow-[var(--primary)]/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="leading-none">
                    <span class="block text-sm font-black tracking-wide uppercase text-slate-900">{{ config('app.name', 'HALAL COMPLIANCE') }}</span>
                    <span class="text-[10px] font-bold text-[var(--secondary)] tracking-widest uppercase block mt-1">Sistem Pendukung Keputusan</span>
                </div>
            </a>

            <div class="items-center hidden gap-7 text-xs font-bold tracking-wide md:flex text-[var(--neutral)]">
                <a href="#cara-kerja"  class="transition hover:text-[var(--primary)]">Cara Kerja</a>
                <a href="#spk-info"    class="transition hover:text-[var(--primary)]">Metode SPK</a>
                <a href="#simulator"   class="transition hover:text-[var(--primary)]">Simulator</a>
                <a href="#layanan"     class="transition hover:text-[var(--primary)]">Layanan</a>
                <a href="#testimoni"   class="transition hover:text-[var(--primary)]">Testimoni</a>
                <a href="#faq"         class="transition hover:text-[var(--primary)]">FAQ</a>
            </div>

            <div class="items-center hidden gap-3 md:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-md shadow-[var(--primary)]/20 transition">Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2.5 text-xs font-bold text-[var(--tertiary)] hover:text-[var(--tertiary-dark)] transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-md shadow-[var(--primary)]/20 transition">Daftar Akun</a>
                        @endif
                    @endauth
                @endif
            </div>

            <button @click="mobileMenu = !mobileMenu" class="p-2 border rounded-xl md:hidden bg-slate-100 border-slate-200 text-slate-700">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileMenu" x-cloak class="px-4 pt-2 pb-6 space-y-3 text-xs font-bold bg-white border-b shadow-lg md:hidden border-slate-200">
        <a href="#cara-kerja" @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">Cara Kerja</a>
        <a href="#spk-info"   @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">Metode SPK</a>
        <a href="#simulator"  @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">Simulator</a>
        <a href="#layanan"    @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">Layanan</a>
        <a href="#testimoni"  @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">Testimoni</a>
        <a href="#faq"        @click="mobileMenu=false" class="block py-2 text-[var(--neutral)]">FAQ</a>
        <div class="flex flex-col gap-2 pt-3 border-t border-slate-100">
            @auth
                <a href="{{ url('/dashboard') }}" class="w-full py-2.5 text-center bg-[var(--primary)] text-white rounded-xl font-bold">Buka Dashboard</a>
            @else
                <a href="{{ route('login') }}"    class="w-full py-2.5 text-center bg-slate-100 text-slate-800 rounded-xl">Masuk</a>
                <a href="{{ route('register') }}" class="w-full py-2.5 text-center bg-[var(--primary)] text-white rounded-xl font-bold">Daftar Akun</a>
            @endauth
        </div>
    </div>
</nav>


<!-- ======================================================================
     2. HERO
     ====================================================================== -->
<section class="relative pt-36 pb-20 overflow-hidden">
    <!-- Subtle grid bg -->
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(var(--border) 1px,transparent 1px),linear-gradient(90deg,var(--border) 1px,transparent 1px);background-size:48px 48px;opacity:.35;"></div>
    <!-- Radial glow -->
    <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full pointer-events-none" style="background:radial-gradient(circle, rgba(16,124,65,.07) 0%, transparent 70%);"></div>

    <div class="relative z-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-12">

            <div id="hero-left" class="space-y-6 text-center lg:col-span-6 lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[var(--primary-tint)] border border-[var(--primary)]/20 text-[var(--primary-dark)] text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-[var(--primary)] animate-pulse"></span>
                    <span>Metode PROMETHEE II · Analisis Multi-Kriteria</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Konsultan halal terbaik, dipilih dengan <span class="text-[var(--primary)]">angka</span> — bukan kebetulan.
                </h1>

                <p class="text-xs sm:text-sm text-[var(--neutral)] font-normal leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Setiap konsultan dinilai dari harga, pengalaman, dan jarak lokasi, lalu diperingkat lewat metode PROMETHEE II — supaya rekomendasi yang Anda terima bisa dijelaskan, bukan sekadar ditebak.
                </p>

                <div class="flex flex-col items-center justify-center gap-4 pt-2 sm:flex-row lg:justify-start">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="lift w-full sm:w-auto px-7 py-3.5 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-lg shadow-[var(--primary)]/20 transition text-center">Mulai Sekarang</a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="lift w-full sm:w-auto px-7 py-3.5 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-lg shadow-[var(--primary)]/20 transition text-center">Mulai Pengajuan</a>
                        @endif
                    @endauth
                    <a href="#cara-kerja" class="lift w-full sm:w-auto px-7 py-3.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-bold text-xs rounded-xl transition text-center shadow-sm">Lihat Cara Kerja</a>
                </div>

                <p class="pt-1 text-[11px] text-[var(--neutral)] font-medium">Dipercaya pelaku usaha dari skala mikro hingga industri.</p>
            </div>

            <!-- Hero matrix visual -->
            <div id="hero-matrix" class="lg:col-span-6">
                <div class="relative bg-[var(--neutral-900)] rounded-3xl border border-slate-700/50 shadow-2xl p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-white/70">Simulasi Peringkat</span>
                        <span class="text-[10px] font-bold text-white/40">PROMETHEE II</span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-4 py-3 border-b matrix-row border-white/10">
                            <div class="flex-1 space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wide text-white/60">Konsultan A</span>
                                <div class="flex gap-1.5">
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--primary)]"   style="width:78%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--secondary)]" style="width:65%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--tertiary)]" style="width:82%"></div></div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-bold text-white">+0.42</div>
                                <div class="matrix-rank inline-flex items-center justify-center w-5 h-5 rounded-full bg-[var(--primary)] text-white text-[10px] font-bold mt-1">1</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 py-3 border-b matrix-row border-white/10">
                            <div class="flex-1 space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wide text-white/60">Konsultan B</span>
                                <div class="flex gap-1.5">
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--primary)]"   style="width:58%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--secondary)]" style="width:71%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--tertiary)]" style="width:54%"></div></div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-bold text-white/70">+0.18</div>
                                <div class="matrix-rank inline-flex items-center justify-center w-5 h-5 rounded-full bg-transparent border border-white/40 text-white/70 text-[10px] font-bold mt-1">2</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 py-3 matrix-row">
                            <div class="flex-1 space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wide text-white/60">Konsultan C</span>
                                <div class="flex gap-1.5">
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--primary)]"   style="width:40%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--secondary)]" style="width:35%"></div></div>
                                    <div class="h-1.5 flex-1 rounded-full bg-white/10 overflow-hidden"><div class="h-full rounded-full matrix-bar bg-[var(--tertiary)]" style="width:48%"></div></div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-bold text-white/40">−0.15</div>
                                <div class="matrix-rank inline-flex items-center justify-center w-5 h-5 rounded-full bg-transparent border border-white/20 text-white/40 text-[10px] font-bold mt-1">3</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-5 pt-4 border-t border-white/10 text-[9px] font-bold uppercase tracking-wide text-white/50">
                        <span class="flex items-center gap-1.5"><i class="w-2 h-2 rounded-full bg-[var(--primary)]   inline-block"></i>Harga</span>
                        <span class="flex items-center gap-1.5"><i class="w-2 h-2 rounded-full bg-[var(--secondary)] inline-block"></i>Pengalaman</span>
                        <span class="flex items-center gap-1.5"><i class="w-2 h-2 rounded-full bg-[var(--tertiary)]  inline-block"></i>Jarak</span>
                    </div>
                </div>
                <p class="mt-3 text-center text-[10px] text-[var(--neutral)] font-medium">*Ilustrasi perhitungan — hasil aktual mengikuti data proyek Anda.</p>
            </div>

        </div>
    </div>
</section>


<!-- ======================================================================
     3. STATS — angka menghitung naik saat viewport
     ====================================================================== -->
<section id="stats" class="py-14 bg-[var(--neutral-900)]">
    <div class="grid grid-cols-2 gap-8 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:grid-cols-4">
        <div class="text-center">
            <div class="flex items-center justify-center gap-0.5 text-3xl font-black text-white sm:text-4xl stat-num">
                <span class="stat-counter" data-target="120">0</span><span class="text-[var(--primary)]">+</span>
            </div>
            <p class="mt-2 text-[11px] font-bold uppercase tracking-wide text-white/50">Konsultan Terverifikasi</p>
        </div>
        <div class="text-center">
            <div class="flex items-center justify-center gap-0.5 text-3xl font-black text-white sm:text-4xl stat-num">
                <span class="stat-counter" data-target="3">0</span><span class="text-[var(--secondary)]">hr</span>
            </div>
            <p class="mt-2 text-[11px] font-bold uppercase tracking-wide text-white/50">Rata-rata Waktu Rekomendasi</p>
        </div>
        <div class="text-center">
            <div class="flex items-center justify-center gap-0.5 text-3xl font-black text-white sm:text-4xl stat-num">
                <span class="stat-counter" data-target="98">0</span><span class="text-[var(--tertiary)]">%</span>
            </div>
            <p class="mt-2 text-[11px] font-bold uppercase tracking-wide text-white/50">Tingkat Kepuasan Klien</p>
        </div>
        <div class="text-center">
            <div class="flex items-center justify-center gap-0.5 text-3xl font-black text-white sm:text-4xl stat-num">
                <span class="stat-counter" data-target="15">0</span><span class="text-[var(--primary)]">+</span>
            </div>
            <p class="mt-2 text-[11px] font-bold uppercase tracking-wide text-white/50">Kota Terjangkau</p>
        </div>
    </div>
</section>


<!-- ======================================================================
     4. CARA KERJA
     ====================================================================== -->
<section id="cara-kerja" class="relative py-20 bg-white border-y border-slate-200/80 scroll-mt-24">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto mb-16 space-y-2 text-center">
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Cara Kerja Sistem Kami</h2>
            <p class="text-xs sm:text-sm text-[var(--neutral)] font-normal leading-relaxed">Proses transparan dan terukur untuk memastikan Anda mendapatkan pendampingan terbaik menuju sertifikasi halal.</p>
        </div>

        <div class="relative max-w-4xl mx-auto">
            <svg class="absolute left-0 right-0 hidden w-full h-1 -translate-y-1/2 md:block top-8" viewBox="0 0 100 2" preserveAspectRatio="none">
                <line x1="16" y1="1" x2="84" y2="1" stroke="var(--border)" stroke-width="0.6"/>
                <line id="cara-kerja-line" x1="16" y1="1" x2="84" y2="1" stroke="var(--primary)" stroke-width="0.6" stroke-dasharray="68" stroke-dashoffset="68"/>
            </svg>
            <div class="relative grid grid-cols-1 gap-8 text-center md:grid-cols-3">
                <div class="p-6 space-y-4 bg-white border shadow-sm gsap-step lift md:bg-transparent md:p-0 rounded-2xl md:border-none border-slate-100 md:shadow-none">
                    <div class="w-16 h-16 rounded-full bg-[var(--tertiary-tint)] text-[var(--tertiary)] flex items-center justify-center mx-auto shadow-md border-2 border-white">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">1. Lengkapi Profil Usaha</h3>
                    <p class="text-xs text-[var(--neutral)] leading-relaxed max-w-xs mx-auto">Masukkan skala usaha, jenis produk, dan target sertifikasi. Dua menit, tanpa dokumen fisik.</p>
                </div>
                <div class="p-6 space-y-4 bg-white border shadow-sm gsap-step lift md:bg-transparent md:p-0 rounded-2xl md:border-none border-slate-100 md:shadow-none">
                    <div class="w-16 h-16 rounded-full bg-[var(--primary)] text-white flex items-center justify-center mx-auto shadow-lg shadow-[var(--primary)]/30 border-2 border-white">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">2. Analisis PROMETHEE II</h3>
                    <p class="text-xs text-[var(--neutral)] leading-relaxed max-w-xs mx-auto">Algoritma kami membandingkan setiap konsultan aktif berdasarkan kriteria yang berlaku.</p>
                </div>
                <div class="p-6 space-y-4 bg-white border shadow-sm gsap-step lift md:bg-transparent md:p-0 rounded-2xl md:border-none border-slate-100 md:shadow-none">
                    <div class="w-16 h-16 rounded-full bg-[var(--tertiary-tint)] text-[var(--tertiary)] flex items-center justify-center mx-auto shadow-md border-2 border-white">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">3. Pilih Konsultan Terbaik</h3>
                    <p class="text-xs text-[var(--neutral)] leading-relaxed max-w-xs mx-auto">Terima peringkat lengkap dengan alasan setiap skor, lalu tentukan konsultan pilihan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     5. CARA LAMA vs SPK — value proposition comparison
     ====================================================================== -->
<section id="perbandingan" class="py-20 scroll-mt-24" style="background:var(--bg)">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto mb-16 space-y-2 text-center">
            <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-[var(--primary)]">Mengapa Harus Berbeda?</span>
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Cara Lama vs Sistem SPK Kami</h2>
            <p class="text-xs sm:text-sm text-[var(--neutral)] leading-relaxed">Bukan sekedar digitalisasi — ini perubahan cara berpikir dalam memilih konsultan.</p>
        </div>

        <div class="grid max-w-5xl grid-cols-1 gap-6 mx-auto md:grid-cols-2">
            <!-- Cara Lama -->
            <div class="p-8 border rounded-3xl bg-white border-red-100 space-y-5 lift">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <h3 class="text-sm font-black text-slate-900">Cara Lama — Manual & Subyektif</h3>
                </div>
                <ul class="space-y-3 text-xs text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Pemilihan berdasarkan kenalan atau rekomendasi tidak terstruktur</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Tidak ada perbandingan antar konsultan yang terukur</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Prosedur dan waktu tidak transparan ke klien</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Kriteria seleksi bisa berubah-ubah tergantung staf</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Bottleneck di Level 3 — penentuan konsultan memakan waktu berhari-hari</span>
                    </li>
                </ul>
            </div>

            <!-- SPK -->
            <div class="p-8 border-2 rounded-3xl bg-white border-[var(--primary)]/30 space-y-5 lift relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full -translate-y-1/2 translate-x-1/2" style="background:radial-gradient(circle, rgba(16,124,65,.08) 0%, transparent 70%);"></div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[var(--primary-tint)] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[var(--primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-sm font-black text-slate-900">SPK PROMETHEE II — Terukur & Transparan</h3>
                </div>
                <ul class="space-y-3 text-xs text-slate-600">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[var(--primary)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Peringkat objektif dari 6 kriteria terbobot yang sudah divalidasi</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[var(--primary)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Setiap skor bisa ditelusuri hingga level perbandingan berpasangan</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[var(--primary)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Klien dan admin memonitor 10 level progres secara real-time</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[var(--primary)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Bobot kriteria tersimpan di database — konsisten antar sesi</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[var(--primary)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span>Level 3 yang sebelumnya 3–5 hari kini terselesaikan dalam hitungan jam</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     6. METODE SPK
     ====================================================================== -->
<section id="spk-info" class="py-20 bg-white border-y border-slate-200/80 scroll-mt-24">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid items-start grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="space-y-4 lg:col-span-5">
                <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-[var(--primary)]">Bagaimana Sistem Menilai</span>
                <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Metode PROMETHEE II, Disederhanakan</h2>
                <p class="text-xs sm:text-sm text-[var(--neutral)] leading-relaxed">Setiap konsultan dibandingkan berpasangan pada tiap kriteria, menghasilkan skor preferensi. Hasil akhirnya adalah peringkat yang bisa dipertanggungjawabkan — bukan sekadar rating bintang.</p>
                <div class="inline-block p-5 rounded-2xl bg-[var(--neutral-900)]">
                    <p class="text-base font-bold text-white">φ(a) = φ⁺(a) − φ⁻(a)</p>
                    <p class="mt-2 text-[10px] font-bold uppercase tracking-wide text-white/50 max-w-xs">Net flow = keunggulan dikurangi kekurangan, dibanding semua konsultan lain</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 lg:col-span-7">
                <div class="p-6 border rounded-2xl bg-[var(--primary-tint)] border-[var(--primary)]/15 lift">
                    <span class="text-[10px] font-black text-[var(--primary-dark)]">C1 · HARGA</span>
                    <p class="mt-3 text-xs text-[var(--neutral)] leading-relaxed">Total biaya pendampingan, dibandingkan relatif terhadap konsultan lain di kategori sejenis.</p>
                </div>
                <div class="p-6 border rounded-2xl bg-[var(--secondary-tint)] border-[var(--secondary)]/15 lift">
                    <span class="text-[10px] font-black text-[var(--secondary-dark)]">C2 · PENGALAMAN</span>
                    <p class="mt-3 text-xs text-[var(--neutral)] leading-relaxed">Jumlah proyek selesai dan lama waktu konsultan aktif menangani sertifikasi halal.</p>
                </div>
                <div class="p-6 border rounded-2xl bg-[var(--tertiary-tint)] border-[var(--tertiary)]/15 lift">
                    <span class="text-[10px] font-black text-[var(--tertiary-dark)]">C3 · JARAK</span>
                    <p class="mt-3 text-xs text-[var(--neutral)] leading-relaxed">Jarak tempuh riil ke lokasi usaha Anda, dihitung dengan formula Haversine.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     7. SIMULATOR BOBOT — interactive PROMETHEE weight slider
     ====================================================================== -->
<section id="simulator" class="py-20 scroll-mt-24" style="background:var(--bg)">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto mb-12 space-y-2 text-center">
            <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-[var(--secondary)]">Coba Sendiri</span>
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Simulator Bobot Kriteria</h2>
            <p class="text-xs sm:text-sm text-[var(--neutral)] leading-relaxed">Geser bobot setiap kriteria dan lihat bagaimana peringkat konsultan berubah secara langsung.</p>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- Controls -->
                <div class="p-8 space-y-7 border-b lg:border-b-0 lg:border-r border-slate-100">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-black uppercase tracking-wide text-[var(--primary)]">C1 · Harga</label>
                            <span id="w1-label" class="text-xs font-bold text-slate-700 tabular-nums">40%</span>
                        </div>
                        <input id="w1" type="range" min="0" max="100" value="40" class="w-full" oninput="updateSimulator()">
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-black uppercase tracking-wide text-[var(--secondary)]">C2 · Pengalaman</label>
                            <span id="w2-label" class="text-xs font-bold text-slate-700 tabular-nums">35%</span>
                        </div>
                        <input id="w2" type="range" min="0" max="100" value="35" class="w-full sec" oninput="updateSimulator()">
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-black uppercase tracking-wide text-[var(--tertiary)]">C3 · Jarak</label>
                            <span id="w3-label" class="text-xs font-bold text-slate-700 tabular-nums">25%</span>
                        </div>
                        <input id="w3" type="range" min="0" max="100" value="25" class="w-full ter" oninput="updateSimulator()">
                    </div>

                    <div class="pt-1 flex items-center gap-2">
                        <div id="weight-total-bar" class="flex-1 h-2 rounded-full overflow-hidden bg-slate-100 flex">
                            <div id="bar-w1" class="h-full bg-[var(--primary)] transition-all duration-300" style="width:40%"></div>
                            <div id="bar-w2" class="h-full bg-[var(--secondary)] transition-all duration-300" style="width:35%"></div>
                            <div id="bar-w3" class="h-full bg-[var(--tertiary)] transition-all duration-300" style="width:25%"></div>
                        </div>
                        <span id="total-label" class="text-[11px] font-bold text-slate-500 tabular-nums shrink-0">= 100%</span>
                    </div>
                    <p class="text-[10px] text-[var(--neutral)]">Total bobot tidak perlu 100% — sistem menormalisasi otomatis.</p>
                </div>

                <!-- Live ranking -->
                <div class="p-8">
                    <p class="text-[10px] font-black uppercase tracking-widest text-[var(--neutral)] mb-5">Peringkat Sekarang</p>
                    <div id="sim-ranking" class="space-y-3"></div>
                    <p class="mt-5 text-[10px] text-[var(--neutral)] leading-relaxed">*Data konsultan dalam simulasi ini menggunakan nilai acuan studi kasus. Hasil aktual bergantung pada data konsultan yang tersedia di sistem.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     8. LAYANAN
     ====================================================================== -->
<section id="layanan" class="py-20 bg-white border-y border-slate-200/80 scroll-mt-24">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto mb-16 space-y-2 text-center">
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Pilihan Layanan Pendampingan</h2>
            <p class="text-xs sm:text-sm text-[var(--neutral)] font-normal leading-relaxed">Pilih paket yang sesuai dengan skala bisnis dan kebutuhan kepatuhan Anda.</p>
        </div>
        <div class="grid items-stretch max-w-6xl grid-cols-1 gap-8 mx-auto md:grid-cols-3">
            <div class="flex flex-col justify-between p-8 space-y-6 bg-white border shadow-sm gsap-card lift rounded-3xl border-slate-200/80">
                <div class="space-y-4">
                    <div><h3 class="text-lg font-bold text-slate-900">Starter</h3><p class="text-xs text-[var(--neutral)]">UMKM & usaha mikro</p></div>
                    <hr class="border-slate-100">
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Akses dashboard dasar</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Rekomendasi 3 konsultan</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Panduan standar dasar</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="lift w-full py-3 bg-white hover:bg-slate-50 text-[var(--primary)] border border-[var(--primary)] font-bold text-xs rounded-xl transition text-center shadow-sm">Pilih Starter</a>
            </div>
            <div class="gsap-card lift bg-white p-8 rounded-3xl border-2 border-[var(--primary)] shadow-xl relative flex flex-col justify-between space-y-6 md:-translate-y-2">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[var(--primary)] text-white text-[10px] font-black uppercase tracking-wider px-3.5 py-1 rounded-full shadow-md">Rekomendasi</div>
                <div class="pt-2 space-y-4">
                    <div><h3 class="text-lg font-bold text-slate-900">Professional</h3><p class="text-xs text-[var(--neutral)]">Usaha menengah</p></div>
                    <hr class="border-slate-100">
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--primary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Akses dashboard penuh</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--primary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Laporan analisis PROMETHEE II</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--primary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Pendampingan audit lapangan</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--primary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Dukungan prioritas</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="w-full py-3 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-md shadow-[var(--primary)]/20 transition text-center">Pilih Professional</a>
            </div>
            <div class="flex flex-col justify-between p-8 space-y-6 bg-white border shadow-sm gsap-card lift rounded-3xl border-slate-200/80">
                <div class="space-y-4">
                    <div><h3 class="text-lg font-bold text-slate-900">Enterprise</h3><p class="text-xs text-[var(--neutral)]">Industri & manufaktur</p></div>
                    <hr class="border-slate-100">
                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Manajemen multi-lokasi</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Analisis kriteria khusus</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Konsultan dedicated</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-[var(--secondary)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>Garansi kepatuhan</li>
                    </ul>
                </div>
                <a href="#spk-info" class="lift w-full py-3 bg-white hover:bg-slate-50 text-[var(--primary)] border border-[var(--primary)] font-bold text-xs rounded-xl transition text-center shadow-sm">Hubungi Sales</a>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     9. PERAN
     ====================================================================== -->
<section id="peran" class="py-20 scroll-mt-24" style="background:var(--bg)">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-2 text-center mb-14">
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Peran & Akses Pengguna</h2>
            <p class="text-xs sm:text-sm text-[var(--neutral)] font-normal">Satu platform untuk empat pemangku kepentingan sertifikasi.</p>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="p-6 space-y-2 border gsap-card lift bg-white border-slate-200/70 rounded-2xl">
                <span class="px-2.5 py-1 bg-[var(--primary)]/10 text-[var(--primary)] rounded-md text-[10px] font-black uppercase">Klien</span>
                <h4 class="pt-1 text-sm font-bold text-slate-900">Pelaku Usaha</h4>
                <p class="text-xs text-[var(--neutral)] leading-relaxed">Mengisi profil usaha, memilih layanan, dan memantau progres sertifikasi.</p>
            </div>
            <div class="p-6 space-y-2 border gsap-card lift bg-white border-slate-200/70 rounded-2xl">
                <span class="px-2.5 py-1 bg-[var(--secondary)]/10 text-[var(--secondary)] rounded-md text-[10px] font-black uppercase">Konsultan</span>
                <h4 class="pt-1 text-sm font-bold text-slate-900">Konsultan Pendamping</h4>
                <p class="text-xs text-[var(--neutral)] leading-relaxed">Menerima penugasan, memverifikasi dokumen, dan menjalankan audit.</p>
            </div>
            <div class="p-6 space-y-2 border gsap-card lift bg-white border-slate-200/70 rounded-2xl">
                <span class="px-2.5 py-1 bg-[var(--tertiary)]/10 text-[var(--tertiary)] rounded-md text-[10px] font-black uppercase">Finance</span>
                <h4 class="pt-1 text-sm font-bold text-slate-900">Tim Keuangan</h4>
                <p class="text-xs text-[var(--neutral)] leading-relaxed">Menetapkan harga, menerbitkan invoice, dan mengonfirmasi pembayaran.</p>
            </div>
            <div class="p-6 space-y-2 border gsap-card lift bg-white border-slate-200/70 rounded-2xl">
                <span class="px-2.5 py-1 bg-[var(--neutral-900)]/10 text-[var(--neutral-900)] rounded-md text-[10px] font-black uppercase">Admin</span>
                <h4 class="pt-1 text-sm font-bold text-slate-900">Administrator</h4>
                <p class="text-xs text-[var(--neutral)] leading-relaxed">Mengelola kriteria SPK, master konsultan, dan sertifikat resmi.</p>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     10. TESTIMONI — scroll-snap carousel
     ====================================================================== -->
<section id="testimoni" class="py-20 bg-white border-y border-slate-200/80 scroll-mt-24">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto mb-12 space-y-2 text-center">
            <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-[var(--secondary)]">Dari Pengguna Nyata</span>
            <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Yang Mereka Rasakan</h2>
        </div>

        <div class="relative">
            <div class="testi-track" id="testi-track">

                <div class="testi-card">
                    <div class="h-full p-7 bg-[var(--bg)] border border-slate-200/80 rounded-3xl space-y-5 lift">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">"Sebelumnya kami memilih konsultan hanya berdasarkan rekomendasi mulut ke mulut. Sekarang ada angka yang bisa kami pertanggungjawabkan ke pimpinan."</p>
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-200/80">
                            <div class="w-9 h-9 rounded-full bg-[var(--primary-tint)] flex items-center justify-center text-[var(--primary)] font-black text-sm shrink-0">R</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Rini Agustina</p>
                                <p class="text-[10px] text-[var(--neutral)]">Owner, Katering Berkah Jaya · Bogor</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="h-full p-7 bg-[var(--bg)] border border-slate-200/80 rounded-3xl space-y-5 lift">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">"Fitur simulator bobot sangat membantu kami memahami mengapa konsultan tertentu lebih direkomendasikan. Kami bisa lihat pengaruh tiap kriteria secara langsung."</p>
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-200/80">
                            <div class="w-9 h-9 rounded-full bg-[var(--secondary-tint)] flex items-center justify-center text-[var(--secondary)] font-black text-sm shrink-0">H</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Hendra Wijaya</p>
                                <p class="text-[10px] text-[var(--neutral)]">Manajer QA, PT Pangan Nusantara · Depok</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="h-full p-7 bg-[var(--bg)] border border-slate-200/80 rounded-3xl space-y-5 lift">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-slate-200 fill-slate-200" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">"Prosesnya jauh lebih cepat dari yang kami bayangkan. Dalam satu hari kerja, sistem sudah memberikan tiga rekomendasi konsultan lengkap dengan alasannya."</p>
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-200/80">
                            <div class="w-9 h-9 rounded-full bg-[var(--tertiary-tint)] flex items-center justify-center text-[var(--tertiary)] font-black text-sm shrink-0">S</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Siti Rahayu</p>
                                <p class="text-[10px] text-[var(--neutral)]">Direktur, CV Berkah Organik · Cianjur</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="h-full p-7 bg-[var(--bg)] border border-slate-200/80 rounded-3xl space-y-5 lift">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed font-medium">"Sebagai konsultan, saya senang dengan transparansi sistem ini. Klien tahu persis mengapa saya dipilih, dan ini membangun kepercayaan dari awal."</p>
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-200/80">
                            <div class="w-9 h-9 rounded-full bg-[var(--primary-tint)] flex items-center justify-center text-[var(--primary)] font-black text-sm shrink-0">B</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Budi Santoso</p>
                                <p class="text-[10px] text-[var(--neutral)]">Konsultan Senior · Jakarta</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Dot indicators -->
            <div id="testi-dots" class="flex justify-center gap-2 mt-6"></div>

            <!-- Prev / Next arrows -->
            <div class="flex justify-center gap-3 mt-5">
                <button id="testi-prev" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:border-[var(--primary)] hover:text-[var(--primary)] transition shadow-sm" aria-label="Sebelumnya">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </button>
                <button id="testi-next" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:border-[var(--primary)] hover:text-[var(--primary)] transition shadow-sm" aria-label="Berikutnya">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     11. FAQ
     ====================================================================== -->
<section id="faq" class="py-20 scroll-mt-24" style="background:var(--bg)">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="grid items-start grid-cols-1 gap-12 lg:grid-cols-12">
            <div class="space-y-4 lg:col-span-4">
                <span class="text-[10px] tracking-[0.14em] uppercase font-bold text-[var(--primary)]">Pertanyaan Umum</span>
                <h2 class="text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Ada yang ingin ditanyakan?</h2>
                <p class="text-xs sm:text-sm text-[var(--neutral)] leading-relaxed">Jika jawaban Anda tidak ada di sini, tim kami siap membantu melalui live chat atau email.</p>
                <a href="{{ route('register') }}" class="lift inline-block mt-2 px-6 py-3 bg-[var(--primary)] hover:bg-[var(--primary-dark)] text-white font-bold text-xs rounded-xl shadow-md shadow-[var(--primary)]/20 transition">Hubungi Kami</a>
            </div>

            <div class="space-y-3 lg:col-span-8">

                <div class="faq-item bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    <button class="w-full flex items-center justify-between gap-4 p-6 text-left" onclick="toggleFaq(this)">
                        <span class="text-sm font-bold text-slate-900">Apa itu metode PROMETHEE II dan mengapa digunakan?</span>
                        <svg class="faq-chevron w-5 h-5 text-[var(--neutral)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-body">
                        <p class="px-6 pb-6 text-xs text-[var(--neutral)] leading-relaxed">PROMETHEE II (<em>Preference Ranking Organisation METHod for Enrichment of Evaluations</em>) adalah metode pengambilan keputusan multi-kriteria yang menghasilkan peringkat lengkap berdasarkan nilai net flow (φ). Dibandingkan metode lain, PROMETHEE II unggul dalam hal transparansi — setiap perbandingan berpasangan bisa ditelusuri, dan hasilnya tidak bergantung pada skala penilaian yang berbeda-beda.</p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    <button class="w-full flex items-center justify-between gap-4 p-6 text-left" onclick="toggleFaq(this)">
                        <span class="text-sm font-bold text-slate-900">Berapa lama proses dari pendaftaran hingga konsultan ditugaskan?</span>
                        <svg class="faq-chevron w-5 h-5 text-[var(--neutral)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-body">
                        <p class="px-6 pb-6 text-xs text-[var(--neutral)] leading-relaxed">Setelah klien mendaftar dan mengisi profil usaha, sistem SPK melakukan komputasi PROMETHEE II secara otomatis. Admin kemudian mengkonfirmasi penugasan berdasarkan hasil peringkat. Rata-rata, seluruh proses Level 1–3 (dari pengajuan hingga plotting konsultan) diselesaikan dalam waktu kurang dari satu hari kerja.</p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    <button class="w-full flex items-center justify-between gap-4 p-6 text-left" onclick="toggleFaq(this)">
                        <span class="text-sm font-bold text-slate-900">Apakah bobot kriteria bisa disesuaikan per proyek?</span>
                        <svg class="faq-chevron w-5 h-5 text-[var(--neutral)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-body">
                        <p class="px-6 pb-6 text-xs text-[var(--neutral)] leading-relaxed">Bobot kriteria dikelola oleh Administrator dan disimpan di database. Saat ini, bobot berlaku secara global untuk semua komputasi. Fitur bobot per-klien sedang dalam roadmap pengembangan untuk paket Enterprise.</p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    <button class="w-full flex items-center justify-between gap-4 p-6 text-left" onclick="toggleFaq(this)">
                        <span class="text-sm font-bold text-slate-900">Bagaimana sistem menangani pembayaran?</span>
                        <svg class="faq-chevron w-5 h-5 text-[var(--neutral)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-body">
                        <p class="px-6 pb-6 text-xs text-[var(--neutral)] leading-relaxed">Pembayaran dilakukan dalam dua tahap (60% di muka, 40% setelah penyelesaian) menggunakan integrasi Midtrans. Tim keuangan menerbitkan invoice melalui sistem, dan konfirmasi pembayaran tercatat otomatis. Seluruh riwayat transaksi dapat diakses kapan saja dari dashboard.</p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                    <button class="w-full flex items-center justify-between gap-4 p-6 text-left" onclick="toggleFaq(this)">
                        <span class="text-sm font-bold text-slate-900">Apakah sertifikat halal diterbitkan langsung oleh platform ini?</span>
                        <svg class="faq-chevron w-5 h-5 text-[var(--neutral)] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-body">
                        <p class="px-6 pb-6 text-xs text-[var(--neutral)] leading-relaxed">Platform ini adalah sistem manajemen pendampingan — bukan lembaga sertifikasi. Sertifikat halal resmi tetap diterbitkan oleh BPJPH setelah seluruh proses audit dan verifikasi selesai. Sistem kami mencatat dan mengelola dokumen sertifikat yang telah diterbitkan sebagai arsip digital klien.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     12. CTA BANNER
     ====================================================================== -->
<section class="py-20 overflow-hidden">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="cta-bg rounded-3xl p-12 sm:p-16 text-center relative overflow-hidden">
            <!-- Decorative rings -->
            <div class="absolute -top-20 -left-20 w-64 h-64 rounded-full border border-white/10 pointer-events-none"></div>
            <div class="absolute -top-10 -left-10 w-44 h-44 rounded-full border border-white/10 pointer-events-none"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 rounded-full border border-white/10 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-44 h-44 rounded-full border border-white/10 pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl mx-auto space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 text-white/90 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span>Sistem Buka 24/7 · Daftar Gratis</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                    Mulai perjalanan sertifikasi halal Anda hari ini.
                </h2>
                <p class="text-sm text-white/75 leading-relaxed">
                    Ribuan pelaku usaha sudah membuktikan bahwa memilih konsultan tidak harus menjadi tebak-tebakan. Daftarkan usaha Anda sekarang dan lihat langsung hasil analisis PROMETHEE II untuk bisnis Anda.
                </p>
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="lift w-full sm:w-auto px-8 py-4 bg-white text-[var(--primary-dark)] font-black text-sm rounded-xl shadow-lg hover:shadow-xl transition text-center">Buka Dashboard</a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="lift w-full sm:w-auto px-8 py-4 bg-white text-[var(--primary-dark)] font-black text-sm rounded-xl shadow-lg hover:shadow-xl transition text-center">Daftar Sekarang — Gratis</a>
                        @endif
                        <a href="{{ route('login') }}" class="lift w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white/40 hover:border-white/70 text-white font-bold text-sm rounded-xl transition text-center">Sudah Punya Akun</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ======================================================================
     13. FOOTER MULTI-KOLOM
     ====================================================================== -->
<footer class="bg-[var(--neutral-900)] text-slate-400 border-t border-slate-800">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 pt-14 pb-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4 pb-12 border-b border-slate-800">

            <!-- Brand -->
            <div class="space-y-4 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[var(--primary)] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="font-black text-sm tracking-wider text-white uppercase">{{ config('app.name', 'Halal Compliance') }}</span>
                </div>
                <p class="text-xs leading-relaxed text-slate-500">Platform SPK berbasis PROMETHEE II untuk pemilihan konsultan halal yang transparan, terukur, dan dapat dipertanggungjawabkan.</p>
                <p class="text-[11px] text-slate-600">PT Konsultan Halal Indonesia<br>Kabupaten Bogor, Jawa Barat</p>
            </div>

            <!-- Produk -->
            <div class="space-y-4">
                <h5 class="text-xs font-black uppercase tracking-widest text-white">Produk</h5>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="#cara-kerja"  class="hover:text-white transition">Cara Kerja</a></li>
                    <li><a href="#spk-info"    class="hover:text-white transition">Metode PROMETHEE II</a></li>
                    <li><a href="#simulator"   class="hover:text-white transition">Simulator Bobot</a></li>
                    <li><a href="#layanan"     class="hover:text-white transition">Paket Layanan</a></li>
                    <li><a href="#peran"       class="hover:text-white transition">Akses Role</a></li>
                </ul>
            </div>

            <!-- Perusahaan -->
            <div class="space-y-4">
                <h5 class="text-xs font-black uppercase tracking-widest text-white">Perusahaan</h5>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                    <li><a href="#testimoni" class="hover:text-white transition">Testimoni Klien</a></li>
                    <li><a href="#faq" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog & Artikel</a></li>
                    <li><a href="#" class="hover:text-white transition">Karier</a></li>
                </ul>
            </div>

            <!-- Dukungan -->
            <div class="space-y-4">
                <h5 class="text-xs font-black uppercase tracking-widest text-white">Dukungan</h5>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="#" class="hover:text-white transition">Dokumentasi</a></li>
                    <li><a href="#" class="hover:text-white transition">Panduan Klien</a></li>
                    <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    <li>
                        <a href="mailto:info@konsualtanhalal.id" class="hover:text-white transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            info@konsultanhalal.id
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="flex flex-col items-center justify-between gap-4 pt-8 text-xs md:flex-row">
            <p class="text-slate-600">&copy; {{ date('Y') }} {{ config('app.name', 'Halal Compliance Interface') }}. Hak cipta dilindungi.</p>
            <div class="flex items-center gap-2 text-slate-600">
                <span class="w-1.5 h-1.5 rounded-full bg-[var(--primary)] animate-pulse"></span>
                <span>Sistem aktif dan berjalan normal</span>
            </div>
        </div>
    </div>
</footer>


<!-- ======================================================================
     SCRIPTS
     ====================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── 1. STAT COUNTERS ── */
    const counters = document.querySelectorAll('.stat-counter');
    const statsSection = document.getElementById('stats');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    counters.forEach(counter => {
                        const target = +counter.getAttribute('data-target');
                        const duration = reduceMotion ? 0 : 1400;
                        const start = performance.now();
                        function step(now) {
                            const progress = Math.min((now - start) / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 3);
                            counter.textContent = Math.floor(ease * target);
                            if (progress < 1) requestAnimationFrame(step);
                            else counter.textContent = target;
                        }
                        if (reduceMotion) { counter.textContent = target; }
                        else requestAnimationFrame(step);
                    });
                    observer.disconnect();
                }
            });
        }, { threshold: 0.4 });
        observer.observe(statsSection);
    }

    /* ── 2. PROMETHEE SIMULATOR ── */
    // Consultant reference data [name, C1_score, C2_score, C3_score]
    // Higher = better for C2 (experience), C3 (proximity); lower = better for C1 (price → we invert)
    const consultants = [
        { name: 'Budi Santoso',   label: 'BS', c1: 0.85, c2: 0.90, c3: 0.70 },
        { name: 'Andi Wijaya',    label: 'AW', c1: 0.60, c2: 0.75, c3: 0.85 },
        { name: 'Citra Lestari',  label: 'CL', c1: 0.40, c2: 0.55, c3: 0.60 },
        { name: 'Dewi Kusuma',    label: 'DK', c1: 0.70, c2: 0.65, c3: 0.90 },
    ];
    const colors = ['var(--primary)', 'var(--secondary)', 'var(--tertiary)', '#7C3AED'];
    const rankEl = document.getElementById('sim-ranking');

    function prometheeNetFlow(weights) {
        const n = consultants.length;
        const netFlow = consultants.map(() => 0);
        for (let i = 0; i < n; i++) {
            for (let j = 0; j < n; j++) {
                if (i === j) continue;
                const a = consultants[i], b = consultants[j];
                let pref = 0;
                pref += weights[0] * Math.max(0, a.c1 - b.c1);
                pref += weights[1] * Math.max(0, a.c2 - b.c2);
                pref += weights[2] * Math.max(0, a.c3 - b.c3);
                netFlow[i] += pref;
                netFlow[j] -= pref;
            }
        }
        return netFlow;
    }

    window.updateSimulator = function () {
        const raw = [+document.getElementById('w1').value, +document.getElementById('w2').value, +document.getElementById('w3').value];
        const total = raw.reduce((a, b) => a + b, 0) || 1;
        const weights = raw.map(v => v / total);

        // Labels
        document.getElementById('w1-label').textContent = raw[0] + '%';
        document.getElementById('w2-label').textContent = raw[1] + '%';
        document.getElementById('w3-label').textContent = raw[2] + '%';
        document.getElementById('total-label').textContent = '= ' + Math.round(raw[0] + raw[1] + raw[2]) + '%';
        const normTotal = raw[0] + raw[1] + raw[2];
        document.getElementById('bar-w1').style.width = (normTotal ? (raw[0]/normTotal*100) : 0) + '%';
        document.getElementById('bar-w2').style.width = (normTotal ? (raw[1]/normTotal*100) : 0) + '%';
        document.getElementById('bar-w3').style.width = (normTotal ? (raw[2]/normTotal*100) : 0) + '%';

        const flows = prometheeNetFlow(weights);
        const ranked = consultants.map((c, i) => ({ ...c, flow: flows[i], origIdx: i }))
                                   .sort((a, b) => b.flow - a.flow);

        // Render
        rankEl.innerHTML = '';
        const maxFlow = Math.max(...ranked.map(r => Math.abs(r.flow))) || 1;
        ranked.forEach((c, rank) => {
            const pct = Math.round(((c.flow + maxFlow) / (2 * maxFlow)) * 100);
            const sign = c.flow >= 0 ? '+' : '';
            const color = colors[c.origIdx];
            const isFirst = rank === 0;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 p-3 rounded-xl transition-all duration-500 ' + (isFirst ? 'bg-[var(--primary-tint)] border border-[var(--primary)]/20' : 'bg-slate-50');
            div.innerHTML = `
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-black shrink-0 ${isFirst ? 'bg-[var(--primary)] text-white' : 'bg-slate-200 text-slate-600'}">${rank+1}</div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs font-bold text-slate-900 truncate">${c.name}</span>
                        <span class="text-[11px] font-bold ml-2 shrink-0" style="color:${color}">${sign}${c.flow.toFixed(4)}</span>
                    </div>
                    <div class="h-1.5 rounded-full bg-slate-200 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700" style="width:${pct}%;background:${color}"></div>
                    </div>
                </div>
            `;
            rankEl.appendChild(div);
        });
    };
    updateSimulator();


    /* ── 3. TESTIMONI CAROUSEL ── */
    const track = document.getElementById('testi-track');
    const dotsContainer = document.getElementById('testi-dots');
    if (track) {
        const cards = track.querySelectorAll('.testi-card');
        const count = cards.length;
        let currentDot = 0;

        // Build dots
        for (let i = 0; i < count; i++) {
            const d = document.createElement('button');
            d.className = 'dot' + (i === 0 ? ' active' : '');
            d.setAttribute('aria-label', 'Ke testimoni ' + (i + 1));
            d.addEventListener('click', () => scrollToCard(i));
            dotsContainer.appendChild(d);
        }
        const dots = dotsContainer.querySelectorAll('.dot');

        function scrollToCard(idx) {
            const card = cards[idx];
            if (!card) return;
            track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
        }

        function updateDots() {
            const scrollLeft = track.scrollLeft;
            let closest = 0, minDist = Infinity;
            cards.forEach((c, i) => {
                const dist = Math.abs(c.offsetLeft - track.offsetLeft - scrollLeft);
                if (dist < minDist) { minDist = dist; closest = i; }
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === closest));
            currentDot = closest;
        }

        track.addEventListener('scroll', updateDots, { passive: true });

        document.getElementById('testi-prev')?.addEventListener('click', () => {
            scrollToCard(Math.max(currentDot - 1, 0));
        });
        document.getElementById('testi-next')?.addEventListener('click', () => {
            scrollToCard(Math.min(currentDot + 1, count - 1));
        });
    }


    /* ── 4. FAQ ACCORDION ── */
    window.toggleFaq = function (btn) {
        const item = btn.closest('.faq-item');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    };


    /* ── 5. HERO ANIMATIONS ── */
    if (!reduceMotion) {
        // Animate hero text
        const heroLeft = document.querySelectorAll('#hero-left > *');
        heroLeft.forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(24px)';
            el.style.transition = `opacity .6s ease ${i * 0.1}s, transform .6s ease ${i * 0.1}s`;
            requestAnimationFrame(() => requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }));
        });

        const heroMatrix = document.getElementById('hero-matrix');
        if (heroMatrix) {
            heroMatrix.style.opacity = '0';
            heroMatrix.style.transform = 'translateY(20px)';
            heroMatrix.style.transition = 'opacity .7s ease .35s, transform .7s ease .35s';
            requestAnimationFrame(() => requestAnimationFrame(() => {
                heroMatrix.style.opacity = '1';
                heroMatrix.style.transform = 'translateY(0)';
            }));
        }

        // Animate matrix bars
        document.querySelectorAll('.matrix-bar').forEach((el, i) => {
            const target = el.style.width;
            el.style.width = '0%';
            el.style.transition = `width .9s cubic-bezier(.22,1,.36,1) ${0.9 + i * 0.05}s`;
            requestAnimationFrame(() => requestAnimationFrame(() => {
                el.style.width = target;
            }));
        });

        // Matrix rank badges
        document.querySelectorAll('.matrix-rank').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'scale(0) rotate(-20deg)';
            el.style.transition = `opacity .4s ease ${1.3 + i * 0.12}s, transform .5s cubic-bezier(.34,1.56,.64,1) ${1.3 + i * 0.12}s`;
            requestAnimationFrame(() => requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'scale(1) rotate(0deg)';
            }));
        });


        /* ── 6. SCROLL-TRIGGERED REVEALS ── */
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.gsap-step, .gsap-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(28px)';
            el.style.transition = `opacity .55s ease ${i * 0.09}s, transform .55s cubic-bezier(.22,1,.36,1) ${i * 0.09}s`;
            revealObserver.observe(el);
        });

        // Comparison section reveal
        document.querySelectorAll('#perbandingan .lift').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(24px)';
            el.style.transition = `opacity .55s ease ${i * 0.12}s, transform .55s cubic-bezier(.22,1,.36,1) ${i * 0.12}s`;
            revealObserver.observe(el);
        });

        // Cara kerja connecting line
        const line = document.getElementById('cara-kerja-line');
        if (line) {
            const lineObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        line.style.transition = 'stroke-dashoffset 1.2s cubic-bezier(.22,1,.36,1)';
                        line.style.strokeDashoffset = '0';
                        lineObserver.disconnect();
                    }
                });
            }, { threshold: 0.3 });
            lineObserver.observe(document.getElementById('cara-kerja'));
        }
    }

});
</script>

</body>
</html>
