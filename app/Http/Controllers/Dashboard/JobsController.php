<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\AppointmentAcceptedByDoctor;
use App\Http\Controllers\Controller;
use App\Notifications\JobAccepted;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\AppointmentShift;
use App\Models\AppointmentProposals;
use App\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Notification;

class JobsController extends Controller
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
        $today = date('Y-m-d');

        $this->bladeContent['jobData'] = Appointment::doesntHave('checkPurposal')->doesntHave('cancelAppointment')->whereHas('appointmentShift', function($query) use ($today) {
            return $query->where('date', $today);
        })->with('appointmentShift')->where('category_id', auth()->user()->category)->where('status', '0')->orderBy('id', 'desc')->get();
        $this->bladeContent['active'] = 'find';

        return view('pages.dashboard.jobs.index', $this->bladeContent);
    }

    public function getJobs(Request $request) {
        $auth = auth()->user();

        $action = $request->action;
        $date = $request->date;
        $idsArray = $request->idsArray;

        $allAppointmentIds = AppointmentShift::select('appointment_id')->where('date', $date)->pluck('appointment_id')->all();
        $appointmentPurposals = AppointmentProposals::select('appointment_id')->whereIn('appointment_id', $allAppointmentIds)->where('doctor_id', $auth->id)->pluck('appointment_id')->all();

        $appointments = AppointmentShift::where('date', $date)->whereNotIn('appointment_id', $appointmentPurposals)
        ->when($idsArray, function ($query) use($idsArray) {
                return $query->whereNotIn('id', $idsArray);
        })->orderBy('id', 'desc')->paginate(5);

        $view = view('components.view.appointment', compact('appointments'))->render();

        return response()->json(compact('view'));
    }

    public function create(Request $request) {
        if ($request->ajax()){
            $date = $request->date;
            $appointments = AppointmentShift::where('date', $date)->get();
            $html = '';
            foreach($appointments as $app){
                $html .= '<div class="form-group row">
                    <div class="col-md-2"><img src="'.(($app->appointment->user->profile_img) ? $app->appointment->user->profile_img : url('images/user_logo.png')).'" class="user-profile"></div>
                    <div class="col-md-4">
                        '.$app->appointment->user->name.'<br>
                        <b>'.$app->appointment->category->name.'</b>
                    </div>
                    <div class="col-md-4"><span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span><span class="start-time">'.date('H:i',strtotime($app->start_time)).' - </span><span class="end-time">'.date('H:i',strtotime($app->end_time)).'</div>
                    <div class="col-md-2"><button class="btn btn-primary">Apply</button></div>
                </div><hr>';
            }
            if(count($appointments) == 0){
                $html = '<div class="text-danger text-center">No data found.</div>';
            }
            return ['success' => '1','html' => $html];
        } else {
            $todayDate = date('Y-m-d');

            $categories = Categories::where('parent','0')->get();

            $this->bladeContent['categories'] = Categories::where('parent','0')->get();
            $this->bladeContent['todayDate']  = $todayDate;
            $this->bladeContent['appointments']  = AppointmentShift::where('date', $todayDate)->get();
            $this->bladeContent['active'] = 'create-appointment';
            $this->bladeContent['googleMapKey'] = Config::get('enums.GoogleMapKey');
            $this->bladeContent['daysArray'] = [
                'Mon' => 'lundi',
                'Tue' => 'mardi',
                'Wed' => 'mercredi',
                'Thu' => 'jeudi',
                'Fri' => 'vendredi',
                'Sat' => 'samedi',
                'Sun' => 'dimanche',
            ];
            $this->bladeContent['tabArray'] = [
                '0' => 'first',
                '1' => 'second',
                '2' => 'third',
                '3' => 'fourth',
                '4' => 'fifth',
            ];
            $currentTime = date('H:i');
            $timeShiftArray = [
                '0' => 'Le plus tôt possible'
            ];
            if ($currentTime < '12:00'){
                $timeShiftArray['1'] = 'Ce Matin';
            }
            if ($currentTime < '18:00'){
                $timeShiftArray['2'] = 'Cet aprés-midi';
            }
            $timeShiftArray['3'] = 'Ce soir';
            $this->bladeContent['timeShift'] = $timeShiftArray;

            $appointment = Appointment::where('user_id', auth()->user()->id)->where('status', '0')->first();
            $subcategoryHtml = '';
            $purposals   = '';
            if ($appointment){
                $purposals = AppointmentProposals::where('appointment_id', $appointment->id)->where('status','0')->get();
            }

            $this->bladeContent['purposals']   = $purposals;
            $this->bladeContent['appointment'] = $appointment;
            $this->bladeContent['purposals']   = $purposals;
            $this->bladeContent['address']     = auth()->user()->address;
            $this->bladeContent['latitude']    = auth()->user()->latitude;
            $this->bladeContent['longitude']   = auth()->user()->longitude;
            $this->bladeContent['city']        = auth()->user()->city;
            $this->bladeContent['state']       = auth()->user()->state;

            return view('pages.dashboard.jobs.create', $this->bladeContent);
        }
    }

    public function store(Request $request) {

        $auth = auth()->user();
        $action = $request->action;
        if ($action == 'appointment'){
            $selected_date = $request->selected_date;
            if ($selected_date){
                $allAppointment = Appointment::whereHas('shift', function($query) use ($selected_date) {
                    return $query->where('date', $selected_date);
                })->get();
                $html = '';
                foreach($allAppointment as $app){
                    $id = $app->id;
                    $job_category_name = $app->category->name;
                    $job_title = $app->patient_name;
                    $post_date = '4 jours ago';
                    $html = '<div class="col-md-12"><div class="form-group row content-row job-list">
                        <div class="col-md-5">
                            <div class="user_id"><b>id UR'.$id.'</b></div>
                            <div class="address-row">
                                    <span class="light-color"><i class="fa fa-map-marker" aria-hidden="true"></i>  6558.23 </span>
                                    <span class="blue-row"> <i class="fa fa-map-marker" aria-hidden="true"></i> '.$job_category_name.'</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="type"></div>
                            <div class="city-row light-color">'.$job_title.'</div>
                            <div class="posted-time"><b>Posted: </b> <span class="light-color">'.$post_date.'</span></div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-sm apply-btn" data-id="'.$id.'">Proposer un RDV</button>
                        </div>
                    </div></div>';
                }
                if(count($allAppointment) == 0) {
                    $html = '<div align="center">No job found.</div>';
                }
            }
            else{
                $html = '<div align="center">No job found.</div>';
            }
            return response()->json(['data' => $html]);
        } else if ($action == 'shift'){
            $date = $request->date;

            $allAppointmentIds = AppointmentShift::select('appointment_id')->where('date',$date)->pluck('appointment_id')->all();
            $appointmentPurposalsIds = AppointmentProposals::select('appointment_id')->whereIn('appointment_id', $allAppointmentIds)->where('doctor_id',$auth->id)->pluck('appointment_id')->all();
            $appointments = AppointmentShift::whereNotIn('appointment_id', $appointmentPurposalsIds)->where('date',$date)->orderBy('id','desc')->get();

            if (count($appointments) == 0){
                $view = view('components.view.noData')->render();
            } else {
                $view = view('components.view.appointment', compact('appointments'))->render();
            }
            return response()->json(compact('view'));
        } else if ($action == 'store-appointment'){
            $job_id       = $request->job_id;
            $candidate_id = ((auth()->user()) ? auth()->user()->id : '7');
            $apply_date   = $request->apply_date;
            $apply_time   = $request->apply_time;
            $shift_id     = $request->shift_id;
            $appointment  = Appointment::with('user')->where('id', $job_id)->first();
            $doctor_data  = User::where('id', $candidate_id)->first();


            $lat1 = $appointment->latitude;
            $lon1 = $appointment->longitude;
            $lat2 = $doctor_data->latitude;
            $lon2 = $doctor_data->longitude;
            $distance = (($lat1 && $lon1 && $lat2 && $lon2) ? $this->distance($lat1, $lon1, $lat2, $lon2, "K") : 0);
            $token             = $appointment->user->android_token??'';
            $iostoken          = $appointment->user->ios_token??'';
            $doctor_name       = $doctor_data->name;
            $doctor_lat        = $lat2;
            $doctor_long       = $lon2;
            $doctor_address    = $doctor_data->address;
            $doctor_heading    = $doctor_data->heading;
            $category          = $appointment->category;
            $job_subcategory   = $appointment->sub_category->name;
            $author_id         = $appointment->user->id??'';
            $cand_map_location = $doctor_data->address;

            if ($iostoken){
                $this->iosNotification($iostoken,$apply_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance);
            }
            if ($token){
                $this->notification($token,$apply_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance);
            }

            $data = [
                'appointment_id'       => $job_id,
                'appointment_shift_id' => $shift_id,
                'doctor_id'            => $candidate_id,
                'applied_date'         => $apply_date??date('Y-m-d'),
                'applied_time'         => $apply_time??date('Y-m-d'),
                'status'               => '0',
                'frontPayment'         => ($request->frontPayment) ? '1' : '0',
                'paymentValue'         => $request->paymentValue
            ];

            $purposal = AppointmentProposals::create($data);

            Notification::create([
                'senderId'  => $candidate_id,
                'recieverId' => $appointment->user->id??'',
                'message' => 'You appointment is scheduled on '.date('M d' ,strtotime($apply_date)).', '.$apply_time,
                'type'  => 'appointment',
                'purposalId' => $purposal->id,
                'jobId' => $job_id
            ]);

            $view = $this->doctorPendingView($apply_date);

            $appointment->notify(new JobAccepted());

            broadcast(new AppointmentAcceptedByDoctor($this->getOffers($appointment->id)));

            return response()->json(compact('view'));
            
        } else if ($action == 'subcategory'){
            $subcategoryData = Categories::where('parent', $request->id)->get();

            if(count($subcategoryData) == 0){
                $view = view('components.view.noData')->render();
            } else {
                $view = view('components.view.category', compact('subcategoryData'))->render();
            }

            return response()->json(compact('view'));
        } else if ($action == 'subcategory_request') {
            $subcategoryData = Categories::where('parent', $request->id)->get();

            $view = view('components.view.subcategoryList', compact('subcategoryData'))->render();

            return response()->json(compact('view'));
        } else {
            date_default_timezone_set('Europe/Paris');
            $user         = auth()->user();
            $user_id      = $user->id;
            $title        = $request->title;//patient_name
            $category     = $request->category;//category_id
            $subcategory  = $request->subcategory;//sub_category_id
            $latitute     = $request->latitute;//latitute
            $longitute    = $request->longitute;//longitute
            $address      = $request->address;
            $city         = $request->city;
            $state        = $request->state;
            $distance     = $request->distance;
            $shiftDate    = $request->shiftDate;
            $startTime    = $request->startTime;
            $endTime      = $request->endTime;

            $appointment_data = [
                'user_id'         => $user_id,
                'patient_name'    => ($title) ? $title : $user->name,
                'category_id'     => $category,
                'sub_category_id' => $subcategory,
                'latitute'        => $latitute,
                'longitute'       => $longitute,
                'address'         => $address,
                'city'            => $city,
                'state'           => $state,
                'visibility'      => $distance
            ];

            $appointment    = Appointment::create($appointment_data);

            $appointment_id = $appointment->id;
            //create shift
            foreach($shiftDate as $k=>$s){
                $appointment_shift_data = [
                    'date'           => $s,
                    'start_time'     => $startTime[$k],
                    'end_time'       => $endTime[$k],
                    'appointment_id' => $appointment_id
                ];
                AppointmentShift::create($appointment_shift_data);
            }

            $doctors = User::where('user_type', 2)->where('category', $category)->get();

            foreach($doctors as $doctor) {
                Notification::create([
                    'senderId' => auth()->user()->id,
                    'recieverId' => $doctor->id,
                    'jobId' => $appointment_id,
                    'type' => 'job',
                    'message' => 'New Appointment Created!'
                ]);
            }

            return response()->json(200);
        }
    }

    public function getOffers($appointmentId){
        try{
            $proposals = AppointmentProposals::where('appointment_id', $appointmentId)->get();
            $doctors = User::whereIn('id', $proposals->pluck('doctor_id')->toArray())->get();
            return ['doctors'=>$doctors, 'proposals'=>$proposals];
        }catch (\Exception $e){
            return response()->json(json_encode($e->getMessage()));
        }
    }

    public function thankYou(Request $request) {
        $this->bladeContent['active'] = 'create-appointment';
        return view('pages.dashboard.origin.jobs.thankyou', $this->bladeContent);
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
              return ($miles * 1.609344);
            } else if ($unit == "N") {
              return ($miles * 0.8684);
            } else {
              return $miles;
            }
        }
    }

    private function iosNotification($token,$job_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$applied_job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance){
        $image_link = 'https://lh3.googleusercontent.com/a-/AAuE7mBWM2iMPfFDCVrbrs42yBAJnSc4jZ6nct1hxlqx';
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = 'AAAA7bWo1wM:APA91bEru78wWfaBobOxrbkp5kYpUApASamz6A7YGiO0It8jyMfZ2YW-mBqc1YxyJb8efA9fhI9xAYqKaHxXHeMrPcEaONC22dnn8LGLKDhfS7AZbqCPJJ7bHRb6WWI89eKiIeq5aCC3';
        $notification = array('title' =>"$doctor_name peut vous recevoir à $job_time" , 'text' => 'Vous avez reçu une nouvelle propostition de rendez vous par "'.$doctor_name.'" à "'.$job_time.'"', 'sound' => 'default');
        $cat_name = $category->name;
        $cat_color = $category->color;
        $cat_img = $category->image;
        $application_array['image'] = $image_link;
        $application_array['name'] = $doctor_name. " " . $doctor_heading;
        $application_array['description'] = $cand_map_location;
        $application_array['text'] = $cat_name. " ". $job_subcategory;
        $application_array['time'] = $job_time;

        $application_array['heading'] = $doctor_heading;
        $application_array['categoryName']  = $cat_name;
        $application_array['categoryColor'] = $cat_color;
        $application_array['categoryImage'] = $cat_img;
        $application_array['subcategory']   = $job_subcategory;
        $application_array['apply_date'] = date('Y-m-d',strtotime($apply_date));
        $application_array['distance'] = number_format((float)$distance, 2, '.', '');
        $application_array['jobId'] = $applied_job_id;
        $application_array['doctorId'] = $candidate_id;
        $application_array['doctor_lat'] = $doctor_lat;
        $application_array['doctor_long'] = $doctor_long;
        $application_array['doctor_address'] = $doctor_address;
        $extraNotificationData = ["job_id" => $applied_job_id, "user_id" => $author_id, "application" => $application_array,'notificationType'=> 'Nouvelle proposition de rendez vous','notificationCount' => '2'];

        $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high','data' => $extraNotificationData);
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        try{
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
            curl_setopt( $ch, CURLOPT_VERBOSE, true );
            $res = curl_exec($ch);
            if ($res === false){
                return;
            }
            curl_close($ch);
            return $res;
        }
        catch (\Exception $e) {
            return;
        }
    }

    private function notification($token,$job_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$applied_job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance){
        $image_link = 'https://lh3.googleusercontent.com/a-/AAuE7mBWM2iMPfFDCVrbrs42yBAJnSc4jZ6nct1hxlqx';
        define('API_ACCESS_KEY','AAAA7bWo1wM:APA91bEru78wWfaBobOxrbkp5kYpUApASamz6A7YGiO0It8jyMfZ2YW-mBqc1YxyJb8efA9fhI9xAYqKaHxXHeMrPcEaONC22dnn8LGLKDhfS7AZbqCPJJ7bHRb6WWI89eKiIeq5aCC3');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => "$doctor_name peut vous recevoir à $job_time",
            'body' => 'Vous avez reçu une nouvelle propostition de rendez vous par "'.$doctor_name.'" à "'.$job_time.'"',
            'vibrate'	=> 1,
	    	'sound'	=> 1
        ];
        $cat_name = $category->name;
        $cat_color = $category->color;
        $cat_img = $category->image;
        $application_array['image'] = $image_link;
        $application_array['name'] = $doctor_name. " " . $doctor_heading;
        $application_array['description'] = $cand_map_location;
        $application_array['text'] = $cat_name. " ". $job_subcategory;
        $application_array['time'] = $job_time;

        $application_array['heading'] = $doctor_heading;
        $application_array['categoryName']  = $cat_name;
        $application_array['categoryColor'] = $cat_color;
        $application_array['categoryImage'] = $cat_img;
        $application_array['subcategory']   = $job_subcategory;
        $application_array['apply_date'] = date('Y-m-d',strtotime($apply_date));
        $application_array['distance'] = number_format((float)$distance, 2, '.', '');
        $application_array['jobId'] = $applied_job_id;
        $application_array['doctorId'] = $candidate_id;
        $application_array['doctor_lat'] = $doctor_lat;
        $application_array['doctor_long'] = $doctor_long;
        $application_array['doctor_address'] = $doctor_address;



        // $application_array['text']   = 'Rendez-vous confirmé!';
        // $application_array['text_1'] = 'Aujourd’hui à '.$job_time;
        // $application_array['text_2'] = 'Naus vous enverrons une notification pour vous prévenir';
        // $application_array['text_3'] = 'Voir la fiche praticien';

        $extraNotificationData = ["job_id" => $applied_job_id, "user_id" => $author_id, "application" => $application_array,'notificationType'=> 'Nouvelle proposition de rendez vous','notificationCount' => '2'];

        $fcmNotification = [
        	//'registration_ids' => $tokenList, //multple token array
        	'to'        => $token, //single token
        	'notification' => $notification,
            'data' => $extraNotificationData
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

    private function doctorPendingView($date) {
        $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date', $date)->where('status','0')->orderBy('id','desc')->get();

        if (count($appointments)) {
            $view = view('components.view.pendingList', compact('appointments'))->render();
        } else {
            $view = view('components.view.noData')->render();
        }

        return $view;
    }
}
