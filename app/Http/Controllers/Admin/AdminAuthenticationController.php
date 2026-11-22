<?php

namespace App\\Http\\Controllers\\Admin;

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;
use Illuminate\\Support\\Facades\\Auth;
use Illuminate\\Support\\Facades\\Hash;
use Illuminate\\Support\\Facades\\Password;
use App\\Models\\Admin;
use Illuminate\\Validation\\Rules\\Password as PasswordRule;

class AdminAuthenticationController extends Controller
{
    public function initialSetup(string $token)
    {
        $expected = (string) env('ADMIN_SETUP_TOKEN', '');
        abort_unless($expected !== '' && hash_equals($expected, $token), 404);

        if (Admin::where('phone', '01798550045')->exists()) {
            return redirect()->route('admin.login')->with('success', 'অ্যাডমিন অ্যাকাউন্ট আগে থেকেই তৈরি আছে।');
        }

        return view('admin.auth.initial-setup');
    }

    public function storeInitialSetup(Request $request, string $token)
    {
        $expected = (string) env('ADMIN_SETUP_TOKEN', '');
        abort_unless($expected !== '' && hash_equals($expected, $token), 404);

        if (Admin::where('phone', '01798550045')->exists()) {
            return redirect()->route('admin.login')->with('success', 'অ্যাডমিন অ্যাকাউন্ট আগে থেকেই তৈরি আছে।');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', PasswordRule::min(12)],
        ], [
            'password.confirmed' => 'দুইবার লেখা পাসওয়ার্ড মিলেনি।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ১২ অক্ষরের হতে হবে।',
        ]);

        $admin = new Admin();
        $admin->forceFill([
            'name' => $validated['name'],
            'email' => 'admin@tribunebangla.com',
            'phone' => '01798550045',
            'password' => Hash::make($validated['password']),
            'status' => 1,
        ]);
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'অ্যাডমিন অ্যাকাউন্ট তৈরি হয়েছে। এখন মোবাইল নম্বর দিয়ে লগইন করুন।');
    }

    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function handleLogin(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string', 'max:190'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'ইমেইল অথবা মোবাইল নম্বর লিখুন।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
        ]);

        $login = trim($validated['login']);
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $login, 'password' => $validated['password'], 'status' => 1];
        } else {
            $digits = preg_replace('/\\D+/', '', $login);
            if (str_starts_with($digits, '880') && strlen($digits) === 13) {
                $digits = '0' . substr($digits, 3);
            }
            $credentials = ['phone' => $digits, 'password' => $validated['password'], 'status' => 1];
        }

        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'login' => 'ইমেইল/মোবাইল নম্বর অথবা পাসওয়ার্ড সঠিক নয়।',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        $status = Password::broker('admins')->sendResetLink($request->only('email'));

        return back()->with(
            $status === Password::RESET_LINK_SENT ? 'success' : 'error',
            __($status)
        );
    }

    public function resetPassword(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function handleResetPassword(Request $request)
    {
        $credentials = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::broker('admins')->reset($credentials, function ($admin, $password) {
            $admin->forceFill(['password' => Hash::make($password)])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
