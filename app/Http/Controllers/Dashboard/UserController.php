<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Categories;
use App\Models\FavouriteDoctor;
use App\Models\Friends;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\File;

class UserController extends Controller
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
  public function profile() {
      abort_if((auth()->user()->user_type == '1'), 404, 'you are not a doctor or patient');
      $this->bladeContent['active']       = 'profile';
      $this->bladeContent['user']         = User::where('id',auth()->user()->id)->first();
      $this->bladeContent['gender']       = Config::get('enums.Gender');
      $this->bladeContent['googleMapKey'] = Config::get('enums.GoogleMapKey');
      $this->bladeContent['friendList'] = Friends::where('user_id', auth()->user()->id)->get();
      $this->bladeContent['followList'] = FavouriteDoctor::where('doctor_id', auth()->user()->id)->get();
      return view('pages.dashboard.user.profile', $this->bladeContent);
  }

  public function edit() {
    $this->bladeContent['active']       = 'edit-profile';
    $this->bladeContent['categories']   = Categories::where('parent', 0)->get();
    return view('pages.dashboard.user.settings', $this->bladeContent);
  }

  public function updateProfile(Request $request) {
      abort_if((auth()->user()->user_type == '1'), 404, 'you are not a doctor or patient');

      if ($request->type == 1) {
        $rules = [
          'first_name'     => ['required', 'string', 'max:200'],
          'last_name'      => ['required', 'string', 'max:200'],
          'email'         => ['required', 'string', 'email', 'max:200', 'unique:users,email,'.auth()->user()->id]
        ];
      }

      $userId = auth()->user()->id;
      $rules =[
          'username'      => ['required', 'string', 'max:200'],
          'firstName'     => ['required', 'string', 'max:200'],
          'lastName'      => ['required', 'string', 'max:200'],
          'email'         => ['required', 'string', 'email', 'max:200', 'unique:users,email,'.$userId]
      ];
      $this->validate($request, $rules);
      $updateData = [
          'name'       => $request->username,
          'first_name' => $request->firstName,
          'last_name'  => $request->lastName,
          'email'      => $request->email,
          'phone'      => $request->phoneNumber,
          'gender'     => $request->gender,
      ];
      if($request->dateOfBirth){
          $updateData['dob']   = Carbon::createFromFormat('d/m/Y', $request->dateOfBirth)->format('Y-m-d');
      }
      if($request->clinicAddress){
          $updateData['address']   = $request->clinicAddress;
          $updateData['latitude']  = $request->latitude;
          $updateData['longitude'] = $request->longitude;
      }
      if($request->clinicCity){
         $updateData['city'] = $request->clinicCity;
      }
      $file = $request->file('userImage');
      if($file){
          $path    = 'storage/images/';
          $date    = date('Y-m-d');
          $newDate = explode('-',$date);
          if (!file_exists($path.$newDate[0].'/'.$newDate[1])) {
              mkdir($path.$newDate[0].'/'.$newDate[1], 0777, true);
          }
          $newDir = $path.$newDate[0].'/'.$newDate[1];
          $filename = time() . "_" . str_replace(" ","_",$file->getClientOriginalName());
          $file->move($newDir, $filename);
          $updateData['profile_img'] = url($newDir.'/'.$filename);
      }
      //profile_img
      User::where('id',$userId)->update($updateData);
      //clinic info update
      $clinicInfo = ClinicInfo::where('userId',$userId)->first();
      $clinicInfoData = [
          'userId'      => $userId,
          'biography'   => $request->biography,
          'name'        => $request->clinicName,
          'address'     => $request->address,
          'address1'    => $request->address1,
          'city'        => $request->city,
          'state'       => $request->state,
          'country'     => $request->country,
          'postal_code' => $request->postalCode
      ];

      if($clinicInfo){
          ClinicInfo::where('id',$clinicInfo->id)->update($clinicInfoData);
      }
      else{
          ClinicInfo::create($clinicInfoData);
      }
      session()->flash('success' ,'Profile successfully updated.');
      return redirect('profile');
  }

    public function updateProfile1(Request $request) {
        abort_if((auth()->user()->user_type == '1'), 404, 'you are not a doctor or patient');

        try {
            $validation = Validator::make($request->all(), [
                'first_name'     => 'required|string|max:200',
                'last_name'      => 'required|string|max:200',
                'email'         => 'required|email|max:200',
            ]);

            $userId = auth()->user()->id;
            $userRow =  User::find($userId);
            if($validation->passes()) {
                $file = $request->file('profile_img');
                if($file){
                    $newDir = public_path('front/img/');
                    $filename = time() . "_" . str_replace(" ","_",$file->getClientOriginalName());
                    $file->move($newDir, $filename);
                    if(file_exists(public_path('front/img/'.$userRow->prfile_img)))
                    {
                        File::delete(public_path('front/img/'.$userRow->avatar));
                    }
                    $userRow->profile_img = '/front/img/'.$filename;
                }
                $userRow->first_name = $request->first_name;
                $userRow->last_name = $request->last_name;
                $userRow->name = $request->first_name.' '.$request->last_name;
                $userRow->email = $request->email;
                $userRow->category = $request->category;
                $userRow->save();

                return response()->json(['name' => $userRow->name]);
            } else {
                return response()->json([
                    'errors' => $validation->errors()
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
        }

        session()->flash('success' ,'Profile successfully updated.');
        return redirect()->back();
    }

    public function updateProfile2(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                'phone'     => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6',
                'genderRadio'      => 'required',
                'dob'         => 'required',
                'address'         => 'required|string|min:10',
            ]);

            $userRow =  User::find(auth()->user()->id);
            if($validation->passes()) {
                $userRow->phone = $request->phone;
                $userRow->address = $request->address;
                $userRow->latitude = $request->lat;
                $userRow->longitude = $request->lng;
                $userRow->city = $request->city;
                $userRow->gender = $request->genderRadio;
                $userRow->dob = $request->dob;
                $userRow->save();
                return response()->json(200);
            } else {
                return response()->json([
                    'errors' => $validation->errors()
                ]);
            }
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
            session()->flash('success' ,'Profile successfully updated.');
            return redirect()->back();
        }
    }

    public function updateProfile4(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                'oldPassword'     => 'required',
                'newPassword'     => 'required|min:3',
                'newConfirmPassword' => 'required|same:newPassword',
            ]);

            if($validation->passes())
            {
                $userId = auth()->user()->id;
                $userRow =  User::find($userId);
                $data = $request->all();
                if(!\Hash::check($data['oldPassword'], $userRow->password)){
                    return back()->with('error','You have entered wrong password');

                }
                else{
                    $userRow->password = bcrypt($data['newPassword']);
                    $userRow->save();
                    return response()->json(200);
                }
            }

        }
        catch (\Exception $e)
        {
            echo json_encode($e->getMessage());
        }
        session()->flash('success' ,'Profile successfully updated.');
        return redirect()->back();
    }

    public function updateProfileImage(Request $request) {
        $userRow =  User::find(auth()->user()->id);
        $image = $request->image_profile;
        if ($image){
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('front/img/'), $new_name);
            if(file_exists(public_path('front/img/'.$userRow->bg_img)))
            {
                File::delete(public_path('front/img/'.$userRow->bg_img));
            }
            $userRow->bg_img = $new_name;
            $userRow->save();
        }
        return response()->json(200);
    }


  public function doctorProfile($id) {
      $doctor = User::where('id',$id)->first();
      $this->bladeContent['active'] = 'profile';
      $this->bladeContent['doctor'] = $doctor;
      return view('pages.dashboard.doctor.profile', $this->bladeContent);
  }

  public function getDoctors() {
    $this->bladeContent['doctors'] = User::where('user_type', 2)->get();
    $this->bladeContent['categories'] = Categories::where('parent', 0)->get();
    $this->bladeContent['active'] = 'doctors';
    return view('pages.dashboard.doctor.list', $this->bladeContent);
  }

  public function getPatients() {
    if (auth()->user()->user_type == 3) {
        $this->bladeContent['patients'] = User::where('user_type', 3)->get();
        $this->bladeContent['active'] = 'patients';
        return view('pages.dashboard.patient.list', $this->bladeContent);
    }
  }

  public function likeUser(Request $request) {
    $status = FavouriteDoctor::where('user_id', auth()->user()->id)->where('doctor_id', $request->id);
    if ($status->count()) {
        $editData = FavouriteDoctor::where('user_id', auth()->user()->id)->where('doctor_id', $request->id)->first();
        $editData->status = !$editData->status;
        $editData->save();
        return response()->json(['status' => $editData->status]);
    } else {
        $newData = new FavouriteDoctor();
        $newData->doctor_id = $request->id;
        $newData->user_id = auth()->user()->id;
        $newData->save();
        return response()->json(['status' => 1]);
    }
  }

  public function searchUser(Request $request) {
      if($request->type == 'doctor') {
        $this->bladeContent['doctors'] = User::where('user_type', 2)->where('name', 'like', '%' . $request->data . '%')->get();

        $view = view('components.view.searchDoctorView', $this->bladeContent)->render();
      } else {
        $this->bladeContent['patients'] = User::where('user_type', 3)->where('name', 'like', '%' . $request->data . '%')->get();

        $view = view('components.view.searchPatientView', $this->bladeContent)->render();
      }

    return response()->json(compact('view'));
  }

  private function profileRule($request) {
    $rule['first_name']='required|string|max:200';
    $rule['last_name']='required|string|max:200';
    $rule['email'] = 'required|string|email|max:200|unique:users,email,.auth()->user()->id';
    return $rule;
  }
}
