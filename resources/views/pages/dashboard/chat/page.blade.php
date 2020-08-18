@extends('layouts.theme')

@section('style')
    <style>
        .sidebar {
            position: absolute;
            width: 360px;
            right: 0;
            top: 0;
            display: block;
            background: #f4f6f8;
            border-left: 1px solid rgba(0, 0, 0, .1) ;
            height: 100%;
            margin-top: 30px;
            height: calc(100vh - 180px) !important;
        }
        .sidebar i {
            font-size: 1rem;
            color: #299acf;
            padding: 6px;
            border: 1px solid lightgrey;
            border-radius: 50%;
            width: 30px;
            text-align: center;
        }
        .middle-text {
            top: 50%;
            left: 50%;
            position: absolute;
            text-align: center;
            transform: translate(-50%, -50%);
        }
        @media (max-width: 1200px) {
            .sidebar {
                height: calc(100vh - 120px) !important;
            }
        }
    </style>
@endsection

@section('page')

<div class="row no-gutters chat-block">

    <div class="col-lg-4 chat-sidebar">

        <div class="chat-sidebar-header">
            <div class="float-right">
                <h5 class="font-weight-bold" id="time"></h5>
                <small id="date">
                    {{Carbon\Carbon::now()->format('Y-m-d')}}
                </small>
            </div>
            <h3 class="mb-4">Chats</h3>
            <form class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search chat">
                    <div class="input-group-append">
                        <button class="btn btn-outline-light" type="button">
                            <i class="ti-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                       role="tab" aria-controls="pills-home" aria-selected="true">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                       role="tab" aria-controls="pills-profile" aria-selected="false">Friends</a>
                </li>
            </ul>
        </div>

        <div class="chat-sidebar-content">
            <div class="tab-content pt-3" id="pills-tabContent-chat">
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
                                <div class="avatar avatar-state-danger">
                                {{-- <div class="avatar {{$friend->user->status == 0 ? 'avatar-state-danger' : 'avatar-state-success'}}"> --}}
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
            </div>
        </div>
    </div>

    <div class="col-lg-8 chat-content"></div>

</div>

<div class="sidebar" style="display: none">
    <div class="profile"></div>
    <div class="w-100 position-absolute" style="height: calc(100vh - 580px)" id="map" style="bottom: 0"></div>
</div>
    
@endsection

@section('script')

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{config('enums.GoogleMapKey')}}&components=country:'FR'"></script>
<script>

$(document).ready(function(){
    var loadingView = '<div class="middle-text"><div class="d-flex text-info"><div class="spinner-border mr-2" role="status">' +
    '<span class="sr-only"></span></div><h5 class="my-auto">Loading...</h5></div></div>';
    var errorView = '<div class="middle-text"><h5 class="text-danger">Server Error!</h5></div>';
    
    var appointments = @json($appointments->count());

    var display = false;

    if (appointments) {
        $.ajax({
            url: "/dashboard/chat/initData",
            type: "POST",
            success: function(res){
                $(".chat-content").html(res.view);
            }
            ,error: function (err) {console.log(err)}
        });

        function showTime() {
            const date = new Date(),
                utc = new Date(Date.UTC(
                    date.getFullYear(),
                    date.getMonth(),
                    date.getDate(),
                    date.getHours(),
                    date.getMinutes(),
                    date.getSeconds()
                ));

            document.getElementById('time').innerHTML = utc.toLocaleTimeString('en-US', {timeZone: 'Europe/Paris'});
        }

        setInterval(showTime, 1000);
    }
    $(document).on('click', '.media-btn', function(e){
        $('.media-btn').removeClass('active');
        $(this).addClass('active');
        var type = $(this).data('type');
        var id = $(this).data('id');

        $.ajax({
            url:"/dashboard/chat/data",
            method:"POST",
            data: {id: id, type: type},
            success:function(res){
                $(".chat-content").html(res.view);
            }
            ,error: function(err) {console.log(err)}
        });
    });

    $(document).on('click', '.video-btn', function(e){
        $.ajax({
            url: "/dashboard/notify/video",
            type: "POST",
            data: {senderId: $(this).data('user'), receiverId: $(this).data('receiver'), jobId: $(this).data('id')},
            error: function(err) {console.log(err)}
        });
    });

    $(document).on('submit', '#message_form', function(e) {
        $.ajax({
            type: 'POST',
            url: '/dashboard/notify/send',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false
        });
    });

    $(document).on('click', '.more-btn', function() {
        if (!display) {
            var id = $(this).data('id');

            $('.chat-block').css('margin-right', '330px');
            $('.sidebar').css('display', 'block');

            $.ajax({
                url: '/dashboard/appointment/profile',
                type: 'get',
                dataType: 'json',
                data: {
                    id: id,
                    action: 'chat'
                },
                success:function(res) {
                    $('.profile').html(res.view);
                    if (res.user.latitute && res.user.longitute) {
                        var latlng = {lat: res.user.latitute, lng: res.user.longitute};
                    } else {
                        var latlng = {lat: 48.8777787, lng: 2.365058};
                    }
                    var latlng = {lat: 48.8777787, lng: 2.365058};

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 4,
                        center: latlng
                    });

                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: 'Hello World!'
                    });
                },
                error: function(err) {
                    $('.sidebar').html(errorView);
                }
            });
            display = true;
        } else {
            $('.chat-block').css('margin-right', '0');
            $('.sidebar').css('display', 'none');
            display = false;
        }
    });
});
</script>

<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-performance.js"></script>
<script src="{{url('firebase/init.js?version='.time())}}"></script>
@endsection