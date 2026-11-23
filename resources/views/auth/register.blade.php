@extends('frontend.layouts.master')
@section('content')
<section class="wrap__section"><div class="container"><div class="row"><div class="col-md-12">
<div class="card mx-auto" style="max-width: 420px;"><div class="card-body">
<h4 class="card-title mb-4">নতুন অ্যাকাউন্ট নিবন্ধন</h4>
<form method="POST" action="{{ route('register.store') }}">@csrf
<div class="form-group"><label for="name">পূর্ণ নাম</label><input id="name" class="form-control" placeholder="আপনার পূর্ণ নাম লিখুন" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">@error('name')<p class="text-danger">{{ $message }}</p>@enderror</div>
<div class="form-group"><label for="phone">মোবাইল নম্বর</label><input id="phone" class="form-control" placeholder="01XXXXXXXXX" type="tel" name="phone" value="{{ old('phone') }}" required inputmode="numeric" autocomplete="tel" pattern="01[3-9][0-9]{8}" maxlength="11"><small class="form-text text-muted">বাংলাদেশি ১১ সংখ্যার মোবাইল নম্বর দিন।</small>@error('phone')<p class="text-danger">{{ $message }}</p>@enderror</div>
<div class="form-group"><label for="email">ইমেইল ঠিকানা</label><input id="email" class="form-control" placeholder="আপনার ইমেইল লিখুন" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">@error('email')<p class="text-danger">{{ $message }}</p>@enderror</div>
<div class="form-group"><label for="password">পাসওয়ার্ড</label><input id="password" class="form-control" placeholder="পাসওয়ার্ড লিখুন" type="password" name="password" required autocomplete="new-password">@error('password')<p class="text-danger">{{ $message }}</p>@enderror</div>
<div class="form-group"><label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label><input id="password_confirmation" class="form-control" placeholder="আবার পাসওয়ার্ড লিখুন" type="password" name="password_confirmation" required autocomplete="new-password"></div>
<div class="form-group"><button type="submit" class="btn btn-primary btn-block">নিবন্ধন করুন</button></div>
</form><p class="text-center mb-0">আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">প্রবেশ করুন</a></p>
</div></div></div></div></div></section>
@endsection
