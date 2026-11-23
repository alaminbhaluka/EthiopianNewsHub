@extends('frontend.layouts.master')

@section('content')
<section class="wrap__section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mx-auto" style="max-width: 380px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">অ্যাকাউন্টে প্রবেশ করুন</h4>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="login-identifier">ইমেইল অথবা মোবাইল নম্বর</label>
                                <input id="login-identifier" class="form-control" placeholder="ইমেইল / 01XXXXXXXXX" type="text" name="email" value="{{ old('email') }}" autocomplete="username" required>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="login-password">পাসওয়ার্ড</label>
                                <input id="login-password" class="form-control" placeholder="পাসওয়ার্ড লিখুন" type="password" name="password" autocomplete="current-password" required>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <a href="{{ route('password.request') }}" class="float-right">পাসওয়ার্ড ভুলে গেছেন?</a>
                                <label class="float-left custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" value="1" class="custom-control-input">
                                    <span class="custom-control-label">আমাকে মনে রাখুন</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">প্রবেশ করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-4 mb-0">অ্যাকাউন্ট নেই? <a href="{{ route('register') }}">নিবন্ধন করুন</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
