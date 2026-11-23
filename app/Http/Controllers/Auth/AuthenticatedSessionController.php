<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'max:190'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'ইমেইল অথবা মোবাইল নম্বর লিখুন।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
        ]);

        $identifier = trim($validated['email']);
        $credentials = ['password' => $validated['password']];

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $identifier;
        } else {
            $phone = preg_replace('/\D+/', '', $identifier);
            if (str_starts_with($phone, '880') && strlen($phone) === 13) {
                $phone = '0' . substr($phone, 3);
            }
            $credentials['phone'] = $phone;
        }

        if (!Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'ইমেইল/মোবাইল নম্বর অথবা পাসওয়ার্ড সঠিক নয়।'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
