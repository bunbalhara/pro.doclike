@foreach($proposal as $k=>$app)
<div class="form-group row" data-id="{{$app->id}}">
    <div class="col-md-2 col-2">
        <img src="{{(($app->appointment->user->profile_img) ? $app->appointment->user->profile_img : url('images/user_logo.png'))}}" class="rounded-circle">
    </div>
    <div class="col-md-4 col-6 text-md-left text-center">
        {{$app->appointment->user->name}}<br>
        <b>{{$app->appointment->category->name}}</b>
    </div>
    <div class="col-md-3 d-md-block d-none">
        <span class="time-icon">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
        </span>
        <span class="start-time">{{date('H:i',strtotime($app->applied_time))}}</span>
    </div>
    <div class="col-md-3 col-4">
        <div class="d-flex call-action">
            <a class="btn btn-primary chat-btn" href="javascript:void(0)"  data-id="{{$app->appointment->id}}">
                <i class="fas fa-comment-dots"></i>
            </a>
            <a class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-phone" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<hr>
@endforeach
