<link href="{{url('css/mb.slider.css')}}" media="all" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="{{url('js/front/jquery.mb.slider.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.wrap-slider').slick({
            autoplay: true,
            arrows: false,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
</script>