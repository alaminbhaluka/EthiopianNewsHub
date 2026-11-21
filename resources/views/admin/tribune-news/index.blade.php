@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>সাইটে প্রকাশিত সংবাদ</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">ড্যাশবোর্ড</a></div>
            <div class="breadcrumb-item">TribuneBangla সংবাদ</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Supabase থেকে প্রকাশিত সংবাদ ({{ $news->count() }})</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>শিরোনাম</th>
                            <th>ক্যাটাগরি</th>
                            <th>প্রকাশের সময়</th>
                            <th>সূত্র</th>
                            <th>দেখুন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($news as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->title }}</strong>
                                    @if (strlen(strip_tags($item->content)) < 500)
                                        <div class="text-warning small">সংক্ষিপ্ত বডি</div>
                                    @endif
                                </td>
                                <td>{{ optional($item->category)->name }}</td>
                                <td>{{ $item->published_at ? date('d-m-Y H:i', strtotime($item->published_at)) : '—' }}</td>
                                <td>{{ $item->source_name ?: '—' }}</td>
                                <td><a href="{{ route('news-details', $item->slug) }}" target="_blank" rel="noopener">লাইভ পাতা</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">এখনো কোনো প্রকাশিত সংবাদ পাওয়া যায়নি। Supabase সংযোগ ও প্রকাশনার নীতি পরীক্ষা করুন।</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
