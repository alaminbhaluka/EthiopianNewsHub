@php
    $languages = collect([(object) ['lang' => 'bn', 'name' => 'বাংলা']]);
    $FeaturedCategories = $siteCategories->take(6);
    $categories = $siteCategories->skip(6);
@endphp

<header class="bg-light">
    <!-- Navbar  Top-->
    <div class="topbar d-none d-sm-block">
        <div class="container ">
            <div class="row">
                <div class="col-sm-6 col-md-8">
                    <div class="topbar-left topbar-right d-flex">
                        <ul class="topbar-sosmed p-0">
                            @foreach ($socialLinks as $link)
                            <li><a href="{{ $link->url }}"><i class="{{ $link->icon }}"></i></a></li>
                            @endforeach
                        </ul>
                        <div class="topbar-text">{{ banglaDate(now(), 'EEEE, d MMMM yyyy') }}</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="list-unstyled topbar-right d-flex align-items-center justify-content-end">
                        <div class="topbar_language">
                            <select id="site-language">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->lang }}" {{ getLangauge() === $language->lang ? 'selected' : '' }}>{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <ul class="topbar-link">
                            @if (!auth()->check())
                            <li><a href="{{ route('login') }}">{{ __('frontend.Login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ __('frontend.Register') }}</a></li>
                            @else
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li><a onclick="event.preventDefault(); this.closest('form').submit();" href="{{ route('logout') }}">{{ __('frontend.Logout') }}</a></li>
                            </form>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Navbar Top  -->
    <div class="navigation-wrap navigation-shadow bg-white">
        <nav class="navbar navbar-hover navbar-expand-lg navbar-soft">
            <div class="container">
                <div class="offcanvas-header">
                    <div data-toggle="modal" data-target="#modal_aside_right" class="btn-md"><span class="navbar-toggler-icon"></span></div>
                </div>
                <figure class="mb-0 mr-lg-3 flex-shrink-0">
                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center">
                        <img src="{{ asset('assets/tribune-mark.png') }}" alt="ট্রিবিউন বাংলা" class="img-fluid" style="height:48px;width:48px;object-fit:contain;">
                        <img src="{{ asset('assets/tribune-wordmark.svg') }}" alt="ট্রিবিউন বাংলা" class="img-fluid" style="height:48px;width:170px;object-fit:contain;margin-left:7px;">
                    </a>
                </figure>
                <div class="collapse navbar-collapse justify-content-between" id="main_nav99">
                    <ul class="navbar-nav ml-auto ">
                        @foreach ($FeaturedCategories as $category)
                            <li class="nav-item"><a class="nav-link active" href="{{ route('news', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                        @endforeach
                        @if (count($categories) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> {{ __('frontend.More') }} </a>
                            <ul class="dropdown-menu animate fade-up">
                                @foreach ($categories as $category)
                                <li><a class="dropdown-item icon-arrow" href="{{ route('news', ['category' => $category->slug]) }}"> {{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}"> {{ __('frontend.About Us') }} </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}"> {{ __('frontend.contact') }} </a></li>
                    </ul>
                    <ul class="navbar-nav ">
                        <li class="nav-item search hidden-xs hidden-sm "><a class="nav-link" href="#"><i class="fa fa-search"></i></a></li>
                    </ul>
                    <div class="top-search navigation-shadow">
                        <div class="container">
                            <div class="input-group ">
                                <form action="{{ route('news') }}" method="GET">
                                    <div class="row no-gutters mt-3">
                                        <div class="col"><input class="form-control border-secondary border-right-0 rounded-0" type="search" value="" placeholder="খুঁজুন" id="example-search-input4" name="search"></div>
                                        <div class="col-auto"><button type="submit" class="btn btn-outline-secondary border-left-0 rounded-0 rounded-right"><i class="fa fa-search"></i></button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div id="modal_aside_right" class="modal fixed-left fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="widget__form-search-bar">
                        <form action="{{ route('news') }}" method="GET">
                            <div class="row no-gutters">
                                <div class="col"><input class="form-control border-secondary border-right-0 rounded-0" value="" placeholder="খুঁজুন" type="search" name="search"></div>
                                <div class="col-auto"><button type="submit" class="btn btn-outline-secondary border-left-0 rounded-0 rounded-right"><i class="fa fa-search"></i></button></div>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <nav class="list-group list-group-flush">
                        <ul class="navbar-nav ">
                            @foreach ($FeaturedCategories as $category)
                            <li class="nav-item"><a class="nav-link active text-dark" href="{{ route('news', ['category' => $category->slug]) }}"> {{ $category->name }}</a></li>
                            @endforeach
                            @if (count($categories) > 0)
                            <li class="nav-item">
                                <a class="nav-link active dropdown-toggle text-dark" href="#" data-toggle="dropdown">{{ __('frontend.More') }}</a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach ($categories as $category)
                                    <li><a class="dropdown-item" href="{{ route('news', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('about') }}"> {{ __('frontend.About Us') }} </a></li>
                            <li class="nav-item"><a class="nav-link text-dark" href="{{ route('contact') }}"> {{ __('frontend.contact') }} </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
