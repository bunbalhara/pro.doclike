<?php
    use App\Models\Notification;
    use App\Models\Categories;
    use Carbon\Carbon;
    use App\Models\FavouriteDoctor;
    use App\Models\Friends;
    use App\Models\AppointmentProposals;
    use App\Models\Appointment;
    use App\User;

    function appMessages() {
        return Notification::where('status', 0)->where('type', '<>', 'video')->where('recieverId', auth()->user()->id);
    }

    function appChats() {
        return Notification::where('recieverId', auth()->user()->id)->where('status', 2)->where('type', 'chat');
    }

    function weekDay() {
        $weekMap = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday'
        ];
        return $weekMap[Carbon::now()->dayOfWeek];
    }

    function cityName($address) {
        $city = '';
        $data = explode(', ', $address);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i] == 'France') {
               $data = explode(' ', $data[$i - 1]);
               for ($i = 0; $i < count($data); $i++) {
                   if (!is_numeric($data[$i])) {
                        $city .= $data[$i];
                        if ($i != count($data) - 1) {
                            $city .= ' ';
                        }
                   }
               }
            }
        }
        return $city;
    }

    function categoryList() {
        return Categories::where('parent', 0)->get();
    }

    function like($id) {
        $status = FavouriteDoctor::where('user_id', auth()->user()->id)->where('doctor_id', $id);
        if ($status->count()) {
            return $status->first()->status;
        } else {
            return 0;
        }
    }

    function friend($id) {
        if (User::find($id)->user_type == auth()->user()->user_type) {
            $thisStatus = FavouriteDoctor::where('user_id', auth()->user()->id)->where('doctor_id', $id)->get();
            $userStatus = FavouriteDoctor::where('user_id', $id)->where('doctor_id', auth()->user()->id)->get();
            if ($thisStatus->count() && $userStatus->count()) {
                if ($thisStatus->first()->status == 1 && $userStatus->first()->status == 1) {
                    return 1;
                }
            }
        }
        return 0;
    }

    function diff($start) {
        $seconds =  Carbon::now()->diffInSeconds($start);
        $mins = Carbon::now()->diffInMinutes($start);
        $hours = Carbon::now()->diffInHours($start);
        $days = Carbon::now()->diffInDays($start);
        $weeks = Carbon::now()->diffInWeeks($start);
        $months = Carbon::now()->diffInMonths($start);
        $years = Carbon::now()->diffInYears($start);
        
        if ($years > 0) {
            return $years.' Years ago';
        } else if ($months > 0) {
            return $months.' Months ago';
        } else if ($weeks > 0) {
            return $weeks.' Weeks ago';
        } else if ($days > 0) {
            return $days.' Days ago';
        } else if ($hours > 0) {
            return $hours.' Hours ago';
        } else if ($mins > 0) {
            return $mins.' Minutes ago';
        } else if ($seconds > 0) {
            return $seconds.' Seconds ago';
        }
    }

    function chatList() {
        if(auth()->user()->user_type == '2'){
            $appointments = AppointmentProposals::where('doctor_id', auth()->user()->id)->
            whereDate('applied_date', date('Y-m-d'))->where('status', 1)->orderBy('id','desc')->get();
        } else {
            $appointments = Appointment::whereHas('appointmentShift', function($query) {
                return $query->where('date', date('Y-m-d'));
            })->whereHas('acceptPurposal')->where('user_id', auth()->user()->id)->where('status', 1)->orderBy('id','desc')->get();
        }

        return $appointments;
    }

    function friendsList() {
        $friends = [];

        $friendsIds = FavouriteDoctor::where('user_id', auth()->user()->id)->where('status', 1)->pluck('doctor_id')->all();
        $friendList = FavouriteDoctor::whereIn('user_id', $friendsIds)->where('doctor_id', auth()->user()->id)->where('status', 1)->get();
        
        foreach ($friendList as $friend) {
            array_push($friends, $friend->user);
        }

        return $friends;
    }