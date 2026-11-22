<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light"><title>পাসওয়ার্ড পুনরুদ্ধার | TribuneBangla</title>
<style>
*{box-sizing:border-box}body{margin:0;min-height:100vh;padding:22px 14px;display:grid;place-items:center;background:linear-gradient(135deg,#071b33,#123d61 55%,#0a263f);font-family:"Noto Sans Bengali","Hind Siliguri",system-ui,sans-serif;color:#172b42}.card{width:100%;max-width:470px;background:#fff;border-radius:20px;padding:38px;box-shadow:0 24px 70px #0004}.brand{font-size:21px;font-weight:900;color:#102a43;margin-bottom:30px}.brand span{color:#d93435}.eyebrow{font-size:12px;font-weight:800;color:#d93435;letter-spacing:1px}h1{font-size:27px;margin:8px 0;color:#102a43}.sub{color:#718096;font-size:14px;line-height:1.8;margin:0 0 25px}label{display:block;font-size:14px;font-weight:700;margin:0 0 8px}.field{margin-bottom:19px}input{width:100%;height:50px;border:1px solid #d8e0e8;border-radius:10px;padding:0 14px;font-size:15px}input:focus{outline:3px solid #1e668e22;border-color:#1e668e}.btn{width:100%;height:50px;border:0;border-radius:10px;background:linear-gradient(100deg,#df3935,#b9222d);color:#fff;font-size:15px;font-weight:800;cursor:pointer}.error{font-size:13px;color:#c62828;margin-top:6px}.notice{padding:11px 13px;border-radius:9px;background:#edf8f0;color:#176b35;margin-bottom:18px;font-size:13px}.back{display:block;text-align:center;margin-top:22px;color:#1b5d83;text-decoration:none;font-size:14px;font-weight:700}.foot{text-align:center;color:#8793a1;font-size:12px;margin-top:25px}@media(max-width:480px){.card{padding:28px 22px}}
</style></head><body>
<main class="card"><div class="brand">Tribune<span>Bangla</span></div><div class="eyebrow">অ্যাকাউন্ট নিরাপত্তা</div><h1>পাসওয়ার্ড পুনরুদ্ধার</h1><p class="sub">আপনার নিবন্ধিত ইমেইল ঠিকানা দিন। পাসওয়ার্ড পরিবর্তনের নির্দেশনা পাঠানো হবে।</p>
@if (session()->has('success'))<div class="notice">{{ session('success') }}</div>@endif
@if (session()->has('status'))<div class="notice">{{ session('status') }}</div>@endif
<form method="POST" action="{{ route('admin.forgot-password.send') }}">@csrf
<div class="field"><label for="email">ইমেইল ঠিকানা</label><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>@error('email')<div class="error">{{ $message }}</div>@enderror</div>
<button class="btn" type="submit">পুনরুদ্ধার লিংক পাঠান</button></form>
<a class="back" href="{{ route('admin.login') }}">← অ্যাডমিন লগইনে ফিরে যান</a><div class="foot">© {{ date('Y') }} TribuneBangla · সর্বস্বত্ব সংরক্ষিত</div></main></body></html>