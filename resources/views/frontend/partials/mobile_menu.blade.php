<div class="mobile-menu">
    <div class="mobile-menu-head ls_bg-dark">
        <a href="#" class="mobile-menu-close"></a>
        <a class="navbar-brand" href="/">
            <img src="{{$settings->logo}}" alt="Project name" class="" />
            <span>{{($settings->app_name)? $settings->app_name : config('app_name')}}</span>
        </a>
        <div class="mobile-menu-btn-color">
            <img src="{{ asset('assets/frontend/images/icon_bulb_light.png') }}" alt="">
        </div>
    </div>
    <div class="mobile-menu-content">
        <div class="mobile-menu-user">
            <div class="mobile-menu-user-img">
                @guest
                    <img src="{{ asset('assets/frontend/images/ava11.png') }}" alt="">
                @endguest
                @auth
                    <img src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif"
                        alt="{{ Auth::user()->name }}" height="44px" width="100%" class="user-logo">
                @endauth
            </div>
            <p>
                @auth
                    {{ Auth::user()->name }}
                @endauth
            </p>
            <span class="caret"></span>
            <div class="selectuser pull-left">
                <div class="btn-group pull-right dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    </button>
                    <ul class="dropdown-menu">
                        @guest
                            <li><a href="{{ route('login') }}">Sign In</a></li>
                            <li><a href="{{ route('register') }}">Sign up</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('public.home') }}">Dashboard</a></li>
                        @endauth
                            @foreach ($contents->where('type', 3)->where('status', 1) as $content)
                                <li>
                                    <a href="{{$content->link}}">{{$content->name}} </a>
                                </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <a href="{{Route('public.upload')}}" class="btn ls_bg-primary mobile-menu-upload">
            <i class="cv cvicon-cv-upload-video"></i>
            <span>Upload Video</span>
        </a>
        <div class="mobile-menu-list">
            <ul>
                {{-- <li class="{{Request::is('/') ? 'color-active': null}}">
                    <a href="{{Route('home')}}">
                        <i class="cv cvicon-cv-play-circle ls_color-primary"></i>
                        <p>Popular Videos</p>
                    </a>
                </li> --}}
                <li class="{{Request::is('music') ? 'color-active': null}}">
                    <a href="{{Route('music')}}">
                        <i class="cv cvicon-cv-play-circle ls_color-primary"></i>
                        <p>Music</p>
                    </a>
                </li>
                <li class="{{Request::is('comedy') ? 'color-active': null}}">
                    <a href="{{Route('comedy')}}">
                        <i class="cv cvicon-cv-play-circle ls_color-primary"></i>
                        <p>Comedy</p>
                    </a>
                </li>
                <li class="{{Request::is('talent') ? 'color-active': null}}">
                    <a href="{{Route('talent')}}">
                        <i class="cv cvicon-cv-play-circle ls_color-primary"></i>
                        <p>Talent</p>
                    </a>
                </li>
                @foreach ($contents->where('type', 1)->where('status', 1) as $content)
                    <li>
                        <a href="{{$content->link}}">
                            {{$content->icon}} 
                            <p> {{$content->name}} </p>
                        </a>
                    </li>
                @endforeach
                
                {{-- <li>
                    <a href="#">
                        <i class="cv cvicon-cv-liked"></i>
                        <p>Liked Videos</p>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="#">
                        <i class="cv cvicon-cv-purchased"></i>
                        <p>Purchased Videos</p>
                    </a>
                </li> --}}
            </ul>
        </div>
        @guest
        <a href="{{ route('login') }}" class="btn mobile-menu-logout">Sign In</a>
        @endguest
        @auth
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn mobile-menu-logout">Sign out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth
        
    </div>
</div>
