$(document).ready(function() {
    var date;
    var page = 1;
    var idsArray = [];
    
    $.ajax({
        url:"data",
        method:"GET",
        success:function(res){
            $("#appointment-row-data").html(res.view);
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
            url:"/dashboard/appointment/get",
            type:'get',
            dataType:'json',
            data:{
                'date':moment(e.date).format('YYYY-MM-DD'),
                'action':'pending'
            },
            success:function(res){
                $('input[name="datepicker"]').val(moment(e.date).format('YYYY-MM-DD'));
                $('.selected-date').html(moment(e.date).format('DD MMMM YYYY'));
                $('#appointment-row-data').html(res.view);
            }
        })
    });


    $(document).on('click', '.cancel-appointment',function(){
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
        })
    });

    setInterval(function(){
        date = $('input[name="datepicker"]').val();
        $("#appointment-row-data .row").each(function() {
            idsArray.push($(this).data('id'));
        });
        if(idsArray.length > 0 ){
            $.ajax({
                url:"/dashboard/appointment/get?page="+page,
                type:'get',
                dataType:'json',
                data:{
                    'status':'0',
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
        } else{
            $.ajax({
                url:"/dashboard/appointment/get?page="+page,
                type:'get',
                dataType:'json',
                data:{
                    'status':'0',
                    'date':date,
                    'action':'confirm_request'
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
                }
            });
        }
    }, 5000);

    $(document).on('click', '.see-more', function(e){
        e.preventDefault();
        $.ajax({
            url:"/dashboard/appointment/get?page="+page,
            dataType:'json',
            data:{
                'status': 0,
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
});