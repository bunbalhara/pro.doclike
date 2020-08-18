var page = 1;
var date;
var isInitiate = 0;

$('#datetimepicker').datetimepicker({
    format: 'DD/MM/YYYY',
    minDate: new Date(),
    inline: true,
    sideBySide: true
}).on('dp.change', function (e){
    $('.appointment-row-data').html('<div class="text-center">Loading....</div>');
    $.ajax({
        url:"/dashboard/jobs",
        type:'post',
        dataType:'json',
        data:{
            'date':moment(e.date).format('YYYY-MM-DD'),
            'action':'shift'
        },
        success:function(res){
            $('input[name="datepicker"]').val(moment(e.date).format('YYYY-MM-DD'));
            $('.purposal-row').hide();
            $('.selected-date').html(moment(e.date).format('DD MMMM YYYY'));
            $('.appointment-row-data').html(res.view);
        },
        error: function(err) {console.log(err)}
    });
});

$(document).on('click', '.save-job',function(){
    var shift_id       = $('input[name="shift_id"]').val();
      var appointment_id = $('input[name="appointment_id"]').val();
      var purposal_time  = $('input[name="purposal_time"]').val();
      var apply_date     = $('input[name="apply_date"]').val();
      $('.purposal-time-error').html('');
      if(purposal_time){
          $.ajax({
            url:"jobs",
            type:'post',
            dataType:'json',
            data:{
                'job_id':appointment_id,
                'apply_date':apply_date,
                'shift_id':shift_id,
                'apply_time':moment(purposal_time,'HH:mm').format('HH:mm'),
                'action':'store-appointment'
            },
            success:function(res){
                if(res.success){
                    $('#'+shift_id).remove();
                    $('.success-message').html('<div class="alert alert-success">Applied successfully.</div>');
                       setTimeout(function(){ $('.purposal-row').hide() }, 2000);
                }
            }
        })
          $('input[name="purposal_time"]').val('');
          
      } else {
          $('.purposal-time-error').html('<span>First select appointment time than click on apply button.</span>');
      }
});


$(document).on('click', '.cancel-job', function(){
    $('.purposal-row').hide();
});

$(document).on('click', '.accept-purposer', function(){
    $('.success-message').html('');
    var id      = $(this).data('id');
    var shiftId = $(this).data('shift');
    var start   = $(this).data('start');
    var end     = $(this).data('end');
    var date    = $(this).data('date');
    if(isInitiate == '1'){
        $('#time').timepicker('destroy');
    }
    isInitiate = 1;
    $('#time').timepicker({
          timeFormat: 'HH:mm',
          interval: 15,
          minTime:start,
          maxTime:end,
        dropdown: true,
        scrollbar: true
      });
      $('#purposalModal').find('input[name="shift_id"]').val(shiftId);
      $('#purposalModal').find('input[name="appointment_id"]').val(id);
      $('#purposalModal').find('input[name="apply_date"]').val(date);
      
      $('#purposalModal').modal({backdrop: 'static', keyboard: false},'show');
});

setInterval(function() {
    date = $('input[name="datepicker"]').val();
    var idsArray = [];
    $(".appointment-row-data .row").each(function() {
        idsArray.push($(this).data('id'));
    });
    if(idsArray.length > 0 ){
        $.ajax({
            url:"/dashboard/jobs/get?page="+page,
            type:'get',
            dataType:'json',
            data:{
                'date':date,
                'idsArray':idsArray
            },
            success:function(res){
                if (res.view != '') {
                    if ($('.appointment-row-data').html() == '') {
                        $('.appointment-row-data').append(res.view);
                    } else {
                        $('.see-more').css('display', 'block');
                    }
                } else {
                    $('.see-more').css('display', 'none');
                }
            },
            error: function(err) {console.log(err)}
        });
    }
    else{
        $.ajax({
            url:"/dashboard/jobs/get?page="+page,
            type:'get',
            dataType:'json',
            data:{
                'date':date,
            },
            success:function(res){
                if (res.view != '') {
                    if ($('.appointment-row-data').html() == '') {
                        $('.appointment-row-data').append(res.view);
                    } else {
                        $('.see-more').css('display', 'block');
                    }
                } else {
                    $('.see-more').css('display', 'none');
                }
            },
            error: function(err) {console.log(err)}
        });
    }
}, 5000);

$(document).on('click', '.see-more', function(e){
    e.preventDefault();
    $.ajax({
        url:"/dashboard/jobs/get?page="+page,
        type:'get',
        dataType:'json',
        data:{
            'date':date,
        },
        success: function(res) {
            $('.appointment-row-data').append(res.view);
            page++
        },
    });
});