@extends('frontend.layout.app')
@section('second_navbar')
@include('frontend.partials.second_navbar')
@endsection
@section('main_section')
<div class="content-wrapper">

    <div class="ls_banner ls_d-flex ls_align-center" style="background-image: url({{ asset($settings->banner_image) }});">
        <div class="ls_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center ls_text-white">
                    <h2 class="ls_title-big">
                        @if (!empty($settings->banner_title))
                            {{ $settings->banner_title}}
                        @else
                            Let the World Hear You <br>
                            Music, Comedy, Dance, All Forms of Arts and Talents
                        @endif
                    </h2>
                    <div class="clearfix ls_d-flex ls_justify-center ls_py-20">
                        <p class="col-lg-8 ls_fz-18">
                            @if (!empty($settings->banner_description))
                            {{ $settings->banner_description}}
                        @else
                            Happiness is the center of all human endeavor. Good entertainment melts away stiffen sorrow to lift souls. This is why we are here. We want to stretch the limit. <br>
                            SpiceArt is a place for all latent musical talents, comedy, and other forms of arts and entertainment to be seen, enjoyed, and rewarded. <br>
                            We reward artistes (upcoming and established) with 2spice tokens just for uploading their work on our website for the listening/viewing pleasure of our beloved community people. Get paid per like on your post.
                        @endif
                        </p>
                    </div>
                    <div class="clearfix">
                        <a href="{{ route('register') }}" class="ls_btn ls_btn-big">SIGN UP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ls_banner-card">
        <div class="container ls_bg-dark ls_py-20">
            <div class="row ls_d-flex ls_align-center">
                <div class="col-xs-6">
                    <div class="ls_text-white ls_d-flex ls_align-center ls_d-block-mob">
                        <img src="{{ asset('assets/frontend/images/increasing.svg') }}" alt="" class="ls_avatar-icon">
                        <h5>Now Trending</h5>
                    </div>
                </div>
                <div class="col-xs-6 ls_d-flex ls_justify-end">
                    <div>
                        <form action="{{ route('getlocation') }}" method="get">
                            <div class="ls_d-flex ls_align-center">
                                <label for="forCountry" class="ls_text-white ls_m-0 ls_mr-10">Region</label>
                                <select class="form-control ls_btn-select " name="country" style="padding: 0;" id="forCountry"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    @foreach ($countries as $val)
                                        <option value="{{ $val }}"
                                            @if (getLocation() && $val == getLocation()) selected @endif>{{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Featured Videos -->
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-xs-12 ls_d-flex ls_align-center ls_justify-between">
                                <ul class="list-inline">
                                    <li>
                                        <a href="#" class="ls_color-primary">
                                            <span class="visible-xs">Featured</span>
                                            <span class="hidden-xs">Featured Videos</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="btn-group pull-right">
                                    <a href="javascript:void();" class="btn dropdown-toggle ls_color-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <span>Sort By</span>
                                      <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a href="{{Route("home.latest")}}">Latest</a></li>
                                      <li><a href="{{Route("home.view")}}">Mostly View</a></li>
                                      <li><a href="{{Route("home.like")}}">Mostly Liked</a></li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        <div class="row">
                            @forelse ($uploads->where('featured', 1) as $item)
                            <input type="hidden" name="upload_id" value="{{$item->id}}">
                            <div class="col-lg-3 col-sm-6 videoitem mx-2">
                                <div class="b-video">
                                    <div class="v-img">
                                        <a href="{{route('singleVideo', $item->id)}}"><img src="{{asset($item->thumbnail_image)}}" alt="" width="100%" height="215px" class="ls_obj-cover"></a>
                                        <div class="time">{{$item->upload_duration}}</div>
                                    </div>
                                    <div class="ls_height-1 v-desc">
                                        <a href="{{route('singleVideo', $item->id)}}">
                                            {{ substr($item->name,0, 50)."..." }}
                                        </a>
                                    </div>
                                    <div class="v-views ls_d-flex ls_align-center ls_justify-between">
                                        {{$item->view}} views.
                                    <div class="pull-right">
                                        @auth
                                            @if ($item->user_id == Auth::id())
                                                <a href="#" disabled class="btn "><i class="fa fa-thumbs-o-up" style="font-size: 1.2em"></i></a>
                                            @else
                                                @if (!$item->likes()->where('user_id', Auth::id())->first() )
                                                    <span class="btn like-icon" id="{{$item->id}}"><i class="fa fa-thumbs-up" style="font-size: 1.2em"></i></span>
                                                @else
                                                    <span class="btn like-icon" id="{{$item->id}}"><i class="fa fa-thumbs-down  " style="font-size: 1.2em"></i></span>
                                                @endif
                                            @endif
                                        @endauth
                                        @guest
                                            <span  disabled class="btn"><i class="fa fa-thumbs-up" style="font-size: 1.2em"></i></span>
                                        @endguest
                                        <small id="totalLikeshow" class="{{$item->id}}"> {{$item->likes->count('count')}} Likes</small>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-lg-3 col-sm-6 videoitem mx-2">
                                <div class="b-video">
                                    <p><strong>No Video Available for this Region</strong></p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                {{-- For Other Contnet --}}
                @if($others)
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li>
                                        <a href="#" class="color-active">
                                            <span class="visible-xs">Others</span>
                                            <span class="hidden-xs">Others Videos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        <div class="row">
                            @foreach ($others->where('featured', 1) as $item)
                            <div class="col-lg-3 col-sm-6 videoitem mx-2">
                                <div class="b-video">
                                    <div class="v-img">
                                        <a href="{{route('singleVideo', $item->id)}}"><img src="{{asset($item->thumbnail_image)}}" alt="" width="270px" height="215px" class="ls_obj-cover"></a>
                                        <div class="time">{{$item->upload_duration}}</div>
                                    </div>
                                    <div class="ls_height-1 v-desc">
                                        <a href="{{route('singleVideo', $item->id)}}">
                                            {{ substr($item->name,0, 50)."..." }}
                                        </a>
                                    </div>
                                    <div class="v-views ls_d-flex ls_align-center ls_justify-between">
                                        {{$item->view}} views.
                                        <div class="pull-right">
                                            @auth
                                                @if ($item->user_id == Auth::id())
                                                    <a href="#" disabled class="btn "><i class="fa fa-thumbs-o-up" style="font-size: 1.2em"></i></a>
                                                @else
                                                    @if (!$item->likes()->where('user_id', Auth::id())->first() )
                                                        <span class="btn like-icon" id="{{$item->id}}"><i class="fa fa-thumbs-up" style="font-size: 1.2em"></i></span>
                                                    @else
                                                        <span class="btn like-icon" id="{{$item->id}}"><i class="fa fa-thumbs-down  " style="font-size: 1.2em"></i></span>
                                                    @endif
                                                @endif
                                            @endauth
                                            @guest
                                                <span  disabled class="btn"><i class="fa fa-thumbs-up" style="font-size: 1.2em"></i></span>
                                            @endguest
                                            <small id="totalLikeshow" class="{{$item->id}}"> {{$item->likes->count('count')}} Likes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <!-- /Featured Videos -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom_script')
<script>
$(document).ready(function() {

// Like Video
$(document).on('click', '.like-icon', function() {
    var id = this.id;
    $.ajax({
        url: `/video/like/${id}`
        , type: 'GET'
        , success: function(data) {
            // console.log(data);
            if(data.data.click == 'like'){
                $('.like-icon#' +id).html('<i class="fa fa-thumbs-down" style="font-size: 1.2em"></i>')
            }else if(data.data.click == 'unlike'){
                $('.like-icon#' +id).html('<i class="fa fa-thumbs-up" style="font-size: 1.2em"></i>')
            }
            $('#totalLikeshow.' +id).html(`${data.data.likecount} like`)

        }
        , error: function(error) {
            console.log(error)
        }
    })
});


});
    </script>
    @endpush

