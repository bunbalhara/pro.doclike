@extends('layouts.theme')

@section('style')

@endsection

@section('page')
<link rel="stylesheet" id="custom-styles" href="{{asset('theme/custom-css/dashboard-explore-patient.css')}}">

<div class="page-header">
    <div class="header-bar">
        <h3>Stories</h3>
    </div>
</div>
<div class="page-content">
    @foreach($stories as $story)
    <div class="story-comment">
        <div class="story card">
            <div class="card-header">
                <h5 class="title">
                    <a href="{{route('blog-explore', $story->id)}}" target="_blank" class="link">{{$story->title}}</a>
                </h5>
                <span class="time-ago">posted by {{$story->user->name}}, {{$story->created_ago}}</span>
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
                <div class="count-info">
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
                @if($story->is_commented == false)
                <div class="button-info">
                    <button class="btn btn-link add_comment" type="button" data-toggle="modal"
                        data-id="{{$story->id}}"
                        data-target="#add-comment-modal">
                        Leave Comment For At This story
                    </button>
                </div>
                @endif
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
                        commented by {{$comment->user->name}}
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
    @endforeach
</div>

<!-- Location Modal -->
<form action="{{route('add-comment')}}" method="POST" class="modal fade" id="add-comment-modal" tabindex="-1">
    @csrf
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Comment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="btn-group">
                    <button type="button" id="modal_like" class="btn btn-success">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        Like
                    </button>
                    <button type="button" id="modal_dislike" class="btn">
                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                        Dislike
                    </button>
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="body" id="body" rows="10" required></textarea>
                </div>

                <input class="hide" type="text" id="liked" value="1" name="liked" required />
                <input class="hide" type="text" id="story_id" name="story_id" required />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')

<script>
    $('#modal_like').click(function() {
        $(this).addClass('btn-success');
        $('#modal_dislike').removeClass('btn-success');
        $('#liked').val('1');
    });
    $('#modal_dislike').click(function() {
        $(this).addClass('btn-success');
        $('#modal_like').removeClass('btn-success');
        $('#liked').val('-1');
    });
    $('.add_comment').click(function() {
        var id = $(this).attr('data-id');
        $('#story_id').val(id);
    });
</script>

@endsection
