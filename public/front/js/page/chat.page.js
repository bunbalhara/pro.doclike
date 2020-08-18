$(document).ready(function(){

    $.ajax({
        url:"/chat/InitData",
        method:"POST",
        success:function(result){
            $(".chat-cont-right").html(result.view);
        }
    });

    function showTime() {
        const date = new Date(),
            utc = new Date(Date.UTC(
                date.getFullYear(),
                date.getMonth(),
                date.getDate(),
                date.getHours(),
                date.getMinutes(),
                date.getSeconds()
            ));

        document.getElementById('time').innerHTML = utc.toLocaleTimeString('en-US', {timeZone: 'Europe/Paris'});
    }

    setInterval(showTime, 1000);
    $('.chat-window').slick({
        draggable: true,
        arrows: false,
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $(document).on('click', '.media-btn', function(e){
        $.ajax({
            url:"/chat-data",
            method:"POST",
            data: {id: $(this).data('id')},
            success:function(result){
                $(".chat-cont-right").html(result.view);
            }
        });
        $('.chat-window').slick('slickNext');
    });
    $(document).on('click', '.fa-arrow-left', function(e){
        $('.chat-window').slick('slickPrev');
    });

});
