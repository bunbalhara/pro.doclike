@extends('layouts.theme')

@section('style')
<style>
    .bg-back {
        background-color: #f4f5fd;
    }
    .friend-tab {
        position: absolute;
        border-radius: 1rem 0 0 1rem;
        padding: .4rem;
        top: 16px;
        right: 0;
        background: 
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
</style>
@endsection

@section('page')

<div class="container">
    <div class="page-header d-md-flex justify-content-between">
        <div>
            <h3>Patients</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Users</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Patient List</li>
                </ol>
            </nav>
        </div>

        <form class="my-auto mr-4">
            <input id="search" type="text" class="form-control bg-back" placeholder="Search for Patients">
        </form>
    </div>

    <div class="row" id="view_1">
        <div class="col-md-12">
            <div class="gallery-container row">
                @foreach ($patients as $patient)

                    @if (auth()->user()->id != $patient->id)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12} mb-4">
                        <a href="javascript:void(0)" class="image-popup-gallery-item">
                            <div class="card">
                                @if (friend($patient->id) == 1)
                                <div class="friend-tab bg-success-bright text-danger">
                                    <i class="fa fa-handshake-o text-success  mr-2"></i>
                                </div>
                                @endif

                                <div class="like-tab bg-danger-bright text-danger" id="{{$patient->id}}" data-id="{{$patient->id}}">
                                    <i class="fa fa-heart {{like($patient->id) == 1 ? 'text-danger' : 'text-white'}}  mr-2"></i>
                                    <span>{{$patient->favourite->count()}}</span>
                                </div>
                                
                                <div class="card-body">
                                    <div class="my-3">
                                        <img src="{{$patient->image()}}" class="img-fluid rounded" alt="Vase">
                                    </div>
                                    <div class="text-center">
                                        <a href="javascript:void(0)">
                                            <h4>{{$patient->name}}</h4>
                                        </a>
                                        <div class="mt-2">
                                            <a class="btn btn-info text-white">View Profile</a>
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


@endsection

@section('script')
<script src="{{asset('theme/vendors/lightbox/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('theme/vendors/jquery.isotope.min.js')}}"></script>
{{-- <script src="{{asset('theme/js/examples/pages/gallery.js')}}"></script> --}}
<script>
    var nth = 0;
    var $container = $('.gallery-container');

    $('.gallery-filter').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: false,
        responsive: [{
            breakpoint: 1600,
            settings: {
                slidesToShow: 6
            }
        }, {
            breakpoint: 1440,
            settings: {
                slidesToShow: 5
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
        }, {
            breakpoint: 442,
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

    $(document).on('click','.like-tab', function(){
        var id = $(this).data('id');
        var num = Number($(this).find('span').text());
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
                    data: data
                },
                success:function(res) {
                   $('#view_2').html(res.view);
                }
            });
        } else {
            $('#view_1').css('display', 'block');
            $('#view_2').css('display', 'none');
        }
    });
</script>
@endsection  