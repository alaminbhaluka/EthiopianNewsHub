<div class="card border border-primary">
    <div class="card-body">
        <form action="{{ route('admin.general-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="site_name">{{ __('admin.Site Name') }}</label>
                <input type="text" id="site_name" name="site_name" class="form-control" value="{{ $settings['site_name'] }}">
                @error('site_name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="site_logo">ওয়েবসাইটের লোগো (হেডার ও ফুটার)</label>
                <div class="mb-3">
                    @if (!empty($settings['site_logo']) && \Illuminate\Support\Str::startsWith($settings['site_logo'], 'data:image/'))
                        <img id="site-logo-preview" src="{{ $settings['site_logo'] }}" alt="বর্তমান সাইট লোগো" style="max-width:260px;max-height:100px;object-fit:contain;background:#f5f5f5;padding:8px;border:1px solid #ddd;">
                    @else
                        <div id="site-logo-preview-fallback" style="display:flex;align-items:center;gap:7px;background:#f5f5f5;padding:8px;border:1px solid #ddd;width:max-content;">
                            <img src="{{ asset('assets/tribune-mark.svg') }}" alt="লোগো আইকন" style="width:48px;height:48px;object-fit:contain;">
                            <img src="{{ asset('assets/tribune-wordmark.svg') }}" alt="ট্রিবিউন বাংলা" style="width:170px;height:48px;object-fit:contain;">
                        </div>
                        <img id="site-logo-preview" src="" alt="নতুন লোগোর প্রিভিউ" style="display:none;max-width:260px;max-height:100px;object-fit:contain;background:#f5f5f5;padding:8px;border:1px solid #ddd;">
                    @endif
                </div>
                <input type="file" id="site_logo" name="site_logo" class="form-control" accept="image/png,image/jpeg,image/webp">
                <small class="form-text text-muted">PNG, JPG অথবা WebP ফাইল দিন। সর্বোচ্চ ২ মেগাবাইট। একটি সম্পূর্ণ লোগো দিন—একই লোগো হেডার ও ফুটারে দেখা যাবে। নতুন ফাইল না দিলে বর্তমান লোগো অপরিবর্তিত থাকবে।</small>
                @error('site_logo')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <img src="{{ asset($settings['site_favicon']) }}" alt="" width="48px"> <br>
                <label for="site_favicon">{{ __('admin.Site Favicon') }}</label>
                <input type="file" id="site_favicon" name="site_favicon" class="form-control" accept="image/*">
                @error('site_favicon')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var logoInput = document.getElementById('site_logo');
        var logoPreview = document.getElementById('site-logo-preview');
        var fallbackPreview = document.getElementById('site-logo-preview-fallback');

        if (logoInput && logoPreview) {
            logoInput.addEventListener('change', function (event) {
                var file = event.target.files && event.target.files[0];
                if (!file) return;

                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    logoPreview.src = loadEvent.target.result;
                    logoPreview.style.display = 'inline-block';
                    if (fallbackPreview) fallbackPreview.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>
