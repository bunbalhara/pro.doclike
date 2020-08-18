<div class="header d-print-none">
    <div class="header-container">
        <div class="header-left">
            <div class="navigation-toggler">
                <a href="#" data-action="navigation-toggler">
                    <i data-feather="menu"></i>
                </a>
            </div>

            <div class="header-logo">
                <a href="/dashboard">
                    <img src="{{asset('front/img/logo-white.png')}}" alt="logo" height="36">
                </a>
            </div>
        </div>

        <div class="header-body">
            <div class="header-body-left">
                <ul class="navbar-nav">
                    <li class="nav-item mr-3">
                        <div class="header-search-form">
                            <form>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn header-search-close-btn">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none d-md-block">
                        <a href="#" class="nav-link" title="Apps" data-toggle="dropdown">Apps</a>
                        <div class="dropdown-menu dropdown-menu-big">
                            <div class="border-bottom px-4 py-3 text-center d-flex justify-content-between">
                                <h5 class="mb-0">Apps</h5>
                            </div>
                            <div class="p-3">
                                <div class="row row-xs">
                                    <div class="col-6">
                                        <a href="{{auth()->user()->user_type == 2 ? url('dashboard/jobs') : url('dashboard/jobs/create')}}">
                                            <div class="border-radius-1 text-center">
                                                <figure class="avatar avatar-lg border-0">
                                            <span class="avatar-title bg-info text-white rounded-circle">
                                                <i class="width-30 height-30" data-feather="check-circle"></i>
                                            </span>
                                                </figure>
                                                <div class="mt-2">Jobs</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{url('dashboard/chat/page')}}">
                                            <div class="border-radius-1 text-center mb-3">
                                                <figure class="avatar avatar-lg border-0">
                                            <span class="avatar-title bg-primary text-white rounded-circle">
                                                <i class="width-30 height-30" data-feather="message-circle"></i>
                                            </span>
                                                </figure>
                                                <div class="mt-2">Chat</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{auth()->user()->user_type == 2 ? url('dashboard/user/doctors') : url('dashboard/user/patients')}}">
                                            <div class="border-radius-1 text-center mb-3">
                                                <figure class="avatar avatar-lg border-0">
                                            <span class="avatar-title bg-secondary text-white rounded-circle">
                                                <i class="width-30 height-30" data-feather="mail"></i>
                                            </span>
                                                </figure>
                                                <div class="mt-2">Friends</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{url('appointment/table')}}">
                                            <div class="border-radius-1 text-center">
                                                <figure class="avatar avatar-lg border-0">
                                            <span class="avatar-title bg-warning text-white rounded-circle">
                                                <i class="width-30 height-30" data-feather="file"></i>
                                            </span>
                                                </figure>
                                                <div class="mt-2">Appointments</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="header-body-right">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link mobile-header-search-btn" title="Search">
                            <i data-feather="search"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown d-none d-md-block">
                        <a href="#" class="nav-link" title="Fullscreen" data-toggle="fullscreen">
                            <i class="maximize" data-feather="maximize"></i>
                            <i class="minimize" data-feather="minimize"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown" id="chat_modal">
                        <a href="#" class="nav-link {{appMessages()->where('type', 'chat')->count() != 0 ? 'nav-link-notify' : 'none'}}" title="Chats" data-sidebar-target="#chat-list" id="chat_section">
                            <i class="fa fa-comment-o"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown" id="notify_modal">
                        <a href="#" class="nav-link {{appMessages()->where('type', '<>', 'chat')->count() !=0 ? 'nav-link-notify' : ''}}" title="Notifications" data-toggle="dropdown" id="notification_section">
                            <i class="fa fa-bell-o"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                            <div class="border-bottom px-4 py-3 text-center d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Notifications</h5>
                                <small class="opacity-7"><span>{{appMessages()->where('type', '<>', 'chat')->count()}}</span>   unread notifications</small>
                            </div>
                            <div class="dropdown-scroll">
                                <ul class="list-group list-group-flush">

                                @if(appMessages()->where('type', '<>', 'chat')->whereDate('updated_at', \Carbon\Carbon::today())->count())

                                    <li class="px-4 py-2 text-center small text-muted bg-light">Today</li>

                                    @if(auth()->user()->user_type == 2)

                                        @if(appMessages()->where('type', 'job')->whereDate('updated_at', \Carbon\Carbon::today())->count())

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
                                                        {{appMessages()->where('type', 'job')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} jobs posted
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'job')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>

                                        @endif

                                        @if(appMessages()->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count())
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
                                                        {{appMessages()->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} appointments Confirmed!
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'appointment')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                    @else

                                        @if(appMessages()->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count())
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
                                                        {{appMessages()->where('type', 'appointment')->whereDate('updated_at', \Carbon\Carbon::today())->count()}} proposals received!
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'appointment')->first()->whereDate('updated_at', \Carbon\Carbon::today())->first()->updated_at)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                    @endif

                                @endif

                                @if(appMessages()->where('type', '<>', 'chat')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())

                                    <li class="px-4 py-2 text-center small text-muted bg-light">Old Notifications</li>

                                    @if(auth()->user()->user_type == 2)

                                        @if(appMessages()->where('type', 'job')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
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
                                                        {{appMessages()->where('type', 'job')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} jobs posted
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'job')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                        @if(appMessages()->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
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
                                                        {{appMessages()->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} appointments Confirmed!
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'appointment')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                    @else

                                        @if(appMessages()->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count())
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
                                                        {{appMessages()->where('type', 'appointment')->whereDate('updated_at', '<>', \Carbon\Carbon::today())->count()}} proposals received!
                                                        <i title="Mark as read" data-toggle="tooltip"
                                                            class="hide-show-toggler-item fa fa-circle-o font-size-11"></i>
                                                    </p>
                                                    <span class="text-muted small">
                                                        {{diff(appMessages()->where('type', 'appointment')->first()->whereDate('updated_at', '<>', \Carbon\Carbon::today())->first()->updated_at)}}
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
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" title="Settings" data-sidebar-target="#settings">
                            <i data-feather="settings"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" title="User menu" data-toggle="dropdown">
                            <figure class="avatar avatar-sm">
                                <img src="{{auth()->user()->image()}}"
                                    class="rounded-circle" id="avatar_img"
                                    alt="avatar"/>
                            </figure>
                            <span class="ml-2 d-sm-inline d-none">{{auth()->user()->name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                            <div class="text-center py-4">
                                <figure class="avatar avatar-lg mb-3 border-0">
                                    <img src="{{auth()->user()->image()}}"
                                        class="rounded-circle" alt="image">
                                </figure>
                                <h5 class="text-center">{{auth()->user()->name}}</h5>
                                <div class="mb-3 small text-center text-muted">{{auth()->user()->email}}</div>
                                <a href="{{url('dashboard/profile/settings')}}" class="btn btn-outline-light btn-rounded">Manage Your Account</a>
                            </div>
                            <div class="list-group">
                                <a href="/dashboard/profile" class="list-group-item">View Profile</a>
                                <a href="{{route('logout')}}" class="list-group-item text-danger">Sign Out!</a>
                            </div>
                            <div class="p-4">
                                <div class="mb-4">
                                    <h6 class="d-flex justify-content-between">
                                        Profile
                                        <div class=""><span>%25</span> Completed</div>
                                    </h6>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success-gradient" role="progressbar" style="width: 40%;"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <hr class="mb-3">
                                <p class="small mb-0">
                                    <a href="#">Privacy policy</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item header-toggler">
                <a href="#" class="nav-link">
                    <i data-feather="arrow-down"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
