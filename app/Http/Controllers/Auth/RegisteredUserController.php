<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $phone = preg_replace('/\D+/', '', (string) $request->input('phone', ''));
        if (str_starts_with($phone, '880')) {
            $phone = '0' . substr($phone, 3);
        }
        $request->merge(['phone' => $phone]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^01[3-9][0-9]{8}$/', 'unique:users,phone'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.required' => 'মোবাইল নম্বর লিখুন।',
            'phone.regex' => 'সঠিক ১১ সংখ্যার বাংলাদেশি মোবাইল নম্বর লিখুন।',
            'phone.unique' => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে নিবন্ধন করা হয়েছে।',
            'email.unique' => 'এই ইমেইল ঠিকানা দিয়ে ইতোমধ্যে নিবন্ধন করা হয়েছে।',
            'password.confirmed' => 'দুটি পাসওয়ার্ড মিলছে না।',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
