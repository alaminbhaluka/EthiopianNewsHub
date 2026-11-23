<section class="wrapper__section p-0">
    <footer class="bg__footer-dark" style="padding:22px 0 10px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-center text-md-left mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        @php $siteLogo = $settings['site_logo'] ?? 'frontend/assets/images/logo1.png'; @endphp
                        <img src="{{ \Illuminate\Support\Str::startsWith($siteLogo, 'data:image/') ? $siteLogo : asset($siteLogo) }}" alt="ট্রিবিউন বাংলা" style="max-width:220px;max-height:52px;width:auto;object-fit:contain;">
                    </div>
                </div>
                <div class="col-md-5 text-center text-md-right">
                    <a href="{{ route('about') }}" class="text-white mx-2" style="font-size:13px;">আমাদের সম্পর্কে</a>
                    <a href="{{ route('contact') }}" class="text-white mx-2" style="font-size:13px;">যোগাযোগ</a>
                    @foreach ($socialLinks as $link)
                        <a href="{{ $link->url }}" class="text-white mx-1" aria-label="Social media"><i class="{{ $link->icon }}"></i></a>
                    @endforeach
                </div>
            </div>
            <div class="text-center mt-3 pt-2" style="border-top:1px solid rgba(255,255,255,.14);">
                <p class="text-white mb-0" style="font-size:11px;opacity:.72;">{{ @$footerInfo->copyright }}</p>
            </div>
        </div>
    </footer>
</section>
