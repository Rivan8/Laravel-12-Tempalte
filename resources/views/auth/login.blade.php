<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Heading --}}
    <div style="margin-bottom: 28px;">
        <p style="font-size: 0.72rem; color: #ea580c; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; margin: 0 0 6px;">Elshaddai Learning Center</p>
        <h1 style="font-size: 1.6rem; font-weight: 800; color: #0f172a; margin: 0 0 6px; letter-spacing: -0.5px;">Selamat Datang 👋</h1>
        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 18px;">
        @csrf

        @if ($errors->has('google'))
            <x-input-error :messages="$errors->get('google')" />
        @endif

        <div style="padding: 14px; border: 1px solid #fed7aa; border-radius: 16px; background: linear-gradient(135deg, #fff7ed, #fff);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-size: 0.68rem; color: #c2410c; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">Akses cepat</span>
                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 8px; border-radius: 999px; background: #ffedd5; color: #c2410c; font-size: 0.64rem; font-weight: 700;">
                    <i class="fas fa-bolt"></i> Direkomendasikan
                </span>
            </div>
            <a href="{{ route('google.redirect') }}" style="
                display: flex; align-items: center; justify-content: center; gap: 10px;
                width: 100%; min-height: 48px; padding: 11px 14px; box-sizing: border-box;
                border: 1px solid #e2e8f0; border-radius: 11px;
                background: #fff; color: #1e293b; font-size: 0.88rem; font-weight: 700;
                text-decoration: none; transition: all 0.2s; font-family: 'Inter', sans-serif;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
            " onmouseover="this.style.borderColor='#f97316'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 7px 16px rgba(234,88,12,0.14)'"
            onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(15,23,42,0.05)'">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 25px; height: 25px; border: 1px solid #e2e8f0; border-radius: 7px; background: #fff;">
                    <svg width="18" height="18" viewBox="0 0 18 18" aria-hidden="true">
                        <path fill="#EA4335" d="M17.64 9.205c0-.638-.057-1.252-.164-1.841H9v3.482h4.844a4.14 4.14 0 0 1-1.796 2.715v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.614Z" />
                        <path fill="#4285F4" d="M9 18c2.43 0 4.467-.806 5.956-2.181l-2.908-2.258c-.806.54-1.835.859-3.048.859-2.347 0-4.337-1.586-5.05-3.72H.944v2.331A9 9 0 0 0 9 18Z" />
                        <path fill="#FBBC05" d="M3.95 10.7A5.4 5.4 0 0 1 3.668 9c0-.59.101-1.163.282-1.7V4.969H.944A9 9 0 0 0 0 9c0 1.452.348 2.826.944 4.031L3.95 10.7Z" />
                        <path fill="#34A853" d="M9 3.58c1.323 0 2.51.454 3.444 1.345l2.583-2.583C13.463.892 11.426 0 9 0A9 9 0 0 0 .944 4.969L3.95 7.3C4.663 5.166 6.653 3.58 9 3.58Z" />
                    </svg>
                </span>
                <span style="flex: 1; text-align: left;">Lanjutkan dengan Google</span>
                <i class="fas fa-arrow-right" style="color: #f97316; font-size: 0.78rem;"></i>
            </a>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; color: #94a3b8; font-size: 0.72rem;">
            <span style="height: 1px; flex: 1; background: #e2e8f0;"></span>
            <span>atau masuk dengan email</span>
            <span style="height: 1px; flex: 1; background: #e2e8f0;"></span>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" style="display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 6px;">
                Alamat Email
            </label>
            <div style="position: relative;">
                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem;">
                    <i class="fas fa-envelope"></i>
                </span>
                <input
                    id="email" type="email" name="email"
                    value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="nama@email.com"
                    style="
                        width: 100%; padding: 11px 14px 11px 40px;
                        border: 1.5px solid #e2e8f0; border-radius: 12px;
                        font-size: 0.88rem; color: #1e293b; background: #f8fafc;
                        outline: none; transition: all 0.2s;
                        font-family: 'Inter', sans-serif;
                    "
                    onfocus="this.style.borderColor='#ea580c'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(234,88,12,0.12)'"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <label for="password" style="font-size: 0.8rem; font-weight: 600; color: #374151;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.78rem; color: #ea580c; font-weight: 600; text-decoration: none;">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div style="position: relative;">
                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem;">
                    <i class="fas fa-lock"></i>
                </span>
                <input
                    id="password" type="password" name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••"
                    style="
                        width: 100%; padding: 11px 14px 11px 40px;
                        border: 1.5px solid #e2e8f0; border-radius: 12px;
                        font-size: 0.88rem; color: #1e293b; background: #f8fafc;
                        outline: none; transition: all 0.2s;
                        font-family: 'Inter', sans-serif;
                    "
                    onfocus="this.style.borderColor='#ea580c'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(234,88,12,0.12)'"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember Me --}}
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <input id="remember_me" type="checkbox" name="remember"
                style="width: 16px; height: 16px; border-radius: 4px; accent-color: #ea580c; cursor: pointer;">
            <span style="font-size: 0.82rem; color: #64748b;">Ingat saya</span>
        </label>

        {{-- Submit Button --}}
        <button type="submit" style="
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #ea580c, #fb923c);
            color: #fff; font-size: 0.9rem; font-weight: 700;
            border: none; border-radius: 12px;
            cursor: pointer; letter-spacing: 0.3px;
            box-shadow: 0 4px 18px rgba(234,88,12,0.4);
            transition: all 0.2s; font-family: 'Inter', sans-serif;
            margin-top: 4px;
        "
        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 24px rgba(234,88,12,0.5)'"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 18px rgba(234,88,12,0.4)'">
            <i class="fas fa-sign-in-alt me-2"></i> Masuk
        </button>

        {{-- Register link --}}
        @if (Route::has('register'))
        <p style="text-align: center; font-size: 0.82rem; color: #64748b; margin: 0;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color: #ea580c; font-weight: 700; text-decoration: none;">
                Daftar sekarang
            </a>
        </p>
        @endif
    </form>
</x-guest-layout>
