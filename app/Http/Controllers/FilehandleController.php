<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class FilehandleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadStoryVideo(Request $request)
    {
        if(auth()->user()->user_type != 1 && auth()->user()->user_type != 2)
        {
            return ['error' => 'permission denined'];
        }
        $rules = ['video_file' => 'required'];
        $error = FacadesValidator::make($request->all(), $rules);
        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $video = $request->file('video_file');
        $new_name = rand().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('story-media/videos'), $new_name);
        return response()->json([
            'success' => 'Video uploaded successfully',
            'origin_name' => $video->getClientOriginalName(),
            'file_name' => 'story-media/videos/'.$new_name
        ]);
    }

    public function uploadStoryImage(Request $request)
    {
        if(auth()->user()->user_type != 1 && auth()->user()->user_type != 2)
        {
            return ['error' => 'permission denined'];
        }
        $rules = ['image_file' => 'required'];
        $error = FacadesValidator::make($request->all(), $rules);
        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $video = $request->file('image_file');
        $new_name = rand().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('story-media/images'), $new_name);
        return response()->json([
            'success' => 'Image uploaded successfully',
            'origin_name' => $video->getClientOriginalName(),
            'file_name' => 'story-media/images/'.$new_name
        ]);
    }
}
