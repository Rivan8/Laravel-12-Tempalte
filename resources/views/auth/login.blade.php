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
