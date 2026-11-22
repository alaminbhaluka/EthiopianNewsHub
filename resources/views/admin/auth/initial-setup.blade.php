<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>অ্যাডমিন অ্যাকাউন্ট সেটআপ | TribuneBangla</title>
<style>
*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:18px;background:linear-gradient(135deg,#071b33,#164f75);font-family:"Noto Sans Bengali","Hind Siliguri",system-ui,sans-serif;color:#172b42}.card{width:100%;max-width:460px;background:#fff;border-radius:20px;padding:34px;box-shadow:0 24px 70px #0004}.brand{font-weight:900;color:#c92e36;font-size:20px;margin-bottom:24px}.brand span{color:#173c5b}h1{font-size:25px;margin:0 0 8px}p{color:#64748b;font-size:14px;line-height:1.8;margin:0 0 24px}label{display:block;font-size:14px;font-weight:700;margin:17px 0 8px}input{width:100%;height:50px;border:1px solid #d7e0e8;border-radius:10px;padding:0 13px;font-size:15px}button{width:100%;height:50px;border:0;border-radius:10px;background:#c92e36;color:white;font-size:16px;font-weight:800;margin-top:24px} .error{color:#c62828;font-size:13px;margin-top:6px}
</style></head><body><main class="card"><div class="brand">Tribune<span>Bangla</span></div><h1>অ্যাডমিন অ্যাকাউন্ট তৈরি</h1><p>নির্ধারিত মোবাইল নম্বরের জন্য আপনার নিজের গোপন পাসওয়ার্ড সেট করুন। কমপক্ষে ১২ অক্ষরের শক্তিশালী পাসওয়ার্ড ব্যবহার করুন।</p>
<form method="POST" action="{{ route('admin.initial-setup.store', ['token' => request()->route('token')]) }}">@csrf
<label for="name">আপনার নাম</label><input id="name" name="name" value="{{ old('name', 'TribuneBangla Administrator') }}" required maxlength="255">
<label for="password">নতুন পাসওয়ার্ড</label><input id="password" type="password" name="password" minlength="12" autocomplete="new-password" required>@error('password')<div class="error">{{ $message }}</div>@enderror
<label for="password_confirmation">পাসওয়ার্ড আবার লিখুন</label><input id="password_confirmation" type="password" name="password_confirmation" minlength="12" autocomplete="new-password" required>
<button type="submit">অ্যাকাউন্ট তৈরি করুন</button></form></main></body></html>