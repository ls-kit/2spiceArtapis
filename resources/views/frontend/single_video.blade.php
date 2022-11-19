@extends('frontend.layout.app')
@section('class', 'single-video')
@section('second_navbar')
    @include('frontend.partials.second_navbar')
@endsection
@push('custom_css')
    <style>
        .cl-comment-reply .cl-comment-reply {
            margin-left: 40px;
        }
    </style>
    <link href="https://vjs.zencdn.net/7.20.2/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet" />
    <link href="{{ asset('assets/frontend/css/single-video.css') }}" rel="stylesheet" />
@endpush
@section('main_section')
    {{-- For get upload for ajax like/unlike --}}
    <input type="hidden" name="upload_id" value="{{ $upload->id }}">
    {{-- For get user for ajax follow/follow --}}
    <input type="hidden" name="user_id" value="{{ $upload->user_id }}">
    @auth

        <input type="hidden" name="image"
            value="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif">
    @endauth
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xs-12 col-sm-12">
                    <div class="@if ($upload->sell && !$is_purchased) ls_purchase-box @endif">
                        @if ($upload->sell && !$is_purchased && !$is_author)
                            <div class="sv-video">
                                <a href=""><img src="{{ asset('images/premium.png') }}" alt="" width="auto"
                                        height="350px" class="ls_obj-cover"></a>
                            </div>
                        @else
                            @if ($upload->upload)
                                <video id="my-video" class="video-js ls_video-container" controls preload="auto"
                                    poster="{{ asset($upload->thumbnail_image) }}" data-setup="{}"
                                    @auth @if (auth()->user()->auto_play == false) autoplay="false" 
                                        @else muted autoplay 
                                        @endif @endauth
                                    @guest
muted autoplay @endguest>
                                    <source src="{{ asset($upload->upload) }}" type="video/mp4" />
                                </video>
                            @else
                                <div class="ls_single-img ls_mb-20">
                                    <div>
                                        <img src="{{ asset($upload->thumbnail_image) }}"
                                        >
                                    </div>
                                    @if (!empty($images))
                                        @foreach ($images as $image)
                                        <div>
                                            <img src="{{ asset($image->image) }}"
                                            >
                                        </div>
                                        @endforeach
                                    @endif
                                </div>


                                <div class="ls_multiple-img">
                                    <div>
                                        <img src="{{ asset($upload->thumbnail_image) }}"
                                        >
                                    </div>
                                    @if (!empty($images))
                                        @foreach ($images as $image)
                                        <div>
                                            <img src="{{ asset($image->image) }}"
                                            >
                                        </div>
                                        @endforeach
                                    @endif

                                </div>
                            @endif
                            {{-- For Next Link --}}
                            <input type="hidden" name="nextlink"
                                value="{{ route('singleVideo', $relatedUpload[0]['id']) }}">
                        @endif
                        <h1><a href="#">{{ $upload->name }}</a></h1>
                        @if ($upload->sell)
                            <div class="card">
                                <div class="card-body">
                                    @if (($upload->sell && $is_purchased) || $is_author)
                                        <a href="{{ route('user.download', $upload->id) }}"
                                            class="ls_btn ls_shadow-1 ls_mb-20 my-2">Download!</a>
                                    @else
                                        <a href="{{ route('user.buynow', $upload->id) }}"
                                            class="ls_btn ls_shadow-1 ls_mb-20 my-2">Buy Now</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- <div class="acide-panel acide-panel-top">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a href="#"><i class="cv cvicon-cv-watch-later" data-toggle="tooltip" data-placement="top" title="Watch Later"></i></a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a href="#"><i class="cv cvicon-cv-liked" data-toggle="tooltip" data-placement="top" title="Liked"></i></a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a href="#"><i class="cv cvicon-cv-flag" data-toggle="tooltip" data-placement="top" title="Flag"></i></a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                    <div class="author clearfix">
                        <div class="author-head ls_avatar-img">
                            <a href="#"><img
                                    src="@if ($upload->user->profile && $upload->user->profile->avatar_status == 1) {{ $upload->user->profile->avatar }} @else {{ Gravatar::get($upload->user->email) }} @endif"
                                    alt="{{ $upload->user->name }}" class="sv-avatar"></a>
                            <div class="sv-name">
                                <div><a href="{{ route('channelpage', $upload->user_id) }}">{{ $upload->user->name }}</a>
                                    . {{ App\Models\Upload::where('user_id', $upload->user_id)->count() }} Videos</div>
                                <div class="c-sub hidden-xs">
                                    @if (empty($followCheck))
                                        @auth
                                            <span class="c-f btn follow-btn">Follow</i></span>
                                        @endauth
                                        @guest
                                            <span class="c-f btn follow-btn ">Follow</i></span>

                                        @endguest
                                    @else
                                        <span class="c-f btn follow-btn">Unfollow</i></span>
                                    @endif
                                    <div class="c-s" id="totalFollowShow">
                                        {{ $upload->user->followers()->get()->count() }}
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


                            <a href="#" class="author-btn-add"><i class="cv cvicon-cv-plus"></i></a>
                        </div>
                        <div class="author-border">
                        </div>
                        <div class="sv-views">
                            <div class="sv-views-count d-flex">
                                @if (empty($likeCheck))
                                    @auth
                                        <span class="btn like-icon"><i class="fa fa-thumbs-up"
                                                style="font-size: 1.2em"></i></span>
                                    @endauth
                                    @guest
                                        <a href="{{ route('like', $upload->id) }}" class="btn"><i class="fa fa-thumbs-up"
                                                style="font-size: 1.2em"></i></a>
                                    @endguest
                                @else
                                    <span class="btn like-icon"><i class="fa fa-thumbs-down  "
                                            style="font-size: 1.2em"></i></span>
                                @endif
                                <small id="totalLikeshow"> {{ $upload->likes->count('count') }} Likes</small>

                                <small> {{ $upload->view }} views</small>
                            </div>
                            <div class="sv-views-progress">
                                <div class="sv-views-progress-bar ls_progress-bar"></div>
                            </div>
                            {{-- <div class="sv-views-stats">
                            <span class="percent">95%</span>
                            <span class="green"><span class="circle"></span> 39,852</span>
                            <span class="grey"><span class="circle"></span> 852</span>
                        </div> --}}
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        {{-- Social Share with jorenvanhocht/laravel-share pack --}}
                        <div class="social-btn-sp pull-right">
                            {!! $shareButtons !!}
                        </div>

                    </div>
                    <div class="info">
                        <div class="info-content">
                            {{-- <h4>Cast:</h4>
                        <p>Nathan Drake , Victor Sullivan , Sam Drake , Elena Fisher</p> --}}

                            <h4>Category </h4>
                            @switch($upload->category_id)
                                @case($upload->category_id == 1)
                                    <p>Music</p>
                                @break

                                @case($upload->category_id == 2)
                                    <p>Talent</p>
                                @break

                                @case($upload->category_id == 3)
                                    <p>Comedy</p>
                                @break

                                @default
                                    <p>No category Found</p>
                            @endswitch


                            <h4>About </h4>
                            <p>{!! $upload->description !!}</p>

                            {{-- <h4>Tags :</h4>
                        <p class="sv-tags">
                            <span><a href="#">Uncharted 4</a></span>
                            <span><a href="#">Playstation 4</a></span>
                            <span><a href="#">Gameplay</a></span>
                            <span><a href="#">1080P</a></span>
                            <span><a href="#">ps4Share</a></span>
                            <span><a href="#">+ 6</a></span>
                        </p> --}}

                            <div class="row date-lic">
                                <div class="col-xs-6">
                                    <h4>Release Date:</h4>
                                    <p>{{ $upload->release_date }}</p>
                                </div>
                                <div class="col-xs-6 ta-r">
                                    <h4>License:</h4>
                                    <p>Standard</p>
                                </div>
                            </div>
                        </div>

                        <div class="showless hidden-xs">
                            <a>Tell Us What You Think</a>
                        </div>

                        <!-- <div class="content-block head-div head-arrow head-arrow-top visible-xs">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="head-arrow-icon">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="cv cvicon-cv-next"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->

                        {{-- <div class="adblock2">
                        <div class="img">
                            <span class="hidden-xs">
                                Google AdSense<br>728 x 90
                            </span>
                            <span class="visible-xs">
                                Google AdSense 320 x 50
                            </span>
                        </div>
                    </div> --}}

                        <!-- similar videos -->
                        <div class="caption hidden-xs">
                            {{-- <div class="left">
                            <a href="#">Similar Videos</a>
                        </div> --}}
                            <div class="clearfix"></div>
                        </div>
                        <div class="single-v-footer">
                            <!-- comments -->
                            <div class="comments">
                                <div class="reply-comment">
                                    <div class="rc-header"><i class="cv cvicon-cv-comment"></i> <span
                                            class="semibold">{{ $upload->comments->count() }}</span> Comments</div>
                                    @auth
                                        <div class="rc-ava"><a href="#"><img
                                                    src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif"
                                                    alt=""></a></div>
                                    @endauth
                                    @guest
                                        <div class="rc-ava"><a href="#"><img
                                                    src="{{ asset('assets/frontend/images/ava5.png') }}"></a></div>
                                    @endguest
                                    <div class="rc-comment">
                                        <form id="commentStore" data-replyForm="0">
                                            <textarea id="body" rows="3" placeholder="Share what you think?"></textarea>
                                            <input type="hidden" id="upload_id" value="{{ $upload->id }}"
                                                id="">
                                            @auth

                                                <input type="hidden" id="image"
                                                    value="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif">
                                            @endauth
                                            <input type="hidden" id="image"
                                                value="{{ asset('assets/frontend/images/ava5.png') }}" id="">
                                            <button type="submit">
                                                <i class="cv cvicon-cv-add-comment"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="comments-list" id="commentList">
                                    @foreach ($upload->comments as $comment)
                                        <!-- comment -->
                                        <div class="cl-comment" id="comment{{ $comment->id }}">
                                            <div class="cl-avatar"><a href="#"><img
                                                        style=" height: 62;width: 70px;"
                                                        src="{{ asset($comment->image) }}"></a></div>
                                            <div class="cl-comment-text">
                                                <div class="cl-name-date"><a
                                                        href="#">{{ $comment->user->name }}</a> .
                                                    {{ $comment->created_at }}</div>
                                                <div class="cl-text">{{ $comment->body }}</div>
                                                <div class="cl-meta">
                                                    <span class="green reply-count"
                                                        id="reply-count{{ $comment->id }}"><span class="circle"></span>
                                                        @if (count($comment->replies) > 0)
                                                            {{ $comment->replies->count() }}
                                                        @else
                                                            0
                                                        @endif

                                                    </span> <span class="grey"></span>
                                                    <a data-toggle="collapse"
                                                        href="#collapseMainReply{{ $comment->id }}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="#collapseMainReply{{ $comment->id }}">Reply</a>
                                                </div>
                                                @if ($comment->user->id == Auth::id())
                                                    <span class="btn btn-sm pull-right comment-del"
                                                        id="{{ $comment->id }}"><i
                                                            class="fa fa-minus-circle text-danger"
                                                            style="font-size: 1.2em"></i></span>
                                                @endif
                                                <div class="cl-replies"><a data-toggle="collapse"
                                                        href="#collapse{{ $comment->id }}"
                                                        id="reply-count{{ $comment->id }}" role="button"
                                                        aria-expanded="false"
                                                        aria-controls="collapse{{ $comment->id }}">View all
                                                        <span id="reply-all-count{{ $comment->id }}">
                                                            @if (count($comment->replies) > 0)
                                                                {{ $comment->replies->count() }}
                                                            @else
                                                                0
                                                            @endif
                                                        </span>
                                                        replies <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="cl-flag"><a href="#"><i
                                                            class="cv cvicon-cv-flag"></i></a></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <!-- END comment -->
                                        <div class="collapse" id="collapseMainReply{{ $comment->id }}">
                                            <div class="reply-comment">
                                                @auth
                                                    <div class="rc-ava"><a href="#"><img
                                                                src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }}@else {{ Gravatar::get(Auth::user()->email) }} @endif"
                                                                alt=""></a></div>
                                                @endauth
                                                @guest
                                                    <div class="rc-ava"><a href="#"><img
                                                                src="{{ asset('assets/frontend/images/ava5.png') }}"
                                                                alt=""></a></div>
                                                @endguest
                                                <div class="rc-comment">
                                                    <form id="replyStore{{ $comment->id }}" data-replyForm="1">
                                                        <textarea name="body" rows="3" placeholder="Reply what you think?"></textarea>
                                                        <input type="hidden" name="upload_id"
                                                            value="{{ $upload->id }}" id="">
                                                        <input type="hidden" name="parent_id"
                                                            value="{{ $comment->id }}" />
                                                        @auth
                                                            <input type="hidden" name="image"
                                                                value="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif"
                                                                id="">
                                                        @endauth
                                                        <button id="replybtn" type="submit">
                                                            <i class="cv cvicon-cv-add-comment"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>

                                        <div class="collapse" id="collapse{{ $comment->id }}">
                                            @include('frontend.partials._comment_replies', [
                                                'comments' => $comment->replies,
                                                'post_id' => $upload->id,
                                                'parent_id' => $comment->parent_id,
                                            ])

                                        </div>
                                    @endforeach

                                    {{-- <div class="row hidden-xs">
                                    <div class="col-lg-12">
                                        <div class="loadmore-comments">
                                            <form action="#" method="post">
                                                <button class="btn btn-default h-btn">Load more Comments</button>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                                </div>
                            </div>
                            <!-- END comments -->
                        </div>
                    </div>
                    <div class="content-block head-div head-arrow visible-xs">
                        <!-- <div class="head-arrow-icon">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <i class="cv cvicon-cv-next"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->
                        {{-- <div class="adblock2 adblock2-v2">
                        <div class="img">
                            <span>Google AdSense 300 x 250</span>
                        </div>
                    </div> --}}
                    </div>
                </div>

                <!-- right column -->
                <div class="col-lg-4 col-xs-12 col-sm-12 hidden-xs">

                    <!-- up next -->
                    <div class="caption">
                        <div class="left">
                            <a href="#">Up Next</a>
                        </div>
                        <div class="right" id="autoplayDiv">
                            {{-- <a href="#">Autoplay <i class="cv cvicon-cv-btn-off"></i></a> --}}
                            @auth
                                <label class="custom-control teleport-switch">
                                    <span class="teleport-switch-control-description">Auto Play</span>
                                    <input type="checkbox" name="autoplay" class="teleport-switch-control-input"
                                        @if (auth()->user()->auto_play) checked @endif>
                                    <span class="teleport-switch-control-indicator"></span>
                                </label>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}">
                                    <label class="custom-control teleport-switch">
                                        <span class="teleport-switch-control-description">Auto Play</span>
                                        <input type="checkbox" disabled class="teleport-switch-control-input" checked>
                                        <span class="teleport-switch-control-indicator"></span>
                                    </label>
                                </a>
                            @endguest
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="list">
                        @forelse ($relatedUpload as $item)
                            <div class="h-video row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="v-img ls_video-thumbnail">
                                        <a href="{{ route('singleVideo', $item->id) }}"><img
                                                src="{{ asset($item->thumbnail_image) }}" alt=""></a>
                                        <div class="time">{{ $item->upload_duration }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="v-desc">
                                        <a href="{{ route('singleVideo', $item->id) }}">{{ $item->name }}</a>
                                    </div>
                                    <div class="v-views">
                                        {{ $upload->view }} views
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @empty
                            <div class="h-video row ">

                                <div class="col-lg-12 col-sm-12">
                                    <div class="v-desc ">
                                        <p class="text-center"><strong> No Video Available</strong></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endforelse
                        <!-- END up next -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('custom_script')
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        {{-- Video Js Plugin --}}
        <script src="https://vjs.zencdn.net/7.20.2/video.min.js"></script>
        <script>
            $(document).ready(function() {
                $(document).on('change', 'input[name="autoplay"]', function() {
                    // alert('welcome')
                    $.ajax({
                        url: '/ajax/autoplay',
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });
                let myVideo = document.getElementById('my-video');
                myVideo.addEventListener('ended', videoCompleted, false);


                function videoCompleted(e) {
                    let nextvideo = $('input[name="nextlink"]').val();
                    window.location.href = nextvideo;
                }

                // Like Video
                $(document).on('click', '.like-icon', function() {
                    let upload_id = $('input[name="upload_id"]').val();
                    $.ajax({
                        url: `/video/like/${upload_id}`,
                        type: 'GET',
                        success: function(data) {
                            // console.log(data);
                            if (data.data.click == 'like') {
                                $('.like-icon').html(
                                    '<i class="fa fa-thumbs-down" style="font-size: 1.2em"></i>'
                                )
                            } else if (data.data.click == 'unlike') {
                                $('.like-icon').html(
                                    '<i class="fa fa-thumbs-up" style="font-size: 1.2em"></i>')
                            }
                            $('#totalLikeshow').html(`${data.data.likecount} like`)

                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });

                // -------- FOLLOW AUTHOR --------//
                $(document).on('click', '.follow-btn', function() {
                    let user_id = $('input[name="user_id"]').val();
                    $.ajax({
                        url: `/author/follow/${user_id}`,
                        type: 'GET',
                        success: function(data) {
                            if (data.data.click == 'follow') {
                                $('.follow-btn').html('Follow')
                            } else if (data.data.click == 'unfollow') {
                                $('.follow-btn').html('Unfollow')
                            }
                            $('#totalFollowShow').html(data.data.followcount)

                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });
                // --------END FOLLOW AUTHOR --------//



                // -------- ADD COMMENT --------//

                $("#commentStore").submit(function(event) {
                    event.preventDefault();

                    var body = $('#body').val();
                    var upload_id = $('#upload_id').val();
                    var image = $('#image').val();


                    $.ajax({

                        url: "{{ url('/comment-store') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            body: body,
                            upload_id: upload_id,
                            image: image
                        },

                        success: function(data) {
                            console.log(data);
                            $('#commentStore')[0].reset();
                            $('#commentList').append(data.data);
                            // commentList();

                        }
                    })
                });

                // -------- END ADD COMMENT --------//

                // -------- DELETE COMMENT --------//
                $(document).on('click', '.comment-del', function() {
                    var id = this.id;
                    $.ajax({
                        url: "{{ url('/comment-delete/') }}/" + id,
                        type: 'get',
                        success: function(res) {
                            $(this).parents(".cl-comment-text").parents(".cl-comment").remove();
                            $(".cl-comment-reply#reply" + id).remove()



                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });
                // -------- END DELETE COMMENT --------//


                $("form").each(function() {

                    /* addEventListener onsubmit each form */
                    $(this).bind("submit", function(event) {
                        alert("found");
                        if ($(this).attr('data-replyForm') == 1) {
                            $.ajax({
                                url: "{{ url('/comment-store-reply') }}",
                                type: "POST",
                                dataType: 'json',
                                data: $(this).serialize(),
                                success: function(data) {
                                    var form = '#' + event.target.id;
                                    $(form).trigger("reset");
                                    console.log(data.count);

                                    var count = $('#reply-count' + data.comment[0]
                                        .parent_id).empty().prepend(data.count);
                                    var getData = data.data;

                                    $('#reply-all-count' + data.comment[0]
                                        .parent_id).empty().prepend(data.count);
                                    var commentId = '#collapse' + data.comment[0]
                                        .parent_id;
                                    $(commentId).append(getData);

                                }
                            });
                        }

                    });

                });
            });
        </script>
