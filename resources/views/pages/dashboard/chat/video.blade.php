@extends('layouts.theme')

@section('style')
<style>
    div#media-div {

        display: flex;

    }

    .end-video-call{

        background: #f70835;

        color: #fff;

        padding: 5px 20px;

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
                       role="tab" aria-controls="pills-home" aria-selected="true">Chats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                       role="tab" aria-controls="pills-profile" aria-selected="false">Calls</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                       role="tab" aria-controls="pills-contact" aria-selected="false">Contacts</a>
                </li>
            </ul>
        </div>

        <div class="chat-sidebar-content">
            <div class="tab-content pt-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                     aria-labelledby="pills-home-tab">
                    <div class="chat-lists">
                        <div class="list-group list-group-flush">
                            @foreach ($appointments as $key => $item)

                                @if (auth()->user()->user_type == '2')
                                
                                <a href="#" class="list-group-item d-flex align-items-center media-btn {{$key == 0 ? 'active' : ''}}" data-id="{{$item->appointment->id}}">
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
                                        @php
                                            $count = appChats()->where('senderId', $item->appointment->user->id)->count();
                                            if ($count) echo '<span class="badge badge-success badge-pill ml-auto mb-2">'.$count.'</span>'
                                        @endphp
                                        <span class="small text-muted">{{date('H:i',strtotime($item->applied_time))}}</span>
                                    </div>
                                </a>

                                @else

                                    <a href="#" class="list-group-item d-flex align-items-center media-btn {{$key == 0 ? 'active' : ''}}" data-id="{{$item->id}}">
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
                                            @php
                                                $count = appChats()->where('senderId', $item->user->id)->count();
                                                if ($count) echo '<span class="badge badge-success badge-pill ml-auto mb-2">'.$count.'</span>'
                                            @endphp
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
                        <a href="#" class="list-group-item d-flex align-items-center">
                            <div class="pr-3">
                                <div class="avatar avatar-state-warning">
                                    <img src="{{asset('theme/media/image/user/women_avatar2.jpg')}}"
                                         class="rounded-circle"
                                         alt="image">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Orelie Rockhall</h6>
                                <div class="text-muted d-flex align-items-center">
                                    <i class="ti-arrow-down mr-1 text-danger"></i>
                                    Today, 03:11 AM
                                </div>
                            </div>
                            <div class="text-right ml-auto">
                                <i class="fa fa-video-camera text-danger"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                     aria-labelledby="pills-contact-tab">
                    <p>142 Contacts</p>
                    <div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="pr-3">
                                    <div class="avatar avatar-state-danger">
                                        <span class="avatar-title bg-secondary rounded-circle">A</span>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">Alene Ranyelld</h6>
                                    <div class="text-muted">United Kingdom</div>
                                </div>
                                <div class="text-right ml-auto">
                                    <a href="#" class="p-1">
                                        <i class="fa fa-phone"></i>
                                    </a>
                                    <a href="#" class="p-1">
                                        <i class="fa fa-comment-o"></i>
                                    </a>
                                    <a href="#" class="p-1">
                                        <i class="fa fa-video-camera"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-8 chat-content">
        <!-- begin::chat header -->
        <div class="chat-header border-bottom">
            <div class="d-flex align-items-center">
                <div class="pr-3">
                    <div class="avatar avatar-state-success">
                    {{-- <div class="avatar {{$appointment->user->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
                        <img src="{{$appointment->user->image()}}" class="rounded-circle" alt="image">
                    </div>
                </div>
                <div>
                    <p class="mb-0">{{$appointment->user->name}}</p>
                    <div class="m-0 small text-success">{{$appointment->category->name}}</div>
                </div>
                <div class="ml-auto">
                    <ul class="nav align-items-center">
                        <li class="mr-4 d-sm-inline d-none">
                            <a href="{{url('dashboard/video/call/'.$appointment->id)}}" title="Start Video Call" data-toggle="tooltip">
                                <i class="fa fa-video-camera"></i>
                            </a>
                        </li>
                        <li class="mr-4 d-sm-inline d-none">
                            <a href="#" title="Start Voice Call"  data-toggle="modal" data-target="#voice_call">
                                <i class="fa fa-phone"></i>
                            </a>
                        </li>
                        <li class="d-sm-inline d-none dropdown">
                            <a href="#" title="More options" data-toggle="dropdown">
                                <i class="ti-more-alt"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Add contact</a>
                                <a href="#" class="dropdown-item text-danger">Delete</a>
                            </div>
                        </li>
                        <li class="ml-4 mobile-chat-close-btn">
                            <a href="#" class="btn text-danger">
                                <i class="ti-close"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end::chat header -->

        <div class="messages">

            <div id="media-div"></div>

        </div>

        <div class="chat-footer text-center" style="display:none;">

            <a href="{{url('dashboard/chat/page')}}" class="end-video-call">End</a>

        </div>
        
    </div>

</div>
    
@endsection

@section('script')
<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<script>

    Twilio.Video.createLocalTracks({

       audio: true,

       video: { }

    }).then(function(localTracks) {

       return Twilio.Video.connect('{{ $accessToken }}', {

           name: '{{ $roomName }}',

           tracks: localTracks,

           video: {  }

       });

    }).then(function(room) {

       console.log('Successfully joined a Room: ', room.name);

       room.participants.forEach(participantConnected);

       var previewContainer = document.getElementById(room.localParticipant.sid);

       if (!previewContainer || !previewContainer.querySelector('video')) {

           participantConnected(room.localParticipant);

       }

       room.on('participantConnected', function(participant) {

           participantConnected(participant);

       });

       room.on('participantDisconnected', function(participant) {

           participantDisconnected(participant);

       });

    });

    function participantConnected(participant) {

       const div = document.createElement('div');

       div.id = participant.sid;

       div.setAttribute("style", "float: left; margin: 10px;");

       //div.innerHTML = "<div style='clear:both'>" + participant.identity + "</div>";

    

       participant.tracks.forEach(function(track) {

           trackAdded(div, track)

       });

    

       participant.on('trackAdded', function(track) {

           trackAdded(div, track)

       });

       participant.on('trackRemoved', trackRemoved);

    

       document.getElementById('media-div').appendChild(div);

        $('.chat-footer').show();

        }

    

    function participantDisconnected(participant) {

       participant.tracks.forEach(trackRemoved);

       document.getElementById(participant.sid).remove();

    }

    

    function trackAdded(div, track) {

       div.appendChild(track.attach());

       var video = div.getElementsByTagName("video")[0];

       if (video) {

           video.setAttribute("style", "max-width:300px;");

       }

    }

    

    function trackRemoved(track) {

       track.detach().forEach( function(element) { element.remove() });

    }

    // additional functions will be added after this point

</script>

@endsection