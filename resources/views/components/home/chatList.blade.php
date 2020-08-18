<div class="sidebar" id="chat-list">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title d-flex justify-content-between">
                Chats
                <a class="btn-sidebar-close" href="#">
                    <i class="ti-close"></i>
                </a>
            </h6>
            <div class="list-group list-group-flush">
            @foreach (chatList() as $app)

                @if (auth()->user()->user_type == 2)
                <a href="{{url('dashboard/chat/page')}}" class="list-group-item d-flex px-0 align-items-start">
                    <div class="pr-3">
                        {{-- <span class="avatar {{$app->appointment->user == '1' ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
                        <span class="avatar avatar-state-success">
                            <img src="{{$app->appointment->user->image()}}"
                                class="rounded-circle"
                                alt="image">
                        </span>
                    </div>

                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{$app->appointment->user->name}}</h6>
                        <span class="text-muted">{{$app->appointment->category->name}}</span>
                    </div>

                    <div class="text-right ml-auto d-flex flex-column">
                        @if (appMessages()->where('jobId', $app->appointment->id)->count())
                        <span class="badge badge-primary badge-pill ml-auto mb-2">
                            {{appMessages()->where('jobId', $app->appointment->id)->count()}}
                        </span>
                        @endif

                        <span class="small text-muted">{{date('g:i A',strtotime($app->applied_time))}}</span>
                    </div>
                </a>
                @else
                <a href="{{url('dashboard/chat/page')}}" class="list-group-item d-flex px-0 align-items-start">
                    <div class="pr-3">
                        {{-- <span class="avatar {{$app->acceptPurposal->doctor == '1' ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
                        <span class="avatar avatar-state-success">
                            <img src="{{$app->acceptPurposal->doctor->image()}}"
                                class="rounded-circle"
                                alt="image">
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{$app->acceptPurposal->doctor->name}}</h6>
                        <span class="text-muted">{{$app->category->name}}</span>
                    </div>
                    <div class="text-right ml-auto d-flex flex-column">
                        @if (appMessages()->where('jobId', $app->acceptPurposal->appointment_id)->count())
                        <span class="badge badge-primary badge-pill ml-auto mb-2">
                            {{appMessages()->where('jobId', $app->acceptPurposal->appointment_id)->count()}}
                        </span>
                        @endif

                        <span class="small text-muted">{{date('g:i A',strtotime($app->applied_time))}}</span>
                    </div>
                </a>
                @endif

            @endforeach

            @foreach (friendsList() as $user)
                <a href="{{url('dashboard/chat/page')}}" class="list-group-item px-0 d-flex align-items-start">
                    <div class="pr-3">
                        <div class="avatar avatar-state-success">
                            {{-- <div class="avatar {{$user->status == '1' ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
                            <img src="{{$user->image()}}"
                                class="rounded-circle"
                                alt="image">
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">{{$user->name}}</h6>
                        <span class="text-muted">Friend</span>
                    </div>
                    <div class="text-right ml-auto d-flex flex-column">
                        @if (appMessages()->where('senderId', $user->id)->count())
                        <span class="badge badge-primary badge-pill ml-auto mb-2">
                            {{appMessages()->where('senderId', $user->id)->count()}}
                        </span>
                        @endif
                    </div>
                </a>
            @endforeach
            </div>
        </div>
    </div>
</div>
