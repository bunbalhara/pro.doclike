@if ($appointments->count())
<div class="slick-confirm-part">
    @foreach ($appointments as $key => $app)
    <div class="media shadow-sm border-radius-1 p-4 m-2 slick-slide slick-current slick-active" data-slick-index="{{$key + 1}}">
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

<script>
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
</script>