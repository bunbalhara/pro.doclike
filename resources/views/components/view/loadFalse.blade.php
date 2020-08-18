@foreach($proposal as $k=>$app)
<div class="form-group row" data-id="{{$app->id}}">
    <div class="col-md-2 col-2">
        <img src="{{(($app->appointment->user->profile_img) ? $app->appointment->user->profile_img : url('/front/img/user_logo.png'))}}" class="user-profile">
    </div>
    <div class="col-md-4 col-6 text-md-left text-center">
        {{$app->appointment->user->name}}<br>
        <b>{{$app->appointment->category->name}}</b>
    </div>
    <div class="col-md-4 d-md-block d-none">
        <span class="time-icon">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
        </span>
        <span class="start-time">{{date('H:i',strtotime($app->applied_time))}}</span>
    </div>
    <div class="col-md-2 col-4">
        <button data-id="{{$app->id}}" class="btn btn-primary cancel-appointment">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
</div>
<hr>
@endforeach
