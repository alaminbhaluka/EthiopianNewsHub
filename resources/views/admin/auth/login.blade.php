<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light">
  <title>অ্যাডমিন লগইন | TribuneBangla</title>
  <style>
    *{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:"Noto Sans Bengali","Hind Siliguri",system-ui,sans-serif;background:linear-gradient(135deg,#071b33 0%,#123d61 52%,#0a263f 100%);color:#172b42;display:flex;align-items:center;justify-content:center;padding:28px 16px}
    .shell{width:100%;max-width:1040px;display:grid;grid-template-columns:1.05fr .95fr;overflow:hidden;border-radius:24px;background:#fff;box-shadow:0 28px 80px rgba(0,0,0,.28)}
    .intro{padding:58px 48px;background:linear-gradient(150deg,rgba(5,25,48,.94),rgba(13,66,99,.95)),radial-gradient(circle at 20% 20%,#27769a,transparent 55%);color:#fff;display:flex;flex-direction:column;justify-content:space-between;min-height:570px}
    .brand{display:flex;align-items:center;gap:13px}.brand-mark{width:48px;height:48px;border-radius:14px;background:#e33b36;display:grid;place-items:center;font-weight:900;font-size:25px;color:white}.brand-name{font-size:23px;font-weight:800;letter-spacing:.2px}.brand-name span{color:#ff6b61}
    .intro h1{font-size:36px;line-height:1.5;margin:62px 0 14px}.intro p{font-size:16px;line-height:2;color:#d5e4ef;margin:0;max-width:390px}.intro-foot{font-size:13px;color:#b8ccdc}
    .panel{padding:58px 52px;display:flex;flex-direction:column;justify-content:center}.eyebrow{color:#df3e38;font-size:13px;font-weight:800;letter-spacing:1px}.panel h2{font-size:29px;margin:10px 0 7px;color:#102a43}.sub{color:#718096;margin:0 0 30px;font-size:14px;line-height:1.8}
    label{display:block;font-weight:700;font-size:14px;margin:0 0 9px;color:#253b52}.field{margin-bottom:20px}.input-wrap{position:relative}.input-wrap .symbol{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#718096;font-size:17px}.input-wrap input{width:100%;height:52px;border:1px solid #d8e0e8;border-radius:11px;padding:0 15px 0 45px;font-size:15px;outline:none;transition:.2s;background:#fbfcfe}.input-wrap input:focus{border-color:#1e668e;box-shadow:0 0 0 4px rgba(30,102,142,.11);background:#fff}
    .meta{display:flex;align-items:center;justify-content:space-between;margin:2px 0 24px;font-size:13px}.remember{display:flex;align-items:center;gap:8px;color:#5d6b7b}.remember input{accent-color:#164f75;width:16px;height:16px}.meta a{color:#1b5d83;text-decoration:none;font-weight:700}.submit{width:100%;height:52px;border:0;border-radius:11px;background:linear-gradient(100deg,#df3935,#b9222d);color:white;font-size:16px;font-weight:800;cursor:pointer;box-shadow:0 8px 18px rgba(185,34,45,.2)}.submit:hover{filter:brightness(.96)}.error{color:#c62828;font-size:13px;margin-top:7px}.notice{padding:11px 13px;background:#fff4e5;border:1px solid #ffe0b2;color:#8a4b08;border-radius:9px;font-size:13px;margin-bottom:18px}.success{background:#eaf8ef;border-color:#bde7c9;color:#176b35}.secure{margin-top:24px;text-align:center;color:#8793a1;font-size:12px}
    @media(max-width:760px){body{padding:14px;align-items:flex-start}.shell{max-width:480px;grid-template-columns:1fr;border-radius:18px}.intro{min-height:auto;padding:25px 25px 27px}.intro h1{font-size:24px;margin:28px 0 7px}.intro p{font-size:13px}.intro-foot{display:none}.panel{padding:32px 25px 35px}.panel h2{font-size:25px}.sub{margin-bottom:23px}}
  </style>
</head>
<body>
  <main class="shell">
    <section class="intro">
      <div class="brand"><div class="brand-mark">T</div><div class="brand-name">Tribune<span>Bangla</span></div></div>
      <div><h1>সংবাদের সঙ্গে থাকুন,<br>সত্যের পাশে থাকুন।</h1><p>TribuneBangla-এর প্রশাসনিক ব্যবস্থাপনা প্যানেলে স্বাগতম। নিরাপদে প্রবেশ করে আপনার দায়িত্ব পালন করুন।</p></div>
      <div class="intro-foot">© {{ date('Y') }} TribuneBangla · সর্বস্বত্ব সংরক্ষিত</div>
    </section>
    <section class="panel">
      <div class="eyebrow">প্রশাসনিক প্রবেশ</div>
      <h2>অ্যাকাউন্টে লগইন করুন</h2>
      <p class="sub">আপনার নিবন্ধিত ইমেইল অথবা মোবাইল নম্বর এবং পাসওয়ার্ড ব্যবহার করুন।</p>
      @if (session()->has('success'))<div class="notice success">{{ session('success') }}</div>@endif
      @if (session()->has('error'))<div class="notice">{{ session('error') }}</div>@endif
      <form method="POST" action="{{ route('admin.handle-login') }}">
        @csrf
        <div class="field">
          <label for="login">ইমেইল অথবা মোবাইল নম্বর</label>
          <div class="input-wrap"><span class="symbol">✉</span><input id="login" type="text" name="login" value="{{ old('login') }}" placeholder="ইমেইল / 01XXXXXXXXX" autocomplete="username" required autofocus></div>
          @error('login')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label for="password">পাসওয়ার্ড</label>
          <div class="input-wrap"><span class="symbol">●</span><input id="password" type="password" name="password" placeholder="আপনার পাসওয়ার্ড লিখুন" autocomplete="current-password" required></div>
          @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="meta"><label class="remember"><input type="checkbox" name="remember" value="1"> আমাকে মনে রাখুন</label><a href="{{ route('admin.forgot-password') }}">পাসওয়ার্ড ভুলে গেছেন?</a></div>
        <button class="submit" type="submit">নিরাপদে লগইন করুন</button>
      </form>
      <div class="secure">🔒 আপনার লগইন তথ্য সুরক্ষিত সংযোগে পাঠানো হবে</div>
    </section>
  </main>
</body>
</html>