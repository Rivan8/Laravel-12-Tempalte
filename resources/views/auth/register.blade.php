<x-guest-layout>
    {{-- Heading --}}
    <div style="margin-bottom: 24px;">
        <p style="font-size: 0.72rem; color: #ea580c; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; margin: 0 0 6px;">Elshaddai Learning Center</p>
        <h1 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0 0 6px; letter-spacing: -0.5px;">Buat Akun Baru ✨</h1>
        <p style="font-size: 0.83rem; color: #64748b; margin: 0;">Bergabunglah dalam perjalanan pertumbuhan rohani</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf

        @php
        $inputStyle = "
            width: 100%; padding: 11px 14px 11px 40px;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            font-size: 0.87rem; color: #1e293b; background: #f8fafc;
            outline: none; transition: all 0.2s; box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        ";
        $inputFocus = "this.style.borderColor='#ea580c'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(234,88,12,0.12)'";
        $inputBlur  = "this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'";
        $labelStyle = "display: block; font-size: 0.79rem; font-weight: 600; color: #374151; margin-bottom: 6px;";
        $iconStyle  = "position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.82rem;";
        @endphp

        {{-- Nama Lengkap --}}
        <div>
            <label for="nama_lengkap" style="{{ $labelStyle }}">Nama Lengkap</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-user"></i></span>
                <input id="nama_lengkap" type="text" name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}" required autofocus autocomplete="name"
                    placeholder="Nama Anda"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <label for="jenis_kelamin" style="{{ $labelStyle }}">Jenis Kelamin</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-venus-mars"></i></span>
                <select id="jenis_kelamin" name="jenis_kelamin" required
                    style="{{ $inputStyle }} appearance: none; padding-right: 36px; cursor: pointer;"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki laki" {{ old('jenis_kelamin') == 'Laki laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" style="{{ $labelStyle }}">Alamat Email</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email" name="email"
                    value="{{ old('email') }}" required autocomplete="username"
                    placeholder="nama@email.com"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- No HP --}}
        <div>
            <label for="no_hp" style="{{ $labelStyle }}">Nomor HP / WhatsApp</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-phone-alt"></i></span>
                <input id="no_hp" type="text" name="no_hp"
                    value="{{ old('no_hp') }}" required autocomplete="tel"
                    placeholder="08xxxxxxxxxx"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        {{-- Kode Registrasi --}}
        <div>
            <label for="fasilitator_code" style="{{ $labelStyle }}">
                Kode Registrasi Khusus
                <span style="font-weight: 400; color: #94a3b8;">(Opsional)</span>
            </label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-key"></i></span>
                <input id="fasilitator_code" type="text" name="fasilitator_code"
                    value="{{ old('fasilitator_code') }}"
                    placeholder="Kosongkan jika mendaftar sebagai Member"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('fasilitator_code')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" style="{{ $labelStyle }}">Password</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" name="password"
                    required autocomplete="new-password"
                    placeholder="Min. 8 karakter"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" style="{{ $labelStyle }}">Konfirmasi Password</label>
            <div style="position: relative;">
                <span style="{{ $iconStyle }}"><i class="fas fa-shield-alt"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    required autocomplete="new-password"
                    placeholder="Ulangi password"
                    style="{{ $inputStyle }}"
                    onfocus="{{ $inputFocus }}" onblur="{{ $inputBlur }}">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <button type="submit" style="
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #ea580c, #fb923c);
            color: #fff; font-size: 0.9rem; font-weight: 700;
            border: none; border-radius: 12px; cursor: pointer;
            box-shadow: 0 4px 18px rgba(234,88,12,0.4);
            transition: all 0.2s; font-family: 'Inter', sans-serif;
            margin-top: 6px; letter-spacing: 0.2px;
        "
        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 24px rgba(234,88,12,0.5)'"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 18px rgba(234,88,12,0.4)'">
            <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
        </button>

        {{-- Login link --}}
        <p style="text-align: center; font-size: 0.82rem; color: #64748b; margin: 0;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="color: #ea580c; font-weight: 700; text-decoration: none;">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
