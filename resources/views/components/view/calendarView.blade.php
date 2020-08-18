<div class="timeline__content swiper-wrapper">
@foreach ($date as $day)
<div class="timeline__slide swiper-slide">
    <div class="timeline__header">
        <span class="timeline__header-day">{{date('d', strtotime($day))}}</span>
        <span class="timeline__header-month">{{date('D', strtotime($day))}}</span>

        @if ($day == date('Y-m-d'))
        <div class="timeline__header-todaybg"></div>
        <div class="timeline__header-today">TODAY</div>
        @endif
    </div>

    <div class="timeline__grid scrollbar-macosx">

        @if ($appData->where('applied_date', $day)->count())

            @foreach ($appData->where('applied_date', $day) as $app)
                
                @if (auth()->user()->user_type == 3)

                    @if (($app->appointment->status == 1 && $app->status == 1) || ($app->appointment->status == 0 && $app->status == 0))
                    <div class="timeline__row">
                        <div class="timeline__hour">{{date('g', strtotime($app->applied_time))}} <span>{{date('A', strtotime($app->applied_time))}}</span></div>
                        <div class="timeline__details {{$app->status == 0 ? 'timeline__details--red' : 'timeline__details--green'}}">
                            <h3 class="timeline__user">{{$app->doctor->name}}</h3>
                            <div class="timeline__time">{{date('g:i A', strtotime($app->applied_time))}}</div>
                            <div class="timeline__info {{$app->status == 0 ? 'timeline__info--red' : 'timeline__info--green'}}">
                                @if ($app->status == 1)
                                    Confirmed
                                @else
                                    Pending...
                                @endif
                            </div>
                            <div class="timeline__more">
                                <span class="show-more show-more--ellipsis show-more--ellipsis-vertical has-dropdown" data-dropdown="{{$app->id}}"></span>
                                <nav class="dropdown-menu dropdown-menu--content dropdown-menu--timeline" id="{{$app->id}}"> 			
                                    <ul>
                                        <li><a href="#">Cancel</a></li>
                                        <li><a href="#">Reschedule</a></li>
                                        <li><a href="#">Contact patient</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    @endif

                @else

                    <div class="timeline__row">
                        <div class="timeline__hour">{{date('g', strtotime($app->applied_time))}} <span>{{date('A', strtotime($app->applied_time))}}</span></div>
                        <div class="timeline__details {{$app->status == 0 ? 'timeline__details--blue' : ($app->status == 1 ? 'timeline__details--green' : 'timeline__details--red')}}">
                            <h3 class="timeline__user">{{$app->appointment->user->name}}</h3>
                            <div class="timeline__time">{{date('g:i A', strtotime($app->applied_time))}}</div>
                            <div class="timeline__info {{$app->status == 0 ? 'timeline__info--blue' : ($app->status == 1 ? 'timeline__info--green' : 'timeline__info--red')}}">
                                @if ($app->status == 1)
                                    Confirmed
                                @elseif ($app->status == 3)
                                    Cancelled
                                @else
                                    Pending...
                                @endif
                            </div>
                            <div class="timeline__more">
                                <span class="show-more show-more--ellipsis show-more--ellipsis-vertical has-dropdown" data-dropdown="{{$app->id}}"></span>
                                <nav class="dropdown-menu dropdown-menu--content dropdown-menu--timeline" id="{{$app->id}}"> 			
                                    <ul>
                                        <li><a href="#">Cancel</a></li>
                                        <li><a href="#">Reschedule</a></li>
                                        <li><a href="#">Contact patient</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                @endif

            @endforeach

        @else
            <p class="mt-5 text-info text-center">
                No appointments
            </p>
        @endif


    </div>
</div>
@endforeach
</div>

<script>
    // Swiper
	if (typeof Swiper == 'function') { 
		var swiper = new Swiper('.appointments', {
		  speed: 600,
		  slidesPerView: "auto",
		  spaceBetween: 0,
		  pagination: false,
		  navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		  },
		});
		
		var swipert = new Swiper('.timeline', {
		  speed: 600,
		  slidesPerView: "auto",
		  spaceBetween: 0,
		  pagination: false,
		  navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		  },
		});
	}
	
	// Custom scrollbar
	if (jQuery.isFunction(jQuery.fn.scrollbar)) {
		$('.timeline__grid').scrollbar();
	}
</script>