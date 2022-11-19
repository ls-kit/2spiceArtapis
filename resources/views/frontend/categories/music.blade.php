{{-- @extends('frontend.layout.app')
@section('second_navbar')
    @include('frontend.partials.second_navbar')
@endsection
@section('main_section')
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li>
                                        <a href="#" class="color-active">
                                            <span class="visible-xs">Featured</span>
                                            <span class="hidden-xs">Featured Videos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="cb-content videolist">
                        <div class="row">
                            @foreach ($uploads->where('featured', 1) as $item)
                            <div class="col-lg-3 col-sm-6 videoitem mx-2">
                                <div class="b-video">
                                    <div class="v-img">
                                        <a href="{{route('singleVideo', $item->id)}}"><img src="{{asset($item->thumbnail_image)}}" alt="" width="100%" height="215px" class="ls_obj-cover"></a>
                                        <div class="time">{{$item->upload_duration}}</div>
                                    </div>
                                    <div class="ls_height-1 v-desc">
                                        <a href="{{route('singleVideo', $item->id)}}">{{ substr($item->name,0, 50)."..." }}</a>
                                    </div>
                                    <div class="v-views">
                                        {{$item->view}} views.
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection --}}

{{-- @extends('frontend.layout.app')
@section('second_navbar')
    @include('frontend.partials.second_navbar')
@endsection
@section('main_section')
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Featured Videos -->
                <div class="content-block head-div">
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-8">
                                <ul class="list-inline">
                                    <li>
                                        <a href="#" class="color-active">
                                            <span class="visible-xs">Featured</span>
                                            <span class="hidden-xs">Featured Videos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cb-content videolist">
                        <div class="row">
                            @foreach ($uploads->where('featured', 1) as $item)
                            <div class="col-lg-3 col-sm-6 videoitem mx-2">
                                <div class="b-video">
                                    <div class="v-img">
                                        <a href="{{route('singleVideo', $item->id)}}"><img src="{{asset($item->thumbnail_image)}}" alt="" width="100%" height="215px"  class="ls_obj-cover"></a>
                                        <div class="time">{{$item->upload_duration}}</div>
                                    </div>
                                    <div class="ls_height-1 v-desc">
                                        <a href="{{route('singleVideo', $item->id)}}">{{ substr($item->name,0, 50)."..." }}</a>
                                    </div>
                                    <div class="v-views">
                                       {{$item->view}} views.
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('frontend.layout.app')
@section('second_navbar')
@include('frontend.partials.second_navbar')
@endsection
@section('main_section')
<div class="content-wrapper">

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



