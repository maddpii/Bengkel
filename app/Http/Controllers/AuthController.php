<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->onlyInput('email');
        }

        if (! $user->hasVerifiedEmail()) {
            return back()
                ->withErrors([
                    'email' => 'Akun ini belum aktif. Selesaikan verifikasi OTP dari proses pendaftaran terlebih dulu.',
                ])
                ->with('pending_verification_email', $user->email)
                ->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathFor($request->user()));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $existingUser = User::where('email', $validated['email'])->first();

        if ($existingUser && $existingUser->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah terdaftar dan aktif. Silakan login memakai akun tersebut.',
            ]);
        }

        if ($existingUser && $existingUser->role !== 'customer') {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah dipakai untuk akun staff. Gunakan email lain.',
            ]);
        }

        $user = $existingUser ?? new User();
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'phone' => $validated['phone'] ?? null,
            'email_verified_at' => null,
        ]);
        $user->save();

        $this->generateAndSendOtp($user);

        return redirect()
            ->route('verification.otp.notice', ['email' => $user->email])
            ->with('success', 'Akun berhasil dibuat. Masukkan kode OTP yang kami kirim ke email Anda untuk mengaktifkan akun.');
    }

    public function showOtpVerification(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        $email = (string) $request->query('email', old('email'));
        $user = $email ? User::where('email', $email)->first() : null;

        abort_if(! $user || $user->hasVerifiedEmail(), 404);

        return view('auth.verify-otp', [
            'email' => $user->email,
            'expiresAt' => $user->email_otp_expires_at,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || $user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => 'Akun tidak ditemukan atau sudah diverifikasi.',
            ]);
        }

        if (! $user->email_otp_code || ! $user->email_otp_expires_at || now()->greaterThan($user->email_otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.',
            ]);
        }

        if (! Hash::check($validated['otp'], $user->email_otp_code)) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak sesuai.',
            ]);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'email_otp_code' => null,
            'email_otp_expires_at' => null,
        ])->save();

        return redirect()
            ->route('login')
            ->with('success', 'Verifikasi berhasil. Akun Anda sudah aktif dan sekarang bisa login.');
    }

    public function resendOtp(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin(Auth::user());
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || $user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => 'Akun tidak ditemukan atau sudah diverifikasi.',
            ]);
        }

        $this->generateAndSendOtp($user);

        return redirect()
            ->route('verification.otp.notice', ['email' => $user->email])
            ->with('success', 'Kode OTP baru sudah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    protected function redirectAfterLogin(User $user)
    {
        return redirect()->to($this->redirectPathFor($user));
    }

    protected function redirectPathFor(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.reports.index'),
            'mekanik' => route('mechanic.bookings.index'),
            'kasir' => route('cashier.transactions.index'),
            'owner' => route('owner.reports.index'),
            default => route('home'),
        };
    }

    protected function generateAndSendOtp(User $user): void
    {
        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'email_otp_code' => Hash::make($otp),
            'email_otp_expires_at' => now()->addMinutes(10),
        ])->save();

        Mail::send('emails.auth-otp', [
            'user' => $user,
            'otp' => $otp,
            'expiresAt' => $user->email_otp_expires_at,
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Kode OTP Verifikasi Akun Bengkel Mobil');
        });
    }
}
