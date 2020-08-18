@extends('layouts.theme')

@section('style')
<style>
    .subcategory-row:hover .subcategory-name {
        color: #299acf;
        font-weight: 500;
    }
</style>
@endsection

@section('page')

<div class="page-header">
    <div id="category_type" class="float-right category-image d-flex">
        <div class="mr-2 my-auto">
            <h5 id="category_name">{{$categories->first()->name}}</h5>
            <h6>Steps <span id="category_step">1</span> of 5</h6>
        </div>
        <img id="category_type" src="{{$categories->first()->image}}" style="background: {{$categories->first()->color}}; border-radius: 8px" alt="" width="60" height="60">
    </div>
    <div>
        <h3>Recherche de consultation</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Consultation</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
            </ol>
        </nav>
    </div>
</div>

<form id="job_form">

    <input id="category" type="hidden" name="category" value="{{$categories->first()->id}}" class="uk-input">
    {{ Form::hidden('latitute', '', ['class' => 'uk-input','id' => 'latitute']) }}
    {{ Form::hidden('longitute', '', ['class' => 'uk-input','id' => 'longitute']) }}
    {{ Form::hidden('city', '', ['class' => 'uk-input','id' => 'city']) }}
    {{ Form::hidden('state', '', ['class' => 'uk-input','id' => 'state']) }}
    {{ Form::hidden('distance', '10', ['class' => 'uk-input']) }}

    <div class="job-post-container pb-5">
        <div class="d-flex justify-content-center mb-2">
            <button type="button" class="btn btn-primary prev-btn mr-auto">Prev</button>
            <div class="my-auto" style="width: calc(100% - 150px)">
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width:0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <button type="button" class="btn btn-primary next-btn ml-auto">Next</button>
        </div>

        <div class="card-deck d-block d-md-flex u-columns col2-set multiple-items">
            <div class="card mb-4 mb-md-0 bg-transparent">
                <div class="category-container create-part-height">
                    @foreach($categories as $cat)
                        @if ($cat->doctor()->count())
                        <a href="javascript:void(0)" class="select-category">
                            <div class="theme-category-row p-2 mx-2 mb-2" id="category_{{$cat->id}}" data-id="{{$cat->id}}" data-img="{{$cat->image}}" data-color="{{$cat->color}}" data-name="{{$cat->name}}">
                                <div class="category-image" style="background:{{$cat->color}}"><img src="{{$cat->image}}"></div>
                                
                                <div class="category-content-row my-auto">
                                    <h4 class="category-name h5 font-weight-medium">{{$cat->name}}</h4>
                                    <div class="category-description">{{$cat->doctor()->count()}} doctors</div>
                                </div>
                                
                                <div class="ml-auto my-auto">
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="card mb-4 mb-md-0 p-0" id="view_0">
                <div class="mb-4 mb-md-0 position-relative create-part-height">
                    <div class="subcategory-container p-4"></div>
                </div>
            </div>

            <div class="card mb-4 mb-md-0 p-0" id="view_1">
                <div class="shift-container position-relative p-4 create-part-height">
                    <h5 class="text-primary">
                        {{\Carbon\Carbon::now()->format('M')}}
                    </h5>

                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        @for ($i = 0; $i < 5; $i++)
                        <li class="nav-item">
                            <a class="nav-link {{($i == 0) ? 'active' : ''}}" id="{{$tabArray[$i]}}-tab" data-toggle="tab" href="#{{$tabArray[$i]}}" role="tab" aria-controls="{{$tabArray[$i]}}" aria-selected="true">
                                @if($i == 0)
                                    Aujourd’hui
                                @elseif($i == 1)
                                    Demain
                                @else
                                    {{$daysArray[date('D',strtotime('+'.$i.' days'))]}}
                                @endif
                            </a>
                        </li>
                        @endfor
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        @for ($i = 0; $i < 5; $i++)
                        <div class="tab-pane fade show {{($i == 0) ? 'active' : ''}}" id="{{$tabArray[$i]}}" role="tabpanel" aria-labelledby="{{$tabArray[$i]}}-tab">
                            <div class="form-group mt-4 row disabled-row">
                                <div class="col-md-12">
                                    <h3>
                                        @if($i == 0)
                                            Aujourd’hui
                                        @elseif($i == 1)
                                            Demain
                                        @else
                                            {{$daysArray[date('D',strtotime('+'.$i.' days'))]}}
                                        @endif
                                    </h3>

                                    <div>
                                        @if($i == 0)
                                            Aujourd’hui
                                        @elseif($i == 1)
                                            Demain
                                        @else
                                            {{$daysArray[date('D',strtotime('+'.$i.' days'))]}}
                                        @endif 

                                        {{date('F d Y',strtotime('+'.$i.' days'))}} de

                                        <span class="selected-time"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-4 time-row">
                                <div class="col-md-12">
                                    <label>Tranches prédéfinies</label>
                                    {{Form::select('timeShift',$timeShift,'',['class' => 'form-control'])}}
                                </div>
                            </div>

                            {{ Form::hidden('shiftDate[]', date('Y-m-d',strtotime('+'.$i.' days')), ['class' => 'uk-input']) }}

                            <div class="form-group row mt-4 time-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control start-time" name="startTime[]" onfocus='this.setAttribute("autocomplete", "off")'>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" class="form-control end-time" name="endTime[]" onfocus='this.setAttribute("autocomplete", "off")'>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="card mb-4 mb-md-0 p-0" id="view_2">
                <div class="create-part-height p-4">
                    <div class="serch-area form-group d-flex">
                        <input class="form-control" id="searchArea" name="searchArea" type="text" value="">
        
                        <a href="javascript:void(0)" class="clear-area" style="display:none">
                            <i class="fa-2x fa fa-times-circle"></i>
                        </a>
                    </div>
        
                    <div class="show-map" style="display:none;">
                        <div id="googlemap"></div>
        
                        <div class="form-group row mt-3 location-details">
                            <div class="col-md-6">
                                <a class="change-distance"><i class="fa fa-location-arrow" aria-hidden="true"></i> 10km autour</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 mb-md-0 p-0" id="view_3">
                <div class="p-4">
                    <h5>Choisissez votre praticien</h5>
                    <hr>
                    @if($purposals && count($purposals) > 0)
                        @foreach($purposals as $p)
                            <div class="form-group row" data-id="{{$p->id}}">
                                <div class="col-2 my-auto">
                                    <img src="{{($p->doctor->profile_img) ? $p->doctor->profile_img : url('front/img/doctor-thumb-02.jpg')}}" width="60">
                                </div>
                                <div class="col-4 my-auto">
                                    {{$p->doctor->name}} @if($p->frontPayment == '1') <span class="ml-2"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></span> @endif<br>
                                    <b>{{$p->appointment->category->name}}</b>
                                </div>
                                <div class="col-3 my-auto"><span class="time-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span><span class="start-time">
                                    {{date('H:i',strtotime($p->applied_time))}}
                                </div>
                                <div class="col-3 my-auto">
                                    <div class="d-flex call-action">
                                        <button type="button" class="btn btn-success btn-floating confirm-appointment mr-2" data-id="{{$p->id}}">
                                            <i class="ti-check-box"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-floating cancel-appointment" data-id="{{$p->id}}">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-danger">No purposal.</div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</form>

<!-- Location Modal -->

<div class="modal fade" id="location-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enter location</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input class="form-control" id="location" name="location" type="text" value="">
            </div>
        </div>
    </div>
</div>

<!-- Distance Modal -->

<div class="modal fade" id="distance-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Périmetre de recherche</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div>
                    <div class="mb_slider" data-property="{rangeColor:'gray', startAt:10, grid:0}" style="display:inline-block;*display:inherit;"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{url('front/js/jquery.mb.slider.js')}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{config('enums.GoogleMapKey')}}&components=country:'FR'"></script>
<script type="text/javascript" src="{{url('front/js/moment-round.js')}}"></script>
{{-- <script src="{{asset('home/js/page/jobs.create.js')}}"></script> --}}
<script>
    var slideValue = 0;
    var flag = true;
    $('.start-time').val(moment().ceil(15, 'minutes').format('HH:mm'));
    $('.end-time').val(moment().ceil(15, 'minutes').add(3, 'hours').format('HH:mm'));
    $('.selected-time').html(moment().ceil(15, 'minutes').format('HH:mm')+' à '+moment().ceil(15, 'minutes').add(3, 'hours').format('HH:mm'))

    progress(0);

    var addressComponent = {
        locality: {key:'long_name',id:'city'},
        administrative_area_level_1: {key:'long_name',id:'state'}
    };
    var latitude  = "{{($appointment) ? $appointment->latitute : (($latitude) ? $latitude : '46.2276')}}";
    var longitude = "{{($appointment) ? $appointment->longitute : (($longitude) ? $longitude : '2.2137')}}";
    
    var zoomLevel = 13;
    var appointment = @json($appointment);
    
    var address = @json($address);
    var latitude = @json($latitude);
    var longitude = @json($longitude);

    if (appointment || (latitude && latitude && longitude)) {
        zoomLevel = 17;
    }

    var myLatlng = new google.maps.LatLng(latitude, longitude);
    var mapOptions = {
        zoom: zoomLevel,
        scrollwheel: false,
        mapTypeControl:false,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        },
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: myLatlng
    };

    map = new google.maps.Map(document.getElementById('googlemap'), mapOptions);

    var input  = document.getElementById('searchArea');
    var options = {
        componentRestrictions: {country: 'FR'}
    };
    var autocomplete  = new google.maps.places.Autocomplete(input,options);

    autocomplete.bindTo('bounds', map);

    if (latitude && latitude && longitude) {
        var marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng("{{$latitude}}","{{$longitude}}"),
            anchorPoint: new google.maps.Point(0, -29)
        });
    } else {
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
    }

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

        $('.clear-area').show();
        $('.show-map').show();
        $('.next-btn').removeClass('disabled');
    });

    $('.multiple-items').slick({
        arrows: false,
        swipe: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 960,
            settings: { slidesToShow: 1, }
        }, {
            breakpoint: 1440,
            settings: { slidesToShow: 2, }
        }]
    });

    $(document).on('click', '.theme-category-row', function(){
        $('.theme-category-row').removeClass('active');
        $(this).addClass('active');
        $('.subcategory-container').html('<div class="d-flex justify-content-center"><div class="d-inline-flex"><div class="spinner-border text-primary mr-2" role="status">' +
        '</div><h5 class="my-auto text-primary">loading....</h5></div></div>');

        var id = $(this).data('id');

        slideValue = 1;

        $('input[name="category"]').val(id);

        $('#category_type img').attr('src', $(this).data('img'));
        $('#category_type img').css('background', $(this).data('color'));
        $('#category_type').fadeIn();
        $('#category_name').html($(this).data('name'));
        
        progress(1);

        $.ajax({
            url:"/dashboard/jobs",
            type:'post',
            dataType:'json',
            data:{'id':id, 'action':'subcategory'},
            success: function(res) {
                $('.subcategory-container').html(res.view);
            }
        });
    });

    $(document).on('click', ".subcategory-row", function(){
        $(this).find('input').prop('checked', true);
        var subcategory = $("input[name='subcategory']:checked").val();
        slideValue = 2;
        progress(2);
        $('.next-btn').removeClass('disabled');
    });
    
    $(document).on('submit', '#job_form', function(e){
        e.preventDefault();

        $('.progress-bar').css('width', '100%');

        $.ajax({
            type: 'POST',
            url: '/dashboard/jobs',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                if (res.success) {
                    toastr.success('Successfully Created');
                    $('#job_form')[0].reset();
                }
            }
        });
    })

    $('select[name="timeShift"]').change(function(){
        $('.start-time').val()

        var val = $(this).val();
        var min = moment().ceil(15, 'minutes').format('HH:mm');
        var max = moment(min,'HH:mm').add(3, 'hours').format('HH:mm');

        if(val == '1'){
            min = '06:00';
            max = '12:00';
        } else if (val == '2') {
            min = '12:00';
            max = '18:00';
        } else if (val == '3'){
            min = '18:00';
            max = '23:45';
        }

        $(this).closest('.tab-pane').find('.start-time').val(min)
        $(this).closest('.tab-pane').find('.end-time').val(max)
        $(this).closest('.tab-pane').find('.selected-time').html(min+' à '+max)
    });

    $('.start-time').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        change: function(time) {
            var startTime = moment(time,'HH:mm').format('HH:mm');

            $('.end-time').timepicker('destroy');
            $('.end-time').timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                minTime: moment(time,'HH:mm').format('HH:mm'),
                maxTime: '23:45',
            });

            var element = $(this), text;
            var timepicker = element.timepicker();

            text = timepicker.format(time);

            if(startTime > '20:45'){
                var endTime = '23:45';
            } else {
                var endTime = moment(time,'HH:mm').add(3, 'hours').format('HH:mm');
            }

            $(this).closest('.time-row').find('.end-time').val(endTime);
            $(this).closest('.tab-pane').find('.selected-time').html(moment(time,'HH:mm').format('HH:mm')+' à '+endTime)
        }
    });

    $('.end-time').timepicker({
        timeFormat: 'HH:mm',
        interval: 15,
        maxTime: '23:45',
    });

    $(document).on('click','.change-distance',function(){
        $('#distance-modal').modal('show');
    });

    $(".mb_slider").mbSlider({
        minVal : 10,
        maxVal : 50,
        formatValue: function(val){
            $('#distance').val(val);
            $('.change-distance').html('<i class="fa fa-location-arrow" aria-hidden="true"></i> '+val+'km autour')
            return val;
        }
    });

    $(document).on('click','.clear-area',function(){
        $('#searchArea').val('');
        $(this).hide();
        $('#searchArea').focus();
    });

    $(document).on('click','.cancel-appointment', function(){
        var id   = $(this).data('id');
        var clst = $(this).closest('.row');
        $.ajax({
            url:"/dashboard/appointment/get",
            type:'get',
            dataType:'json',
            data:{
                'id':id,
                'action':'cancel'
            },
            success:function(res){
                toastr.success('Appointment cancelled!');
                clst.remove();
            }
        });
    });

    $(document).on('click','.confirm-appointment',function(){
        var id   = $(this).data('id');
        var appointment = $(this).data('appointment');
        var clst = $(this).closest('.row');
        
        $.ajax({
            url:"/dashboard/appointment/get",
            type:'get',
            dataType:'json',
            data:{
                'id':id,
                'appointmentId':appointment,
                'action':'confirm_appointment'
            },
            success:function(res){
                toastr.success('Appointment confirmed!');
                clst.remove();
            }
        });
    });

    $(document).on('click','.prev-btn', function(){
        if (!$(this).hasClass('disabled')) {
            slideValue--;
            flag = false;
            progress(slideValue);
        }
    });

    $(document).on('click','.next-btn', function(){
        if (!$(this).hasClass('disabled')) {
            slideValue++;
            progress(slideValue);
        }
    });

    function progress(value) {
        var windowWidth = $(window).width();
        
        if (flag) {
            if (windowWidth < 960) {
                $('.multiple-items').slick('slickNext');
            } else if (windowWidth < 1440) {
                if (value > 1) {
                    $('.multiple-items').slick('slickNext');
                }
            } else {
                if (value > 2) {
                    $('.multiple-items').slick('slickNext');
                }
            }
        } else {
            $('.multiple-items').slick('slickPrev');
        }

        flag = true;

        $('.progress-bar').css('width', value * 100 / 4 + '%');

        for (var i = 0; i < 7; i++) {
            if (i < value) {
                $('#view_' + i).css('display', 'block');
            } else {
                $('#view_' + i).css('display', 'none');
            }
        }

        $('#category_step').html(value + 1);

        $('.prev-btn').addClass('disabled');
        $('.next-btn').addClass('disabled');
        
        if (value > 0) {
            $('.prev-btn').removeClass('disabled');
        }
    }
</script>

@endsection