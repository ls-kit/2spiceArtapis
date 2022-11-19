@foreach ($comments as $reply)
    <!-- reply comment -->
    <div class="cl-comment" id="reply{{ $reply->id }}">
        <div class="cl-avatar"><a href="#"><img style=" height: 62;width: 70px;" src="{{ asset($reply->image) }}"></a>
        </div>
        <div class="cl-comment-text">
            <div class="cl-name-date"><a href="#">{{ $reply->user->name }}</a> .
                {{ $reply->created_at }}</div>
            <div class="cl-text">{{ $reply->body }}</div>
            <div class="cl-meta">
            </div>
        </div>
        @if ($reply->user->id == Auth::id())
            <span class="btn btn-sm pull-right comment-del" id="{{ $reply->id }}"><i
                    class="fa fa-minus-circle text-danger" style="font-size: 1.2em"></i></span>
        @endif

        <a data-toggle="collapse" href="#collapse{{ $reply->id }}" role="button" aria-expanded="false"
            aria-controls="collapseExample">Reply</a>
        <div class="collapse" id="collapse{{ $reply->id }}">
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
                    <form id="replyStore" data-replyForm="1">
                        <textarea name="body" rows="3" placeholder="Reply what you think?"></textarea>
                        <input type="hidden" name="upload_id" value="{{ $post_id }}" id="">
                        <input type="hidden" name="parent_id" value="{{ $reply->id }}" />
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
        <div class="clearfix"></div>
    </div>
    <!-- END reply comment -->
@endforeach
