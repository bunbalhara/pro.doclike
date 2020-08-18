
<!-- begin::chat header -->
<div class="chat-header border-bottom">
    <div class="d-flex align-items-center">
        <div class="pr-3">
        @php
            if ($type == 'job') {
                if (auth()->user()->user_type == 2) {
                    $user = $appointment->user;
                    $jobId = $appointment->id;
                } else {
                    $user = $appointment->acceptPurposal->doctor;
                    $jobId = $appointment->acceptPurposal->appointment_id;
                }
            } else {
                $jobId = 0;
            }
        @endphp

        @if ($type == 'job')
            @if (auth()->user()->user_type == '2')

            {{-- <div class="avatar {{$appointment->user->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
            <div class="avatar avatar-state-success">
                <img src="{{$appointment->user->image()}}" class="rounded-circle" alt="image">
            </div>

            @else

            {{-- <div class="avatar {{$appointment->acceptPurposal->doctor->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
            <div class="avatar avatar-state-success">
                <img src="{{$appointment->acceptPurposal->doctor->image()}}" class="rounded-circle" alt="image">
            </div>

            @endif
        @else
            {{-- <div class="avatar {{$user->status == 1 ? 'avatar-state-success' : 'avatar-state-danger'}}"> --}}
            <div class="avatar avatar-state-success">
                <img src="{{$userImage}}" class="rounded-circle" alt="image">
            </div>
        @endif
        </div>
        <div>
        @if ($type == 'job')

            @if (auth()->user()->user_type == '2')

            <p class="mb-0">{{$appointment->user->name}}</p>
            <div class="m-0 small text-success">{{$appointment->category->name}}</div>

            @else

            <p class="mb-0">{{$appointment->acceptPurposal->doctor->name}}</p>
            <div class="m-0 small text-success">{{$appointment->category->name}}</div>

            @endif
        @else
            <p class="mb-0">{{$user->name}}</p>
            <div class="m-0 small text-success">Friend</div>
        @endif
        </div>
        <div class="ml-auto">
            <ul class="nav align-items-center">
                <li class="mr-4 d-sm-inline d-none">
                @if ($type == 'job')
                    <a href="{{url('dashboard/video/call/'.$chatId)}}" class="video-btn" data-user="{{auth()->user()->id}}" data-id="{{$appointment->id}}" data-receiver="{{auth()->user()->user_type == 2 ? $appointment->user->id : $appointment->acceptPurposal->doctor->id}}" title="Start Video Call" data-toggle="tooltip">
                        <i class="fa fa-video-camera"></i>
                    </a>
                @else
                    <a href="{{url('dashboard/video/call/'.$chatId)}}" class="video-btn" data-user="{{auth()->user()->id}}" data-id="0" data-receiver="{{$user->id}}" title="Start Video Call" data-toggle="tooltip">
                        <i class="fa fa-video-camera"></i>
                    </a>
                @endif
                </li>
                <li class="mr-4 d-sm-inline d-none">
                    <a href="#" title="Start Voice Call"  data-toggle="modal" data-target="#voice_call">
                        <i class="fa fa-phone"></i>
                    </a>
                </li>
                <li class="d-sm-inline d-none more-btn" data-id="{{$user->id}}">
                    <a href="#" title="More options">
                        <i class="ti-more-alt"></i>
                    </a>
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

<!-- begin::messages -->
<div class="messages" id="message_card"></div>
<!-- end::messages -->

<!-- begin::chat footer -->
<div class="chat-footer border-top">
    <form id="message_form">
        <input type="hidden" name="senderId" value="{{auth()->user()->id}}">
        <input type="hidden" name="recieverId" value="{{$user->id}}">
        <input type="hidden" name="type" value="chat">
        <input type="hidden" name="jobId" value="{{$jobId}}">
        <div class="form-group">
            <div class="chat-footer-buttons">
                <button class="btn btn-outline-light mr-2" type="button" title="Emoji"
                        data-toggle="tooltip">
                    <i class="ti-face-smile"></i>
                </button>
            </div>
            <input id="message" name="message" type="text" class="form-control" placeholder="Write message...">
            <div class="chat-footer-buttons">
                <button class="btn btn-outline-light" type="button" title="Attach files"
                        data-toggle="tooltip">
                    <i class="ti-link"></i>
                </button>
                <button class="btn btn-primary" type="submit">
                    <i class="ti-location-arrow"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<!-- end::chat footer -->



<input type="hidden" id="user-name" name="userName" value="{{$userName}}">
<input type="hidden" id="user-pic" name="userPic" value="{{$userImage}}">
<input type="hidden" id="node-id" name="NodeId" value="{{$chatId}}">
<input type="hidden" id="login-id" name="loginUserId" value="{{$userId}}">
<input type="hidden" id="profile-pic" name="profilePic" value="{{$imageUrl}}">
<input type="hidden" id="chat-user-name" name="chatUserName" value="{{$chatUserName}}">

<script src="{{url('firebase/chat_v1.js?version='.time())}}"></script>