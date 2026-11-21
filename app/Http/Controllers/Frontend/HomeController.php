<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\RecivedMail;
use App\Models\SocialCount;
use App\Models\SocialLink;
use App\Models\Subscriber;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index(\App\Services\TribuneNewsService $tribuneNews)
    {
        $posts = $tribuneNews->publishedNews(100);
        $categories = $tribuneNews->categories();

        $breakingNews = $posts->take(10);
        $heroSlider = $posts->take(7);
        $recentNews = $posts->take(6);
        $popularNews = $posts->sortByDesc('views')->take(4)->values();

        $categorySectionOne = $categories->get(0) ? $posts->where('category_id', $categories->get(0)->id)->take(8) : collect();
        $categorySectionTwo = $categories->get(1) ? $posts->where('category_id', $categories->get(1)->id)->take(8) : collect();
        $categorySectionThree = $categories->get(2) ? $posts->where('category_id', $categories->get(2)->id)->take(6) : collect();
        $categorySectionFour = $categories->get(3) ? $posts->where('category_id', $categories->get(3)->id)->take(4) : collect();

        $mostViewedPosts = $posts->sortByDesc('views')->take(3)->values();
        $socialCounts = collect();
        $mostCommonTags = collect();
        $ad = (object) [
            'home_top_bar_ad_status' => 0,
            'view_page_ad_status' => 0,
            'home_top_bar_ad_url' => '',
            'home_top_bar_ad' => '',
        ];

        return view('frontend.home', compact(
            'breakingNews', 'heroSlider', 'recentNews', 'popularNews',
            'categorySectionOne', 'categorySectionTwo', 'categorySectionThree',
            'categorySectionFour', 'mostViewedPosts', 'socialCounts',
            'mostCommonTags', 'ad'
        ));
    }

    public function ShowNews(string $slug, \App\Services\TribuneNewsService $tribuneNews)
    {
        $posts = $tribuneNews->publishedNews(200)->values();
        $index = $posts->search(function ($post) use ($slug) {
            return $post->slug === $slug;
        });

        abort_if($index === false, 404);

        $news = $posts->get($index);
        $recentNews = $posts->reject(function ($post) use ($slug) {
            return $post->slug === $slug;
        })->take(4)->values();
        $previousPost = $index > 0 ? $posts->get($index - 1) : null;
        $nextPost = $index < ($posts->count() - 1) ? $posts->get($index + 1) : null;
        $relatedPosts = $posts->filter(function ($post) use ($news) {
            return $post->slug !== $news->slug && $post->category_id === $news->category_id;
        })->take(5)->values();
        $mostCommonTags = collect();
        $socialCounts = collect();
        $ad = (object) ['view_page_ad_status' => 0];

        return view('frontend.news-details', compact(
            'news', 'recentNews', 'mostCommonTags', 'nextPost',
            'previousPost', 'relatedPosts', 'socialCounts', 'ad'
        ));
    }

    public function news(Request $request, \App\Services\TribuneNewsService $tribuneNews)
    {
        $posts = $tribuneNews->publishedNews(200);
        $categories = $tribuneNews->categories();

        if ($request->filled('category')) {
            $posts = $posts->filter(function ($post) use ($request) {
                return optional($post->category)->slug === $request->input('category');
            });
        }

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $posts = $posts->filter(function ($post) use ($term) {
                return mb_stripos($post->title, $term) !== false
                    || mb_stripos(strip_tags($post->content), $term) !== false
                    || mb_stripos(optional($post->category)->name ?? '', $term) !== false;
            });
        }

        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = $posts->values();
        $news = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $recentNews = $tribuneNews->publishedNews(6);
        $mostCommonTags = collect();
        $ad = (object) ['view_page_ad_status' => 0];

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ad'));
    }

    public function countView($news)
    {
        if(session()->has('viewed_posts')){
            $postIds = session('viewed_posts');

            if(!in_array($news->id, $postIds)){
                $postIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $postIds]);

        }else {
            session(['viewed_posts' => [$news->id]]);

            $news->increment('views');

        }
    }

    public function mostCommonTags()
    {
        return Tag::select('name', \DB::raw('COUNT(*) as count'))
            ->where('language', getLangauge())
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(15)
            ->get();
    }

    public function handleComment(Request $request)
    {

        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();
        toast(__('frontend.Comment added successfully!'), 'success');
        return redirect()->back();
    }

    public function handleReplay(Request $request)
    {

        $request->validate([
            'replay' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->replay;
        $comment->save();
        toast(__('frontend.Comment added successfully!'), 'success');

        return redirect()->back();
    }

    public function commentDestory(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        if(Auth::user()->id === $comment->user_id){
            $comment->delete();
            return response(['status' => 'success', 'message' => __('frontend.Deleted Successfully!')]);
        }

        return response(['status' => 'error', 'message' => __('frontend.Someting went wrong!')]);
    }

    public function SubscribeNewsLetter(Request $request)
    {
       $request->validate([
        'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
       ],[
        'email.unique' => __('frontend.Email is already subscribed!')
       ]);

       $subscriber = new Subscriber();
       $subscriber->email = $request->email;
       $subscriber->save();

       return response(['status' => 'success', 'message' => __('frontend.Subscribed successfully!')]);

    }

    public function about()
    {
        $about = About::where('language', getLangauge())->first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        $contact = Contact::where('language', getLangauge())->first();
        $socials = SocialLink::where('status', 1)->get();
        return view('frontend.contact', compact('contact', 'socials'));
    }

    public function handleContactFrom(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500']
        ]);

        try{
            $toMail = Contact::where('language', 'en')->first();

            /** Send Mail */
            Mail::to($toMail->email)->send(new ContactMail($request->subject, $request->message, $request->email));

            /** store the mail */

            $mail = new RecivedMail();
            $mail->email = $request->email;
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->save();

        }catch(\Exception $e){
            toast(__($e->getMessage()));
        }

        toast(__('frontend.Message sent successfully!'), 'success');

        return redirect()->back();
    }
}
