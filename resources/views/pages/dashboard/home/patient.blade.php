@extends('layouts.theme')

@section('style')
<style>
    .text-white-bright {
        color: rgba(255, 255, 255, .6)
    }
    .tab-content > .tab-pane:not(.active), 
    .pill-content > .pill-pane:not(.active) {
        display: block;
        height: 0;
        overflow-y: hidden;
    }
    .job-card {
        z-index: 2;
        right: 30px;
        background: rgba(0, 0, 0, .4);
        top: 70px;
        width: 273px;
    }
    .select2-selection.select2-selection--single, .select2-selection__rendered {
        height: calc(1.5em + .75rem + 3px);
    }
    .watch-video .video a:after {
        position: absolute;
        content: '';
        width: 0;
        height: 0;
        border-top: 17px solid transparent;
        border-left: 25px solid #fff;
        border-bottom: 17px solid transparent;
        left: 55%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }

    @keyframes ripple_shadow {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2), 0 0 0 20px rgba(255, 255, 255, 0.2), 0 0 0 40px rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2), 0 0 0 20px rgba(255, 255, 255, 0.2), 0 0 0 40px rgba(255, 255, 255, 0.2);
        }

        100% {
            -webkit-box-shadow: 0 0 0 20px rgba(255, 255, 255, 0.2), 0 0 0 40px rgba(255, 255, 255, 0.2), 0 0 0 60px rgba(255, 255, 255, 0);
            box-shadow: 0 0 0 20px rgba(255, 255, 255, 0.2), 0 0 0 40px rgba(255, 255, 255, 0.2), 0 0 0 60px rgba(255, 255, 255, 0);
        }
    }
    .card.job-part{
        background-color: transparent !important;
    }
    .slick-next {
        right: -10px;
    }
    .slick-prev {
        left: -10px;
    }
    .gm-style-mtc, .gm-style-mtc {
        margin-top: 10px
    }
    .gm-control-active.gm-fullscreen-control {
        margin-top: 20px!important
    }
    .fa:hover {
        cursor: pointer;
    }
    .irs .irs-bar {
        border: 1px solid rgba(255, 255, 255, .4);
    }
    .irs--round .irs-min, .irs--round .irs-max {
        color: white
    }
    .slick-post-part .form-control {
        background: transparent;
        font-weight: 500;
        color: white
    }
    .slick-post-part .form-control::placeholder {
        color: white
    }
</style>
@endsection

@section('page')
    <section class="patient_dashboard">
        <div class="row">
            <div class="col-xl-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{auth()->user()->image()}}" alt="" class="rounded-circle" width="120">

                            <h5 class="mt-2">{{auth()->user()->name}}</h5>

                            @if (cityName(auth()->user()->address))
                            <div class="d-inline-flex text-muted">
                                <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>
                                {{cityName(auth()->user()->address)}}
                            </div>
                            @endif

                            <div class="bg-info-bright p-4 border-rounded">
                                <div class="row text-primary">
                                    <div class="col-sm-4">
                                        <small>Diagnoses</small>
                                        <h6>Multiple</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Weight</small>
                                        <h6>170 cm</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Height</small>
                                        <h6>65 kg</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-primary btn-rounded btn-sm" aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button">Action</button>
                                    <button class="dropdown-item" type="button">Another action</button>
                                    <button class="dropdown-item" type="button">Something else here
                                    </button>
                                </div>
                            </div>

                            <h4 class="my-auto">Confirmed Appointments</h4>
                            <p class="text-white-bright">You have {{$proposalData->count()}} proposals today</p>

                            <ul class="list-group list-group-flush text-white mt-4 p-0">
                                @foreach ($proposalData as $proposal)
                                <li class="list-group-item bg-primary d-flex justify-content-between align-items-center">
                                    <div>
                                        {{$proposal->doctor->name}}
                                        <span class="text-white-bright"> | {{$proposal->appointment->category->name}}</span>
                                    </div>
                                    <h5 class="my-auto">{{date('H:i', strtotime($proposal->applied_time))}}</h5>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-primary btn-rounded btn-sm" aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-settings"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" type="button">Action</button>
                                    <button class="dropdown-item" type="button">Another action</button>
                                    <button class="dropdown-item" type="button">Something else here</button>
                                </div>
                            </div>

                            <h4 class="my-auto">Pending Appointments</h4>
                            <p class="text-white-bright">There are {{$pendingData->count()}} pending proposals today</p>

                            <ul class="list-group list-group-flush text-white mt-4 p-0">
                                @foreach ($pendingData as $app)
                                <li class="list-group-item bg-primary d-flex justify-content-between align-items-center">
                                    <div>
                                        {{$app->doctor->name}}
                                        <span class="text-white-bright"> | {{$app->appointment->category->name}}</span>
                                    </div>
                                    <h5 class="my-auto">{{date('H:i', strtotime($app->applied_time))}}</h5>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="col-md-12">
                    <div class="card job-part">
                        <form id="job_form">
                            {{ Form::hidden('latitute', '', ['class' => 'uk-input','id' => 'latitute']) }}
                            {{ Form::hidden('longitute', '', ['class' => 'uk-input','id' => 'longitute']) }}
                            {{ Form::hidden('city', '', ['class' => 'uk-input','id' => 'city']) }}
                            {{ Form::hidden('state', '', ['class' => 'uk-input','id' => 'state']) }}
                            {{ Form::hidden('category', '') }}
                            {{ Form::hidden('subcategory', '') }}
                            {{ Form::hidden('shiftDate[]', '') }}
                            {{ Form::hidden('address', '') }}
                            <div class="post-header text-white position-relative bg-primary p-4 border-rounded" style="z-index: 9">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <h6>Hello</h6>
                                        <h5>{{auth()->user()->name}}</h5>
                                    </div>
                                <button type="submit" class="btn btn-primary" style="border: 1px solid white;display: {{$currentApp ? 'block' : 'none'}}" id="submit" {{$currentApp ? 'disabled' : ''}}>
                                        <i class="ti-check-box mr-2"></i>Submit
                                    </button>
                                </div>

                                <div class="slick-post-part">
                                    <div class="">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="my-3 text-center mx-auto">Choose your medical field?</h5>
                                            
                                            @if ($currentApp)
                                            <i class="fa fa-angle-right font-large" aria-hidden="true"></i>
                                            @endif
                                        </div>
                                        <div class="slick-category-part text-center">
                                            @if ($currentApp)
                                                {{$currentApp->category->name}}
                                            @else
                                                @foreach ($categories as $category)
                                                    @if ($category->doctor()->count())
                                                    <button type="button" class="cat-btn btn btn-primary btn-rounded" data-id="{{$category->id}}" style="border: 1px solid white">
                                                        {{substr($category->name, 0, 10)}}
                                                    </button>                                                
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <i class="fa fa-angle-left font-large" aria-hidden="true"></i>
                                            <h5 class="my-3 text-center mx-auto">Let me know in details</h5>

                                            @if ($currentApp)
                                            <i class="fa fa-angle-right font-large" aria-hidden="true"></i>
                                            @endif
                                        </div>
                                        <div class="subcategory_view text-center">
                                            @if ($currentApp)
                                                {{$currentApp->sub_category->name}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <i class="fa fa-angle-left font-large" aria-hidden="true"></i>
                                            <h5 class="my-3 text-center mx-auto">Choose the date and time</h5>
                                            <i class="fa fa-angle-right font-large time-part" aria-hidden="true" style="display: {{$currentApp ? 'block' : 'none'}}"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" class="form-control" id="date"
                                                value="{{$currentApp ? date('m/d/Y', strtotime($currentApp->appointmentShift->date)) : ''}}"
                                                {{$currentApp ? 'disabled' : ''}}
                                                >
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="startTime[]" class="form-control"
                                                value="{{$currentApp ? date('H:i', strtotime($currentApp->appointmentShift->start_time)) : ''}}"
                                                {{$currentApp ? 'disabled' : ''}}
                                                >
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="endTime[]" class="form-control"
                                                value="{{$currentApp ? date('H:i', strtotime($currentApp->appointmentShift->end_time)) : ''}}"
                                                {{$currentApp ? 'disabled' : ''}}
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <i class="fa fa-angle-left font-large mr-auto" aria-hidden="true"></i>
                        
                                            <i class="fa fa-angle-right font-large address-part ml-auto" aria-hidden="true" style="display: {{$currentApp ? 'block' : 'none'}}"></i>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <h5 class="mx-auto">Insert your address</h5>
                                            <input id="area" class="form-control mx-auto w-50"
                                            value="{{$currentApp ? $currentApp->address : ''}}"
                                            {{$currentApp ? 'disabled' : ''}}
                                            >
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <i class="fa fa-angle-left font-large" aria-hidden="true"></i>
                                            <h5 class="text-center mt-4 mx-auto">Distance</h5>
                                        </div>

                                        <input type="text" name="distance" class="form-control w-100"
                                        value="{{$currentApp ? $currentApp->visibility : ''}}"
                                        {{$currentApp ? 'disabled' : ''}}
                                        >
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="map" style="height: 500px; margin-top: -12px"></div>
                    </div>
                </div>

                <div class="col-md-12" style="height: 470px">
                    <div class="card">
                        <div class="card-body">
                            <h4>Appointments</h4>
                            <div class="">
                                <ul class="nav nav-pills mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-confirm-tab" data-toggle="pill" href="#pills-confirm"
                                        role="tab" aria-controls="pills-confirm" aria-selected="true">Confirmed</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-pending-tab" data-toggle="pill" href="#pills-pending"
                                        role="tab" aria-controls="pills-pending" aria-selected="false">Pending</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <button type="button" class="btn btn-outline-primary btn-floating mx-2 prev-btn">
                                        <i class="fa fa-angle-left"></i>
                                    </button>
    
                                    <button type="button" class="btn btn-outline-primary btn-floating mx-2 next-btn">
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
    
                                <input type="text" name="daterangepicker" class="form-control date-picker">
                            </div>
    
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pills-confirm" role="tabpanel" aria-labelledby="pills-confirm-tab"> 
                                    
                                    @if ($proposalData->count())
                                    <div class="slick-confirm-part">
                                        @foreach ($proposalData as $app)
                                        <div class="media shadow-sm border-radius-1 p-4 m-2">
                                            <div class="media-body">
                                                <div class="d-flex">
                                                    <figure class="avatar avatar-xl mr-2">
                                                        <img src="{{$app->doctor->image()}}" class="rounded-circle mr-2" alt="avatar">
                                                    </figure>
                                                    <div class="my-auto">
                                                        <h4>{{$app->doctor->name}}</h4>
                                                        <p class="text-muted">{{$app->appointment->category->name}}</p>
                                                    </div>
                                                </div>
        
                                                @if ($app->doctor->address)
                                                <div class="d-flex mt-5 h6">
                                                    <i class="fa fa-map-marker mr-2 text-primary" aria-hidden="true"></i>
                                                    <div class="my-auto">{{$app->doctor->address}}</div>
                                                </div>
                                                @endif
        
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="">
                                                        <i class="fa fa-calendar-check-o mr-2 text-primary" aria-hidden="true"></i>
                                                        {{$app->applied_date}}
                                                    </div>
        
                                                    <div class="">
                                                        <i class="fa fa-clock-o mr-2 text-primary" aria-hidden="true"></i>
                                                        {{date('H:i', strtotime($app->applied_time))}}
                                                    </div>
                                                </div>
        
                                                <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <button type="button" class="btn btn-outline-success btn-rounded btn-uppercase">
                                                        <i class="fa fa-comments-o mr-2"></i> Chat
                                                    </button>
        
                                                    <button type="button" class="btn btn-outline-info btn-rounded btn-uppercase">
                                                        <i class="fa fa-video-camera mr-2"></i> Call
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="alert alert-info alert-with-border mt-2" role="alert">No appointments found!</div>
                                    @endif

                                </div>
                                <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab"> 
                                    @if ($pendingData->count())
                                    <div class="slick-pending-part">
                                        @foreach ($pendingData as $app)
                                        <div class="media shadow-sm border-radius-1 p-4 m-2">
                                            <div class="media-body">
                                                <div class="d-flex">
                                                    <figure class="avatar avatar-xl mr-2">
                                                        <img src="{{$app->doctor->image()}}" class="rounded-circle mr-2" alt="avatar">
                                                    </figure>
                                                    <div class="my-auto">
                                                        <h4>{{$app->doctor->name}}</h4>
                                                        <p class="text-muted">{{$app->appointment->category->name}}</p>
                                                        {{$app->id}}
                                                    </div>
                                                </div>
        
                                                @if ($app->doctor->address)
                                                <div class="d-flex mt-5 h6">
                                                    <i class="fa fa-map-marker mr-2 text-primary" aria-hidden="true"></i>
                                                    <div class="my-auto">{{$app->doctor->address}}</div>
                                                </div>
                                                @endif
        
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <div class="">
                                                        <i class="fa fa-calendar-check-o mr-2 text-primary" aria-hidden="true"></i>
                                                        {{$app->applied_date}}
                                                    </div>
        
                                                    <div class="">
                                                        <i class="fa fa-clock-o mr-2 text-primary" aria-hidden="true"></i>
                                                        {{date('H:i', strtotime($app->applied_time))}}
                                                    </div>
                                                </div>
        
                                                <div class="d-flex justify-content-between align-items-center mt-5">
                                                    <button type="button" class="btn btn-outline-success btn-rounded btn-uppercase app-btn" data-type="confirm_appointment" data-appointment="{{$app->appointment->id}}" data-id="{{$app->id}}">
                                                        <i class="ti-check-box"></i><span class="d-sm-block d-none ml-2"> Confirm</span>
                                                    </button>
        
                                                    <button type="button" class="btn btn-outline-danger btn-rounded btn-uppercase app-btn" data-type="cancel" data-id="{{$app->id}}">
                                                        <i class="ti-trash"></i><span class="d-sm-block d-none ml-2"> Cancel</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                    @else
                                    <div class="alert alert-info alert-with-border mt-2" role="alert">No appointments found!</div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{config('enums.GoogleMapKey')}}&components=country:'FR'"></script>

<script>
    var action = 'confirm';
    var picker = moment(new Date()).format('YYYY-MM-DD');
    var submit = false;

    $('input[name="daterangepicker"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate: new Date()
    }).on('change', function(e){
        picker = moment($('input[name="daterangepicker"]').val()).format('YYYY-MM-DD');
        getView(picker, action);
    });

    $('.slick-confirm-part').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1140,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
        ]
    });

    $('.slick-pending-part').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1140,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
        ]
    });

    $(document).on('click', '.prev-btn', function(e){
        $('.slick-pending-part').slick('slickPrev');
        $('.slick-confirm-part').slick('slickPrev');
    });

    $(document).on('click', '.next-btn', function(e){
        $('.slick-pending-part').slick('slickNext');
        $('.slick-confirm-part').slick('slickNext');
    });

    $(document).on('click', '#pills-confirm-tab', function(e){
        action = 'confirm';
        getView(picker, action);
    });

    $(document).on('click', '#pills-pending-tab', function(e){
        action = 'pending';
        getView(picker, action);
    });
    
    $(document).on('click', '.app-btn', function(e){
        var id = $(this).data('id');
        var action = $(this).data('type');
        var appointment = $(this).data('appointment');
        var clst = $(this).closest('.media');

        $.ajax({
            url: '/dashboard/appointment/get',
            type: 'get',
            dataType: 'json',
            data: {
                'id': id,
                'action': action,
                'appointment': appointment
            },
            success:function(res) {
                clst.remove();
                toastr.success('Successfully Done!');
            },
            error: function(err) {
                toastr.error('Something went wrong');
            }
        });
    });


    $('.slick-post-part').slick({
        draggable: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false
    });

    $('.slick-category-part').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true
    });

    $(document).on('click', '.cat-btn', function() {
        var id = $(this).data('id');

        $('input[name="category"]').val(id);

        $.ajax({
            url:"/dashboard/jobs",
            type:'post',
            dataType:'json',
            data:{'id':id,' action':'subcategory_request'},
            success: function(res){
                $('.subcategory_view').html(res.view);
                $('.slick-post-part').slick('slickNext');
            }
        });
    });

    $(document).on('click', '.subcat-btn', function() {
        var id = $(this).data('id');

        $('input[name="subcategory"]').val(id);

        $('.slick-post-part').slick('slickNext');
    });

    $(document).on('click', '.fa-angle-left', function() {
        $('.slick-post-part').slick('slickPrev');
    });

    $(document).on('click', '.fa-angle-right', function() {
        $('.slick-post-part').slick('slickNext');

        if (submit) {
            $('#submit').css('display', 'block');
        }
    });

    $('input[name="shiftDate[]"]').val(moment(new Date()).format('YYYY-MM-DD'));

    $('#date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate: new Date()
    }).on('change', function(e){
        var date = $('#date').val();
        $('input[name="shiftDate[]"]').val(moment(date).format('YYYY-MM-DD'));
    });

    $('input[name="startTime[]"]').clockpicker({
        autoclose: true,
    });

    $('input[name="endTime[]"]').clockpicker({
        autoclose: true,
        afterDone: function() {
            var start = $('input[name="startTime[]"]').val();
            var end = $('input[name="endTime[]"]').val();
            if (start != '') {
                if (start >= end) {
                    toastr.error('Invalid time!');
                    $('input[name="endTime[]"]').val('');
                } else {
                    $('.time-part').css('display', 'block');
                }
            }
        }
    });

    $('input[name="distance"]').ionRangeSlider({
        min: 0,
        max: 100,
        from: 50,
        suffix: "km",
        skin: "round"
    });

    $(document).on('submit', '#job_form', function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/dashboard/jobs',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                toastr.success('Successfully Created!');
            }, error: function(err) {
                toastr.error('Something went wrong');
            }
        });
    });

    function getView(date, action) {
        $.ajax({
            url: '/dashboard/appointment/get',
            type:'get',
            dataType:'json',
            data:{
                'date': date,
                'action': action
            },
            success:function(res){
                $('#pills-' + action).html(res.view);
            },
            error: function(err) {
                $('#' + action + '_view').html(noData);
            }
        });
    }

    var currentApp = @json($currentApp);

    var doctors = @json($doctorData);

    google.maps.visualRefresh = true;

    var slider, infowindow = null;
    var bounds = new google.maps.LatLngBounds();
    var map, current = 0;

    var icons = {
        'default':'{{asset("front/img/marker.png")}}'
    };

    var bounds = new google.maps.LatLngBounds();
    if (currentApp) {
        var lat = currentApp.latitute;
        var lng = currentApp.longitute;
    } else {
        var lat = 48.8777787;
        var lng = 2.365058;
    }
    var mapOptions = {
        zoom: 16,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        },
        streetViewControl: false,
        center: new google.maps.LatLng(lat, lng),
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    map.slide = true;

    setMarkers(map, doctors);

    infowindow = new google.maps.InfoWindow({
        content: "loading..."
    });

    google.maps.event.addListener(infowindow, 'closeclick',function(){
        infowindow.close();
    });
    slider = window.setTimeout(show, 3000);

    if (!currentApp) {
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            marker.setVisible(false);

            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();

            $('input[name="latitute"]').val(lat);
            $('input[name="longitute"]').val(lng);
            $('input[name="address"]').val($('#area').val());

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var mapCentre = map.getCenter();

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];

                if (addressComponent[addressType]) {
                    var val = place.address_components[i][addressComponent[addressType].key];
                    $("#"+addressComponent[addressType].id).val(val);
                }
            }

            $('.address-part').css('display', 'block');
            submit = true;
        });
    } else {
        google.maps.event.addDomListener(window, 'load', initialize);

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(currentApp.latitute, currentApp.longitute),
            map: map
        });

        var infoLocation = new google.maps.InfoWindow({
            content: "<p>Awaiting acceptance...</p>"
        });
        infoLocation.open(map, marker);
    }
    
    var addressComponent = {
        locality: {key:'long_name', id:'city'},
        administrative_area_level_1: {key:'long_name',id:'state'}
    }; 
    var input  = document.getElementById('area');
    var options = {
        componentRestrictions: {country: 'FR'}
    };
    var autocomplete  = new google.maps.places.Autocomplete(input, options);

    autocomplete.bindTo('bounds', map);

    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    function setMarkers(map, markers) {
        for (var i = 0; i < markers.length; i++) {
            var item = markers[i];
            if (!item.latitude) {
                item.latitude = 48.8777787;
            }
            if (!item.longitude) {
                item.longitude = 2.365058;
            }
            if (!item.category) {
                item.category = 'general';
            }
            if (!item.profile_img) {
                item.profile_img = '{{asset("front/img/doctor-thumb-02.jpg")}}';
            }

            var latlng = new google.maps.LatLng(item.latitude, item.longitude);
            var marker = new google.maps.Marker({
                id: item.id,
                position: latlng,
                map: map,
                doc_name: item.name,
                address: item.address,
                speciality: item.category,
                animation: google.maps.Animation.DROP,
                icon: icons.default,
                image: item.profile_img
            });

            bounds.extend(marker.position);

            markers[i] = marker;

            google.maps.event.addListener(marker, "click", function () {
                setInfo(this);
                infowindow.open(map, this);
                window.clearTimeout(slider);
            });
        }
        map.fitBounds(bounds);
        var listener = google.maps.event.addListener(map, "idle", function() { 
            if (currentApp) {
                map.setZoom(12); 
            } else {
                map.setZoom(6); 
            }
            google.maps.event.removeListener(listener); 
        });
        google.maps.event.addListener(map, 'zoom_changed', function() {
            if (map.zoom > 16) map.slide = false;
        });
    }

    function setInfo(marker) {
        var content = '<div class="d-flex"><img src="' + marker.image +'" class="border-radius-1 mr-2" width="72" height="72"><div style="width:150px">' +
            '<h5>' + marker.doc_name + '</h5><small class="text-muted">' + marker.speciality + '</small><p>' + marker.address + '</p></div></div';
        infowindow.setContent(content);
    }

    function show() {
        if (!map.slide) {
            return;
        }
        var next, marker;
        if (doctors.length == 0 ) {
            return
        } else if (doctors.length == 1 ) {
            next = 0;
        }
        if (doctors.length >1) {
            do {
                next = Math.floor (Math.random()*doctors.length);
            } while (next == current)
        }
        current = next;
        marker = doctors[next];
        setInfo(marker);
    }

    function initialize() {
        var map  = new google.maps.Map(input, mapOptions);
    }
</script>
@endsection
