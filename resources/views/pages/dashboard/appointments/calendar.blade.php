@extends('layouts.theme')

@section('style')
<link rel="stylesheet" href="{{asset('medikit/css/swiper.css')}}">
<link rel="stylesheet" href="{{asset('medikit/css/jquery.scrollbar.css')}}">
<link rel="stylesheet" href="{{asset('medikit/css/dashboard.min.css')}}">
<style>
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

<div class="d-flex justify-content-between align-items-center">
    <div class="page-header">
        <div>
            <h3>Appointments</h3>
            <nav aria-label="breadcrumb" class="d-flex align-items-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Appointments</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="content-subheader__options">
        <div class="content-subheader__dropdown" id="reportrange">
            <span class="content-subheader__more show-more show-more--select show-more--select-gray"></span>
        </div>
        
        <div class="content-subheader__slider-nav">
            <div class="timeline__button--next swiper-button-next"></div>
            <div class="timeline__button--prev swiper-button-prev"></div>
        </div>
    </div>
</div>

<div class="timeline position-relative"></div>
@endsection

@section('script')

{{-- <script src="{{asset('medikit/js/jquery.dashboard-custom.js')}}"></script> --}}
<script>
    /*------------------------------------------------------------------
jQuery document ready
-------------------------------------------------------------------*/
var $ = jQuery.noConflict();
$(document).ready(function () {
	"use strict";
	
	// Date picker
	if (jQuery.isFunction(jQuery.fn.daterangepicker)) {	
		
		var start = moment();
		var end = moment().subtract(-6, 'days');

		function cb(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var start_date = start.format('YYYY-MM-DD');
            var end_date = end.format('YYYY-MM-DD');

            $('.timeline').html('<div class="middle-text"><div class="d-inline-flex"><div class="spinner-border text-primary mr-2" role="status">' +
            '</div><h5 class="my-auto text-primary">loading....</h5></div></div>');

            $.ajax({
                url: '/dashboard/appointment/calendarView',
                type: 'get',
                dataType: 'json',
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success:function(res) {
                   $('.timeline').html(res.view);
                },
                error: function(err) {
                    console.log(err);
                    $('.timeline').html('<h5 class="text-center my-5 text-danger">Server Error!</h5>');
                }
            });
        }

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
			   'Next 7 Days': [moment(), moment().subtract(-6, 'days')],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);

        cb(start, end);
	}
	
	$(document).on( "click", ".has-dropdown", function(e) {
	    var dropdownid  = $(this).data("dropdown");
			if ($("#"+dropdownid).hasClass("active")){
				$("#"+dropdownid).removeClass('active');			
			}
			else {
				$(".dropdown-menu").removeClass('active');
				$("#"+dropdownid).addClass('active');
			}		
	});
	
	$(".dropdown-menu--content").hover(function(){
		$(this).addClass("hovered");
	},function(){
		$(this).removeClass("hovered");
	});
});
</script>

@endsection