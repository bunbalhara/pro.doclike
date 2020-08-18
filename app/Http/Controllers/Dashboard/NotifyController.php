<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\User;

use App\Models\Appointment;
use App\Models\AppointmentProposals;
use App\Models\FavouriteDoctor;

class NotifyController extends Controller
{
    public function modal() {
        if(auth()->user()->user_type == '2'){
            $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->
            whereDate('applied_date', date('Y-m-d'))->where('status', 1)->orderBy('id','desc')->get();
        }
        else{
            $appointments = Appointment::whereHas('appointmentShift', function($query) {
                return $query->where('date', date('Y-m-d'));
            })->whereHas('acceptPurposal')->where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id','desc')->get();
        }
    
        $friendsIds = FavouriteDoctor::where('user_id', auth()->user()->id)->where('status', 1)->pluck('doctor_id')->all();
        $friends = FavouriteDoctor::whereIn('user_id', $friendsIds)->where('doctor_id', auth()->user()->id)->where('status', 1)->get();

        $this->bladeContent['allData'] = Notification::where('status', 0)->where('type', '<>', 'video')->where('recieverId', auth()->user()->id);

        $this->bladeContent['notifyView'] = view('components.view.notify', $this->bladeContent)->render();
        $this->bladeContent['chatView'] = view('components.view.chatModal')->render();
        $this->bladeContent['chatListView'] = view('components.view.chatlist')->render();
        $this->bladeContent['chatCount'] = view('components.view.chatCount')->render();
        $this->bladeContent['chatList'] = view('components.view.chatUsers', compact('appointments', 'friends'))->render();

        return response()->json($this->bladeContent);
    }

    public function get() {
        $this->bladeContent['count'] = Notification::where('recieverId', auth()->user()->id)->where('status', 0)->count();
        $this->bladeContent['notify'] = Notification::where('recieverId', auth()->user()->id)->where('status', 0)->where('type', '<>', 'chat')->count();

        return response()->json($this->bladeContent);
    }
    
    public function setVideo(Request $request) {
        Notification::create([
            'senderId' => $request->senderId,
            'recieverId' => $request->receiverId,
            'message' => 'video calling now',
            'jobId' => $request->jobId,
            'type' => 'video'
        ]);
    }

    public function getVideo() {
        $calling = Notification::where('recieverId', auth()->user()->id)->where('status', 0)->where('type', 'video')->get();
        if($calling->count()) {
            $data = $calling->first();
            $user = User::find($data->recieverId);
            $this->bladeContent['image'] = $user->image();
            $this->bladeContent['name'] = $user->name;
            $this->bladeContent['id'] = $data->id;
            $this->bladeContent['jobId'] = $data->jobId;
            return response()->json($this->bladeContent);
        }
        return response()->json(['data' => false]);
    }

    public function setCall(Request $request) {
        Notification::where('id', $request->id)->update(['status' => $request->status]);
    }

    public function read(Request $request) {
        if ($request->date == 'today') {
            $allData = Notification::where('type', $request->type)->where('recieverId', auth()->user()->id)->whereDate('created_at', \Carbon\Carbon::today())->get();
        } else {
            $allData = Notification::where('type', $request->type)->where('recieverId', auth()->user()->id)->whereDate('created_at', '<>', \Carbon\Carbon::today())->get();
        }
        
        foreach($allData as $data) {
            $data->status = 1;
            $data->save();
        }
    }

    public function readAll() {
        $allData = Notification::where('recieverId', auth()->user()->id)->get();
        
        foreach($allData as $data) {
            $data->status = 1;
            $data->save();
        }
    }

    public function send(Request $request) {
        Notification::create($request->all());
    }
}
