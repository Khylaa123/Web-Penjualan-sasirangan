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
            mask-image: radial-gradient(ellipse 70% 60% at 50% 25%, black 0%, transparent 75%);
        }
        .ms-inner { position: relative; max-width: 27rem; margin: 0 auto; }
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
            margin-bottom: 0.3rem;
        }
        .ms-card-sub {
            font-family: 'Karla', sans-serif;
            font-size: 0.83rem;
            color: var(--ms-ink-soft);
            margin-bottom: 1.4rem;
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
        .ms-field.ms-textarea .ms-icon { top: 2.55rem; }
        .ms-field label {
            font-family: 'Karla', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.03em;
            color: var(--ms-ink-soft);
            text-transform: uppercase;
        }
        .ms-input, .ms-textarea-el {
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
        .ms-textarea-el { resize: vertical; }
        .ms-input:focus, .ms-textarea-el:focus {
            border-color: var(--ms-honey) !important;
            box-shadow: 0 0 0 3px rgba(217,164,65,0.22) !important;
            outline: none !important;
        }
        .ms-links { margin-top: 1.5rem; text-align: center; }
        .ms-links a {
            font-family: 'Karla', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ms-honey-dark);
            text-decoration: none;
            text-underline-offset: 3px;
        }
        .ms-links a:hover { text-decoration: underline; color: var(--ms-ink); }
        .ms-submit-row { margin-top: 0.6rem; }
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
                <div class="ms-tagline">Bergabung bersama kami</div>
            </div>

            <div class="ms-card">
                <div class="ms-card-title">Buat akun baru</div>
                <div class="ms-card-sub">Isi data di bawah untuk mulai berbelanja</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="ms-field">
                        <x-input-label for="name" :value="__('Name')" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20c1.4-4 4.2-6 7.5-6s6.1 2 7.5 6"/></svg>
                        </span>
                        <x-text-input id="name" class="ms-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="ms-field">
                        <x-input-label for="email" :value="__('Email')" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M3.5 6.5L12 13L20.5 6.5"/></svg>
                        </span>
                        <x-text-input id="email" class="ms-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
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
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="ms-field">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/><path d="M9.5 15.5l1.6 1.6 3.4-3.4"/></svg>
                        </span>
                        <x-text-input id="password_confirmation" class="ms-input"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div class="ms-field">
                        <x-input-label for="no_whatsapp" :value="'Nomor WhatsApp'" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.5 14.4c-.3-.15-1.8-.9-2.1-1-.28-.1-.48-.15-.68.15-.2.3-.78 1-.96 1.2-.18.2-.35.23-.65.08-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.5-1.8-1.68-2.1-.18-.3-.02-.46.13-.6.14-.14.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.08-.15-.68-1.65-.94-2.25-.25-.6-.5-.5-.68-.5h-.58c-.2 0-.53.08-.8.38-.28.3-1.05 1.03-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.13 3.25 5.15 4.55.72.3 1.28.5 1.72.63.72.23 1.38.2 1.9.12.58-.09 1.8-.73 2.05-1.44.25-.7.25-1.3.18-1.44-.08-.13-.28-.2-.58-.35z"/><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.6-1.2A9 9 0 1 0 12 3z"/></svg>
                        </span>
                        <x-text-input
                            id="no_whatsapp"
                            class="ms-input"
                            type="text"
                            name="no_whatsapp"
                            :value="old('no_whatsapp')"
                            required
                        />
                        <x-input-error :messages="$errors->get('no_whatsapp')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="ms-field ms-textarea">
                        <x-input-label for="alamat_lengkap" :value="'Alamat Lengkap'" />
                        <span class="ms-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s-7-6.1-7-11a7 7 0 0 1 14 0c0 4.9-7 11-7 11z"/><circle cx="12" cy="10" r="2.4"/></svg>
                        </span>
                        <textarea
                            id="alamat_lengkap"
                            name="alamat_lengkap"
                            rows="3"
                            class="ms-textarea-el"
                            required>{{ old('alamat_lengkap') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
                    </div>

                    <div class="ms-submit-row" style="margin-top: 1.5rem;">
                        <x-primary-button class="ms-btn">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>

                    <div class="ms-links">
                        <a href="{{ route('login') }}">{{ __('Sudah punya akun? Login di sini') }}</a>
                    </div>
                </form>
            </div>

            <div class="ms-foot">Melissari Shop <span class="ms-dot">&#8226;</span> Belanja nyaman, tepercaya</div>
        </div>
    </div>
</x-guest-layout>