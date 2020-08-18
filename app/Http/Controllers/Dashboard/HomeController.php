<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AppointmentProposals;
use App\Models\Appointment;

use App\User;
use App\Models\FavouriteDoctor;
use App\Models\Friends;

use App\Models\Categories;

use App\Models\Notification;

class HomeController extends Controller
{
    /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct() {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index() {
    // Notification::truncate();
    $today = date('Y-m-d');

    $this->bladeContent['active'] = 'home';

    if (auth()->user()->user_type == 3) {
      $confirmIds = Appointment::whereHas('shift', function ($query) use($today) {
        $query->where('date', $today);
      })->where('user_id', auth()->user()->id)->where('status', '1')->pluck('id')->all();
      $pendingIds = Appointment::whereHas('shift', function ($query) use($today) {
        $query->where('date', $today);
      })->where('user_id', auth()->user()->id)->where('status', '0')->pluck('id')->all();

      $this->bladeContent['proposalData'] = AppointmentProposals::whereIn('appointment_id', $confirmIds)->where('applied_date', $today)->where('status', '1')->orderBy('id','desc')->get();
      $this->bladeContent['pendingData'] = AppointmentProposals::whereIn('appointment_id', $pendingIds)->where('applied_date', $today)->where('status', '0')->orderBy('id','desc')->get();
      $this->bladeContent['doctorData'] = User::where('user_type', 2)->get();
      $this->bladeContent['categories'] = Categories::where('parent', 0)->get();

      // $this->bladeContent['currentApp'] = Appointment::doesntHave('checkPurposal')->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->first();
      $this->bladeContent['currentApp'] = null;
      return view('pages.dashboard.home.patient', $this->bladeContent);
    } else if (auth()->user()->user_type == 2) {

      $this->bladeContent['appCount'] = Appointment::count();
      $this->bladeContent['postCount'] = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('status', 1)->count();
      $this->bladeContent['appData'] = AppointmentProposals::where('doctor_id', auth()->user()->id)->where('applied_date', $today)->orderBy('id', 'desc')->get();
      $this->bladeContent['jobData'] = Appointment::doesntHave('checkPurposal')->doesntHave('cancelAppointment')->whereHas('appointmentShift', function($query) use ($today) {
        return $query->where('date', $today);
      })->with('appointmentShift')->where('category_id', auth()->user()->category)->where('status', '0')->orderBy('id', 'desc')->get();

      $this->bladeContent['friendCount'] = Friends::where('user_id', auth()->user()->id)->count();
      $this->bladeContent['favouriteCount'] = FavouriteDoctor::where('doctor_id', auth()->user()->id)->count();
      $this->bladeContent['patientCount'] = User::where('user_type', 3)->count();
      $this->bladeContent['messageCount'] = Notification::where('recieverId', auth()->user()->id)->where('status', 0)->where('type', '<>', 'video')->count();
      $this->bladeContent['callCount'] = Notification::where('recieverId', auth()->user()->id)->where('status', 0)->where('type', 'video')->count();

      return view('pages.dashboard.home.doctor', $this->bladeContent);
    }
  }
}
