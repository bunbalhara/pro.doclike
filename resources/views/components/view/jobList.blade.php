@if ($jobData->count())
<div class="table-responsive">
    <table class="table">
        <thead>
            <th scope="row" class="text-center">#</th>
            <th scope="row" class="text-center">Name</th>
            <th scope="row" class="text-center">Gender</th>
            <th scope="row" class="text-center">Category</th>
            <th scope="row" class="text-center">Availability</th>
            <th scope="row" class="text-center">Action</th>
        </thead>
        <tbody>
            @foreach ($jobData as $id => $job)
            <tr>
                <th scope="row" class="text-center">{{$id + 1}}</th>
                <th class="d-flex">
                    <figure class="avatar avatar-md mr-2">
                        <img src="{{$job->user->image() }}" class="rounded-circle" alt="image">
                    </figure>
                    <div class="my-auto">
                        {{$job->user->name}}
                    </div>
                </th>
                <td>{{$job->user->gender}}</td>
                <td>{{$job->category->name}}</td>
                <td>{{date('H:i', strtotime($job->appointmentShift->start_time)) }} ~ {{date('H:i',strtotime($job->appointmentShift->end_time)) }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-success btn-rounded btn-uppercase job-btn" data-id="{{$job->id}}" data-shift="{{$job->appointmentShift}}">
                        <i class="ti-check-box mr-2"></i> Accept
                    </button>
                    <button type="button" class="btn btn-danger btn-rounded btn-uppercase app-btn" data-id="{{$job->id}}" data-type="cancel_request">
                        <i class="ti-trash mr-2"></i> Cancel
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<h5 class="text-center text-danger mt-5">There is no available Data</h5>
@endif