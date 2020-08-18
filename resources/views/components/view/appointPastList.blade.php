@if ($appointments->count())
<table class="table">
    <tbody>
    @foreach ($appointments as $app)

        @php
            if (auth()->user()->user_type == 2) {
                $user = $app->appointment->user;
            } else {
                $user = $app->doctor;
            }
        @endphp
        <tr>
            <td class="d-flex">
                <figure class="avatar avatar-lg">
                    <img src="{{$user->image()}}" class="rounded-circle" alt="avatar">
                </figure>
                <div class="ml-2 my-auto">
                    <h5>{{$user->name}}</h5>
                    <p class="text-muted">{{$app->appointment->category->name}}</p>
                </div>
            </td>

            <td class="address-row">{{$user->address}}</td>

            <td>
                <i class="fa fa-clock-o mr-2 text-primary" aria-hidden="true"></i>
                {{date('M d', strtotime($app->applied_date))}} {{date('H:i', strtotime($app->applied_time))}}
            </td>

            <td>
                @if ($app->status == 1)
                    <span class="badge badge-success">Successed</span>
                @else
                    <span class="badge badge-danger">Cancelled</span>
                @endif
            </td>

            <td>
                <div class="text-center text-black less-btn action-btn" style="display: none" id="{{$app->id}}_less" data-id="{{$app->id}}">
                    <i class="fa fa-folder-open-o font-large"></i>
                    <h6>Less</h6>
                </div>
                <div class="text-center text-black more-btn action-btn" id="{{$app->id}}_more" data-id="{{$app->id}}"">
                    <i class="ti-more-alt font-large"></i>
                    <h6>More</h6>
                </div>
            </td>
        </tr>
        
    @endforeach
    </tbody>
</table>
@else
<div class="alert alert-danger alert-with-border" role="alert">There is no available data</div>
@endif