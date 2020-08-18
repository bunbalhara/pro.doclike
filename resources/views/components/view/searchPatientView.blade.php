<div class="col-md-12">
    <div class="gallery-container row">
        @foreach ($patients as $patient)
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
        @endforeach
    </div>
</div>

<script>
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
</script>