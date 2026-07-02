<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Karla:wght@400;500;600;700&display=swap');

        .ms-wrap {
            --ms-ink: #2B2118;
            --ms-ink-soft: #5A4A38;
            --ms-honey: #D9A441;
            --ms-honey-dark: #A97524;
            --ms-honey-light: #F3E2B8;
            --ms-cream: #FBF3E3;
            --ms-card: #FFFDF8;
            --ms-line: #EADCC0;
            font-family: 'Karla', sans-serif;
            position: fixed;
            inset: 0;
            z-index: 9999;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            display: flex;
            align-items: safe center;
            justify-content: safe center;
            padding: 2.5rem 1rem;
            background-color: var(--ms-cream);
            background-image:
                radial-gradient(circle at 15% 8%, rgba(217,164,65,0.16), transparent 40%),
                radial-gradient(circle at 88% 82%, rgba(217,164,65,0.14), transparent 42%);
        }
        .ms-hex-field {
            position: absolute;
            inset: 0;
            opacity: 0.5;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='74' viewBox='0 0 64 74'%3E%3Cpath d='M32 0 L64 18.5 L64 55.5 L32 74 L0 55.5 L0 18.5 Z' fill='none' stroke='%23D9A441' stroke-opacity='0.15' stroke-width='1'/%3E%3C/svg%3E");
            background-size: 64px 74px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 30%, black 0%, transparent 75%);
        }
        .ms-inner { position: relative; max-width: 26rem; margin: 0 auto; }
        .ms-brand { text-align: center; margin-bottom: 1.75rem; }
        .ms-mark { display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.85rem; }
        .ms-wordmark {
            font-family: 'Fraunces', serif;
            font-weight: 700;
            font-size: 1.85rem;
            letter-spacing: 0.09em;
            color: var(--ms-ink);
            line-height: 1;
        }
        .ms-tagline {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-weight: 500;
            font-size: 0.88rem;
            color: var(--ms-ink-soft);
            margin-top: 0.4rem;
            letter-spacing: 0.02em;
        }
        .ms-card {
            background: var(--ms-card);
            border-radius: 1.25rem;
            border: 1px solid var(--ms-line);
            box-shadow: 0 1px 2px rgba(43,33,24,0.04), 0 18px 40px -20px rgba(43,33,24,0.28);
            padding: 2.1rem 1.9rem;
            position: relative;
            overflow: hidden;
        }
        .ms-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--ms-honey-light), var(--ms-honey) 45%, var(--ms-honey-dark) 100%);
        }
        .ms-card-title {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.15rem;
            color: var(--ms-ink);
            margin-bottom: 1.4rem;
        }
        .ms-alert {
            font-family: 'Karla', sans-serif;
            font-size: 0.86rem;
            border-radius: 0.85rem;
            padding: 0.7rem 1rem;
            margin-bottom: 1.1rem;
            background: #EFF4E9;
            border: 1px solid #C9DAB8;
            color: #43592F;
        }
        .ms-field { position: relative; margin-top: 1.05rem; }
        .ms-field:first-of-type { margin-top: 0; }
        .ms-field .ms-icon {
            position: absolute;
            left: 0.9rem;
            top: 2.35rem;
            color: var(--ms-honey-dark);
            opacity: 0.75;
            pointer-events: none;
        }
        .ms-field label {
            font-family: 'Karla', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.03em;
            color: var(--ms-ink-soft);
            text-transform: uppercase;
        }
        .ms-input {
            font-family: 'Karla', sans-serif !important;
            width: 100%;
            border-radius: 0.85rem !important;
            border: 1px solid #E3D5B8 !important;
            background: #FFFFFF !important;
            padding: 0.65rem 0.9rem 0.65rem 2.55rem !important;
            font-size: 0.94rem !important;
            color: var(--ms-ink) !important;
            box-shadow: none !important;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .ms-input:focus {
            border-color: var(--ms-honey) !important;
            box-shadow: 0 0 0 3px rgba(217,164,65,0.22) !important;
            outline: none !important;
        }
        .ms-remember {
            display: flex;
            align-items: center;
            margin-top: 1.15rem;
            font-family: 'Karla', sans-serif;
            font-size: 0.87rem;
            color: var(--ms-ink-soft);
        }
        .ms-remember input {
            border-radius: 0.3rem;
            border-color: #E3D5B8;
            color: var(--ms-honey-dark);
            margin-right: 0.55rem;
        }
        .ms-links { margin-top: 1.4rem; display: flex; flex-direction: column; gap: 0.35rem; }
        .ms-links a {
            font-family: 'Karla', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ms-honey-dark);
            text-decoration: none;
            text-underline-offset: 3px;
        }
        .ms-links a:hover { text-decoration: underline; color: var(--ms-ink); }
        .ms-links a.ms-muted { color: var(--ms-ink-soft); font-weight: 500; }
        .ms-submit-row { margin-top: 1.6rem; }
        .ms-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: 'Karla', sans-serif !important;
            font-weight: 700 !important;
            font-size: 0.92rem !important;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--ms-cream) !important;
            background: linear-gradient(135deg, var(--ms-ink) 0%, #3E2F20 100%) !important;
            border: none !important;
            border-radius: 0.85rem !important;
            padding: 0.8rem 1.4rem !important;
            box-shadow: 0 10px 24px -10px rgba(43,33,24,0.55);
            transition: transform .15s ease, box-shadow .15s ease, background .2s ease;
        }
        .ms-btn:hover {
            background: linear-gradient(135deg, var(--ms-honey-dark) 0%, var(--ms-ink) 100%) !important;
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -10px rgba(169,117,36,0.5);
        }
        .ms-foot {
            text-align: center;
            margin-top: 1.5rem;
            font-family: 'Karla', sans-serif;
            font-size: 0.78rem;
            color: var(--ms-ink-soft);
            letter-spacing: 0.02em;
        }
        .ms-foot .ms-dot { color: var(--ms-honey); margin: 0 0.4rem; }
    </style>

    <div class="ms-wrap">
        <div class="ms-hex-field"></div>
        <div class="ms-inner">
            <div class="ms-brand">
                <div class="ms-mark">
                    <svg width="46" height="52" viewBox="0 0 64 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 1.5 L62 19 V55 L32 72.5 L2 55 V19 Z" stroke="#A97524" stroke-width="1.5" fill="#FBF3E3"/>
                        <text x="32" y="45" text-anchor="middle" font-family="Fraunces, serif" font-weight="700" font-size="28" fill="#A97524">M</text>
                    </svg>
                </div>
                <div class="ms-wordmark">MELISSARI SHOP</div>
                <div class="ms-tagline">Selamat datang kembali</div>
            </div>

            <div class="ms-card">
                <div class="ms-card-title">Masuk ke akun Anda</div>

                @if(session('success'))
                    <div class="ms-alert">{{ session('success') }}</div>
                @endif

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="ms-field">
                        <x-input-label for="email" :value="__('Email')" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13L20.5 6.5"/></svg>
                        </span>
                        <x-text-input id="email" class="ms-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="ms-field">
                        <x-input-label for="password" :value="__('Password')" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/></svg>
                        </span>
                        <x-text-input id="password" class="ms-input"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <label for="remember_me" class="ms-remember">
                        <input id="remember_me" type="checkbox" name="remember">
                        {{ __('Ingat saya') }}
                    </label>

                    <div class="ms-links">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Belum punya akun? Daftar di sini</a>
                        @endif
                        @if (Route::has('password.request'))
                            <a class="ms-muted" href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <div class="ms-submit-row">
                        <x-primary-button class="ms-btn">
                            Login
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="ms-foot">Melissari Shop <span class="ms-dot">&#8226;</span> Belanja nyaman, tepercaya</div>
        </div>
    </div>
</x-guest-layout>