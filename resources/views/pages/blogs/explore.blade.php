<head>
    <link rel="icon" href="{{asset('fox/img/favicon.png')}}">
    <link href="{{asset('fox/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('fox/css/slick.css')}}" rel="stylesheet">
    <link href="{{asset('fox/css/slick-theme.css')}}" rel="stylesheet">
    <link href="{{asset('fox/css/aos.css')}}" rel="stylesheet">
    <link href="{{asset('fox/css/lity.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fox/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('fox/css/linearicons.css')}}">
    <link href="{{asset('fox/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('fox/css/color-1.css')}}" rel="stylesheet">
    <script src="{{asset('fox/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('fox/js/popper.min.js')}}"></script>
    <script src="{{asset('fox/js/bootstrap.min.js')}}"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script src="{{asset('fox/js/slick.min.js')}}"></script>
    <script src="{{asset('fox/js/waypoints.min.js')}}"></script>
    <script src="{{asset('fox/js/jquery.counterup.js')}}"></script>
    <script src="{{asset('fox/js/aos.js')}}"></script>
    <script src="{{asset('fox/js/lity.min.js')}}"></script>
    <script src="{{asset('fox/js/main.js')}}"></script>

    <link href="{{asset('theme/custom-css/blogs-explore.css')}}" rel="stylesheet">
</head>

<div class="container">
    <div class="page-header">
        <div class="header-bar"></div>
    </div>
    <div class="page-content">
        <div class="story-comment">
            <div class="story card">
                <div class="card-header">
                    <div class="user-info">
                        <img src="{{($story->user->profile_img ?? asset('front/img/user_logo.png'))}}" alt="" />
                        {{$story->user->name}}
                    </div>
                    <h5 class="title">{{$story->title}}</h5>
                    <span class="time-ago">{{$story->created_ago}}</span>
                </div>
                <div class="card-body">
                    @if($story->media_type != null && $story->media_type != '')
                    <div class="media">
                        @if($story->media_type == 'video')
                        <video src="{{asset($story->media_url)}}" controls></video>
                        @elseif($story->media_type == 'image')
                        <img src="{{asset($story->media_url)}}" alt="" />
                        @endif
                    </div>
                    @endif
                    <div class="description">
                        <pre>{{$story->description}}</pre>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="total-count">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        {{$story->comment_count}}
                    </span>
                    <span class="like-count">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        {{$story->like_count}}
                    </span>
                    <span class="dislike-count">
                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                        {{$story->dislike_count}}
                    </span>
                </div>
            </div>
            <div class="comments">
                @foreach($story->comments as $comment)
                <div class="comment card">
                    <div class="card-body">
                        <pre>{{$comment->body}}</pre>
                    </div>
                    <div class="card-footer">
                        <span class="auth-name">
                            <img src="{{((empty($comment->user->profile_img) || $comment->user->profile_img=='') ? asset('front/img/user_logo.png') : $comment->user->profile_img)}}" alt="" />
                            <span class="name">{{$comment->user->name}}</span>
                            <span class="liked">
                                @if($comment->liked == 1)
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                @else
                                <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                @endif
                            </span>
                        </span>
                        <span class="time-ago">{{$comment->created_ago}}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{url('front/js/jquery.mb.slider.js')}}"></script>
<script type="text/javascript" src="{{url('front/js/moment-round.js')}}"></script>
<script>
</script>
