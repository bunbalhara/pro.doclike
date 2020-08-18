@extends('layouts.theme')

@section('style')
<style>
    .ui-timepicker-container { 
        z-index:1151 !important; 
    }
    .sidebar {
        position: absolute;
        width: 360px;
        right: 0;
        top: 0;
        display: block;
        background: #f4f6f8;
        border-left: 1px solid rgba(0, 0, 0, .1) ;
        height: 100%;
    }
    .sidebar i {
        font-size: 2rem
    }
    tr.disabled {
        opacity: .6;
    }
    .disabled, .disabled .action-btn {
        cursor: not-allowed;
    }
    .middle-text {
        top: 50%;
        left: 50%;
        position: absolute;
        text-align: center;
        transform: translate(-50%, -50%);
    }
</style>
@endsection

@section('page')
    <div class="page-header">
        <div class="d-flex justify-content-center">
            <div class="mr-auto">
                <h3>Jobs</h3>
                <nav aria-label="breadcrumb" class="d-flex align-items-start">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Appointments</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Jobs</li>
                    </ol>
                </nav>
            </div>

            <input type="text" name="daterangepicker_job" class="form-control date-picker my-auto ml-auto">
        </div>
    </div>

    <div class="card" id="list">
        <div class="card-body">
            <div class="table-responsive mt-2" id="view">
                @if ($jobData->count())

                    @foreach ($jobData as $app)
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <figure class="avatar avatar-lg">
                                            <img src="{{$app->user->image()}}" class="rounded-circle" alt="avatar">
                                        </figure>
                                        
                                        <div class="ml-2 my-auto">
                                            <h5>{{$app->user->name}}</h5>
                                        </div>
                                    </div>
                                </td>

                                <td class="address-row">{{$app->city}}</td>

                                <td class="address-row">{{$app->state}}</td>

                                <td>{{date('H:i', strtotime($app->appointmentShift->start_time)) }} ~ {{date('H:i',strtotime($app->appointmentShift->end_time)) }}</td>

                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-success text-center action-btn job-btn" data-id="{{$app->id}}" data-shift="{{$app->appointmentShift}}">
                                            <i class="fa fa-check-circle-o font-large" aria-hidden="true"></i>
                                            <h6>Accept</h6>
                                        </div>

                                        <div class="text-danger text-center action-btn app-btn mx-auto" data-id="{{$app->id}}" data-type="cancel_request">
                                            <i class="fa fa-ban font-large" aria-hidden="true"></i>
                                            <h6>Deny</h6>
                                        </div>

                                        <div class="text-center text-black less-btn action-btn" style="display: none" id="{{$app->id}}_less" data-id="{{$app->id}}">
                                            <i class="fa fa-folder-open-o font-large"></i>
                                            <h6>Less</h6>
                                        </div>
                                        <div class="text-center text-black more-btn action-btn" id="{{$app->id}}_more" data-id="{{$app->id}}">
                                            <i class="ti-more-alt font-large"></i>
                                            <h6>More</h6>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                    
                @else
                    <div class="alert alert-danger alert-with-border" role="alert">
                        There is available Confirmed proposal today
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="sidebar p-5" style="display: none"></div>

    <div class="modal fade" id="purposal_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::open(array('id' => 'job_form')) }}
                <div class="modal-body">
                    {{ Form::hidden('shift_id','', ['class' => 'form-control']) }}
                    {{ Form::hidden('job_id','', ['class' => 'form-control']) }}
                    {{ Form::hidden('apply_date','', ['class' => 'form-control']) }}
                    {{ Form::hidden('action', 'store-appointment') }}
                    <div class="input-group mb-4" id="clockpicker">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-clock-o"></i>
                          </span>
                        </div>
                        {{ Form::text('apply_time','',['class' => 'form-control','id' => 'time']) }}
                    </div>
                    <div class="row form-group">
                        <div class="col-md-1 col-2">
                            <label><i class="fa fa-credit-card-alt fa-2x" aria-hidden="true"></i></label>
                        </div>
                        <div class="col-md-6 col-6">
                            UpFront payment
                        </div>
                        <div class="col-md-5 col-4 text-right">
                            <label class="switch">
                                <input type="checkbox" name="frontPayment">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row payment-row" style="display:none;">
                        <div class="col-md-1 col-2"></div>
                        <div class="col-md-11 col-10">
                            {{ Form::text('paymentValue','',['class' => 'form-control','placeholder' => 'enter value here']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary save-job">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div> 
@endsection

@section('script')
<script>
    var isInitiate = 0;
    var loading = '<div class="text-center"><div class="d-inline-flex"><div class="spinner-border text-primary mr-2" role="status"></div><div class="text-primary my-auto">Loading...</div></div></div>';
    var noData = '<div class="alert alert-danger alert-with-border" role="alert">There is available Confirmed proposal</div>';
    var loadingView = '<div class="middle-text"><div class="d-flex text-info"><div class="spinner-border mr-2" role="status">' +
    '<span class="sr-only"></span></div><h5 class="my-auto">Loading...</h5></div></div>';
    var errorView = '<div class="middle-text"><h5 class="text-danger">Server Error!</h5></div>'

    $(document).on('click', '.app-btn', function(){
        var id = $(this).data('id');
        var type = $(this).data('type');
        var clst = $(this).closest('tr');

        $.ajax({
            url: '/dashboard/appointment/get',
            type: 'get',
            dataType: 'json',
            data: {
                'id': id,
                'action': type
            },
            success:function(res) {
                clst.remove();
                toastr.success('Successfully Done!');
            },
            error: function(err) {
                toastr.error('Something went wrong');
            }
        });
    });

    $(document).on('click', '.job-btn', function(){
        var id = $(this).data('id');
        var shift = $(this).data('shift');
        job_row = $(this).closest('tr');
        
        if(isInitiate == '1'){
            $('#time').timepicker('destroy');
        }

        isInitiate = 1;

        $('input[name="apply_time"]').clockpicker({
            autoclose: true
        });

        $('#purposal_modal').find('input[name="shift_id"]').val(shift.id);
        $('#purposal_modal').find('input[name="job_id"]').val(id);
        $('#purposal_modal').find('input[name="apply_date"]').val(shift.date);
        $('#purposal_modal').find('input[name="apply_time"]').val('');
        $('#purposal_modal').modal({backdrop: 'static', keyboard: false},'show');
    });

    $(document).on('submit', '#job_form', function(e){
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '/dashboard/jobs',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                toastr.success('Successfully Created!');
                job_row.remove();
                $('#pending_view').html(res.view);
                $('#purposal_modal').modal('hide');
            }, error: function(err) {
                toastr.error('Something went wrong');
            }
        });
    });

    $(document).on('click', 'input[name="frontPayment"]', function(){ 
        $('input[name="frontPayment"]').val(this.checked);
        if (this.checked){
            $('.payment-row').show();
        } else {
            $('.payment-row').hide();
        }
    });

    $('input[name="daterangepicker_job"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        opens: 'left',
        minDate: new Date()
    }).on('change', function(e){
        var date = $('input[name="daterangepicker_job"]').val();
        getView('job', moment(date).format('YYYY-MM-DD'));
    });

    $(document).on('click', '.more-btn', function() {
        var clst = $(this).closest('tr');

        if (!clst.hasClass('disabled')) {
            var id = $(this).data('id');
            $(this).toggle();
            $('#' + id + '_less').toggle();

            $('tr').addClass('disabled');
            clst.addClass('shadow');
            clst.removeClass('disabled');

            sidebarShow(id);
        }
    });

    $(document).on('click', '.less-btn', function() {
        var id = $(this).data('id');
        $(this).toggle();
        $('#' + id + '_more').toggle();

        $('tr').removeClass('disabled');
        var clst = $(this).closest('tr');
        clst.removeClass('shadow');

        sidebarHide();
    });

    function getView(action, date) {
        $('#view').html(loading);

        $.ajax({
            url: '/dashboard/appointment/view',
            type:'get',
            dataType:'json',
            data:{
                'date': date,
                'action': action
            },
            success:function(res){
                $('#view').html(res.view);
            },
            error: function(err) {
                $('#view').html(noData);
            }
        });
    }

    function sidebarShow(id) {
        $('#list').css('margin-right', '360px');
        $('.address-row').toggle();
        $('.sidebar').css('display', 'block');
        $('.sidebar').html(loadingView);

        $.ajax({
            url: '/dashboard/appointment/profile',
            type: 'get',
            dataType: 'json',
            data: {
                id: id,
                action: 'job'
            },
            success:function(res) {
                $('.sidebar').html(res.view);
            },
            error: function(err) {
                $('.sidebar').html(errorView);
            }
        });
    }

    function sidebarHide() {
        $('#list').css('margin-right', '0');
        $('.address-row').toggle();
        $('.sidebar').css('display', 'none');
    }
</script>
@endsection