@if ($appointments->count())
    @if (auth()->user()->user_type == '3')
        
        @foreach($appointments as $k=>$app)

            <div class="form-group row" data-id="{{$app->id}}">
                <div class="col-2 my-auto">
                    <img src="{{$app->doctor->image()}}" class="user-profile">
                </div>

                <div class="col-3 my-auto pr-0">
                    &nbsp;{{$app->doctor->name}}

                    @if($app->frontPayment == '1')
                        <a href="javascript:void(0)" class="upfront-payment">
                            <span class="ml-2"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span>
                        </a>
                    @endif

                    <br>

                    <b>&nbsp;{{$app->appointment->category->name}}</b>
                </div>

                <div class="col-3 my-auto">
                    <span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                    <span class="start-time">{{date('H:i',strtotime($app->applied_time))}}</span>
                </div>

                <div class="col-4 my-auto">
                    <div class="d-flex call-action">
                        <button data-appointment="{{$app->appointment->id}}" data-id="{{$app->id}}" class="btn btn-success btn-floating confirm-appointment mr-2"><i class="ti-check-box" aria-hidden="true"></i></button>
                        <button data-id="{{$app->id}}" class="btn btn-success btn-danger btn-floating cancel-appointment"><i class="ti-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <hr>

        @endforeach

    @else
        @foreach($appointments as $k=>$app)
        <table class="table"><tbody>
            <tr data-id="{{$app->id}}">
                <th class="d-flex">
                    <figure class="avatar avatar-md mr-2">
                        <img src="{{$app->appointment->user->image() }}" class="rounded-circle" alt="image">
                    </figure>
                    <div class="my-auto">
                        {{$app->appointment->user->name}}
                        <p class="text-muted">{{$app->appointment->category->name}}</p>
                    </div>
                </th>
                <td>{{date('M d - H:i', strtotime($app->applied_time)) }}</td>
                <td class="text-right">
                    <div class="text-danger text-center action-btn app-btn" data-id="{{$app->id}}" data-type="cancel">
                        <i class="fa fa-ban font-large" aria-hidden="true"></i>
                        <h6>Deny</h6>
                    </div>
                </td>
            </tr>
        </tbody></table>
        @endforeach

    @endif

@else
<div class="alert alert-danger alert-with-border" role="alert">No data found!</div>
@endif


