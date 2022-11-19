@foreach ($comments as $reply)
    <!-- reply comment -->

    <div class="cl-comment-reply" id="reply{{ $reply->id }}">
        <div class="cl-avatar"><a href="#"><img style=" height: 62;width: 70px;" src="{{ asset($reply->image) }}"></a>
        </div>
        <div class="cl-comment-text">
            <div class="cl-name-date"><a href="#">{{ $reply->user->name }}</a> .
                {{ $reply->created_at }}</div>
            <div class="cl-text">{{ $reply->body }}</div>
            <div class="cl-meta">
            </div>
        </div>
        <div class="cl-meta">
            <span class="green reply-count" id="reply-count{{ $reply->id }}"><span class="circle"></span>
                @if (count($reply->replies) > 0)
                    {{ $reply->replies->count() }}
                @else
                    0
                @endif

            </span> <span class="grey"></span>
            <a data-toggle="collapse" href="#collapseReply{{ $reply->id }}" role="button" aria-expanded="false"
                aria-controls="#collapseReply{{ $reply->id }}">Reply</a>
        </div>
        <div class="cl-replies"><a data-toggle="collapse" href="#collapse{{ $reply->id }}"
                id="reply-count{{ $reply->id }}" role="button" aria-expanded="false"
                aria-controls="collapse{{ $reply->id }}">View all
                <span id="reply-all-count{{ $reply->id }}">
                    @if (count($reply->replies) > 0)
                        {{ $reply->replies->count() }}
                    @else
                        0
                    @endif
                </span>
                replies <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        </div>
        @if ($reply->user->id == Auth::id())
            <span class="btn btn-sm pull-right comment-del" id="{{ $reply->id }}"><i
                    class="fa fa-minus-circle text-danger" style="font-size: 1.2em"></i></span>
        @endif

        <div class="collapse" id="collapseReply{{ $reply->id }}">
            <div class="reply-comment">
                @auth
                    <div class="rc-ava"><a href="#"><img
                                src="@if (Auth::user()->profile && Auth::user()->profile->avatar_status == 1) {{ Auth::user()->profile->avatar }}@else {{ Gravatar::get(Auth::user()->email) }} @endif"
                                alt=""></a></div>
                @endauth
                @guest
                    <div class="rc-ava"><a href="#"><img src="{{ asset('assets/frontend/images/ava5.png') }}"
                                alt=""></a></div>
                @endguest
                <div class="rc-comment">
                    <form id="replyStore{{ $reply->id }}" data-replyForm="1">
                        <textarea name="body" rows="3" placeholder="Reply what you think?"></textarea>
                        <input type="hidden" name="upload_id" id="upload_id" value="{{ $post_id }}"
                            id="">
                        <input type="hidden" name="parent_id" id="parent_id" value="{{ $reply->id }}" />
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
        <div class="collapse" id="collapse{{ $reply->id }}">
        </div>
        @include('frontend.partials._comment_replies', [
            'comments' => $reply->replies,
            'post_id' => $post_id,
            'parent_id' => $reply->id,
        ])
        <div class="clearfix"></div>
    </div>

    <!-- END reply comment -->
@endforeach
