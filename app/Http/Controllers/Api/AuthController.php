<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Register a mobile user with email and password.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki laki,Perempuan'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'role' => 'Member',
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        return $this->tokenResponse($user, 'Registration successful', 201);
    }

    /**
     * Handle mobile api login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            return $this->tokenResponse($user, 'Logged in successfully');
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Authenticate a native mobile Google Sign-In credential.
     * Accepts Google's ID token, or an OAuth access token as a fallback.
     */
    public function google(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => ['required_without:access_token', 'string'],
            'access_token' => ['required_without:id_token', 'string'],
        ]);

        try {
            $googleUser = $request->filled('id_token')
                ? $this->googleUserFromIdToken($request->string('id_token')->toString())
                : Socialite::driver('google')->userFromToken($request->string('access_token')->toString());
        } catch (\Throwable $exception) {
            report($exception);

            throw ValidationException::withMessages([
                'google' => 'Kredensial Google tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        if (! $googleUser->getEmail()) {
            throw ValidationException::withMessages([
                'google' => 'Akun Google tidak menyediakan alamat email.',
            ]);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'nama_lengkap' => $googleUser->getName() ?: Str::before($googleUser->getEmail(), '@'),
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

        return $this->tokenResponse($user, 'Google login successful');
    }

    private function googleUserFromIdToken(string $idToken): object
    {
        $response = Http::acceptJson()->get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        $allowedAudiences = array_filter([
            config('services.google.client_id'),
            config('services.google.android_client_id'),
        ]);

        if (! $response->successful() || ! in_array($response->json('aud'), $allowedAudiences, true)) {
            throw new \RuntimeException('Invalid Google ID token.');
        }

        if ($response->json('email_verified') !== 'true') {
            throw new \RuntimeException('Google email is not verified.');
        }

        return new class($response->json()) {
            public function __construct(private array $data) {}

            public function getEmail(): ?string
            {
                return $this->data['email'] ?? null;
            }

            public function getName(): ?string
            {
                return $this->data['name'] ?? $this->data['given_name'] ?? null;
            }
        };
    }

    private function tokenResponse(User $user, string $message, int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'token' => $user->createToken('MobileAppToken')->plainTextToken,
            'user' => $user,
        ], $status);
    }

    /**
     * Handle mobile logout.
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * Get user profile.
     */
    public function user(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user()
        ], 200);
    }
}
