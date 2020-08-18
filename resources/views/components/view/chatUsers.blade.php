<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
        aria-labelledby="pills-home-tab">
    <div class="chat-lists">
        <div class="list-group list-group-flush">
            @foreach ($appointments as $key => $item)

                @if (auth()->user()->user_type == '2')
                
                <a href="#" class="list-group-item d-flex align-items-center media-btn {{$key == 0 ? 'active' : ''}}" data-id="{{$item->appointment->id}}" data-type="job">
                    <div class="pr-3">
                        {{-- <div class="avatar {{$item->appointment->user->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}} "> --}}
                        <div class="avatar avatar-state-success">
                            <img src="{{$item->appointment->user->image()}}"class="rounded-circle" alt="image">
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">{{$item->appointment->user->name}}</h6>
                        <span class="text-muted">{{$item->appointment->category->name}}</span>
                    </div>
                    <div class="text-right ml-auto d-flex flex-column">
                        @if (appChats()->where('jobId', $item->appointment->id)->count())
                        <span class="badge badge-success badge-pill ml-auto mb-2">
                            {{appChats()->where('jobId', $item->appointment->id)->count()}}
                        </span>
                        @endif
                        <span class="small text-muted">{{date('H:i',strtotime($item->applied_time))}}</span>
                    </div>
                </a>

                @else

                <a href="#" class="list-group-item d-flex align-items-center media-btn {{$key == 0 ? 'active' : ''}}" data-id="{{$item->id}}" data-type="job">
                    <div class="pr-3">
                        {{-- <div class="avatar {{$item->acceptPurposal->doctor->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}} "> --}}
                        <div class="avatar avatar-state-success">
                            <img src="{{$item->acceptPurposal->doctor->image()}}"class="rounded-circle" alt="image">
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">{{$item->acceptPurposal->doctor->name}}</h6>
                        <span class="text-muted">{{$item->category->name}}</span>
                    </div>
                    <div class="text-right ml-auto d-flex flex-column">
                        @if (appChats()->where('jobId', $item->acceptPurposal->appointment_id)->count())
                        <span class="badge badge-success badge-pill ml-auto mb-2">
                            {{appChats()->where('jobId', $item->acceptPurposal->appointment_id)->count()}}
                        </span>
                        @endif
                        <span class="small text-muted">{{date('g:i A', strtotime($item->acceptPurposal->applied_time))}}</span>
                    </div>
                </a>

                @endif

            @endforeach
        </div>
    </div>
</div>
<div class="tab-pane fade" id="pills-profile" role="tabpanel"
        aria-labelledby="pills-profile-tab">
    <div class="list-group list-group-flush">
        @foreach ($friends as $friend)
        <a href="#" class="list-group-item d-flex align-items-center media-btn" data-id="{{$friend->user_id}}" data-type="friend">
            <div class="pr-3">
                {{-- <div class="avatar {{$friend->user->status == 0 ? 'avatar-state-danger' : 'avatar-state-success'}}"> --}}
                <div class="avatar avatar-state-danger">
                    <img src="{{$friend->user->image()}}"
                            class="rounded-circle"
                            alt="image">
                </div>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-1">{{$friend->user->name}}</h6>
                <div class="text-muted d-flex align-items-center">
                    <i class="fa fa-user mr-2"></i>
                    Friend
                </div>
            </div>
            <div class="text-right ml-auto">
                @if (appChats()->where('senderId', $friend->user->id)->count())
                    <span class="badge badge-success badge-pill ml-auto mb-2">
                        {{appChats()->where('senderId', $friend->user->id)->count()}}
                    </span>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>