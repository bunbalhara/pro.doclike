@extends('layouts.theme')

@section('style')
    <style>
        .form-control {
            border-radius: .2rem !important
        }
        .inputfile {
            position: absolute;
            width: .1px;
            height: .1px;
            z-index: -1;
        }
    </style>
@endsection

@section('page')
<div class="page-header">
    <div>
        <h3>Settings</h3>
        <nav aria-label="breadcrumb" class="d-flex align-items-start">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href=index.html>Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Profile</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-item nav-link active" id="v-pills-home-tab" data-toggle="pill"
                       href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Your
                        Profile</a>
                    <a class="nav-item nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                       role="tab" aria-controls="v-pills-profile" aria-selected="false">Password</a>
                    <a class="nav-item nav-link" id="v-pills-messages-tab" data-toggle="pill"
                       href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Email
                        Notifications</a>
                    <a class="nav-item nav-link" id="v-pills-settings-tab" data-toggle="pill"
                       href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Integrations</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="card">
                            <div class="card-body">
                                <form id="profile1">
                                    <input type="hidden" name="type" value="1">
                                    <h6 class="card-title">Your Profile</h6>
                                    <div class="d-flex mb-3">
                                        <figure class="mr-3">
                                            <img width="100" height="100" class="rounded-pill" src="{{auth()->user()->image()}}" id="profile_upload">
                                            <input type="file" name="profile_img" accept="image/*" class="inputfile" id="profile_img">
                                        </figure>
                                        <div>
                                            <p id="userName">{{auth()->user()->name}}</p>
                                            <label for="profile_img" class="btn btn-outline-light mr-2">Change Avatar</label>
                                            <p class="small text-muted mt-3">For best results, use an image at least 256px by 256px in either .jpg or .png format</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" name="first_name" class="form-control" value="{{auth()->user()->first_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="{{auth()->user()->last_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" value="{{auth()->user()->email}}">
                                            </div>

                                            @if (auth()->user()->user_type == 2)

                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" class="form-control">
                                                    @foreach ($categories as $category)
                                                    <option value="{{$category->id}}" {{auth()->user()->category == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form id="profile2" action="{{url('dashboard/profile/update2')}}" method="POST">
                                    @csrf
                                    <h6 class="card-title">Contact</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{auth()->user()->phone}}">
                                            </div>
                                            <div class="form-group">
                                                <p>Gender</p>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="genderRadio1" name="genderRadio" value="1"
                                                           class="custom-control-input" {{auth()->user()->gender == '1' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="genderRadio1">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="genderRadio2" name="genderRadio" value="2"
                                                           class="custom-control-input" {{auth()->user()->gender == '2' ? 'checked' : ''}}>
                                                    <label class="custom-control-label"
                                                           for="genderRadio2">Female</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="genderRadio3" name="genderRadio" value="3"
                                                           class="custom-control-input" {{auth()->user()->gender == '3' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="genderRadio3">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input id="address" type="text" class="form-control" name ="address" value="{{auth()->user()->address}}">
                                                <input type="hidden" name="lat">
                                                <input type="hidden" name="lng">
                                                <input type="hidden" name="city">
                                            </div>
                                            <div class="form-group">
                                                <label>BirthDay</label>
                                                <input type="text" name="dob" class="form-control" value="{{auth()->user()->dob}}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                         aria-labelledby="v-pills-profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Password</h6>
                                <form id="password-part">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" name="oldPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="newPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>New Password Repeat</label>
                                                <input type="password" name="newConfirmPassword" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                         aria-labelledby="v-pills-messages-tab">
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <h5 class="mb-3">Activity Notifications</h5>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked
                                                   id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">Someone assigns
                                                me
                                                to a task</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked
                                                   id="customSwitch2">
                                            <label class="custom-control-label" for="customSwitch2">Someone mentions
                                                me
                                                in a conversation</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked
                                                   id="customSwitch3">
                                            <label class="custom-control-label" for="customSwitch3">Someone adds me
                                                to a
                                                project</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch41">
                                            <label class="custom-control-label" for="customSwitch41">Activity on a
                                                project I am a member of</label>
                                        </div>
                                    </div>
                                    <h5 class="mb-3 mt-5">Service Notifications</h5>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch51">
                                            <label class="custom-control-label" for="customSwitch51">Monthly
                                                newsletter</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" checked
                                                   id="customSwitch6">
                                            <label class="custom-control-label" for="customSwitch6">Major feature
                                                enhancements</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch7">
                                            <label class="custom-control-label" for="customSwitch7">Minor updates
                                                and
                                                bug fixes</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                         aria-labelledby="v-pills-settings-tab">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <figure class="mb-0 mr-3">
                                        <img
                                            src="https://pipeline.mediumra.re/assets/img/logo-integration-slack.svg"
                                            alt="...">
                                    </figure>
                                    <div>
                                        <h6 class="card-title mb-1">Slack</h6>
                                        <div class="text-muted">Permissions: Read, Write, Comment</div>
                                    </div>
                                </div>
                                <button class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <figure class="mb-0 mr-3">
                                        <img
                                            src="https://pipeline.mediumra.re/assets/img/logo-integration-drive.svg"
                                            alt="...">
                                    </figure>
                                    <div>
                                        <h6 class="card-title mb-1">Google Drive</h6>
                                        <div class="text-muted">Permissions: Read, Write</div>
                                    </div>
                                </div>
                                <button class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <figure class="mb-0 mr-3">
                                        <img
                                            src="https://pipeline.mediumra.re/assets/img/logo-integration-dropbox.svg"
                                            alt="...">
                                    </figure>
                                    <div>
                                        <h6 class="card-title mb-1">Dropbox</h6>
                                        <div class="text-muted">Permissions: Read, Write, Upload</div>
                                    </div>
                                </div>
                                <button class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{config('enums.GoogleMapKey')}}&components=country:'FR'"></script>
<script>
    var input  = document.getElementById('address');
    var options = {
        componentRestrictions: {country: 'FR'}
    };
    var autocomplete  = new google.maps.places.Autocomplete(input, options);

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();

        $('input[name="lat"]').val(place.geometry.location.lat());
        $('input[name="lng"]').val(place.geometry.location.lng());
        $('input[name="city"]').val(place.address_components[1].long_name);
    });
</script>
<script>
    $(document).on('change', '#profile_img', function(e) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile_upload');
            output.src = reader.result;
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(':checkbox.custom-control-input').click(function() {
        this.checked && $(this).siblings('input[name="' + this.name + '"]:checked.' + this.className).prop('checked', false);
    });

    $(document).on('submit', '#profile1', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update1',
            type: 'post',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                if (res.errors) {
                    toastr.error('Please fill out correct data');
                } else {
                    $('#userName').html(res.name);
                    toastr.success('Successfully Changed');
                }
            }
        });
    });

    $(document).on('submit', '#profile2', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update2',
            type: 'post',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                if (res.errors) {
                    toastr.error('Please fill out correct data');
                } else {
                    $('#userName').html(res.name);
                    toastr.success('Successfully Changed');
                }
            }
        });
    });

    $(document).on('submit', '#password-part', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update4',
            type: 'post',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                if (res.errors) {
                    toastr.error('Please fill out correct data');
                } else {
                    toastr.success('Successfully Changed');
                }
            }
        });
    });

    $('input[name="dob"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
</script>
@endsection
