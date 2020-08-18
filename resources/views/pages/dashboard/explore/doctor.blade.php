@extends('layouts.theme')

@section('style')
<style>
    .post-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        position: absolute;
        left: 24px;
        top: 10px;
        z-index: 22;
    }
    .panel {
        margin-bottom: 20px;
        background-color: #fff;
        /* border: 1px solid transparent; */
        border-radius: 3px;
    }
    .sidebar .list-group, .post > .panel, ul#filterby-post {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        border: 0;
    }
    .sun_pub_name {
        margin: 0 0 10px 64px;
        padding-top: 16px;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        pointer-events: none;
        border-radius: 5px;
    }
    textarea.form-control {
        resize: none!important;
    }
    textarea.postText {
        border: none;
        padding-top: 12px;
        padding-left: 50px;
        height: 45px;
        box-shadow: none;
    }
    .publisher-box textarea.postText {
        padding: 63px 35px 10px 50px;
        line-height: 1.628571;
        height: 112px;
        min-height: 112px;
        border-radius: 5px;
        color: inherit !important;
    }
    .sun_pub_mid_foot {
        position: relative;
    }
    .sun_pub_mid_foot {
        margin: 0 10px;
        border-top: 1px solid #e8e8e8;
        padding: 8px 3px;
        display: flex;
        align-items: center;
    }
    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        text-align: center;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        border-radius: 3px;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .sun_pub_mid_foot .poster-left-buttons .btn {
        padding: 0 6px;
        border-radius: 2em;
        height: 32px;
        transition: all 0.15s;
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 500;
        font-size: 13px;
        text-overflow: ellipsis;
        white-space: nowrap;
        line-height: 28px;
        background: #f3f3f3;
        width: 100%;
    }
    
    button, input, select, textarea {
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        text-align: right;
        opacity: 0;
        outline: 0;
        background: #fff;
        cursor: inherit;
        display: block;
    }
    .sun_pub_mid_foot .poster-left-buttons .btn img {
        width: 20px;
        height: 20px;
        margin-right: 1px;
        margin-top: -1px;
        border-radius: 3px;
        object-fit: cover;
    }
    .pub-footer-bottom {
        border-top: 1px solid #f4f4f4;
        padding: 11px 8px 7px;
    }
    .btn-main {
        color: #ffffff;
        background-color: #4d91ea;
        border-color: #4d91ea;
    }
    .publisher-box #publisher-button {
        height: 34px;
        padding: 5px 16px;
        border-radius: 17px;
        line-height: 19px;
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 500;
        letter-spacing: 0.7px;
        min-width: 130px;
    }
    #publisher-button:hover {
        background: #046d9f;
        color: white
    }
    #video-form  style="display: none"{
        border-top: 1px dashed #ededed;
    }
    #video-form  style="display: none"div.video-poster-image {
        width: 100%;
        overflow: hidden;
        background: #fff;
        padding: 7px;
    }
    #video-form  style="display: none"div.video-poster-image .thumb-renderer {
        width: 100%;
        display: table;
        min-height: 210px;
        overflow: hidden;
        border: 2px dashed #ccc;
        background: #fff;
        padding: 5px;
        transition: all .2s ease-in-out;
    }
    #video-form  style="display: none"div.video-poster-image .thumb-renderer #post_vthumb_droparea {
        vertical-align: middle;
        display: table-cell;
        text-align: center;
        color: #666;
    }
    #video-form  style="display: none"div.video-poster-image .thumb-renderer #post_vthumb_droparea div.preview svg {
        margin-top: 0;
        width: 50px;
        height: 50px;
        color: #cecece;
    }
    #video-form  style="display: none"div.video-poster-image .thumb-renderer #post_vthumb_droparea div.preview div p {
        font-size: 17px;
        margin: 8px 0 0;
        padding: 0;
        text-transform: lowercase;
    }
    .story.card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        border: 0;
        margin-left: 10px;
    }
    .story .post-avatar {
        width: 44px;
        height: 44px;
        display: block;
        border-radius: 50%;
        margin-left: -32px;
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
    }
    .verified-color {
        color: #55acee;
    }
    .description pre{
        font-size: 14px;
        color: #555;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif
    }
    .comment-btn {
        padding: 4px 8px;
        color: #555
    }
    .comment-btn i {
        font-size: 18px
    }
    .comment-btn:hover {
        background: #f4f6f8;
        cursor: pointer;
    }
    .comment {
        padding: 10px;
        background: #f2f3f5;
    }
    .comment .post-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 1px solid #f4f4f4;
        margin-left: -12px;
        box-shadow: none;
    }
    .comment-body {
        margin-left: 48px;
    }
    .comment-heading {
        display: flex;
        margin-bottom: 4px;
    }
    .sun_innr_comm {
        border-radius: 18px;
        display: block;
        padding: 8px 12px;
        background-color: #fff;
        position: relative;
        box-shadow: 0 0px 1px rgba(0, 0, 0, 0.1);
    }
    .sun_innr_comm pre {
        font-size: 14px;
        color: #777;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        margin-bottom: 0
    }
    .sun_innr_comm:before {
        content: '';
        display: block;
        position: absolute;
        left: -6px;
        top: 9px;
        width: 0;
        height: 0;
        border: 8px solid transparent;
        border-left-width: 0;
        border-right-color: #ffffff;
        cursor: default;
        z-index: 1;
        filter: drop-shadow(-1px 1px 0px rgba(0, 0, 0, 0.02));
    }
    .comment-options {
        font-size: 11px;
        color: #9197a3;
    }
    .card .sub-title {
        display: block;
        overflow: hidden;
        padding: 0 12px;
        line-height: 32px;
        font-size: 13px;
        color: #616770;
        font-weight: 600;
        background: #fff;
    }
    .card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        border: 0;
        padding: 10px
    }
    .story-card {
        margin-right: 10px;
        position: relative;
        line-height: 1;
        vertical-align: middle;
        width: 96px;
        height: 112px;
        display: block;
        user-select: none;
        text-decoration: none;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s;
        color: #7b7b7b;
        font-size: 13px;
        text-align: center;
        border: 1.5px dashed #cacaca;
        white-space: normal;
    }
    .wo_sidebar_users {
        margin: 12px 6px;
        padding: 0px 12px 12px;
        display: block;
        border-bottom: 1px solid #ebebeb;
        overflow: hidden;
    }
</style>
@endsection

@section('page')
<div class="container">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-6">
            <form action="{{route('add-story')}}" class="post publisher-box" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type">
                <div class="panel post panel-shadow sun_pub_box">
                    <div class="" id="post-textarea">
                        <div class="wo_pub_txtara_combo">
                            <img src="{{auth()->user()->image()}}" alt="" class="post-avatar">
                            <div class="pt-2">
                                <span class="sun_pub_name">{{auth()->user()->name}}</span>
                                <input class="form-control" name="title" style="display: none; margin-left: 50px; width: calc(100% - 60px)" placeholder="Title here..." required>
                            </div>
                            <textarea name="description" class="form-control postText ui-autocomplete-input" id="" cols="10" rows="3" placeholder="What's going on? #Hashtag.. @Mention.."></textarea>
                        </div>
                        <div class="publisher-hidden-option" id="video-form" style="display: none">
                            <div class="video-poster-image">
                                <div class="thumb-renderer pointer">
                                    <div class="" id="post_vthumb_droparea">
                                        <img src="" id="image_preview" class="w-100">
                                        <video class="w-100" controls id="video_preview"></video>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sun_pub_mid_foot">
                            <div class="poster-left-buttons mx-1">
                                <span class="btn btn-file img px-3">
                                    <img src="https://demo.wowonder.com/themes/sunshine/img/icons/pub-img.svg" alt="">
                                    Upload Images
                                    <input type="file" id="publisher-photo" accept="image/x-png, image/gif, image/jpeg" name="postPhoto">
                                </span>
                            </div>
                            <div class="poster-left-buttons mx-1">
                                <span class="btn btn-file poll-form pol px-3">
                                    <img src="https://demo.wowonder.com/themes/sunshine/img/icons/pub-poll.svg" alt="">
                                    CreatePoll
                                </span>
                            </div>
                            <div class="poster-left-buttons mx-1">
                                <span class="btn btn-file vid px-3">
                                    <img src="https://demo.wowonder.com/themes/sunshine/img/icons/pub-vid.svg" alt="">
                                    Upload Video
                                    <input type="file" id="publisher-video" name="postVideo" accept="video/*">
                                </span>
                            </div>
                            <div class="poster-left-buttons mx-1 add-btn">
                                <span class="btn mor px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,13H13V17H11V13H7V11H11V7H13V11H17M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"></path></svg>
                                </span>
                            </div>
                        </div>
                        <div class="pub-footer-bottom" style="display: none">
                            <div class="text-right">
                                <button class="btn btn-main" type="submit" id="publisher-button">
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="page-content">
                @foreach($stories as $story)
                <div class="story-comment">
                    <div class="story card">
                        <div class="card-header d-flex ml-3">
                            <img src="{{auth()->user()->image()}}" alt="" class="post-avatar">
                            <div class="ml-2 my-auto">
                                <div class="d-flex">
                                    <h6 class="title mb-0">
                                        <a href="{{route('blog-explore', $story->id)}}" target="_blank" class="link">
                                            {{$story->title}}
                                        </a>
                                    </h6>
                                    <span class="ml-2" style="color:#767994">
                                        <i class="fa fa-rocket fa-fw" title="" data-toggle="tooltip" data-original-title="Vip Member"></i>
                                    </span>
                                </div>
                                <p class="text-muted small mb-0">posted by {{$story->user->name}}, {{diff($story->created_at)}}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($story->media_type != null && $story->media_type != '')
                            <div class="media">
                                @if($story->media_type == 'video')
                                <video src="{{asset($story->media_url)}}" controls class="w-100"></video>
                                @elseif($story->media_type == 'image')
                                <img src="{{asset($story->media_url)}}" alt="" class="w-100" />
                                @endif
                            </div>
                            @endif
                            <div class="description">
                                <pre>{{$story->description}}</pre>
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div class="like-count comment-btn">
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        Like 
                                        @if ($story->like_count != 0)
                                        {{$story->like_count}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="total-count comment-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"> <path fill="currentColor" d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z"></path> </svg>
                                        Comment 
                                        @if ($story->comment_count != 0)
                                        {{$story->comment_count}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="dislike-count comment-btn">
                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        Dislike 
                                        @if ($story->dislike_count != 0)
                                        {{$story->dislike_count}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach($story->comments as $comment)
                        <div class="comment position-relative">
                            <img src="{{$comment->user->image()}}" alt="" class="post-avatar">
                            <div class="comment-body">
                                <div class="comment-heading">
                                    <div class="sun_innr_comm">
                                        <pre>{{$comment->body}}</pre>
                                    </div>
                                </div>
                                <div class="comment-options">
                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{$comment->created_ago}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="sub-title">Stories</div>
                <div class="d-flex">
                    <img src="{{auth()->user()->image()}}" alt="" class="story-card">
                    @if ($stories->where('media_type', 'image')->count())
                    <img src="{{asset($stories->where('media_type', 'image')->first()->media_url)}}" class="story-card">
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="sub-title">Trending !</div>
            </div>
            <div class="card">
                <div class="sub-title">People you may know</div>
                @foreach ($followers as $user)
                <div class="wo_sidebar_users">
                    <div class="d-flex">
                        <figure class="avatar">
                            <img src="{{$user->user->image()}}" class="rounded-circle" alt="avatar">
                        </figure>
                        <h5 class="ml-2 my-auto">{{$user->user->name}}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-1"></div>
    </div>    
</div>

@endsection

@section('script')
<script>
    $(document).on('click', '.wo_pub_txtara_combo', function() {
        postStatus();
    });

    $(document).on('change', '#publisher-photo', function() {
        $('input[name="type"]').val('image');
        readURL(this, 'image');
    });

    $(document).on('change', '#publisher-video', function() {
        $('input[name="type"]').val('video');
        readURL(this, 'video');
    });

    $('#submit_form').click(function() {
        if($('#title').val() == '' || $('#description').val() == '') {
            alert('Please fill title and description');
            return;
        }
        var type = $('#media_type').val();
        if(type == '') {
            $('#add-story-modal').submit();
            return;
        }
        type += '_file';
        mediaUpload(type);
    });

    $('#media_type').change(function() {
        var media = $(this).val();
        if(media == 'video') {
            $('#video-group').removeClass('hide');
            $('#image-group').addClass('hide');
            $('.video-preview').removeClass('hide');
            $('.image-preview').addClass('hide');
            $('.progress').removeClass('hide');
        }
        else if(media == 'image') {
            $('#video-group').addClass('hide');
            $('#image-group').removeClass('hide');
            $('.video-preview').addClass('hide');
            $('.image-preview').removeClass('hide');
            $('.progress').removeClass('hide');
        }
        else {
            $('#video-group').addClass('hide');
            $('#image-group').addClass('hide');
            $('.video-preview').addClass('hide');
            $('.image-preview').addClass('hide');
            $('.progress').addClass('hide');
        }
    });

    function readURL(input, type) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#video-form').css('display', 'block');
                if (type == 'image') {
                    $('#image_preview').attr('src', e.target.result);
                    $('#post_vthumb_droparea video').css('display', 'none');
                    $('#post_vthumb_droparea img').css('display', 'block');
                } else {
                    $('#video_preview')[0].src = URL.createObjectURL(input.files[0]);
                    $('#post_vthumb_droparea img').css('display', 'none');
                    $('#post_vthumb_droparea video').css('display', 'block');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
        postStatus();
    }

    function postStatus() {
        $('.sun_pub_name').css('display', 'none');
        $('input[name="title"]').css('display', 'block');
        $('textarea.postText').css('padding', '16px 35px 10px 50px');
        $('.pub-footer-bottom').fadeIn();
        $('.add-btn').css('display', 'none');
    }
</script>

@endsection
