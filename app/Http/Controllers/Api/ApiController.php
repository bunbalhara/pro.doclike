<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\Categories;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\User;
use App\Models\AppointmentShift;
use App\Models\Appointment;
use App\Models\Skills;
use App\Models\AppointmentProposals;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\CancelAppointment;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Models\FavouriteDoctor;
use App\Models\Friends;
use DB;

class ApiController extends Controller
{
	public $successStatus = 200;
    public $errorStatus = 404;
    
    /** 
     * login with phone api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login_with_phone(Request $request){ 
        $phone = trim(str_replace('-','',str_replace('+','',$request->phone)));
        if(Auth::attempt(['phone' => $phone,'password'=>$phone])){ 
            $user_data['device_type']   = $request->device_type;
            $user_data['android_token'] = $request->android_token;
            $user_data['ios_token']     = $request->ios_token;
            $user        = Auth::user(); 
            User::where('id',$user->id)->update($user_data);
            $data['token'] =  $user->createToken('MyApp')-> accessToken; 
            $data['id']            = $user->id;
            $data['display_name']  = $user->name;
            $data['profile_img']   = url($user->profile_img);
            $data['user_email']	   = $user->email;
            return response()->json(['success' => true,'data' =>$data], $this-> successStatus); 
        } 
        else{  
            return response()->json(['error'=>'Unauthorised']); 
        } 
    }
    /** 
     * Register with phone api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    // name: '',
    // email: '',
    // password: '',
    // numeroFinesse: '',
    // rpps: '',
    // first_name: '',
    // last_name: '', 
    // address: '',
    // category: 
    // latitude
    // longitude
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name'  => 'required', 
            'email' => 'required|email', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all(); 
        $user = User::where('email',$input['email'])->orWhere('phone',$input['phone'])->first();
        if($user){
            return response()->json(['message'=>'This user already exits.','success' => false], $this-> successStatus);
        }
        else{
            $input['password'] = bcrypt($input['password']); 
            $input['phone']    = trim(str_replace('-','',str_replace('+','',$input['phone'])));
            $input['profile_img']    = url('public/images/user_logo.png');
            $input['user_type']      = '2';
            $user = User::create($input); 
            $data['token'] =  $user->createToken('MyApp')-> accessToken; 
            $data['id']            = $user->id;
            $data['display_name']  = $user->name;
            $data['profile_img']   = url($user->profile_img);
            $data['user_email']	   = $user->email;
            $data['message']       = 'Registered Successfully.';
            return response()->json(['success'=>true,'data' => $data], $this-> successStatus); 
        }
    }
    
    public function register_with_phone(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name'  => 'required', 
            'email' => 'required|email', 
            'phone' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all(); 
        $user = User::where('email',$input['email'])->orWhere('phone',$input['phone'])->first();
        if($user){
            return response()->json(['message'=>'This user already exits.','success' => false], $this-> successStatus);
        }
        else{
            $input['password'] = bcrypt($input['phone']); 
            $input['phone']    = trim(str_replace('-','',str_replace('+','',$input['phone'])));
            $input['profile_img']    = url('public/images/user_logo.png');
            $input['user_type']      = '3';
            $user = User::create($input); 
            $data['token'] =  $user->createToken('MyApp')-> accessToken; 
            $data['id']            = $user->id;
            $data['display_name']  = $user->name;
            $data['profile_img']   = url($user->profile_img);
            $data['user_email']	   = $user->email;
            $data['message']       = 'Registered Successfully.';
            return response()->json(['success'=>true,'data' => $data], $this-> successStatus); 
        }
    }
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 
        $type        = $request->type;
        if( $type == 'social' )
		{
		    $email = $request->email;
		    $user  = User::where('email',$email)->first();
		    if($user){
		        $user_data['device_type']   = $request->device_type;
                $user_data['android_token'] = $request->android_token;
                $user_data['ios_token']     = $request->ios_token;
                $user_data['profile_img']   = $request->profile_img;
                User::where('id',$user->id)->update($user_data);
		        $data['token']        =  $user->createToken('MyApp')-> accessToken; 
                $data['id']            = $user->id;
                $data['display_name']  = $user->name;
                $data['profile_img']   = $request->profile_img;
                $data['user_email']	   = $user->email;
                $data['message']       = 'login Successfully.';
		        return response()->json(['success'=>true,'data' => $data], $this-> successStatus); 
		    }
		    else{
		        $input = $request->all(); 
		        $input['password']       = bcrypt($input['email']); 
                $input['user_type']      = '3';
                $user = User::create($input); 
                $data['token'] =  $user->createToken('MyApp')-> accessToken; 
                $data['id']            = $user->id;
                $data['display_name']  = $user->name;
                $data['profile_img']   = $user->profile_img;
                $data['user_email']	   = $user->email;
                $data['message']       = 'login Successfully.';
                return response()->json(['success'=>true,'data' => $data], $this-> successStatus); 
		    }
		}
		if($type == 'login_with_email')
		{
		    $email = $request->get('email');
		    $user = User::where('email',$email)->first(); 
		    if($user){
    		    $user_data['device_type']   = $request->device_type;
                $user_data['android_token'] = $request->android_token;
                $user_data['ios_token']     = $request->ios_token;
                User::where('id',$user->id)->update($user_data);
		        if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){ 
                    $data['token']         =  $user->createToken('MyApp')-> accessToken; 
                    $data['id']            = $user->id;
                    $data['display_name']  = $user->name;
                    $data['profile_img']   = $user->profile_img;
                    $data['user_email']	   = $user->email;
                    return response()->json(['success' => true,'data' => $data], $this-> successStatus); 
                } 
                else{ 
                    return response()->json(['success' => false,'error'=>'Unauthorised'], 401); 
                } 
		    }
            else{
                return response()->json(['success' => false,'message'=>'No email is found.']); 
            }
		}
    }
    
    public function logout(Request $request){ 
        $user       = Auth::user();
        $user_id    = $user->id;
        User::where('id',$user_id)->update(['ios_token' => '','android_token' => '']);
        return response()->json(['success'=>true], $this-> successStatus); 
    }
    
    public function cancel_job(Request $request){
        $appointment_id = $request->jobId;
        Appointment::where('id',$appointment_id)->update(['status' => '3']);
        AppointmentProposals::where('appointment_id',$appointment_id)->update(['status' => '2']);
        return response()->json(['success'=>true,'appointment_id'=>$appointment_id], $this-> successStatus); 
    }
    
    public function update_job(Request $request){
        $type   = $request->type;
        $id     = $request->jobId;
        if($type == 'address'){
            $latitute   = $request->lat;
            $longitute  = $request->long;
            $address    = $request->address;
            $city       = $request->city;
            $state      = $request->state;
            $data = [
                'latitute'  => $latitute,
                'longitute' => $longitute,
                'address'   => $address,
                'city'      => $city,
                'state'     => $state
            ];
            Appointment::where('id',$id)->update($data);
            return response()->json(['success' => true], $this-> successStatus); 
        }
        else if($type == 'radius'){
            $visibility = $request->visibility;
            $data['visibility'] = $visibility;
            Appointment::where('id',$id)->update($data);
            return response()->json(['success' => true], $this-> successStatus); 
        }
        return response()->json(['success' => false], $this-> successStatus); 
    }
    
    public function post_job(Request $request){
        date_default_timezone_set('Europe/Paris');
        $user    = Auth::user();
        $user_id = $user->id;
        $job_title      = $request->job_title;//patient_name
        $job_cat        = $request->job_cat;//category_id
        $job_cat_second = $request->job_subcat;//sub_category_id
        $job_lat        = $request->job_lat;//latitute
        $job_long       = $request->job_long;//longitute
        $job_shift      = $request->job_shift; 
        $address        = $request->address; 
        $city           = $request->city; 
        $state          = $request->state; 
        $appointment_data = [
            'user_id'         => $user_id,
            'patient_name'    => ($job_title) ? $job_title : $user->name,
            'category_id'     => $job_cat,
            'sub_category_id' => $job_cat_second,
            'latitute'        => $job_lat,
            'longitute'       => $job_long,
            'address'         => $address,
            'city'            => $city,
            'state'           => $state
        ]; 
        $appointment    = Appointment::create($appointment_data);
        $appointment_id = $appointment->id;
        //create shift
        if($job_shift == '24_JOB'){
            $start_time = date('H:i');
            $end_time   = date('H:i', strtotime($start_time. ' + 3 hours'));
            $date       = date('Y-m-d');
            $appointment_shift_data = [
                'date'           => $date,
                'start_time'     => $start_time,
                'end_time'       => $end_time,
                'appointment_id' => $appointment_id
            ];
            AppointmentShift::create($appointment_shift_data);
        }
        else{
            $job_shift = json_decode($job_shift);
            foreach($job_shift as $s){
                $date = $s->date;
                foreach($s->timing as $t){
                    $appointment_shift_data = [
                        'date'           => $date,
                        'start_time'     => $t->startTime,
                        'end_time'       => $t->endTime,
                        'appointment_id' => $appointment_id
                    ];
                    AppointmentShift::create($appointment_shift_data);
                }
            }
        }
        $data['appointment_id'] = $appointment_id;
        $appointment = Appointment::where('user_id',$user_id)->where('status','0')->first();
        if($appointment){
            $appointmentArray = [ 
                'cat_name'     => $appointment->category->name,
                'cat_color'    => $appointment->category->color,
                'cat_img'      => $appointment->category->image,
                'sub_cat_name' => $appointment->sub_category->name,
                'job_id'       => $appointment->id,
                'city'         => $appointment->city,
                'radious'      => '10',
                'latitute'     => $appointment->latitute,
                'longitute'    => $appointment->longitute,
            ];
        }
        else{
            $appointmentArray = null;
        }
        return response()->json(['success' => true,'data' => $data,'job'=>$appointmentArray], $this-> successStatus); 
    }
    
    public function job_appointments(Request $request)
    {
        $user      = Auth::user();
        $user_id   = $user->id;
        $type      = $request->type;
        $todayDate = date('Y-m-d');
        if($type == 'current'){
            $appointments = AppointmentProposals::whereHas('appointment', function($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->with('doctor')->where('applied_date','>=',$todayDate)->get();
        }
        else if($type == 'previous'){
            $appointments = AppointmentProposals::whereHas('appointment', function($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->with('doctor')->where('applied_date','<',$todayDate)->take(15)->get();
        }
        $applicationArray = [];
        $lat1      = $user->latitude;
        $lon1      = $user->longitude;
        foreach($appointments as $k=>$app){
            $lat2      = $app->doctor->latitude;
            $lon2      = $app->doctor->longitude;
            if($lat1 && $lon1 && $lat2 && $lon2){
                $distance  = $this->distance($lat1, $lon1, $lat2, $lon2, "K");
            }
            $applicationArray[$k]['id'] = $app->id;
            $applicationArray[$k]['name'] = $app->doctor->name;
            $applicationArray[$k]['info'] = $app->appointment->category->name;//'Family doctor, '.
            $applicationArray[$k]['time']  = date('H:i',strtotime($app->applied_time));
            $applicationArray[$k]['date']  = date('Y-m-d',strtotime($app->applied_date));
            $applicationArray[$k]['distance']  = '4.5 km';
            $applicationArray[$k]['doctor_id']  = $app->doctor->id;
            $applicationArray[$k]['address'] = $app->doctor->address;
            $applicationArray[$k]['job_id']  = $app->appointment->id;
            $applicationArray[$k]['status']  = $app->status;
            $applicationArray[$k]['img']  = ($app->doctor->profile_img) ? $app->doctor->profile_img : url('public/images/user_logo.png');
        }
        return response()->json(['success' => true,'data' => $applicationArray], $this-> successStatus); 
    }
    /** 
     * get all categories api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function job_meta(Request $request)
    {
        $user       = Auth::user();
        $user_id    = $user->id;
        $today_date = date('Y-m-d');
        $appointment = Appointment::where('user_id',$user_id)->where('status','0')->first();
        if($appointment){
            $appointmentArray = [ 
                'cat_name'     => $appointment->category->name,
                'cat_color'    => $appointment->category->color,
                'cat_img'      => $appointment->category->image,
                'sub_cat_name' => $appointment->sub_category->name,
                'job_id'       => $appointment->id,
                'latitute'     => $appointment->latitute,
                'longitute'    => $appointment->longitute,
            ];
        }
        else{
            $appointmentArray = null;
        }
                
        $pending_appointment = AppointmentProposals::whereHas('appointment', function($query) use ($user_id) {
            return $query->where('user_id', $user_id)
            ->where('status','0');
        })->where('status','0')->with('doctor')->where('applied_date','>=',$today_date)->take(3)->get();
        $pending_appointment_array = [];
        foreach($pending_appointment as $k=>$p){
            $pending_appointment_array[$k]['id'] = $p->id;
            $pending_appointment_array[$k]['name'] = $p->doctor->name;
            $pending_appointment_array[$k]['info'] = $p->appointment->category->name;//'Family doctor, '.
            $pending_appointment_array[$k]['time']  = date('H:i',strtotime($p->applied_time));
            $pending_appointment_array[$k]['date']  = date('Y-m-d',strtotime($p->applied_date));
            $pending_appointment_array[$k]['distance']  = '4.5 km';
            $pending_appointment_array[$k]['doctor_id']  = $p->doctor->id;
            $pending_appointment_array[$k]['address'] = $p->doctor->address;
            $pending_appointment_array[$k]['job_id']  = $p->appointment->id;
            $pending_appointment_array[$k]['img']  = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            
            // $pending_appointment_array[$k]['cand_image'] = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            // $pending_appointment_array[$k]['bottom_text'] = $p->doctor->name.' '.$p->doctor->heading;
            // $pending_appointment_array[$k]['top_text'] = (($p->applied_date == $today_date) ? 'Today' : ((date('Y-m-d',strtotime($today_date.' +1 days')) == $p->applied_date) ? 'Tomorrow' : date('l',strtotime($p->applied_date)))).' '. date('H:i',strtotime($p->applied_time));
            // $pending_appointment_array[$k]['day'] = (($p->applied_date == $today_date) ? 'Today' : ((date('Y-m-d',strtotime($today_date.' +1 days')) == $p->applied_date) ? 'Tomorrow' : date('l',strtotime($p->applied_date))));
            // $pending_appointment_array[$k]['date'] = date('F j, Y',strtotime($p->applied_date));
            // $pending_appointment_array[$k]['time'] = date('H:i',strtotime($p->applied_time));
            // $pending_appointment_array[$k]['cand_image'] = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            // $pending_appointment_array[$k]['name'] = $p->doctor->name;
            // $pending_appointment_array[$k]['heading'] = $p->doctor->heading;
            // $pending_appointment_array[$k]['cand_map_lat'] = $p->doctor->latitude;
            // $pending_appointment_array[$k]['cand_map_lon'] = $p->doctor->longitude;
        }
        $proposals  = AppointmentProposals::whereHas('appointment', function($query) use ($user_id) {
            return $query->where('user_id', $user_id)
            ->where('status','1');
        })->with('doctor')->where('applied_date','>=',$today_date)->take(3)->get();
        $application_array = [];
        foreach($proposals as $k=>$p){
            $application_array[$k]['id'] = $p->id;
            $application_array[$k]['day'] = (($p->applied_date == $today_date) ? 'Today' : ((date('Y-m-d',strtotime($today_date.' +1 days')) == $p->applied_date) ? 'Tomorrow' : date('l',strtotime($p->applied_date))));
            $application_array[$k]['date'] = date('Y-m-d',strtotime($p->applied_date));
            $application_array[$k]['time'] = date('H:i',strtotime($p->applied_time));
            $application_array[$k]['cand_image'] = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            $application_array[$k]['doctor_id'] = $p->doctor->id;
            $application_array[$k]['name'] = $p->doctor->name;
            $application_array[$k]['heading'] = $p->doctor->heading;
            $application_array[$k]['cand_map_lat'] = $p->doctor->latitude;
            $application_array[$k]['cand_map_lon'] = $p->doctor->longitude;
            $application_array[$k]['address'] = $p->doctor->address;
            $application_array[$k]['chat'] = [
                'job_id'      => $p->appointment_id,
                'doctor_img'  => ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png'),
                'doctor_name' => $p->doctor->name,
                'doctor_id'   => $p->doctor->id, 
                'status'      => $p->appointment->status
            ];
        }
        $application = $application_array;
        $category = Categories::where('parent','0')->get(); 
        $skills   = Skills::get();
        $skillsArray = [];
        foreach($skills as $skill){
            $data = [
                'id'     => $skill->id,
                'skill'  => $skill->skill,
                'doctor' => $user_id
            ];
            $skillsArray[] = $data;
        }
        $user_activity = Appointment::where('user_id',$user_id)->count();
        return response()->json(['success' => true,'job' => $appointmentArray,'category' => $category, 'application' => $application,'pending_application' => $pending_appointment_array,'skills' => $skillsArray,'user_activity' =>$user_activity,'notificationType'=> 'Nouvelle proposition de rendez vous','notificationCount' => '2'], $this-> successStatus); 
    }
    /** 
     * get all categories api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function job_sub_meta(Request $request)
    {
        $parent_id = $request->parent_id;
        $data = Categories::select('id','name')->where('parent',$parent_id)->get(); 
        return response()->json(['success' => true,'data' => $data], $this-> successStatus); 
    }
    
    public function get_job_shift(Request $request)
    {
        $user    = Auth::user();
        $user_id = $user->id;
        $date    = $request->selected_date;
        $start   = date('Y-m-d',strtotime($date.' -5 days'));
        $applications = [];
        for($i=0;$i<=10;$i++){
            $new_date = date('Y-m-d',strtotime($start.' +'.$i.' days'));
            $shifts  = AppointmentShift::whereHas('appointment', function($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->with('appointment.category','appointment.sub_category')->where('date',$new_date)->get();
        
            foreach($shifts as $key=>$shift){
                $appointment_id = $shift->appointment->id;
                $shift_id       = $shift->id;
                
           $resume_counts  = $this->get_proposals($appointment_id,$shift_id);
     
                
                $category = $shift->appointment->category;
                $sub_category = $shift->appointment->sub_category;
$applications[$new_date][$key]['cat_name']    = $category->name;
$applications[$new_date][$key]['date']        = $new_date;
$applications[$new_date][$key]['applications']= (($resume_counts > 0)? true :false);
$applications[$new_date][$key]['cat_image']   = $category->image;
$applications[$new_date][$key]['cat_color']   = $category->color;
$applications[$new_date][$key]['subcat_name'] = $sub_category->name;
$applications[$new_date][$key]['start_time']  = date('H:i',strtotime($shift->start_time));
$applications[$new_date][$key]['end_time']    = date('H:i',strtotime($shift->end_time));
$applications[$new_date][$key]['status']      = $shift->appointment->status;
$applications[$new_date][$key]['job_id']      = $shift->appointment->id;

if($resume_counts == 0) {
    $button_text = 'Waiting of applications';
}
else if($resume_counts > 0) {
    $button_text = 'View applications';
}
if($shift->appointment->status == 1) {
    $button_text = 'View doctor';
}
$applications[$new_date][$key]['button_text'] = $button_text;
            }
            if(count($shifts) == 0){
                $applications[$new_date] = array();
            }
        }
        return response()->json(['success' => true,'applications' => $applications], $this-> successStatus); 
    }
    
    public function get_applications_by_date(Request $request){
        $user    = Auth::user();
        $user_id = $user->id;
        $status  = $request->status;
        $date    = $request->selected_date;
        $currentDay = date('D', strtotime($date));
        $monday  = ($currentDay == 'Sun') ? date( 'Y-m-d', strtotime($date.' next monday')) : date( 'Y-m-d', strtotime($date.' monday this week'));
        $start   = date('Y-m-d',strtotime($monday.' -1 days'));
        $application_array = [];
        for($i=0;$i<=6;$i++){
            $new_date = date('Y-m-d',strtotime($start.' +'.$i.' days'));
            $proposals = AppointmentProposals::whereHas('appointment', function($query) use ($status,$user_id) {
                return $query->where('user_id', $user_id)
                ->where('status', $status);
            })->with('doctor','appointment')->where('status','<>','2')->where('applied_date',$new_date)->get();
            foreach($proposals as $key=>$p){
                $appointment_id = $p->appointment->id;
                $category = $p->appointment->category;
                $sub_category = $p->appointment->sub_category;
$application_array[$new_date][$key]['id'] = $p->id;
$application_array[$new_date][$key]['job_id'] = $appointment_id;
$application_array[$new_date][$key]['date']   = $new_date;
$application_array[$new_date][$key]['title'] = $p->doctor->name;
$application_array[$new_date][$key]['heading'] = $p->doctor->heading;
$application_array[$new_date][$key]['time'] = date('H:i',strtotime($p->applied_time));
$application_array[$new_date][$key]['status'] = $p->status;
$application_array[$new_date][$key]['image'] = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
$application_array[$new_date][$key]['address'] = $p->doctor->address;
$application_array[$new_date][$key]['candidate_id'] =  $p->doctor->id;
$application_array[$new_date][$key]['distance'] = '5';
$application_array[$new_date][$key]['cat']['name'] = $category->name;
$application_array[$new_date][$key]['cat']['subcategory'] = $sub_category->name;
            }
            if(count($proposals) ==  0) {
        		//$application_array[$new_date] = array();
        	}
        }
        if(count($application_array) == 0){
            $application_array = '';
        }
        return response()->json(['success' => true,'applications' => $application_array], $this-> successStatus); 
    }
    
    // public function chat_notification(Request $request){
        // $user    = Auth::user();
        // $user_id = $user->id;
    //     $chatId      = $request->get('chatId');
    //     $mainUserId  = $request->get('mainUserId');
    //     $chatUserId  = $request->get('chatUserId');
    //     $message     = $request->get('message');
    //     $messageTime = $request->get('messageTime');
    // }
    
    public function update_info(Request $request){
        $user    = Auth::user();
        $user_id = $user->id;
        $action  = $request->action;
        if($action == 'image'){
            $image   = $request->image;
            $path    = 'storage/images/'; 
            $date    = date('Y-m-d');
            $newDate = explode('-',$date);
            if (!file_exists($path.$newDate[0].'/'.$newDate[1])) {
                mkdir($path.$newDate[0].'/'.$newDate[1], 0777, true);
            }
            $newDir = $path.$newDate[0].'/'.$newDate[1];
            $fileName   = $user_id.'_'.time() . '.png';
            $file       = $newDir.'/'.$fileName;
            User::where('id',$user_id)->update(['profile_img' => url($file)]);
            file_put_contents($file, base64_decode($image));
        }
        if($action == 'address'){
            $address    = $request->address;
            $latitude   = $request->latitude;
            $longitude  = $request->longitude;
            User::where('id',$user_id)->update([
                'address'   => $address,
                'latitude'  => $latitude,
                'longitude' => $longitude
            ]);
        }
        $user = User::where('id',$user_id)->first();
        $candidate_info_array = [];
        if($user){
$candidate_info_array['name'] = $user->name;
$candidate_info_array['heading'] = $user->heading;
$candidate_info_array['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$candidate_info_array['cand_map_lat'] = $user->latitude;
$candidate_info_array['cand_map_long'] = $user->longitude;
$candidate_info_array['address'] = $user->address;
$candidate_info_array['phone'] = $user->phone;
$candidate_info_array['email'] = $user->email; 
        }
        return response()->json(['success' => true,'user' => $candidate_info_array], $this-> successStatus); 
    }
    
    public function action_application(Request $request){
        $user          = Auth::user();
        $user_id       = $user->id;
        $job_id        = $request->job_id;
        $cand_status   = $request->cand_status;
        $candidiate_id = $request->candidiate_id;
        $purposal      = AppointmentProposals::where('appointment_id',$job_id)->where('doctor_id',$candidiate_id)->first();
        $chat = [];
        if($cand_status == 1){
            Chat::create([
                'job_id'    => $job_id,
                'user_id'   => $user_id,
                'doctor_id' => $candidiate_id
            ]);
            $doctorData = User::where('id',$candidiate_id)->first();
            $chat = [
                'job_id'      => $job_id,
                'doctor_img'  => ($doctorData->profile_img) ? $doctorData->profile_img : url('public/images/user_logo.png'),
                'doctor_name' => $doctorData->name,
                'doctor_id'   => $candidiate_id, 
                'status'      => $cand_status
            ];
            Appointment::where('id',$job_id)->update(['status' => '1']);
            $notification = [
                'senderId'   => $candidiate_id,
                'recieverId' => $user_id,
                'jobId'      => $job_id,
                'message'    => 'You appointment is scheduled on '.date('F j, Y',strtotime($purposal->applied_date)).' '.date('H:i',strtotime($purposal->applied_time)),
                'type'       => 'reminder'
            ];
            Notification::create($notification);
            $appointment  = Appointment::with('user')->where('id',$job_id)->first();
            $userName     = $appointment->user->name;
            $token        = $purposal->doctor->android_token;
            $date         = date('jS F Y',strtotime($purposal->applied_date));
            $time         = date('H:i',strtotime($purposal->applied_time));
            if($token){
                $this->job_notification($token,$date,$time,$userName);
            }
        }
        if($cand_status == '2' && $purposal->status == '1'){
            Appointment::where('id',$job_id)->update(['status' => '2']);
        }
        AppointmentProposals::where('appointment_id',$job_id)->where('doctor_id',$candidiate_id)->update(['status' => $cand_status]);
        $application_array['text']   = 'Rendez-vous confirmé!';
        $application_array['text_1'] = 'Aujourd’hui à '.date('H:i',strtotime($purposal->applied_time));
        $application_array['text_2'] = 'Naus vous enverrons une notification pour vous prévenir';
        $application_array['text_3'] = 'Voir la fiche praticien';
        return response()->json(['success' => true,"application" => $application_array,'chat' => $chat], $this-> successStatus); 
    }
    
    public function get_candidate(Request $request){
        $allUsers = User::where('user_type','2')->get();
        $user_array = [];
        foreach($allUsers as $i=>$user){
$user_array[$i]['id'] = $user->id;
$user_array[$i]['name'] = $user->name;
$user_array[$i]['heading'] = $user->heading;
$user_array[$i]['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$user_array[$i]['address'] = $user->address;
$user_array[$i]['city'] = $user->city;
$user_array[$i]['cand_map_lat'] = $user->latitude;
$user_array[$i]['cand_map_long'] = $user->longitude;
$user_array[$i]['employee_skills'] = 'skills';
$user_array[$i]['info'] = 'Mutuelle Assurance';
        }
        return response()->json(['success' => true,'users' => $user_array], $this-> successStatus); 
    }
    
    public function get_candidate_by_category(Request $request){
        $allUsers = User::where('user_type','2')->get();
        $user_array = [];
        foreach($allUsers as $i=>$user){
$user_array[$i]['id'] = $user->id;
$user_array[$i]['name'] = $user->name;
$user_array[$i]['heading'] = $user->heading;
$user_array[$i]['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$user_array[$i]['address'] = $user->address;
$user_array[$i]['city'] = $user->city;
$user_array[$i]['cand_map_lat'] = $user->latitude;
$user_array[$i]['cand_map_long'] = $user->longitude;
$user_array[$i]['employee_skills'] = 'skills';
$user_array[$i]['info'] = 'Mutuelle Assurance';
        }
        return response()->json(['success' => true,'users' => $user_array], $this-> successStatus); 
    }
    
    public function get_candidate_by_skills(Request $request){
        $allUsers = User::where('user_type','2')->get();
        $user_array = [];
        foreach($allUsers as $i=>$user){
$user_array[$i]['id'] = $user->id;
$user_array[$i]['name'] = $user->name;
$user_array[$i]['heading'] = $user->heading;
$user_array[$i]['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$user_array[$i]['address'] = $user->address;
$user_array[$i]['city'] = $user->city;
$user_array[$i]['cand_map_lat'] = $user->latitude;
$user_array[$i]['cand_map_long'] = $user->longitude;
$user_array[$i]['employee_skills'] = 'skills';
$user_array[$i]['info'] = 'Mutuelle Assurance';
        }
        return response()->json(['success' => true,'users' => $user_array], $this-> successStatus); 
    }
    
    public function get_candidate_details(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id',$user_id)->first();
        $candidate_info_array = [];
        if($user){
$candidate_info_array['name'] = $user->name;
$candidate_info_array['heading'] = $user->heading;
$candidate_info_array['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$candidate_info_array['cand_intro'] = '';
$candidate_info_array['skills'] = '';
$candidate_info_array['cand_map_lat'] = $user->latitude;
$candidate_info_array['cand_map_long'] = $user->longitude;
$candidate_info_array['address'] = $user->address;
$candidate_info_array['phone'] = $user->phone;
$candidate_info_array['email'] = $user->email;
$candidate_info_array['gender'] = '';
$candidate_info_array['formations'] = '';
$candidate_info_array['experiences'] = '';
$candidate_info_array['diplome'] = '';
$candidate_info_array['video'] = '';
$candidate_info_array['formations_heading'] = 'Formations';
$candidate_info_array['experiences_heading'] = 'Expériences';
$candidate_info_array['diplome_heading'] = "Diplôme d'État";
$candidate_info_array['skills_heading'] = 'Expertises, actes et symptômes';
$candidate_info_array['info_heading'] = 'Présentation du professionnel de santé';
    return response()->json(['success' => true,'user'=>$candidate_info_array], $this-> successStatus); 
        }
        else{
            return response()->json(['success' => false], $this-> successStatus); 
        }
    }
    
    public function get_profile(Request $request){
        $user    = Auth::user();
        $user_id = $user->id;
        $user = User::where('id',$user_id)->first();
        $candidate_info_array = [];
        if($user){
$candidate_info_array['name'] = $user->name;
$candidate_info_array['heading'] = $user->heading;
$candidate_info_array['image'] = ($user->profile_img) ? $user->profile_img : url('public/images/user_logo.png');
$candidate_info_array['cand_map_lat'] = $user->latitude;
$candidate_info_array['cand_map_long'] = $user->longitude;
$candidate_info_array['address'] = $user->address;
$candidate_info_array['phone'] = $user->phone;
$candidate_info_array['email'] = $user->email; 
        }
        $show = '15';
        $page = $request->input('page','1');
        if ($page) {
            $skip = $show * ($page - 1);
        } else {
            $skip = 0;
        }
        $appointment_array = [];
        $appointments = Appointment::with('shift')->where('user_id',$user_id)->orderBy('id','desc')->take($show)->skip($skip)->get();
        foreach($appointments as $i=>$app){
            foreach($app->shift as $s){
                $data = [ 
                    'cat_name'     => $app->category->name,
                    'cat_color'    => $app->category->color,
                    'cat_img'      => $app->category->image,
                    'sub_cat_name' => $app->sub_category->name,
                    'job_id'       => $app->id,
                    'date'         => date('M d',strtotime($s->date)),
                    'start_time'   => date('H:i',strtotime($s->start_time)),
                    'end_time'     => date('H:i',strtotime($s->end_time)),
                    'status'       => $app->status,
                    'year'         => date('Y',strtotime($s->date)),
                    'posted_time'  => date('Y-m-d H:i',strtotime($s->created_at)),
                ];
                $appointment_array[] = $data;
            }
        }
        
        // $pending_appointment_array = [];
        // $pending_appointment = Appointment::with('shift')->where('user_id',$user_id)->where('status','0')->orderBy('id','desc')->get();
        // $i= 0;
        // foreach($pending_appointment as $app){
        //     foreach($app->shift as $s){
        //         $pending_appointment_array[$i]['purposal'] = ((count($app->purposal) > 0) ? true : false);
        //         $pending_appointment_array[$i]['cat_color'] = $app->category->color;
        //         $pending_appointment_array[$i]['cat_name'] = $app->category->name;
        //         $pending_appointment_array[$i]['cat_img'] = $app->category->image;
        //         $pending_appointment_array[$i]['sub_cat_name'] = $app->sub_category->name;
        //         $pending_appointment_array[$i]['job_id'] = $app->id;
        //         $pending_appointment_array[$i]['date'] = date('M d',strtotime($s->date));
        //         $pending_appointment_array[$i]['start_time'] = date('H:i',strtotime($s->start_time));
        //         $pending_appointment_array[$i]['end_time'] = date('H:i',strtotime($s->end_time));
        //         $pending_appointment_array[$i]['year'] = date('Y',strtotime($s->date));
        //         $i++;
        //     }
        // }
        // $confirm_appointment = Appointment::with('shift','acceptPurposal')->where('user_id',$user_id)->where('status','1')->orderBy('id','desc')->get();
        // $j= 0;
        // $confirm_appointment_array = [];
        // foreach($confirm_appointment as $app){
        //     foreach($app->shift as $s){
        //         $confirm_appointment_array[$j]['doctor_id']     = $app->acceptPurposal->doctor_id;
        //         $confirm_appointment_array[$j]['doctor_name']     = $app->acceptPurposal->doctor->name;
        //         $confirm_appointment_array[$j]['applied_time'] = date('H:i',strtotime($app->acceptPurposal->applied_time));
        //         $confirm_appointment_array[$j]['purposal'] = ((count($app->purposal) > 0) ? true : false);
        //         $confirm_appointment_array[$j]['cat_color'] = $app->category->color;
        //         $confirm_appointment_array[$j]['cat_name'] = $app->category->name;
        //         $confirm_appointment_array[$j]['cat_img'] = $app->category->image;
        //         $confirm_appointment_array[$j]['sub_cat_name'] = $app->sub_category->name;
        //         $confirm_appointment_array[$j]['job_id'] = $app->id;
        //         $confirm_appointment_array[$j]['date'] = date('M d',strtotime($s->date));
        //         $confirm_appointment_array[$j]['start_time'] = date('H:i',strtotime($s->start_time));
        //         $confirm_appointment_array[$j]['end_time'] = date('H:i',strtotime($s->end_time));
        //         $confirm_appointment_array[$j]['year'] = date('Y',strtotime($s->date));
        //         $j++;
        //     }
        // }
        // $expired_appointment = Appointment::with('shift')->where('user_id',$user_id)->where('status','2')->orderBy('id','desc')->get();
        // $k= 0;
        // $expired_appointment_array = [];
        // foreach($expired_appointment as $app){
        //     foreach($app->shift as $s){
        //         $expired_appointment_array[$k]['purposal'] = ((count($app->purposal) > 0) ? true : false);
        //         $expired_appointment_array[$k]['cat_color'] = $app->category->color;
        //         $expired_appointment_array[$k]['cat_name'] = $app->category->name;
        //         $expired_appointment_array[$k]['cat_img'] = $app->category->image;
        //         $expired_appointment_array[$k]['sub_cat_name'] = $app->sub_category->name;
        //         $expired_appointment_array[$k]['job_id'] = $app->id;
        //         $expired_appointment_array[$k]['date'] = date('M d',strtotime($s->date));
        //         $expired_appointment_array[$k]['start_time'] = date('H:i',strtotime($s->start_time));
        //         $expired_appointment_array[$k]['end_time'] = date('H:i',strtotime($s->end_time));
        //         $expired_appointment_array[$k]['year'] = date('Y',strtotime($s->date));
        //         $k++;
        //     }
        // }
        return response()->json(['success' => true,'user'=>$candidate_info_array,'appointments' => $appointment_array], $this-> successStatus); 
    }
    
    public function get_pending_applications(Request $request){
        $id = $request->job_id;
        $proposals = AppointmentProposals::with('doctor','appointment')->where('appointment_id',$id)->where('status','0')->get();
        $applications_array = [];
        foreach($proposals as $k=>$p){
            $applications_array[$k]['id'] = $p->id;
            $applications_array[$k]['name'] = $p->doctor->name;
            $applications_array[$k]['info'] = $p->appointment->category->name;//'Family doctor, '.
            $applications_array[$k]['time']  = date('H:i',strtotime($p->applied_time));
            $applications_array[$k]['date']  = date('Y-m-d',strtotime($p->applied_date));
            $applications_array[$k]['distance']  = '4.5 km';
            $applications_array[$k]['doctor_id']  = $p->doctor->id;
            $applications_array[$k]['address'] = $p->doctor->address;
            $applications_array[$k]['job_id']  = $p->appointment->id;
            $applications_array[$k]['img']  = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            // $applications_array[$k]['name'] = $p->doctor->name;
            // $applications_array[$k]['info'] = $p->appointment->category->name;//'Family doctor, '.
            // $applications_array[$k]['default_time']  = date('H:i',strtotime($p->applied_time));
            // $applications_array[$k]['date']  = date('Y-m-d',strtotime($p->applied_date));
            // $applications_array[$k]['time']  = 'Aujourd’hui à'.date('H:i',strtotime($p->applied_time));
            // $applications_array[$k]['distance']  = '4.5 km';
            // $applications_array[$k]['doctor_id']  = $p->doctor->id;
            // $applications_array[$k]['cand_map_lat'] = $p->doctor->latitude;
            // $applications_array[$k]['cand_map_lon'] = $p->doctor->longitude;
            // $applications_array[$k]['address'] = $p->doctor->address;
            // $applications_array[$k]['job_id']  = $p->appointment->id;
            // $applications_array[$k]['img']  = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
            // $applications_array[$k]['total_favourite']  = '1';
        }
        return response()->json(['success' => true,'applications'=>$applications_array], $this-> successStatus); 
        
    }
    
    public function get_applications(Request $request){
        $id = $request->job_id;
        $proposals = AppointmentProposals::with('doctor','appointment')->where('appointment_id',$id)->orderBy('applied_date','desc')->get();
        $application_array = [];
        $i = 0;
        foreach($proposals as $key=>$p){
$new_date = date('Y-m-d',strtotime($p->applied_date));
$appointment_id = $p->appointment->id;
$category = $p->appointment->category;
$sub_category = $p->appointment->sub_category;
$new_data['job_id'] = $appointment_id;
$new_data['id'] = $p->id;
$new_data['date']   = $new_date;
$new_data['title'] = $p->doctor->name;
$new_data['heading'] = $p->doctor->heading;
$new_data['time'] = date('H:i',strtotime($p->applied_time));
$new_data['status'] = $p->status;
$new_data['image'] = ($p->doctor->profile_img) ? $p->doctor->profile_img : url('public/images/user_logo.png');
$new_data['address'] = $p->doctor->address;
$new_data['candidate_id'] =  $p->doctor->id;
$new_data['distance'] = '5';
$new_data['cat']['name'] = $category->name;
$new_data['cat']['subcategory'] = $sub_category->name;
if(isset($application_array[$i])){
    if($application_array[$i]['date'] == $new_date){
        array_push($application_array[$i]['data'],$new_data);
    }
    else{
        $i++;
        $application_array[$i] = [
            'date' => date('Y-m-d',strtotime($new_date)),
            'day'  => date('D',strtotime($new_date)),
            'data' => array($new_data)
        ];
        
    }
}
else{
    $application_array[$i] = [
        'date' => date('Y-m-d',strtotime($new_date)),
        'day'  => date('D',strtotime($new_date)),
        'data' => array($new_data)
    ];
}
            }
        return response()->json(['success' => true,'applications'=>$application_array], $this-> successStatus); 
        
    }
    
    public function get_application_details(Request $request){
        $loginUser = Auth::user();
        $id        = $request->id;
        $lat1      = $loginUser->latitude;
        $lon1      = $loginUser->longitude;
        $proposals = AppointmentProposals::with('doctor','appointment')->where('id',$id)->first();
        $lat2      = $proposals->doctor->latitude;
        $lon2      = $proposals->doctor->longitude;
        if($lat1 && $lon1 && $lat2 && $lon2){
            $distance  = $this->distance($lat1, $lon1, $lat2, $lon2, "K");
        }
        else{
            $distance  = '0';
        }
        // $application['doctor_id'] = $proposals->doctor->id;
        // $application['name'] = $proposals->doctor->name;
        // $application['address'] = $proposals->doctor->address;
        // $application['date'] = date('Y-m-d',strtotime($proposals->applied_date)).'. '.date('H:i',strtotime($proposals->applied_time));
        // $application['info'] = 'Family doctor, '.$proposals->appointment->category->name;
        // $application['img']  = ($proposals->doctor->profile_img) ? $proposals->doctor->profile_img : url('public/images/user_logo.png');
        $application['application_id'] = $proposals->id;
        $application['job_id'] = $proposals->appointment_id;
        $application['doctor_id'] = $proposals->doctor->id;
        $application['name'] = $proposals->doctor->name;
        $application['img']  = ($proposals->doctor->profile_img) ? $proposals->doctor->profile_img : url('public/images/user_logo.png');
        $application['status'] = $proposals->status;
        $application['date'] = date('Y-m-d',strtotime($proposals->applied_date));
        $application['time'] = date('H:i',strtotime($proposals->applied_time));
        $application['address'] = $proposals->doctor->city.(($proposals->doctor->state) ? ', '.$proposals->doctor->state : '');
        $application['distance'] = number_format((float)$distance, 2, '.', '');
        $application['lat'] = $proposals->doctor->latitude;
        $application['long'] = $proposals->doctor->longitude;
        $application['price'] = ($proposals->frontPayment == '1') ? $proposals->paymentValue : '';
        $application['category'] = (($proposals->doctor->categories) ? $proposals->doctor->categories->name : '');
        $application['chat'] = [
            'job_id'      => $proposals->appointment_id,
            'doctor_img'  => ($proposals->doctor->profile_img) ? $proposals->doctor->profile_img : url('public/images/user_logo.png'),
            'doctor_name' => $proposals->doctor->name,
            'doctor_id'   => $proposals->doctor->id, 
            'status'      => $proposals->appointment->status
        ];
        return response()->json(['success' => true,'application'=>$application], $this-> successStatus); 
        
    }
    
    public function get_notification(Request $request){
        $user         = Auth::user();
        $user_id      = $user->id;
        $notification = Notification::where('recieverId',$user_id)->where('status','0')->get();
        $notificationArray = [];
        foreach($notification as $n){
            $data = [
                'id'  => $n->id
            ];
            if($n->type == 'chat'){
                $purposalData = AppointmentProposals::where('doctor_id',$n->senderId)->where('appointment_id',$n->jobId)->first();
                $data['applied_time'] = date('H:i',strtotime($purposalData->applied_time));
                $data['title']        = $n->sender->name.' sent a message';
            }
            else if($n->type == 'appointment'){
                $data['title'] = $n->sender->name.' sent his application for job #'.$n->jobId;
                $data['purposalId'] = $n->purposalId;
            }
            else if($n->type == 'reminder'){
                $data['title'] = 'Reminder for next appointment';
            }
            $data['doctor_img']   = ($n->sender->profile_img) ? $n->sender->profile_img : url('public/images/user_logo.png');
            $data['doctor_name']  = $n->sender->name;
            $data['doctor_id']    = $n->senderId;
            $data['created_date'] = date('Y-m-d H:i',strtotime($n->created_at));
            $data['description'] = $n->message;
            $data['jobId'] = $n->jobId;
            $data['type'] = $n->type;
            array_push($notificationArray,$data);
        }
        return response()->json(['success' => true,'notification'=>$notificationArray], $this-> successStatus); 
    }
    
    public function read_notification(Request $request){
        $id = $request->id;
        Notification::where('id',$id)->update(['status' => '1']);
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function create_chat(Request $request){
        $user       = Auth::user();
        $user_id    = $user->id;
        $name       = $user->name;
        $type       = $request->type;
        if($type == 'list'){
            $notification = Notification::where('recieverId',$user_id)->where('status','0')->count();
            $listArray  = [];
            if($user->user_type == '2'){
                $chatData   = Chat::whereHas('appointment', function($query) {
                    return $query->where('status', '1');
                })->where('doctor_id',$user_id)->orderBy('id','desc')->get();
                foreach($chatData as $key=>$data){
                    $purposalData = AppointmentProposals::where('doctor_id',$data->doctor_id)->where('appointment_id',$data->job_id)->first();
                    $listArray[$key]['status'] = (($data->appointment->status == 2) ? false : true);
                    $listArray[$key]['applied_time'] = date('H:i',strtotime($purposalData->applied_time));
                    $listArray[$key]['job_id']       = $data->job_id;
                    $listArray[$key]['message']      = $data->message;
                    $listArray[$key]['user_id']      = $data->user_id;
                    $listArray[$key]['user_name']    = $data->user->name;
                    $listArray[$key]['user_img']     = ($data->user->profile_img) ? $data->user->profile_img : url('public/images/user_logo.png');
                }
            }
            else{
                $chatData   = Chat::whereHas('appointment', function($query) {
                    return $query->where('status', '1');
                })->where('user_id',$user_id)->orderBy('id','desc')->get();
                foreach($chatData as $key=>$data){
                    $purposalData = AppointmentProposals::where('doctor_id',$data->doctor_id)->where('appointment_id',$data->job_id)->first();
                    $listArray[$key]['status'] = (($data->appointment->status == 2) ? false : true);
                    $listArray[$key]['applied_time'] = date('H:i',strtotime($purposalData->applied_time));
                    $listArray[$key]['job_id']       = $data->job_id;
                    $listArray[$key]['message']      = $data->message;
                    $listArray[$key]['doctor_id']    = $data->doctor_id;
                    $listArray[$key]['doctor_name']  = $data->doctor->name;
                    $listArray[$key]['doctor_img']   = ($data->doctor->profile_img) ? $data->doctor->profile_img : url('public/images/user_logo.png');
                }
            }
            
            return response()->json(['success' => true,'list' => $listArray,'totalNotification' => $notification], $this-> successStatus);
        }
        else if($type == 'notification'){
            if($user->user_type == '2'){
                $userId  = $request->userId;
                $job_id  = $request->chatId;
                $message = $request->text;
                Chat::where('job_id',$job_id)->where('user_id',$userId)->where('doctor_id',$user_id)->update(['message' => $message]);
                $user = User::where('id',$userId)->first();
                $android_token = $user->android_token;
                $ios_token     = $user->ios_token;
                if($android_token){
                    $this->messageNotification($android_token,$name,$message);
                }
                if($ios_token){
                    $this->messageNotification($ios_token,$name,$message);
                }
            }
            else{
                $doctor_id  = $request->doctorId;
                $job_id     = $request->chatId;
                $message    = $request->text;
                Chat::where('job_id',$job_id)->where('user_id',$user_id)->where('doctor_id',$doctor_id)->update(['message' => $message]);
                $notification = [
                    'senderId'   => $user_id,
                    'recieverId' => $doctor_id,
                    'jobId'      => $job_id,
                    'message'    => $message,
                    'type'       => 'chat'
                ];
                Notification::create($notification);
                $user = User::where('id',$doctor_id)->first();
                $android_token = $user->android_token;
                $ios_token     = $user->ios_token;
                if($android_token){
                    $this->messageNotification($android_token,$name,$message);
                }
                if($ios_token){
                    $this->messageNotification($ios_token,$name,$message);
                }
            }
            
            
            return response()->json(['success' => true], $this-> successStatus);
        }
        else{
            $doctor_id  = $request->doctor_id;
            $job_id     = $request->job_id;
            $chatData   = Chat::where('job_id',$job_id)->where('user_id',$user_id)->where('doctor_id',$doctor_id)->first();
            if(!$chatData){
                Chat::create([
                    'job_id'    => $job_id,
                    'user_id'   => $user_id,
                    'doctor_id' => $doctor_id
                ]);
            }
            $appointment = Appointment::where('id',$job_id)->first();
            $success = false;
            if($appointment && $appointment->status != '2'){
                $success = true;
            }
            return response()->json(['success' => $success], $this-> successStatus);
        }
    }
    
    public function doctor_home(Request $request){
        $user       = Auth::user();
        $user_id    = $user->id;
        $today_date = date('Y-m-d');
        $pending_appointment = AppointmentProposals::whereHas('appointment', function($query) {
            return $query->where('status','0');
        })->where('applied_date','>=',$today_date)->where('doctor_id',$user_id)->take(3)->get();
        $pending_appointment_array = [];
        foreach($pending_appointment as $k=>$p){
            $pending_appointment_array[$k]['name']       = $p->appointment->user->name;
            $pending_appointment_array[$k]['info']       = $p->appointment->category->name;//'Family doctor, '.
            $pending_appointment_array[$k]['time']       = 'Aujourd’hui à'.date('H:i',strtotime($p->applied_time));
            $pending_appointment_array[$k]['distance']   = '4.5 km';
            $pending_appointment_array[$k]['user_id']    = $p->appointment->user->id;
            $pending_appointment_array[$k]['job_id']     = $p->appointment->id;
            $pending_appointment_array[$k]['img']        = ($p->appointment->user->profile_img) ? $p->appointment->user->profile_img : url('public/images/user_logo.png');
        }
        $proposals  = AppointmentProposals::whereHas('appointment', function($query) {
            return $query->where('status','1');
        })->where('applied_date','>=',$today_date)->where('doctor_id',$user_id)->take(3)->get();
        $application_array = [];
        foreach($proposals as $k=>$p){
            $application_array[$k]['day']          = (($p->applied_date == $today_date) ? 'Today' : ((date('Y-m-d',strtotime($today_date.' +1 days')) == $p->applied_date) ? 'Tomorrow' : date('l',strtotime($p->applied_date))));
            $application_array[$k]['date']         = date('Y-m-d',strtotime($p->applied_date));
            $application_array[$k]['time']         = date('H:i',strtotime($p->applied_time));
            $application_array[$k]['cand_image']   = ($p->appointment->user->profile_img) ? $p->appointment->user->profile_img : url('public/images/user_logo.png');
            $application_array[$k]['user_id']      = $p->appointment->user->id;
            $application_array[$k]['name']         = $p->appointment->user->name;
            $application_array[$k]['heading']      = $p->appointment->user->heading;
            $application_array[$k]['user_map_lat'] = $p->appointment->user->latitude;
            $application_array[$k]['user_map_lon'] = $p->appointment->user->longitude;
        }
        return response()->json(['success' => true,'application' => $application_array,'pending_application' => $pending_appointment_array], $this-> successStatus); 
    }
    
    public function doctor_job_listing(Request $request){
        $user         = Auth::user();
        $user_id      = $user->id;
        $today_date   = date('Y-m-d');
        $date         = $request->date;
        $categoryId   = $user->category;
        $appointments = Appointment::doesntHave('checkPurposal')->doesntHave('cancelAppointment')->whereHas('appointmentShift', function($query) use ($date) {
            return $query->where('date', $date);
        })->with('appointmentShift')->where('category_id',$categoryId)->where('status','0')->orderBy('id','desc')->get();
        $appointmentArray = [];
        $lat2 = $user->latitude;
        $lon2 = $user->longitude;
        foreach($appointments as $appointment){
            $lat1 = $appointment->user->latitude;
            $lon1 = $appointment->user->longitude;
            $distance = (($lat1 && $lon1 && $lat2 && $lon2) ? $this->distance($lat1, $lon1, $lat2, $lon2, "K") : 0);
            $data = [ 
                'user_id'      => $appointment->user->id,
                'name'         => $appointment->user->name,
                'img'          => ($appointment->user->profile_img) ? $appointment->user->profile_img : url('public/images/user_logo.png'),
                'distance'     => number_format((float)$distance, 2, '.', ''),
                'start_time'   => date('H:i',strtotime($appointment->appointmentShift->start_time)),
                'end_time'     => date('H:i',strtotime($appointment->appointmentShift->end_time)),
                'shift_id'     => $appointment->appointmentShift->id,
                'cat_name'     => $appointment->category->name,
                'cat_color'    => $appointment->category->color,
                'cat_img'      => $appointment->category->image,
                'sub_cat_name' => $appointment->sub_category->name,
                'job_id'       => $appointment->id,
                'latitute'     => $appointment->latitute,
                'longitute'    => $appointment->longitute,
            ];
            array_push($appointmentArray,$data);
        }
        return response()->json(['success' => true,'appointments' => $appointmentArray], $this-> successStatus); 
    }
    
    public function doctor_cancel_job(Request $request){
        $user         = Auth::user();
        $user_id      = $user->id;
        $job_id       = $request->job_id;
        CancelAppointment::create([
            'appointment_id' => $job_id,
            'doctor_id'      => $user_id
        ]);
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function apply_job(Request $request){
        $user         = Auth::user();
        $user_id      = $user->id;
        $job_id       = $request->job_id;
        $candidate_id = $user_id;
        $apply_date   = $request->apply_date;
        $apply_time   = $request->apply_time;
        $shift_id     = $request->shift_id;
        $appointment  = Appointment::with('user')->where('id',$job_id)->first();
        if($appointment->user && ($appointment->user->android_token || $appointment->user->ios_token)){
            $lat1              = $appointment->user->latitude;
            $lon1              = $appointment->user->longitude;
            $lat2              = $user->latitude;
            $lon2              = $user->longitude;
            $distance          = (($lat1 && $lon1 && $lat2 && $lon2) ? $this->distance($lat1, $lon1, $lat2, $lon2, "K") : 0);
            $token             = $appointment->user->android_token;
            $iostoken          = $appointment->user->ios_token;
            $doctor_name       = $user->name;
            $doctor_lat        = $lat2;
            $doctor_long       = $lon2;
            $doctor_address    = $user->address;
            $doctor_heading    = $user->heading;
            $category          = $appointment->category;
            $job_subcategory   = $appointment->sub_category->name;
            $author_id         = $appointment->user->id;
            $cand_map_location = $user->address;
            if($iostoken){
                $this->iosNotification($iostoken,$apply_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance,$lat1,$lon1);
            }
            if($token){
                $this->notification($token,$apply_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance,$lat1,$lon1);
            }
        }
        $data = [
            'appointment_id'       => $job_id,
            'appointment_shift_id' => $shift_id,
            'doctor_id'            => $candidate_id,
            'applied_date'         => $apply_date,
            'applied_time'         => $apply_time,
            'status'               => '0'
        ];
        $purposal = AppointmentProposals::create($data);
        //create notification
        $message = 'Appointment time '.date('F j, Y',strtotime($apply_date)).' '.date('H:i',strtotime($apply_time));
        $notification = [
            'recieverId'    => $appointment->user->id,
            'senderId'      => $candidate_id,
            'jobId'         => $job_id,
            'purposalId'    => $purposal->id,
            'message'       => $message,
            'type'          => 'appointment'
        ];
        Notification::create($notification);
        return response()->json(['success' => true], $this-> successStatus);
    }
    
    public function doctor_applications_by_date(Request $request){
        $user    = Auth::user();
        $user_id = $user->id;
        $status  = $request->status;
        $date    = $request->selected_date;
        $currentDay = date('D', strtotime($date));
        $monday  = ($currentDay == 'Sun') ? date( 'Y-m-d', strtotime($date.' next monday')) : date( 'Y-m-d', strtotime($date.' monday this week'));
        $start   = date('Y-m-d',strtotime($monday.' -1 days'));
        $application_array = [];
        for($i=0;$i<=6;$i++){
            $new_date = date('Y-m-d',strtotime($start.' +'.$i.' days'));
            $proposals = AppointmentProposals::whereHas('appointment', function($query) use ($status) {
                return $query->where('status', $status);
            })->with('appointment')->where('status','<>','2')->where('doctor_id',$user_id)->where('applied_date',$new_date)->get();
            foreach($proposals as $key=>$p){
                $appointment_id = $p->appointment->id;
                $category = $p->appointment->category;
                $sub_category = $p->appointment->sub_category;
$application_array[$new_date][$key]['id'] = $p->id;
$application_array[$new_date][$key]['job_id'] = $appointment_id;
$application_array[$new_date][$key]['date']   = $new_date;
$application_array[$new_date][$key]['title'] = $p->appointment->user->name;
$application_array[$new_date][$key]['heading'] = $p->appointment->user->heading;
$application_array[$new_date][$key]['time'] = date('H:i',strtotime($p->applied_time));
$application_array[$new_date][$key]['status'] = $p->status;
$application_array[$new_date][$key]['image'] = ($p->appointment->user->profile_img) ? $p->appointment->user->profile_img : url('public/images/user_logo.png');
$application_array[$new_date][$key]['address'] = $p->appointment->user->address;
$application_array[$new_date][$key]['candidate_id'] =  $p->appointment->user->id;
$application_array[$new_date][$key]['distance'] = '5';
$application_array[$new_date][$key]['cat']['name'] = $category->name;
$application_array[$new_date][$key]['cat']['subcategory'] = $sub_category->name;
            }
            if(count($proposals) ==  0) {
        		//$application_array[$new_date] = array();
        	}
        }
        if(count($application_array) == 0){
            $application_array = '';
        }
        return response()->json(['success' => true,'applications' => $application_array], $this-> successStatus); 
    }
    
    public function doctor_category(Request $request){
        $category = Categories::where('parent','0')->get();
        return response()->json(['success' => true,'category' => $category], $this-> successStatus); 
    }
    
    public function generate_token(Request $request){ 
        $user    = Auth::user();
        $user_id = $user->id;
        $job_id  = $request->jobId;
        // Required for all Twilio access tokens
        $accountSid   = config('services.twilio.sid');
        $apiKeySid    = config('services.twilio.key');
        $apiKeySecret = config('services.twilio.secret');
        // Required for Video grant
        $roomName = $job_id;
        // An identifier for your app - can be anything you'd like
        $identity = $user_id;
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $accountSid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity
        );
        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        // Add grant to token
        $token->addGrant($videoGrant);
        // render token to string
        $accessToken= $token->toJWT();
        // Serialize the token as a JWT
        return response()->json(['success' => true,'token' => $accessToken], $this-> successStatus); 
    }
    
    public function test(Request $request){ 
        $userId = $request->userId;
        $jobId  = $request->jobId;
        $type   = $request->type;
        $user   = User::where('id',$userId)->first();
        if(!$user){
            return response()->json(['success' => false]); 
        }
        if($type == 'video'){
            // Required for all Twilio access tokens
            $accountSid   = config('services.twilio.sid');
            $apiKeySid    = config('services.twilio.key');
            $apiKeySecret = config('services.twilio.secret');
            // Required for Video grant
            $roomName = $jobId;
            // An identifier for your app - can be anything you'd like
            $identity = $userId;
            // Create access token, which we will serialize and send to the client
            $token = new AccessToken(
                $accountSid,
                $apiKeySid,
                $apiKeySecret,
                3600,
                $identity
            );
            // Create Video grant
            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);
            // Add grant to token
            $token->addGrant($videoGrant);
            // render token to string
            $accessToken  = $token->toJWT();
            //notification send to user
            $androidToken = $user->android_token;
            $iosToken     = $user->ios_token;
            $userName     = $user->name;
            if($androidToken){
                $this->testNotification($accessToken,$androidToken,$userId,$userName,$jobId,$type);
            }
            if($iosToken){
                $this->testNotification($accessToken,$iosToken,$userId,$userName,$jobId,$type);
            }
        }
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function user_match_by_phone(Request $request){ 
        $user     = Auth::user();
        $user_id  = $user->id;
        $contacts = $request->contacts;
        $phoneNumbers = [];
        foreach($contacts as $contact){ 
            foreach($contact['numbers'] as $number){
                $phoneNumbers[] = str_replace('-','',str_replace("+","",$number));
            }
        }
        $users = User::doesntHave('friends')->doesntHave('isFriend')->where('user_type','3')->where('id','<>',$user_id)
        ->WhereIn('phone',$phoneNumbers)->get();
        $userArray = [];
        foreach($users as $user){
            $data['id']            = $user->id;
            $data['display_name']  = $user->name;
            $data['profile_img']   = (($request->profile_img) ? $request->profile_img : url('public/images/user_logo.png'));
            $data['user_email']	   = $user->email;
            $data['phone']	       = $user->phone;
            $data['type']          = $user->type;
            array_push($userArray,$data);
            
        }
        return response()->json(['success' => true,'users' => $userArray], $this-> successStatus); 
    }
    
    public function stripe_payment(Request $request){
        $user       = Auth::user();
        $user_id    = $user->id;
        $token      = $request->token;
        $jobId      = $request->job_id;
        $purposalId = $request->application_id;
        $purposal   = AppointmentProposals::where('id',$purposalId)->first();
        AppointmentProposals::where('id',$purposalId)->update(['isPaid' => '1','status' => '1']);
        Chat::create([
            'job_id'    => $jobId,
            'user_id'   => $user_id,
            'doctor_id' => $purposal->doctor_id
        ]);
        $doctorData = User::where('id',$purposal->doctor_id)->first();
        $chat = [
            'job_id'      => $jobId,
            'doctor_img'  => ($doctorData->profile_img) ? $doctorData->profile_img : url('public/images/user_logo.png'),
            'doctor_name' => $doctorData->name,
            'doctor_id'   => $purposal->doctor_id, 
            'status'      => '1'
        ];
        Appointment::where('id',$jobId)->update(['status' => '1']);
        $notification = [
            'senderId'   => $purposal->doctor_id,
            'recieverId' => $user_id,
            'jobId'      => $jobId,
            'message'    => 'You appointment is scheduled on '.date('F j, Y',strtotime($purposal->applied_date)).' '.date('H:i',strtotime($purposal->applied_time)),
            'type'       => 'reminder'
        ];
        Notification::create($notification);
        $appointment  = Appointment::with('user')->where('id',$jobId)->first();
        $userName     = $appointment->user->name;
        $token        = $purposal->doctor->android_token;
        $date         = date('jS F Y',strtotime($purposal->applied_date));
        $time         = date('H:i',strtotime($purposal->applied_time));
        if($token){
            $this->job_notification($token,$date,$time,$userName);
        }
        return response()->json(['success'=>true]); 
    }
    
    public function update_address(Request $request){ 
        $loginUser = Auth::user();
        $lat       = $request->lat;
        $long      = $request->long;
        $address   = $request->address;
        $city      = $request->city;
        $state     = $request->state;
        $zipCode   = $request->zipCode;
        $country   = $request->country;
        $data = [
            'address'   => $address,
            'city'      => $city,
            'state'     => $state,
            'zipCode'   => $zipCode,
            'country'   => $country,
            'latitude'  => $lat,
            'longitude' => $long
        ];
        User::where('id',$loginUser->id)->update($data);
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function search_by_category(Request $request){ 
        $loginUser = Auth::user();
        $lat      = $request->lat;
        $long     = $request->long;
        $category = $request->category;
        $sortBy   = $request->sortBy;
        $sortBy   = $request->sortBy;
        $users    = User::where('user_type','2')->where('category',$category)->get();
        $userArray = [];
        $topRatedDoctors = [];
        $lat1  = $loginUser->latitude;
        $lon1  = $loginUser->longitude;
        if($lat1 && $lon1){
            foreach($users as $user){
                $lat2     = $user->latitude;
                $lon2     = $user->longitude;
                $distance = '0';
                if($lat1 && $lon1 && $lat2 && $lon2){
                    $distance = $this->distance($lat1, $lon1, $lat2, $lon2, "K");
                }
                $data['id']            = $user->id;
                $data['display_name']  = $user->name;
                $data['profile_img']   = (($request->profile_img) ? $request->profile_img : url('public/images/user_logo.png'));
                $data['distance']      = number_format((float)$distance, 2, '.', '');
                $data['category']      = ($user->categories) ? $user->categories->name : '';
                $data['rating']        = 5;
                $data['price']         = 30;
                $data['favourite']     = (($user->fvDoctor) ? true : false);
                array_push($userArray,$data);
                array_push($topRatedDoctors,$data);
            }
        }
        else{
            return response()->json(['success' => false,'message' => 'Your latitude & longitude not available']); 
        }
        return response()->json(['success' => true,'users' => $userArray,'topRatedDoctors' => $topRatedDoctors], $this-> successStatus); 
    }
    
    public function doctor_by_category(Request $request){ 
        $loginUser = Auth::user();
        $recentSearch = json_decode($loginUser->recent_search);
        //recent_search
        $name = $request->name;
        $users    = User::where('user_type','2')->where('name','LIKE','%'.$name.'%')->get();
        if(count($users) > 0){
            $serachData = [];
            $serachData[0] = $name;
            if(isset($recentSearch[1])){
                $serachData[1] = ($name != $recentSearch[0]) ? $recentSearch[0] : $recentSearch[1];
            }
            else if(isset($recentSearch[0])){
                $serachData[1] = $recentSearch[0];
            }
            if(isset($recentSearch[2])){
                $serachData[2] = ($serachData[1] != $recentSearch[2]) ? $recentSearch[1] : $recentSearch[2];
            }
            else if(isset($recentSearch[1])){
                $serachData[2] = $recentSearch[1];
            }
            User::where('id',$loginUser->id)->update(['recent_search' => json_encode($serachData)]);
        }
        // $category = $request->category;
        // $distance = $request->distance;
        // $status   = $request->status;
        // $gender   = $request->gender;
        // $fav      = $request->fav;
        // $latitude  = $user->latitude;
        // $longitude = $user->longitude;
        // // $users    = User::select(DB::raw('*, ( 3959 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) as distance'))
        // //     ->having('distance', '<=', $distance)->where('user_type','2')->where('category',$category)->get();
        // if($fav == 'fav'){
        //     $users    = User::whereHas('fvDoctor')->where('user_type','2')->where('category',$category)->get();
        // }
        // else if($fav == 'not_fav'){
        //     $users    = User::doesntHave('fvDoctor')->where('user_type','2')->where('category',$category)->get();
        // }else{
        //     $users    = User::where('user_type','2')->where('category',$category)->get();
        // }
        
        //
        $lat1              = $loginUser->latitude;
        $lon1              = $loginUser->longitude;
        $userArray = [];
        foreach($users as $user){
            $lat2     = $user->latitude;
            $lon2     = $user->longitude;
            $distance = '0';
            if($lat1 && $lon1 && $lat2 && $lon2){
                $distance = $this->distance($lat1, $lon1, $lat2, $lon2, "K");
            }
            $data['id']            = $user->id;
            $data['display_name']  = $user->name;
            $data['profile_img']   = (($request->profile_img) ? $request->profile_img : url('public/images/user_logo.png'));
            $data['distance']      = $distance;
            $data['category']      = ($user->categories) ? $user->categories->name : '';
            $data['rating']        = 5;
            $data['price']         = 30;
            array_push($userArray,$data);
        }
        $recentSearchArray = [];
        foreach($recentSearch as $r){
            if (!in_array($r, $recentSearchArray)) {
                array_push($recentSearchArray,$r);
            }
        }
        //distance
        // foreach($users as $user){
        //     $data['id']            = $user->id;
        //     $data['display_name']  = $user->name;
        //     $data['profile_img']   = (($request->profile_img) ? $request->profile_img : url('public/images/user_logo.png'));
        //     $data['user_email']	   = $user->email;
        //     $data['phone']	       = $user->phone;
        //     $data['description']   = $user->heading;
        //     $data['favourite']     = (($user->fvDoctor) ? true : false);//
        //     $data['total_favourite']  = '1';
        //     array_push($userArray,$data);
        // }
        return response()->json(['success' => true,'users' => $userArray,'recentSearch' => $recentSearchArray], $this-> successStatus); 
    }
    
    public function add_fav_doctor(Request $request){ 
        $user      = Auth::user();
        $user_id   = $user->id;
        $doctor_id = $request->doctor_id;
        $fvDoctor  = FavouriteDoctor::where('user_id',$user_id)->where('doctor_id',$doctor_id)->first();
        if($fvDoctor){
            $status = (($fvDoctor->status == '1') ? '0' : '1');
            FavouriteDoctor::where('id',$fvDoctor->id)->update(['status' => $status]);
        }
        else{
            FavouriteDoctor::create([
                'user_id'   => $user_id,
                'doctor_id' => $doctor_id
            ]);
        }
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function add_friend(Request $request){ 
        $user      = Auth::user();
        $user_id   = $user->id;
        $friend_id = $request->friend_id;
        $friends   = Friends::where('user_id',$user_id)->where('friend_id',$friend_id)->first();
        if(!$friends){
            $friends = Friends::where('user_id',$friend_id)->where('friend_id',$user_id)->first();
        }
        if($friends){
            $status = (($friends->status == '1') ? '0' : '1');
            Friends::where('id',$friends->id)->update(['status' => $status]);
        }
        else{
            Friends::create([
                'user_id'   => $user_id,
                'friend_id' => $friend_id
            ]);
        }
        return response()->json(['success' => true], $this-> successStatus); 
    }
    
    public function friends_list(Request $request){ 
        $user      = Auth::user();
        $user_id   = $user->id;
        $friends   = Friends::where('status','1')->where(function($query) use($user_id){
            $query->where('user_id', $user_id)
                ->orWhere('friend_id', $user_id);
            })->orderBy('id','desc')->get();
        $userArray = [];
        foreach($friends as $friend){
            if($friend->user_id == $user_id){
                $data = [
                    'id'            => $friend->friend->id,
                    'display_name'  => $friend->friend->name,
                    'profile_img'   => (($friend->friend->profile_img) ? $friend->friend->profile_img : url('public/images/user_logo.png')),
                    'user_email'    => $friend->friend->email,
                    'phone'         => $friend->friend->phone,
                    'type'          => $friend->friend->type,
                    'status'        => $friend->status
                ];
            }
            else{
                $data = [
                    'id'            => $friend->user->id,
                    'display_name'  => $friend->user->name,
                    'profile_img'   => (($friend->user->profile_img) ? $friend->user->profile_img : url('public/images/user_logo.png')),
                    'user_email'    => $friend->user->email,
                    'phone'         => $friend->user->phone,
                    'type'          => $friend->user->type,
                    'status'        => $friend->status
                ];
            }
            array_push($userArray,$data);
        }
        return response()->json(['success' => true, 'list' => $userArray], $this-> successStatus); 
    }
    
    private function iosNotification($iostoken,$job_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$applied_job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance,$lat1,$lon1){
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
        $application_array['user_lat'] = $lat1;
        $application_array['user_long'] = $lon1;
        $extraNotificationData = ["job_id" => $applied_job_id, "user_id" => $author_id, "application" => $application_array,'notificationType'=> 'Nouvelle proposition de rendez vous','notificationCount' => '2'];
        
        $arrayToSend = array('to' => $iostoken, 'notification' => $notification,'priority'=>'high','data' => $extraNotificationData);
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
            if($res === false){
                return;
            }
            curl_close($ch);
            return $res;
        }
        catch (\Exception $e) {
            return;
        }
    } 
    
    private function notification($token,$job_time,$doctor_name,$doctor_lat,$doctor_long,$doctor_address,$doctor_heading,$category,$job_subcategory,$applied_job_id,$author_id,$cand_map_location,$apply_date,$candidate_id,$distance,$lat1,$lon1){
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
        $application_array['user_lat'] = $lat1;
        $application_array['user_long'] = $lon1;
        		 
        $extraNotificationData = ["job_id" => $applied_job_id, "user_id" => $author_id, "application" => $application_array,'notificationType'=> 'Nouvelle proposition de rendez vous','notificationCount' => '2'];
        
        $fcmNotification = [
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
    
    private function get_proposals($appointment_id,$shift_id){
        return AppointmentProposals::where('appointment_id',$appointment_id)->where('appointment_shift_id',$shift_id)->count();
    }
    
    private function messageNotification($token,$name,$message){
        $image_link = 'https://lh3.googleusercontent.com/a-/AAuE7mBWM2iMPfFDCVrbrs42yBAJnSc4jZ6nct1hxlqx';
        define('API_ACCESS_KEY','AAAA7bWo1wM:APA91bEru78wWfaBobOxrbkp5kYpUApASamz6A7YGiO0It8jyMfZ2YW-mBqc1YxyJb8efA9fhI9xAYqKaHxXHeMrPcEaONC22dnn8LGLKDhfS7AZbqCPJJ7bHRb6WWI89eKiIeq5aCC3');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => $name." sent message",
            'body' => $message,
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
    private function testNotification($accessToken,$token,$userId,$userName,$jobId,$type){
        $image_link = 'https://lh3.googleusercontent.com/a-/AAuE7mBWM2iMPfFDCVrbrs42yBAJnSc4jZ6nct1hxlqx';
        define('API_ACCESS_KEY','AAAA7bWo1wM:APA91bEru78wWfaBobOxrbkp5kYpUApASamz6A7YGiO0It8jyMfZ2YW-mBqc1YxyJb8efA9fhI9xAYqKaHxXHeMrPcEaONC22dnn8LGLKDhfS7AZbqCPJJ7bHRb6WWI89eKiIeq5aCC3');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $data = array
        (
        	'vibrate'	=> 1,
        	'sound'		=> 1,
        	'success'   => 1,
        	'token'     => $accessToken,
        	'userId'    => $userId,
        	'userName'  => $userName,
        	'jobId'     => $jobId,
        	'type'      => $type,
        );
        $fcmNotification = [
        	'to'           => $token, //single token
            'data'         => $data,
            'priority'     =>'high'
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
    
    // private function get_proposals_by_appointment($appointment_id){
    //     return AppointmentProposals::where('appointment_id',$appointment_id)->count();
    // }
}
?>