<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AppointmentProposals;
use App\Models\Notification;
use App\Models\Appointment;
use App\Models\CancelAppointment;
use App\Models\Chat;
use App\User;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentController extends Controller
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

    public function tableView() {
        $today = date('Y-m-d');

        $this->bladeContent['active'] = 'tableView';

        if (auth()->user()->user_type == 3) {
            $confirmIds = Appointment::whereHas('shift', function ($query) use($today) {
                $query->where('date', $today);
            })->where('user_id', auth()->user()->id)->where('status', '1')->pluck('id')->all();
            
            $this->bladeContent['confirmData'] = AppointmentProposals::whereIn('appointment_id', $confirmIds)->where('applied_date', $today)->where('status', '1')->orderBy('id','desc')->get();
        } else {
            $this->bladeContent['confirmData'] = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date', $today)->where('status', '1')->orderBy('id', 'desc')->get();
        }

        return view('pages.dashboard.appointments.table', $this->bladeContent);
    }

    public function calendar() {
        $this->bladeContent['active'] = 'calendarView';

        return view('pages.dashboard.appointments.calendar', $this->bladeContent);
    }

    public function calendarView(Request $request) {
        $start = $request->start_date;
        $end = $request->end_date;

        $diff = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date));

        $date = [];
        for ($i = 0; $i < $diff + 1; $i++) {
            $date[$i] = date('Y-m-d', strtotime($request->start_date . "+".$i." days"));
        }
        $this->bladeContent['date'] = $date;

        if (auth()->user()->user_type == 3) {
            $appointIds =  Appointment::whereHas('shift', function ($query) use($start, $end) {
                $query->whereBetween('date', [$start, $end]);
            })->where(function ($query) {
                $query->where('status', 1)->orWhere('status', 0);
            })->where('user_id', auth()->user()->id)->pluck('id')->all();
            
            $this->bladeContent['appData'] = AppointmentProposals::whereIn('appointment_id', $appointIds)->where(function ($query) use($start, $end) {
                $query->whereBetween('applied_date', [$start, $end])->where(function ($query) {
                    $query->where('status', 1)->orWhere('status', 0);
                });
            })->orderBy('applied_date', 'asc')->orderBy('applied_time', 'asc')->get();
        } else {
            $this->bladeContent['appData'] = AppointmentProposals::where('doctor_id', auth()->user()->id)->where(function ($query) use($start, $end) {
                $query->whereBetween('applied_date', [$start, $end]);
            })->orderBy('applied_date', 'asc')->orderBy('applied_time', 'asc')->get();
        }

        $view = view('components.view.calendarView', $this->bladeContent)->render();

        return response()->json(compact('view'));
    }

    public function pendingAppointment() {
        $today = date('Y-m-d');
        $pendingIds = Appointment::whereHas('shift', function ($query) use($today) {
            $query->where('date', $today);
        })->where('user_id', auth()->user()->id)->where('status', '0')->pluck('id')->all();

        $this->bladeContent['pendingData'] = AppointmentProposals::whereIn('appointment_id', $pendingIds)->where('applied_date', $today)->where('status', '0')->orderBy('id','desc')->get();
        $this->bladeContent['active'] = 'pending';
        
        return view('pages.dashboard.appointment.pending', $this->bladeContent);
    }

    public function pendingData() {
        $view = $this->getPendingView();
        return response()->json(compact('view'));
    }

    public function confirmAppointment() {
        if($auth->user_type == '3'){
            $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($todayDate) {
                $query->where('date', $todayDate);
            })->where('user_id',$auth->id)->where('status','1')->pluck('id')->all();
            $confirms = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where('applied_date',$todayDate)->where('status','1')->orderBy('id','desc')->get();
        }
        else{
            $confirms = AppointmentProposals::where('doctor_id', $auth->id)->where('applied_date', $todayDate)->where('status', '1')->orderBy('id', 'desc')->paginate(5);
        }

        $this->bladeContent['confirms'] = $confirms;
        $this->bladeContent['active'] = 'confirm';

        return view('pages.dashboard.appointment.confirm', $this->bladeContent);
    }

    public function getAppointment(Request $request) {
        $auth = auth()->user();
        $action = $request->action;

        if ($action == 'pending'){
            $date = $request->date;
            
            if ($auth->user_type == '3') {
                $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($date) {
                    $query->where('date', $date);
                })->where('user_id',$auth->id)->where('status','0')->pluck('id')->all();
                $appointments = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where('applied_date',$date)->where('status','0')->orderBy('id','desc')->get();
            
                $view = view('components.view.pendingSlick', compact('appointments'))->render();
            } else {
                $view = $this->doctorPendingView($date);
            }

            return response()->json(compact('view'));
        } else if ($action == 'confirm'){
            $date = $request->date;

            \Session::put('appointment_date',$date);

            if ($auth->user_type == '3') {
                $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($date) {
                    $query->where('date', $date);
                })->where('user_id',$auth->id)->where('status','1')->pluck('id')->all();
                $appointments = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where('applied_date',$date)->where('status','1')->orderBy('id','desc')->take(5)->get();
            
                $view = view('components.view.confirmSlick', compact('appointments'))->render();
            } else {
                $view = $this->doctorConfirmView($date);
            }

            return response()->json(compact('view'));
        } else if($action == 'confirm_request'){
            $date     = $request->date;
            $status   = $request->status;
            $idsArray = $request->idsArray;

            if ($auth->user_type == '3') {
                $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($date) {
                    $query->where('date', $date);
                })->where('user_id', $auth->id)->where('status',$status)->pluck('id')->all();

                $appointments = AppointmentProposals::where('status',$status)->where('applied_date',$date)->whereIn('appointment_id', $appointmentsIds)
                ->when($idsArray, function ($query) use($idsArray) {
                     return $query->whereNotIn('id',$idsArray);
                })->orderBy('id','desc')->paginate(5);
                
                $view = view('components.view.confirmList', compact('appointments'))->render();
            } else {
                $proposal = AppointmentProposals::where('status',$status)->where('applied_date',$date)->where('doctor_id',$auth->id)
                ->when($idsArray, function ($query) use($idsArray) {
                     return $query->whereNotIn('id',$idsArray);
                })->orderBy('id','desc')->paginate(5);

                if ($status == '0'){
                    $view = view('components.view.loadFalse', compact('proposal'))->render();
                } else {
                    $view = view('components.view.loadTrue', compact('proposal'))->render();
                }
            }

            return response()->json(compact('view'));
        } else if ($action == 'cancel') {
            $id = $request->id;

            AppointmentProposals::where('id', $id)->update(['status' => '3']);

            return response()->json(200);
        } else if ($action == 'cancel_request') {
            CancelAppointment::create([
                'appointment_id' => $request->id,
                'doctor_id' => auth()->user()->id
            ]);

            return response()->json(200);
        } else if ($action == 'job') {
            $date = $request->date;

            $jobData = Appointment::doesntHave('checkPurposal')->doesntHave('cancelAppointment')->whereHas('appointmentShift', function($query) use ($date) {
                return $query->where('date', $date);
            })->with('appointmentShift')->where('category_id', auth()->user()->category)->where('status', '0')->orderBy('id', 'desc')->get();
        
            $view = view('components.view.jobList', compact('jobData'))->render();
            return response()->json(compact('view'));
        } else {
            $id = $request->id;
            $appointmentId = $request->appointmentId;

            if ($auth->user_type == '3') {
                $id = $request->id;
                $appointmentId = $request->appointment;

                $purposal = AppointmentProposals::where('id', $id)->first();

                Chat::create([
                    'job_id'    => $appointmentId,
                    'user_id'   => $auth->id,
                    'doctor_id' => $purposal->doctor_id
                ]);

                Appointment::where('id', $appointmentId)->update(['status' => '1']);

                AppointmentProposals::where('id',$id)->update(['status' => '1']);

                $notification = [
                    'senderId'   => $auth->id,
                    'recieverId' => $purposal->doctor_id,
                    'jobId'      => $appointmentId,
                    'message'    => 'You appointment is scheduled on '.date('F j, Y',strtotime($purposal->applied_date)).' '.date('H:i',strtotime($purposal->applied_time)),
                    'type'       => 'appointment'
                ];

                Notification::create($notification);

                $appointment  = Appointment::where('id', $appointmentId)->first();

                $userName     = $appointment->user->name;
                $token        = $purposal->doctor->android_token;
                $date         = date('jS F Y',strtotime($purposal->applied_date));
                $time         = date('H:i',strtotime($purposal->applied_time));
                $iosTokeen    = $purposal->doctor->ios_token;

                if ($token) {
                    $this->job_notification($token,$date,$time,$userName);
                }
            }

            return response()->json(200);
        }
    }

    public function getView(Request $request) {
        $action = $request->action;
        $start_date = $request->start_date;
        $start_date = str_replace('-', '/', $start_date);

        $end_date = $request->end_date;
        $end_date = str_replace('-', '/', $end_date);

        if ($action == 'past') {
            if (auth()->user()->user_type == 2) {
                $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->where(function ($query) use($start_date, $end_date) {
                    $query->whereBetween('applied_date', [$start_date, $end_date]);
                })->orderBy('id', 'desc')->get();
            } else {
                $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                })->where('user_id', auth()->user()->id)->pluck('id')->all();
                $appointments = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where(function ($query) use($start_date, $end_date) {
                    $query->whereBetween('applied_date', [$start_date, $end_date]);
                })->orderBy('id','desc')->get();
            }

            $view = view('components.view.appointPastList', compact('appointments'))->render();
        } else {
            if (auth()->user()->user_type == 2) {
                if ($action == 'pending') {
                    $status = 0;
                } else {
                    $status = 1;
                }

                $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->where(function ($query) use($start_date, $end_date) {
                    $query->whereBetween('applied_date', [$start_date, $end_date]);
                })->where('status', $status)->orderBy('id', 'desc')->get();

                if ($status) {
                    $view = view('components.view.appointConfirmList', compact('appointments'))->render();
                } else {
                    $view = view('components.view.appointPendingList', compact('appointments'))->render();
                }
            } else {
                if ($action == 'pending') {
                    $status = 0;
                } else {
                    $status = 1;
                }

                $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                })->where('user_id', auth()->user()->id)->where('status', $status)->pluck('id')->all();
                $appointments = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where(function ($query) use($start_date, $end_date) {
                    $query->whereBetween('applied_date', [$start_date, $end_date]);
                })->where('status', $status)->orderBy('id','desc')->get();

                if ($status) {
                    $view = view('components.view.appointConfirmList', compact('appointments'))->render();
                } else {
                    $view = view('components.view.appointPendingList', compact('appointments'))->render();
                }
            }
        }

        return response()->json(compact('view'));
    }

    public function profileView(Request $request) {
        if ($request->action == 'chat') {
            $user = User::find($request->id);
            $view = view('components.view.profileView', compact('user'))->render();
        } else {
            if ($request->action != 'job') {
                $app = AppointmentProposals::find($request->id);
                $user = $app->doctor;
            } else {
                $app = Appointment::find($request->id);
                $user = $app->user;
            }
            $view = view('components.view.profileView', compact('user'))->render();
        }
        return response()->json(compact('view', 'user'));
    }

    private function getPendingView() {
        $todayDate = date('Y-m-d');
        $auth = auth()->user();
        if($auth->user_type == '3'){
            $appointmentsIds =  Appointment::whereHas('shift', function ($query) use($todayDate) {
                $query->where('date', $todayDate);
            })->where('user_id', $auth->id)->where('status','0')->pluck('id')->all();
            $this->bladeContent['appointments'] = AppointmentProposals::whereIn('appointment_id', $appointmentsIds)->where('applied_date',$todayDate)->where('status','0')->orderBy('id','desc')->get();
        }
        else{
            $this->bladeContent['appointments'] = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date', $today)->orderBy('id', 'desc')->get();
        }
        $view = view('components.view.pendingList', $this->bladeContent)->render();
        return $view;
    }

    private function doctorPendingView($date) {
        $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date', $date)->where('status','0')->orderBy('id','desc')->get();

        $view = view('components.view.pendingList', compact('appointments'))->render();

        return $view;
    }

    private function doctorConfirmView($date) {
        $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date',$date)->where('status','1')->orderBy('id','desc')->take(5)->get();
            
        $view = view('components.view.confirmList', compact('appointments'))->render();

        return $view;
    }

    private function job_notification($token,$date,$time,$userName){
        $image_link = 'https://lh3.googleusercontent.com/a-/AAuE7mBWM2iMPfFDCVrbrs42yBAJnSc4jZ6nct1hxlqx';
        define('API_ACCESS_KEY','AAAA7bWo1wM:APA91bEru78wWfaBobOxrbkp5kYpUApASamz6A7YGiO0It8jyMfZ2YW-mBqc1YxyJb8efA9fhI9xAYqKaHxXHeMrPcEaONC22dnn8LGLKDhfS7AZbqCPJJ7bHRb6WWI89eKiIeq5aCC3');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => "Appointment schduled for $date at $time",
            'body' => "You appointment has been scheduled with $userName on $date at $time",
            'vibrate'	=> 1,
	    	'sound'	=> 1
        ];
        $fcmNotification = [
        	'to'        => $token, //single token
        	'notification' => $notification,
            'priority'=>'high'
        ];
        
        $headers = [
        	'Authorization: key=' . API_ACCESS_KEY,
        	'Content-Type: application/json'
        ];
        
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch); 
            return $result;
        }
        catch (\Exception $e) {
            return;
        }
    }
}
