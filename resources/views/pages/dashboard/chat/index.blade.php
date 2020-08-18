@extends('layouts.theme')

@section('page')
<div class="container">
    <div class="mb-3">
    	<h2 class="h5 mb-0">Trouver un Patient</h2>
    </div>
    <div class="card-deck d-block d-md-flex u-columns col2-set">
    	<div class="card mb-4 mb-md-0 p-5">
    		<header class="row justify-content-between align-items-end title">
                <div class="col-12">
                    <h2 class="h5 mb-0">Prochaines consultations</h2>
                </div>
            </header>
            <hr class="mt-2 mb-4">
    		<div class="mb-5">
                <h6>Vos rendez-vous pour le <b>Samedi <span class="selected-date">{{date('d F Y',strtotime($date))}}</span></b></h6>
            </div>
            <div class="appointment-row-data">
                @foreach($confirms as $k=>$app)
                <div class="form-group row" data-id="{{$app->id}}">
                    <div class="col-md-2"><img src="{{($app->appointment->user->profile_img) ? $app->appointment->user->profile_img : url('images/user_logo.png')}}" class="user-profile"></div>
                    <div class="col-md-4">
                        {{$app->appointment->user->name}}<br>
                        <b>{{$app->appointment->category->name}}</b>
                    </div>
                    <div class="col-md-3"><span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span><span class="start-time">{{date('H:i',strtotime($app->applied_time))}}</div>
                    <div class="col-md-3">
                        <div class="d-flex call-action">
                            <a class="btn btn-primary" href="{{url('chat/'.$app->appointment->id)}}" data-id="{{$app->appointment->id}}"><i class="fas fa-comment-dots"></i></a><a class="btn btn-primary" href="javascript:void(0)"><i class="fa fa-phone" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
    	</div>
    	<div class="card mb-4 mb-md-0 p-5">
    	    <div class="form-group row">
    	        <div class="col-md-1"><a href="{{url('confirm-appointment')}}"><i class="fas fa-arrow-left"></i></a></div>
                <div class="col-md-2"><img src="{{$imageUrl}}" class="chat-user-profile"></div>
                <div class="col-md-4">
                    {{$chatUserName}}<br>
                    <b>{{$appointment->category->name}}</b>
                </div>
                <div class="col-md-5 text-right chat-icon">
                    <a href="javascript:void(0)" class="mr-3"><i class="fa fa-phone" aria-hidden="true"></i></a>
                    <a href="javascript:void(0)" class="mr-3"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                </div>
            </div>
            <hr class="mt-2 mb-4">
		        <div class="row">
                <div class="col-md-12">
                    <div>
                    	<div hidden id="sign-out" class=""></div>
                    	<div hidden id="sign-in" class=""></div>
                    </div>
                    <main class="">
                        <input type="hidden" id="user-name" name="userName" value="{{$userName}}">
                        <input type="hidden" id="user-pic" name="userPic" value="{{$userImage}}">
                        <input type="hidden" id="node-id" name="NodeId" value="{{$chatId}}">
                        <input type="hidden" id="login-id" name="loginUserId" value="{{$userId}}">
                        <input type="hidden" id="profile-pic" name="profilePic" value="{{$imageUrl}}">
                        <input type="hidden" id="chat-user-name" name="chatUserName" value="{{$chatUserName}}">
                        <!-- call -->
                        <div id="messages-card-container">
                            <!-- Messages container -->
                            <div id="messages-card">
                              <div id="messages"></div>
                                <form id="message-form" action="#">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="message" autocomplete="off">
                                        <label class="mdl-textfield__label" for="message">Enter your message...</label>
                                    </div>

                                </form>
                                <form id="image-form" action="#">
                                    <input id="mediaCapture" type="file" capture="camera">
                                    <button id="submitImage" title="Add an image" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--amber-400 mdl-color-text--white">
                                      <i class="fa fa-paperclip"></i>
                                    </button>
                                </form>
                            </div>
                            <div id="must-signin-snackbar" class="mdl-js-snackbar mdl-snackbar">
                                <div class="mdl-snackbar__text"></div>
                                <button class="mdl-snackbar__action" type="button"></button>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
    	</div>
	</div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="{{url('firebase/main.css?version='.time())}}">
<link rel="stylesheet" href="{{url('firebase/chat.css?version='.time())}}">
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-performance.js"></script>
<script src="{{url('firebase/init.js?version='.time())}}"></script>
<script src="{{url('firebase/main.js?version='.time())}}"></script>
@endsection
