@extends('layouts.theme')

@section('style')
<style>
    .bg-back {
        background-color: #f4f5fd;
    }
    .like-tab {
        position: absolute;
        border-radius: 0 1rem 1rem 0;
        padding: .4rem;
        top: 16px;
        cursor: pointer;
    }
    .like-tab:hover .fa-heart.text-white {
        color: #ff3e6c !important;
    }
    .like-tab:hover .fa-heart.text-danger {
        color: white !important;
    }
    .arrow-icons i {
        font-size: 1.6rem;
        color: lightgrey;
        cursor: pointer;
        background: transparent;
        border-radius: 50%;
        padding: 0 .5rem;
    }
    .arrow-icons i:hover {
        background: rgba(0, 0, 0, .1);
    }
    .arrow-icons i.active {
        color:  grey
    }
    .friend-tab {
        position: absolute;
        border-radius: 1rem 0 0 1rem;
        padding: .4rem;
        top: 16px;
        right: 0;
        background: 
    }
    .form-control {
        border-radius: .2rem!important
    }
    #search {
        width: calc(100% - 124px);
    }
    .item {
        font-size: .8rem
    }
    .item.active {
        color: #299acf;
    }
    #map {
        position: fixed!important;
        width: 40%;
        height: calc(100vh - 180px);
    }
</style>
@endsection

@section('page')
{{-- <div class="my-auto arrow-icons">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
    <i class="fa fa-angle-right active" aria-hidden="true"></i>
</div> --}}

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 px-0">
            <form class="d-flex justify-content-between">
                <input id="search" type="text" class="form-control bg-back my-auto" placeholder="Search for Doctors">
                <button type="submit" class="btn btn-primary btn-uppercase my-auto ml-2">
                    <i class="fa fa-search mr-2" aria-hidden="true"></i>Submit</button>
            </form>

            <div class="my-3">
                <input type="text" id="rangeSlider">
            </div>

            <div class="page-header d-md-flex justify-content-between bg-white"> 
                <ul class="nav nav-pills gallery-filter justify-content-md-center mb-3 mb-md-0">
                    <li class="nav-item py-2 text-center">
                        <a href="javascript:void(0)" class="item active" data-filter="*" id="cat_0" data-id="0">
                            All
                        </a>
                    </li>
                    
                    @foreach ($categories as $key => $category)
                    <li class="nav-item py-2 text-center">
                        <a href="javascript:void(0)" class="item" data-filter=".{{$category->id}}" id="cat_{{$key + 1}}" data-id="{{$key + 1}}">
                            {{substr($category->name, 0, 10)}}
                            @if (strlen($category->name) > 10)
                                ...
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        
            <h6>Total {{$doctors->count()}} doctors</h6>

            <hr style="background: #e0e0e0; height: 1px">

            <div class="row" id="view_1">
                <div class="col-md-12">
                    <div class="gallery-container row">
                        @foreach ($doctors as $doctor)
        
                            @if (auth()->user()->id != $doctor->id)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 {{$doctor->category}} mb-4">
                                <a href="javascript:void(0)" class="image-popup-gallery-item" data-lat="{{$doctor->latitude}}" data-lng="{{$doctor->longitude}}">
                                    <div class="card">
                                        @if (friend($doctor->id) == 1)
                                        <div class="friend-tab bg-success-bright text-danger">
                                            <i class="fa fa-handshake-o text-success  mr-2"></i>
                                        </div>
                                        @endif
        
                                        <div class="like-tab bg-danger-bright text-danger" id="{{$doctor->id}}" data-id="{{$doctor->id}}">
                                            <i class="fa fa-heart {{like($doctor->id) == 1 ? 'text-danger' : 'text-white'}}  mr-2"></i>
                                            <span>{{$doctor->favourite->count()}}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="my-3">
                                                <img src="{{$doctor->image()}}" class="img-fluid rounded" alt="Vase">
                                            </div>
                                            <div class="text-center">
                                                <a href="javascript:void(0)">
                                                    <h4>{{$doctor->name}}</h4>
                                                </a>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <i class="fa fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <i class="fa fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <i class="fa fa-star text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <i class="fa fa-star-half-o text-warning"></i>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <i class="fa fa-star-o"></i>
                                                    </li>
                                                    <li class="list-inline-item">(47)</li>
                                                </ul>
                                                <div class="badge bg-info-bright text-info text-center">
                                                    @if ($doctor->categories)
                                                    {{substr($doctor->categories->name, 0, 12)}}
                                                    @else
                                                    General 
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
        
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row" id="view_2" style="display: none"></div>
        </div>
        <div class="col-lg-6 1">
            <div id="map"></div>
        </div>
    </div>

</div>


@endsection

@section('script')
<script src="{{asset('theme/vendors/lightbox/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('theme/vendors/jquery.isotope.min.js')}}"></script>
{{-- <script src="{{asset('theme/js/examples/pages/gallery.js')}}"></script> --}}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{config('enums.GoogleMapKey')}}&components=country:'FR'"></script>
<script>
    var latlng = {lat: 48.8777787, lng: 2.365058};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: latlng
    });

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Hello World!'
    });

    $(document).on('click', '.image-popup-gallery-item', function() {
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');
        if (lat == '') {
            lat = 48.8777787;
        }
        if (lng == '') {
            lng = 2.365058;   
        }
        latlng = {lat: lat, lng: lng};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: latlng
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'Hello World!'
        });
    });
</script>
<script>
    var nth = 0;
    var $container = $('.gallery-container');
    var count = '{{$categories->count()}}';

    $('.gallery-filter').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: false,
        responsive: [{
            breakpoint: 1600,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 992,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 576,
            settings: {
                slidesToShow: 2
            }
        }]
    });

    $container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });

    $(document).on('click','.gallery-filter a', function(){
        $('#view_1').css('display', 'block');
        $('#view_2').css('display', 'none');
        var $this = $(this);

        $('.gallery-filter .active').removeClass('active');
        $this.addClass('active');

        var selector = $this.attr('data-filter');
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 300,
                easing: 'linear',
                queue: false
            }
        });
        return false;
    });

    $(document).on('click','.like-tab', function(){
        var id = $(this).data('id');
        var num = Number($('#' + id + ' span').text());
        $.ajax({
            url: "like",
            type:'post',
            dataType:'json',
            data:{
                'id' : id,
            },
            success:function(res){
                if (res.status) {
                    $('#' + id + ' i').removeClass('text-white');
                    $('#' + id + ' i').addClass('text-danger');
                    $('#' + id + ' span').text(++num);
                } else {
                    $('#' + id + ' i').removeClass('text-danger');
                    $('#' + id + ' i').addClass('text-white');
                    $('#' + id + ' span').text(--num);
                }
            }
        });
    });

    $('.arrow-icons').on('click', '.fa-angle-left', function() {
        $('#view_1').css('display', 'block');
        $('#view_2').css('display', 'none');

        $(this).addClass('active');
        $('.fa-angle-right').removeClass('active');
        $('.gallery-filter').slick('slickPrev');
        nth--;
        if (nth < 0) { nth = Number(count);};
        $('#cat_' + nth).click();
    });

    $('.arrow-icons').on('click', '.fa-angle-right', function() {
        $('#view_1').css('display', 'block');
        $('#view_2').css('display', 'none');

        $(this).addClass('active');
        $('.fa-angle-left').removeClass('active');
        $('.gallery-filter').slick('slickNext');
        nth++;
        if (nth > Number(count)) { nth = 0;};
        $('#cat_' + nth).click();
    });

    $('.gallery-filter').on('click', 'a', function() {
        nth = $(this).data('id');
    });

    $(document).on('keyup', '#search', function() {
        var data = $(this).val();

        if (data != '') {
            $('#view_2').css('display', 'block');
            $('#view_1').css('display', 'none');

            $.ajax({
                url: 'search',
                type: 'get',
                dataType: 'json',
                data: {
                    data: data,
                    type: 'doctor'
                },
                success:function(res) {
                   $('#view_2').html(res.view);
                }
                ,error: function(err) {
                    console.log(err);
                }
            });
        } else {
            $('#view_1').css('display', 'block');
            $('#view_2').css('display', 'none');
        }
    });

    $("#rangeSlider").ionRangeSlider({
        min: 0,
        max: 100,
        from: 50,
        suffix: "Km",
        skin: "round"
    });

</script>
@endsection  