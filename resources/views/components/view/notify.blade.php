<a href="#" class="nav-link {{$allData->where('type', '<>', 'chat')->count() !=0 ? 'nav-link-notify' : ''}}" title="Notifications" data-toggle="dropdown" id="notification_section">
    <i class="fa fa-bell-o"></i>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
    <div class="border-bottom px-4 py-3 text-center d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Notifications</h5>
        <small class="opacity-7"><span>{{$allData->where('type', '<>', 'chat')->count()}}</span>   unread notifications</small>
    </div>
    <div class="dropdown-scroll">
        <ul class="list-group list-group-flush">

        @if($allData->where('type', '<>', 'chat')->whereDate('updated_at', \Carbon\Carbon::today())->count())

            <li class="px-4 py-2 text-center small text-muted bg-light">Today</li>

            @if(auth()->user()->user_type == 2)

                @if($allData->where('type', 'job')->whereDate('updated_at', \Carbon\Carbon::today())->count())

                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="job" data-date="today">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-info-bright text-info rounded-circle">
                                    <i class="ti-lock"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'job')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} jobs posted
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'job')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>

                @endif

                @if($allData->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count())
                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="appointment" data-date="today">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-warning-bright text-warning rounded-circle">
                                    <i class="ti-server"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} appointments Confirmed!
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'appointment')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>
                @endif

            @else

                @if($allData->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count())
                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="appointment" data-date="today">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-info-bright text-info rounded-circle">
                                    <i class="ti-lock"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} proposals received!
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'appointment')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>
                @endif

            @endif

        @endif 

        @if($allData->where('type', '<>', 'chat')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
            
            <li class="px-4 py-2 text-center small text-muted bg-light">Old Notifications</li>

            @if(auth()->user()->user_type == 2)

                @if($allData->where('type', 'job')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="job" data-date="old">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-info-bright text-info rounded-circle">
                                    <i class="ti-lock"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'job')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} jobs posted
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'job')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>
                @endif

                @if($allData->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="appointment" data-date="old">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-warning-bright text-warning rounded-circle">
                                    <i class="ti-server"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} appointments Confirmed!
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'appointment')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>
                @endif

            @else

                @if($allData->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
                <li class="px-4 py-3 list-group-item">
                    <div class="d-flex align-items-center hide-show-toggler" data-type="appointment" data-date="old">
                        <div class="flex-shrink-0">
                            <figure class="avatar mr-3">
                                <span
                                    class="avatar-title bg-info-bright text-info rounded-circle">
                                    <i class="ti-lock"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 line-height-20 d-flex justify-content-between">
                                {{$allData->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} proposals received!
                                <i title="Mark as read" data-toggle="tooltip"
                                    class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                            </p>
                            <span class="text-muted small">
                                {{diff($allData->where('type', 'appointment')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
                            </span>
                        </div>
                    </div>
                </li>
                @endif

            @endif

        @endif
        </ul>
    </div>
    <div class="px-4 py-3 text-right border-top">
        <ul class="list-inline small">
            <li class="list-inline-item mb-0">
                <a href="javascript:void(0);" class="all-read-btn">Mark All Read</a>
            </li>
        </ul>
    </div>
</div>