<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Chat;
use App\Models\Appointment;
use App\Models\AppointmentProposals;
use App\Models\FavouriteDoctor;

use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\AccessToken;
use Twilio\Rest\Client;

class ChatController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index() {
    $appointment = Appointment::where('id', auth()->user())->first();
    if($appointment->status != 1){
        //abort(404, 'Page not found');
    }
    $auth = auth()->user();
    $imageUrl = '';
    $chatUserName = '';
    if($auth->id === $appointment->acceptPurposal->doctor->id){
        $imageUrl   = $appointment->user->image();
        $chatUserName = $appointment->user->name;
    }
    else{
        $imageUrl   = $appointment->acceptPurposal->doctor->image();
        $chatUserName = $appointment->acceptPurposal->doctor->name;
    }
    $this->bladeContent['appointment'] = $appointment;
    $this->bladeContent['imageUrl'] = $imageUrl;
    $this->bladeContent['chatUserName'] = $chatUserName;
    $this->bladeContent['userName'] = $auth->name;
    $this->bladeContent['userImage'] = $auth->image();
    $this->bladeContent['chatId'] = $id;
    $this->bladeContent['userId'] = $auth->id;
    $this->bladeContent['showheader'] = '1';

    $date = \Session::get('appointment_date');

    if(!$date){
        $date = date('Y-m-d');
    }

    $this->bladeContent['date']     = $date;
    $this->bladeContent['confirms'] = AppointmentProposals::where('doctor_id',$auth->id)->where('applied_date', '>=', $date)->where('status','1')->orderBy('id','desc')->get();

    return view('pages.dashboard.chat.index', $this->bladeContent);
  }

  public function page() {
    $setData = appMessages()->where('type', 'chat')->get();

    foreach ($setData as $data) {
        $data->status = 2;
        $data->save();
    }
    $today = date('Y-m-d');

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
    $this->bladeContent['friends'] = FavouriteDoctor::whereIn('user_id', $friendsIds)->where('doctor_id', auth()->user()->id)->where('status', 1)->get();

    $this->bladeContent['appointments'] = $appointments;
    $this->bladeContent['active'] = 'chat';

    return view('pages.dashboard.chat.page', $this->bladeContent);
  }

  public function getInitData() {
    $auth = auth()->user();

    if($auth->user_type == '2'){
        $data = AppointmentProposals::where('doctor_id', auth()->user()->id)->whereDate('applied_date', '>=', date('Y-m-d'))->orderBy('id','desc')->where('status', 1)->first();

        foreach (appChats()->where('jobId', $data->appointment->id)->get() as $chat) {
            $chat->status = 1;
            $chat->save();
        }
    } else {
        $data = Appointment::whereHas('appointmentShift', function($query) {
            return $query->where('date', date('Y-m-d'));
        })->whereHas('acceptPurposal')->where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id','desc')->first();
    
        foreach (appChats()->where('jobId', $data->acceptPurposal->appointment_id)->get() as $chat) {
            $chat->status = 1;
            $chat->save();
        }
    }

    if($data) {
        if($auth->user_type == '2'){
            $id = $data->appointment->id;
        }
        else {
            $id = $data->id;
        }

        $view = $this->getView($id, 'job');

    } else {
        $view = '';
    }

    return response()->json(compact('view'));
  }

  public function chatData(Request $request) {
    $auth = auth()->user();
    $setData = appChats()->where('senderId', $auth->id)->get();
    foreach ($setData as $data) {
        $data->status = 1;
        $data->save();
    }
    $view = $this->getView($request->id, $request->type);
    return response()->json(compact('view'));
  }

  public function joinRoom(Request $request, $id) {
    $sid    = config('services.twilio.sid');
    $token  = config('services.twilio.token');
    $key    = config('services.twilio.key');
    $secret = config('services.twilio.secret');

    $client = new Client($sid, $token);

    $exists = $client->video->rooms->read([ 'uniqueName' => $id]);

    if (empty($exists)) {
       $client->video->rooms->create([
           'uniqueName' => $id,
           'type' => 'group',
           'recordParticipantsOnConnect' => false
       ]);
    }
    // A unique identifier for this user
    $identity = auth()->user()->name;
    $token = new AccessToken($sid, $key, $secret, 3600, $identity);
    $videoGrant = new VideoGrant();
    $videoGrant->setRoom($id);
    $token->addGrant($videoGrant);
    $auth = auth()->user();
    if($auth->user_type == '2'){
        $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->
        whereDate('applied_date', date('Y-m-d'))->where('status', 1)->orderBy('id','desc')->get();
    }
    else{
        $appointments = Appointment::whereHas('appointmentShift', function($query) {
            return $query->where('date', date('Y-m-d'));
        })->whereHas('acceptPurposal')->where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id','desc')->get();
    }
    $appointment = Appointment::where('id', $id)->first();
    //dd($appointment);
    $this->bladeContent['appointments'] = $appointments;
    $this->bladeContent['appointment'] = $appointment;
    $this->bladeContent['accessToken'] = $token->toJWT();
    $this->bladeContent['roomName']    = $id;
    $this->bladeContent['active']    = 'chat';

    return view('pages.dashboard.chat.video', $this->bladeContent);
  }

  private function getView($id, $action) {
      if ($action == 'job') {
        $appointment = Appointment::find($id);
        if ($appointment != null) {
            $setData = appMessages()->where('type', 'chat')->where('senderId', $appointment->user_id)->get();
    
            foreach ($setData as $data) {
                $data->status = 1;
                $data->save();
            }
    
            $auth = auth()->user();
    
            if ($appointment->acceptPurposal) {
                $imageUrl   = $appointment->acceptPurposal->doctor->image();
                $chatUserName = $appointment->acceptPurposal->doctor->name;
            } else {
                $imageUrl   = $appointment->user->image();
                $chatUserName = $appointment->user->name;
            }
    
            if(auth()->user()->user_type == '2'){
                $userImage = $appointment->user->image();
            }
            else{
                $userImage = $appointment->acceptPurposal->doctor->image();
            }
            $this->bladeContent['appointment'] = $appointment;
            $this->bladeContent['imageUrl'] = $imageUrl;
            $this->bladeContent['chatUserName'] = $chatUserName;
            $this->bladeContent['userName'] = auth()->user()->name;
            $this->bladeContent['userImage'] = $userImage;
            $this->bladeContent['chatId'] = $id;
            $this->bladeContent['userId'] = auth()->user()->id;
            $this->bladeContent['date'] = date('Y-m-d');
            $this->bladeContent['confirms'] = AppointmentProposals::where('doctor_id',auth()->user()->id)->where('applied_date', date('Y-m-d'))->where('status','1')->orderBy('id','desc')->get();
            $this->bladeContent['type'] = 'job';
        }
      } else {
        $user = User::find($id);

        $data = Appointment::create([
            'user_id' => auth()->user()->id,
            'patient_name' => $user->name,
            'category_id' => 0,
            'sub_category_id' => 0,
            'address' => 'chat',
            'city' => 'chat',
            'state' => 'chat',
            'latitute' => 0,
            'longitute' => 0
        ]);

        $chatId = $data->id;
        $data->delete();
        $this->bladeContent['imageUrl'] = $user->image();
        $this->bladeContent['chatUserName'] = $user->name;
        $this->bladeContent['userName'] = auth()->user()->name;
        $this->bladeContent['userImage'] = $user->image();
        $this->bladeContent['chatId'] = $chatId;
        $this->bladeContent['userId'] = auth()->user()->id;
        $this->bladeContent['type'] = 'friend';
        $this->bladeContent['user'] = $user;
      }

    return view('components.view.chat', $this->bladeContent)->render();
  }
}
