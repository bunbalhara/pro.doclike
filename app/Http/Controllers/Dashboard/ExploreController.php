<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryCommentRequest;
use App\Http\Requests\StoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\FavouriteDoctor;
use App\Models\Story;
use App\Models\StoryComment;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;

class ExploreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_comment_resource_of_story($story_id)
    {
        $comments = StoryComment::where('story_id', $story_id)->latest()->get();
        foreach($comments as &$comment)
        {
            $comment->created_ago = $comment->created_at->diffForHumans();
            $comment->user = User::where('id', $comment->patient_id)->first();
        }
        return $comments;
    }

    public function get_story_resource($story)
    {
        $result = $story;
        $result->created_ago = $story->created_at->diffForHumans();
        $comments = StoryComment::where('story_id', $story->id)->latest()->get()->toArray();
        $result->comment_count = count($comments);
        $result->like_count = count(array_filter($comments, function($cmt) { return $cmt['liked'] == 1; }));
        $result->dislike_count = count(array_filter($comments, function($cmt) { return $cmt['liked'] == -1; }));
        $result->comments = $this->get_comment_resource_of_story($story->id);
        $result->user = User::where('id', $story->doctor_id)->first();
        if(auth()->user()->user_type == 3) {
            $result->is_commented = count(array_filter($comments, function($cmt) { return $cmt['patient_id'] == auth()->id(); }));
        }
        return $result;
    }

    public function index()
    {
        $this->bladeContent['active'] = 'explore';

        $stories = [];
        if(auth()->user()->user_type == 2) {
            $stories = Story::where('doctor_id', auth()->id())->latest()->get();
        }
        else if(auth()->user()->user_type == 3) {
            $followed_doctor_ids = array_column(FavouriteDoctor::where('user_id', auth()->id())->get('doctor_id')->toArray(), 'doctor_id');
            $stories = Story::whereIn('doctor_id', $followed_doctor_ids)->latest()->get();
        }
        foreach($stories as &$story) {
            $story = $this->get_story_resource($story);
        }

        $this->bladeContent['stories'] = $stories;
        $this->bladeContent['followers'] = FavouriteDoctor::where('doctor_id', auth()->user()->id)->get();

        if(auth()->user()->user_type == 2) {
            return view('pages.dashboard.explore.doctor', $this->bladeContent);
        }
        else {
            return view('pages.dashboard.explore.patient', $this->bladeContent);
        }
    }

    public function addStory(Request $request) {
        if ($request->title) {
            $media_url = null;

            if ($request->postPhoto) {
                $image = $request->postPhoto;
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('story-media/images/'), $new_name);
                $media_url = '/story-media/images/'.$new_name;
            }
    
            if ($request->postVideo) {
                $video = $request->postVideo;
                $new_name = rand() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('story-media/videos/'), $new_name);
                $media_url = '/story-media/videos/'.$new_name;
            }
            
            Story::create([
                'doctor_id' => auth()->user()->id,
                'title'     => $request->title,
                'description'   => $request->description,
                'media_url'     => $media_url,
                'media_type'    => $request->type
            ]);
        }

        return redirect()->back();
    }

    public function addComment(Request $request)
    {
        if(auth()->user()->user_type != 3) {
            return redirect()->route('doctor-explore');
        }
        if(empty($request->story_id) || empty($request->body)) {
            return redirect()->route('doctor-explore');
        }
        $comment = new StoryComment([
            'story_id' => $request->story_id,
            'body' => $request->body,
            'patient_id' => auth()->id(),
            'liked' => $request->liked,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $comment->save();
        return redirect()->route('doctor-explore');
    }

    public function show(Request $request, $story)
    {
        $this->bladeContent['data'] = ['story' => $this->get_story_resource(Story::where('id', $story)->first())];
        return view('pages.blogs.explore', $this->bladeContent);
    }
}
