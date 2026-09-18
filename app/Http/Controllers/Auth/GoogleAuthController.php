<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $exception) {
            return redirect()->route('login')->withErrors([
                'google' => 'Sesi login Google kedaluwarsa. Silakan coba lagi.',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'google' => 'Login dengan Google gagal. Silakan coba lagi.',
            ]);
        }

        if (! $googleUser->getEmail()) {
            return redirect()->route('login')->withErrors([
                'google' => 'Akun Google tidak menyediakan alamat email.',
            ]);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'nama_lengkap' => $googleUser->getName() ?: 'Pengguna Google',
                'jenis_kelamin' => 'Laki laki',
                'email' => $googleUser->getEmail(),
                'no_hp' => '-',
                'role' => 'Member',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(40)),
            ]);
        } elseif (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
