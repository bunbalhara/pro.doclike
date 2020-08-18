@if ($appointments->count())

    @foreach($appointments as $k=>$app)
    <hr>
    <div class="form-group row" data-id="{{$app->id}}">
        <div class="col-md-2 col-2">
            <figure class="avatar avatar-md mr-2">
                <img src="{{$app->appointment->user->image()}}" class="rounded-circle">
            </figure>
        </div>

        <div class="col-md-4 col-6 text-md-left text-center">
            {{$app->appointment->user->name}}<br>
            <b>{{$app->appointment->category->name}}</b>
        </div>

        <div class="col-md-3 d-md-block d-none my-auto">
            <span class="time-icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
            </span>
            <span class="start-time">{{date('H:i',strtotime($app->applied_time))}}</span>
        </div>

        <div class="col-md-3 col-4">
            <div class="d-flex call-action">       
                <a href="{{url('dashboard/chat/page')}}" class="text-center text-success action-btn">
                    <i class="fa fa-video-camera font-large"></i>
                    <h6>Start</h6>
                </a>
            </div>
        </div>
    </div>
    @endforeach

@else
<div class="alert alert-danger alert-with-border" role="alert">No data found!</div>
@endif


