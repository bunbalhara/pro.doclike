@foreach ($appointments as $key => $item)
    <div class="form-group row" data-id="{{$item->id}}" id="{{$item->id}}">
        <div class="col-2 my-auto">
            <img src="{{(($item->appointment->user->profile_img) ? $item->appointment->user->profile_img : asset('front/img/user_logo.png'))}}" class="user-profile">
        </div>
        <div class="col-4 my-auto pr-0">
            &nbsp;{{$item->appointment->user->name}}<br>
            <b>&nbsp;{{$item->appointment->category->name}}</b>
        </div>
        <div class="col-4 my-auto">
            <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
            <span class="start-time">{{date('H:i',strtotime($item->start_time))}} - </span>
            <span class="end-time">{{date('H:i',strtotime($item->end_time))}}</span>
        </div>
        <div class="col-2 my-auto">
            <button data-id="{{$item->appointment->id}}" data-shift="{{$item->id}}" data-start="{{$item->start_time}}" data-end="{{$item->end_time}}" data-date="{{$item->date}}" class="btn btn-primary accept-purposer">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <hr>
@endforeach
