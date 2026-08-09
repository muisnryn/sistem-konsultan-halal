<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — {{ config('app.name', 'SPK Sertifikasi Halal') }}</title>

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
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--neutral-900);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        ::selection { background: var(--primary); color: white; }
        *:focus-visible {
            outline: 2px solid var(--tertiary);
            outline-offset: 2px;
            border-radius: 6px;
        }

        /* ── Input base ── */
        .field-input {
            width: 100%;
            padding: 0.55rem 0.875rem;
            font-size: 0.8125rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--neutral-900);
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 0.625rem;
            transition: border-color .18s, box-shadow .18s;
            outline: none;
            -webkit-appearance: none;
        }
        .field-input::placeholder { color: #94A3B8; font-weight: 400; }
        .field-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16,124,65,.10);
        }
        .field-input.error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,.08);
        }

        /* ── Password toggle ── */
        .pw-wrap { position: relative; }
        .pw-toggle {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; padding: 2px;
            color: #94A3B8; transition: color .15s;
            display: flex; align-items: center;
        }
        .pw-toggle:hover { color: var(--neutral); }

        /* ── Custom checkbox ── */
        .custom-checkbox {
            -webkit-appearance: none; appearance: none;
            width: 0.9375rem; height: 0.9375rem; border-radius: 4px;
            border: 1.5px solid var(--border);
            background: white; cursor: pointer;
            transition: border-color .15s, background .15s;
            flex-shrink: 0;
            position: relative;
        }
        .custom-checkbox:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute; top: 1px; left: 3px;
            width: 4px; height: 7px;
            border: 2px solid white; border-top: none; border-left: none;
            transform: rotate(45deg);
        }
        .custom-checkbox:focus-visible {
            outline: 2px solid var(--tertiary); outline-offset: 2px;
        }

        /* ── Primary button ── */
        .btn-primary {
            width: 100%; padding: 0.65rem 1.25rem;
            background: var(--primary); color: white;
            font-size: 0.8125rem; font-weight: 700; font-family: 'Inter', sans-serif;
            border: none; border-radius: 0.625rem; cursor: pointer;
            transition: background .18s, transform .15s, box-shadow .18s;
            box-shadow: 0 4px 14px rgba(16,124,65,.22);
            letter-spacing: .01em;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16,124,65,.28);
        }
        .btn-primary:active { transform: translateY(0); }

        /* ── Error message ── */
        .field-error { font-size: 0.7rem; color: #EF4444; font-weight: 500; margin-top: 0.25rem; }

        /* ── Session status ── */
        .session-status {
            font-size: 0.75rem; font-weight: 500;
            color: var(--secondary-dark);
            background: var(--secondary-tint);
            border: 1px solid rgba(13,148,136,.2);
            border-radius: 0.625rem; padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
        }

        /* ── Divider ── */
        .divider { display: flex; align-items: center; gap: .75rem; }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* ── Entrance animation ── */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: slideUp .45s cubic-bezier(.22,1,.36,1) both; }
        .delay-1 { animation-delay: .06s; }
        .delay-2 { animation-delay: .10s; }
        .delay-3 { animation-delay: .14s; }
        .delay-4 { animation-delay: .18s; }
        .delay-5 { animation-delay: .22s; }

        @media (prefers-reduced-motion: reduce) {
            .animate-in { animation: none; }
            .btn-primary:hover { transform: none; }
        }
    </style>
</head>

<body>

    <!-- ── Back link ── -->
    <div class="px-4 pt-3 sm:px-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[var(--neutral)] hover:text-[var(--primary)] transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Kembali ke beranda
        </a>
    </div>

    <!-- ── Main layout ── -->
    <main class="flex items-center justify-center flex-1 px-4 py-4 sm:py-6">
        <div class="w-full max-w-md">

            <!-- Logo + heading -->
            <div class="mb-5 text-center animate-in">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center group mb-2.5">
                    <div class="w-10 h-10 rounded-xl bg-[var(--primary)] text-white flex items-center justify-center shadow-md shadow-[var(--primary)]/25 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </a>
                <h1 class="text-xl font-black tracking-tight text-slate-900">Selamat datang kembali</h1>
                <p class="mt-0.5 text-xs text-[var(--neutral)] font-normal">Masuk ke akun Anda untuk melanjutkan proses sertifikasi.</p>
            </div>

            <!-- Card -->
            <div class="p-5 bg-white border shadow-sm rounded-2xl border-slate-200/80 sm:p-6 animate-in delay-1">

                <!-- Session status -->
                @if (session('status'))
                    <div class="session-status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="animate-in delay-2">
                        <label for="email" class="block mb-1 text-xs font-bold text-slate-700">
                            Alamat Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukan email anda"
                            class="field-input {{ $errors->has('email') ? 'error' : '' }}"
                        />
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-3.5 animate-in delay-3">
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-xs font-bold text-slate-700">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="pw-wrap">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Minimal 8 karakter"
                                class="field-input {{ $errors->has('password') ? 'error' : '' }}"
                                style="padding-right:2.5rem"
                            />
                            <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Tampilkan kata sandi">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="mt-3.5 animate-in delay-4">
                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="custom-checkbox">
                            <span class="text-xs font-medium text-slate-600">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="mt-4 animate-in delay-5">
                        <button type="submit" class="btn-primary">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer note -->
            <p class="mt-4 text-center text-[11px] text-[var(--neutral)] animate-in delay-5">
                Dengan masuk, Anda menyetujui
                <a href="#" class="font-semibold text-slate-600 hover:text-[var(--primary)] transition">Syarat & Ketentuan</a>
                serta
                <a href="#" class="font-semibold text-slate-600 hover:text-[var(--primary)] transition">Kebijakan Privasi</a>
            </p>
        </div>
    </main>

    <!-- ── Minimal footer ── -->
    <footer class="py-2.5 text-center text-[11px] text-[var(--neutral)]">
        &copy; {{ date('Y') }} {{ config('app.name', 'Halal Compliance Interface') }}
    </footer>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
        }
    </script>

</body>
</html>
