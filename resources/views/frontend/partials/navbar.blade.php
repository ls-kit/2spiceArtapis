{{-- <div style="display: none">
<div class="navbar-container">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 visible-xs">
                <a href="{{ route('home') }}" class="btn-menu-toggle"><i class="cv cvicon-cv-menu"></i></a>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-6">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ $settings->logo }}" alt="{{ $settings->app_name }}" class="logo" />
                    <span>{{ $settings->app_name ? $settings->app_name : config('app_name') }}</span>
                </a>
            </div>
            <div class="col-lg-3 col-sm-10 hidden-xs">
                <ul class="list-inline menu">
                    <li class="{{ Request::is('music') ? 'color-active' : null }}">
                        <a href="{{ route('music') }}">Music</a>
                    </li>
                    <li class="{{ Request::is('comedy') ? 'color-active' : null }}">
                        <a href="{{ route('comedy') }}">Comedy</a>
                    </li>
                    <li class="{{ Request::is('talent') ? 'color-active' : null }}">
                        <a href="{{ route('talent') }}">Talents</a>
                    </li>
                    <li>
                        <a href="#">More</a>
                        <ul>
                            @foreach ($contents->where('type', 1)->where('status', 1) as $content)
                                <li>
                                    <a href="{{ $content->link }}">{{ $content->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 col-sm-8 col-xs-3" style="position: relative">
                <form action="{{ route('search') }}" method="get">
                    <div class="topsearch">
                        <i class="cv cvicon-cv-cancel topsearch-close"></i>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-search"></i></span>
                            <input type="text" name="keyword"
                                @if (isset($_GET['keyword'])) value="{{ $_GET['keyword'] }}" @endif
                                class="form-control" placeholder="Search" aria-describedby="sizing-addon2">
                            <div class="input-group-btn">
                                <div type="text" class="btn btn-default">
                                    <i class="cv cvicon-cv-video-file"></i>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                </form>
            </div>
            <dv class="col-lg-2 col-sm-4 hidden-xs">
                <div class="avatar pull-left">
                    @guest
                        <img src="{{ asset('assets/frontend/images/avatar.png') }}" alt="avatar" />
                    @endguest
                    @auth
                        <img src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif"
                            alt="{{ Auth::user()->name }}" height="44px" width="100%" class="user-logo" />
                    @endauth
                    <span class="status"></span>
                </div>
                <div class="selectuser pull-left">
                    <div class="btn-group pull-right dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            @auth
                                {{ Auth::user()->name }}
                            @endauth

                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @guest
                                <li><a href="{{ route('login') }}">Sign In</a>
                                </li>
                                <li><a href="{{ route('register') }}">Sign
                                        up</a></li>
                            @endguest
                            @auth
                                <li><a href="{{ route('public.home') }}">Dashboard</a>
                                </li>
                                <li><a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                        out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endauth
                            @foreach ($contents->where('type', 3)->where('status', 1) as $content)
                                <li>
                                    <a href="{{ $content->link }}">{{ $content->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </dv>
        </div>
        <div class="hidden-xs">
            <a href="{{ Route('public.upload') }}">
                <div class="upload-button">
                    <i class="cv cvicon-cv-upload-video"></i>
                </div>
            </a>
        </div>
    </div>
</div>
</div>
</div> --}}

<!-- header area  -->
<header class="ls_bg-dark ls_header">
    <div class="container-fluid">
        <div class="row ls_d-flex ls_align-center">
            <!-- left area  -->
            <div class="col-xs-5 ls_d-flex ls_align-center">
                <div class="ls_logo">
                    <!-- logo -->
                    <a class="" href="{{ route('home') }}">
                        <img src="{{ $settings->logo }}" alt="{{ $settings->app_name }}" class="img-responsive" />
                        <span>{{ $settings->app_name ? $settings->app_name : config('app_name') }}</span>
                    </a>
                </div>

                <!-- menu  -->
                <div class="ls_w-100 ls_d-flex ls_justify-center">
                    <ul class="list-inline menu ls_m-0 ls_menu ls_d-md-none">
                        <li class="{{ Request::is('music') ? 'color-active' : null }}">
                            <a href="{{ route('music') }}">Music</a>
                        </li>
                        <li class="{{ Request::is('comedy') ? 'color-active' : null }}">
                            <a href="{{ route('comedy') }}">Comedy</a>
                        </li>
                        <li class="{{ Request::is('talent') ? 'color-active' : null }}">
                            <a href="{{ route('talent') }}">Talents</a>
                        </li>
                        <li class="{{ Request::is('contact') ? 'color-active' : null }}">
                            <a href="{{ route('contactPage') }}">Contact</a>
                        </li>
                        @if(count($contents->where('type', 1)->where('status', 1)) > 0)
                        <li>
                            <a href="#">More</a>
                            <ul class="ls_dynamic-menu">
                                @foreach ($contents->where('type', 1)->where('status', 1) as $content)
                                    <li>
                                        <a href="{{ $content->link }}">{{ $content->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- middle area  -->
            <div class="col-xs-4">
                <form action="{{ route('search') }}" method="get" class="ls_d-md-none">
                    <div class="topsearch ls_m-0">
                        <i class="cv cvicon-cv-cancel topsearch-close"></i>
                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-search ls_color-primary"></i></span>
                            <input type="text" name="keyword"
                                @if (isset($_GET['keyword'])) value="{{ $_GET['keyword'] }}" @endif
                                class="form-control" placeholder="Search for artists, song, albums!" aria-describedby="sizing-addon2">
                            <div class="input-group-btn">
                                <div type="text" class="btn btn-default"></div>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                </form>
                <div id="searchResultDiv" class="ls_d-md-none" style="position: absolute;z-index:1; width:95%">

                </div>
            </div>

            <!-- right area  -->
            <div class="col-xs-3 ls_d-flex ls_justify-end">
                <div class="ls_d-flex ls_align-center ls_d-md-none">
                    <ul class="list-inline menu ls_m-0 ls_menu ls_text-white">
                        @guest
                            <li class="ls_px-0"><a href="{{ route('login') }}" class="ls_px-0 ls_fw-600">Sign In</a>
                            </li>
                            <li class="ls_px-0">
                                <span>/</span>
                            </li>
                            <li class="ls_px-0"><a href="{{ route('register') }}" class="ls_px-0 ls_fw-600">Sign
                                    up</a></li>
                        @endguest
                        @auth
                            <li><a href="{{ route('public.home') }}" class="ls_px-0  ls_fw-600">Dashboard</a>
                            </li>
                            <li class="ls_px-0">
                                <span>/</span>
                            </li>
                            <li><a href="{{ route('logout') }}" class="ls_px-0  ls_fw-600"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                    out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                        @foreach ($contents->where('type', 3)->where('status', 1) as $content)
                            <li>
                                <a href="{{ $content->link }}">{{ $content->name }}
                                </a>
                            </li>
                        @endforeach
                        @auth
                        <a href="{{ Route('public.upload') }}" class="ls_btn ls_btn-upload">
                            <img src="{{ asset('assets/frontend/images/upload.svg') }}" alt="upload">
                        </a>
                        @endauth
                    </ul>

                    <div class="avatar ls_p-0">
                        @guest
                            <img src="{{ asset('assets/frontend/images/user.svg') }}" alt="avatar" class="ls_avatar-icon" />
                        @endguest
                        @auth
                            <img src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif"
                                alt="{{ Auth::user()->name }}" height="44px" width="100%" class="user-logo" />
                            <span class="status"></span>
                        @endauth
                    </div>

                    @guest
                    <a href="{{ Route('public.upload') }}" class="ls_btn">
                        <img src="{{ asset('assets/frontend/images/upload.svg') }}" alt="upload">
                        Upload
                    </a>
                    @endguest
                </div>

                <a href="javascript:void(0)" id="ls_search-btn" class="ls_d-none ls_d-md-block ls_text-white ls_mr-10"><i class="fa fa-search ls_color-primary"></i></a>
                <a href="{{ route('home') }}" class="btn-menu-toggle ls_m-0 ls_d-none ls_d-md-block ls_text-white"><i class="cv cvicon-cv-menu"></i></a>
            </div>

        </div>
    </div>
</header>

<div class="container-fluid ls_mob-search ls_visible-hidden-mob" id="ls_form-expand">
    <form action="{{ route('search') }}" method="get">
        <div class="topsearch ls_m-0">
            <i class="cv cvicon-cv-cancel topsearch-close"></i>
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-search ls_color-primary"></i></span>
                <input type="text" name="keyword"
                    @if (isset($_GET['keyword'])) value="{{ $_GET['keyword'] }}" @endif
                    class="form-control" placeholder="Search for artists, song, albums!" aria-describedby="sizing-addon2">
                <div class="input-group-btn">
                    <div type="text" class="btn btn-default"></div>
                </div><!-- /btn-group -->
            </div>
        </div>
    </form>
    <div id="searchResultDiv2"></div>
</div>
