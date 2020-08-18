var loadData;
var date;
var idsArray = [];
var page = 1;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#datetimepicker').datetimepicker({
    format: 'DD/MM/YYYY',
    minDate: new Date(),
    inline: true,
    sideBySide: true
}).on('dp.change', function (e){
    $('#appointment-row-data').html('<div class="text-center">Loading....</div>');
    $.ajax({
        url:"/get-appointment",
        type:'get',
        dataType:'json',
        data:{
            'date':moment(e.date).format('YYYY-MM-DD'),
            'action':'confirm'
        },
        success:function(res){
            $('input[name="datepicker"]').val(moment(e.date).format('YYYY-MM-DD'));
            $('.selected-date').html(moment(e.date).format('DD MMMM YYYY'));
            $('#appointment-row-data').html(res.view);
            if(res.view != '' && window.innerWidth < 992) {
                $('.slick-next').click();
            }
        }
    });
});

setInterval(function(){
    date = $('input[name="datepicker"]').val();
    idsArray = [];
    $("#appointment-row-data .row").each(function() {
        idsArray.push($(this).data('id'));
    });
    if(idsArray.length > 0 ){
        loadData = true;
        $.ajax({
            url:"/get-appointment?page="+page,
            type:'get',
            dataType:'json',
            data:{
                'status':'1',
                'date':date,
                'action':'confirm_request',
                'idsArray':idsArray
            },
            success:function(res){
                if (res.view != '') {
                    if ($('#appointment-row-data').html() == '') {
                        $('#appointment-row-data').append(res.view);
                    } else {
                        $('.see-more').css('display', 'block');
                    }
                } else {
                    $('.see-more').css('display', 'none');
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    } else {
        loadData = false;
        $.ajax({
            url:"/get-appointment?page="+page,
            type:'get',
            dataType:'json',
            data:{
                'status':'1',
                'date':date,
                'action':'confirm_request'
            },
            success:function(res){
                if (res.view != '') {
                    if ($('#appointment-row-data').html() == '') {
                        $('#appointment-row-data').append(res.view);
                        display = false;
                    } else {
                        $('.see-more').css('display', 'block');
                    }
                } else {
                    $('.see-more').css('display', 'none');
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
}, 5000);

$('.multiple-items').slick({
    draggable: false,
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

$(document).on('click', '.chat-btn', function(e){
    var id = $(this).data('id');
    $.ajax({
        url:"chat/data",
        method:"POST",
        data: {id: id},
        success:function(result){
            $("#chat_box").html(result.view);
            $('.multiple-items').slick('slickNext');
        }
    });
});

$(document).on('click', '.before-btn', function(e){
    $('.multiple-items').slick('slickPrev');
});

$(document).on('click', '.see-more', function(e){
    e.preventDefault();
    $.ajax({
        url:"/get-appointment?page="+page,
        dataType:'json',
        data:{
            'status': loadData,
            'date':date,
            'action':'confirm_request',
            'idsArray':idsArray
        },
        success: function(res) {
            $('#appointment-row-data').append(res.view);
            page++
        }
    });
});