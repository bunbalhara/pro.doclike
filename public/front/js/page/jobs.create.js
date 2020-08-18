    var windowWidth = $(window).width();

    var slideValue = 0;

    var addressComponent = {

        locality: {key:'long_name',id:'city'},

        administrative_area_level_1: {key:'long_name',id:'state'}

    };

    var latitude  = "46.2276";

    var longitude = "2.2137";

    var myLatlng = new google.maps.LatLng(latitude, longitude);

    var mapOptions = {

        zoom: 13,

        scrollwheel: false,

        mapTypeControl:false,

        zoomControl: true,

        zoomControlOptions: {

        position: google.maps.ControlPosition.LEFT_TOP

        },

        streetViewControl: false,

        mapTypeId: google.maps.MapTypeId.ROADMAP,

        center: myLatlng

    };

    map = new google.maps.Map(document.getElementById('googlemap'), mapOptions);

    var input  = document.getElementById('searchArea');

    var options = {

        componentRestrictions: {country: 'FR'}

    };

    var autocomplete  = new google.maps.places.Autocomplete(input,options);

    autocomplete.bindTo('bounds', map);

    var marker = new google.maps.Marker({

        map: map,

        anchorPoint: new google.maps.Point(0, -29)

    });

    autocomplete.addListener('place_changed', function() {

        var place = autocomplete.getPlace();

        marker.setVisible(false);

        if (!place.geometry) {

            window.alert("No details available for input: '" + place.name + "'");

            return;

        }

        var lat = place.geometry.location.lat();

        var lng = place.geometry.location.lng();

        $('input[name="latitute"]').val(lat);

        $('input[name="longitute"]').val(lng);

        if (place.geometry.viewport) {

            map.fitBounds(place.geometry.viewport);

        }

        else {

            map.setCenter(place.geometry.location);

            map.setZoom(17);  // Why 17? Because it looks good.

        }

        marker.setPosition(place.geometry.location);

        marker.setVisible(true);

        var mapCentre = map.getCenter();

        for (var i = 0; i < place.address_components.length; i++) {

            var addressType = place.address_components[i].types[0];

            if (addressComponent[addressType]) {

                var val = place.address_components[i][addressComponent[addressType].key];

                $("#"+addressComponent[addressType].id).val(val);

            }

        }

        $('.clear-area').show();

        $('.show-map').show();

    });

    $(document).on('submit', '#job_form', function(e){
        e.preventDefault();

        $('.progress-bar').css('width', '100%');

        $.ajax({
            type: 'POST',
            url: '/dashboard/jobs',
            data: new FormData(this),
            processData: false,
            cache: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    toastr.success('Successfully Created');
                    $('#job_form')[0].reset();
                    $('.fa-arrow-left').click();
                }
            }
        });
    })

    $(document).on('click', '.fa-arrow-left', function(e){
        $('.multiple-items').slick('slickPrev');
    });

    $('select[name="timeShift"]').change(function(){

        $('.start-time').val()

        var val = $(this).val();

        var min = moment().ceil(15, 'minutes').format('HH:mm');

        var max = moment(min,'HH:mm').add(3, 'hours').format('HH:mm');

        if(val == '1'){

            min = '06:00';

            max = '12:00';

        }

        else if(val == '2') {

            min = '12:00';

            max = '18:00';

        }

        else if(val == '3'){

            min = '18:00';

            max = '23:45';

        }

        $(this).closest('.tab-pane').find('.start-time').val(min)

        $(this).closest('.tab-pane').find('.end-time').val(max)

        $(this).closest('.tab-pane').find('.selected-time').html(min+' à '+max)

    })

    $('.start-time').val(moment().ceil(15, 'minutes').format('HH:mm'));

    $('.end-time').val(moment().ceil(15, 'minutes').add(3, 'hours').format('HH:mm'));

    $('.selected-time').html(moment().ceil(15, 'minutes').format('HH:mm')+' à '+moment().ceil(15, 'minutes').add(3, 'hours').format('HH:mm'))

    $('.start-time').timepicker({

        timeFormat: 'HH:mm',

        interval: 15,

        change: function(time) {

            var startTime = moment(time,'HH:mm').format('HH:mm');

            $('.end-time').timepicker('destroy');

            $('.end-time').timepicker({

                timeFormat: 'HH:mm',

                interval: 15,

                minTime: moment(time,'HH:mm').format('HH:mm'),

                maxTime: '23:45',

            });

            // the input field

            var element = $(this), text;

            // get access to this Timepicker instance

            var timepicker = element.timepicker();

            text = timepicker.format(time);

            if(startTime > '20:45'){

                var endTime = '23:45';

            }

            else{

                var endTime = moment(time,'HH:mm').add(3, 'hours').format('HH:mm');

            }

            $(this).closest('.time-row').find('.end-time').val(endTime);

            $(this).closest('.tab-pane').find('.selected-time').html(moment(time,'HH:mm').format('HH:mm')+' à '+endTime)

        }

    });

    $('.end-time').timepicker({

        timeFormat: 'HH:mm',

        interval: 15,

        maxTime: '23:45',

    });

    $('.multiple-items').slick({
        arrows: false,

        swipe: false,

        infinite: false,

        slidesToShow: 2,

        slidesToScroll: 1,

        responsive: [
            {
                breakpoint: 960,

                settings: {
                    swipe: false,

                    infinite: false,

                    slidesToShow: 1,

                    slidesToScroll: 1
                }
            }
        ]

    });

    $('.multiple-items').on('beforeChange', function(event, slick, currentSlide, nextSlide){

        slideValue = nextSlide;

        $('.progress-bar').css('width', (slideValue + 1) * 25 + '%');

    });

    $(document).on('click', '.job-btn', function(e){

        var category    = $('input[name="category"]').val();

        var subcategory = $("input[name='subcategory']:checked").val();

        if(windowWidth < 960) {

            if((slideValue == 0 && category) || (slideValue == 1 && subcategory)){

                $('.job-slider').removeClass('active');

                $('#job_slider_'+slideValue).addClass('active');

            }
                
            $('.multiple-items').slick('slickNext');

            $(this).fadeToggle();

        } else {

            if((slideValue == 0 && category && subcategory) || (slideValue == 1)){

                $('.job-slider').removeClass('active');

                $('#job_slider_'+slideValue).addClass('active');
                            
                $('.multiple-items').slick('slickNext');

                $(this).fadeToggle();
            }


        }

    });

    $(document).on('click',"input[name='subcategory']",function(){

        var subcategory = $("input[name='subcategory']:checked").val();

        if(subcategory){

            $('.next-button-row').show();

        }

        else{

            $('.next-button-row').hide();

        }

    });

    $('.prev-button').click(function(){

        $('.slick-prev').click();

    });

    $(document).on('click','.category-row',function(){

        $('.category-row').removeClass('active');

		$('.next-button-row').hide();

        $(this).addClass('active');

        $('.subcategory-container').html('<div class="text-center">loading....</div>');

        var id = $(this).data('id');

        $('input[name="category"]').val(id);

		var clst = $(this).closest('div.card');

        $.ajax({

            url:"/dashboard/jobs",

            type:'post',

            dataType:'json',

            data:{'id':id,'action':'subcategory'},

            success:function(res){

                $('.subcategory-container').html(res.html);

                if (windowWidth < 960) {
                    $('.multiple-items').slick('slickNext');
                }

				var subcategory = $("input[name='subcategory']:checked").val();

				if(subcategory){

					$('.next-button-row').show();

				}

				else{

					$('.next-button-row').hide();

				}

				if(windowWidth < 960){

					clst.find('.next-button-row').show();

				}

            }

        });

    });

    $(document).on('click','.theme-category-row',function(){

        $('.theme-category-row').removeClass('active');

		$('.next-button-row').hide();

        $(this).addClass('active');

        $('.subcategory-container').html('<div class="text-center">loading....</div>');

        var id = $(this).data('id');

        $('input[name="category"]').val(id);

        var clst = $(this).closest('div.card');

        $('#category_type img').attr('src', $(this).data('img'));

        $('#category_type').css('background', $(this).data('color'));

        $('#category_type').fadeIn();
        
        $.ajax({

            url:"/dashboard/jobs",

            type:'post',

            dataType:'json',

            data:{'id':id,'action':'subcategory'},

            success: function(res){

                $('.subcategory-container').html(res.view);

                if (windowWidth < 960) {
                    $('.multiple-items').slick('slickNext');
                }

				var subcategory = $("input[name='subcategory']:checked").val();

				if(subcategory){

					$('.next-button-row').show();

				}

				else{

					$('.next-button-row').hide();

				}

				if(windowWidth < 960){

					clst.find('.next-button-row').show();

                }
                
                $('.progress-bar').css('width', (slideValue + 1) * 25 + '%');
            }

        });

    });

    $(document).on('click','.disabled-event',function(){

        if (this.checked) {

            $(this).closest('.tab-pane').find('.time-row').removeClass('disabled');

        }

        else{

            $(this).closest('.tab-pane').find('.time-row').addClass('disabled');

        }

    });

    $(document).on('click','.change-my-location',function(){

        $('#location').val('');

        $('#location-modal').modal('show');

    });

    $(document).on('click','.change-distance',function(){

        $('#distance-modal').modal('show');

    });

    $(".mb_slider").mbSlider({

        minVal : 10,

		maxVal : 50,

        formatValue: function(val){

            $('#distance').val(val);

            $('.change-distance').html('<i class="fa fa-location-arrow" aria-hidden="true"></i> '+val+'km autour')

            return val;

        }

    });

    $(document).on('click','.clear-area',function(){

        $('#searchArea').val('');

        $(this).hide();

        $('#searchArea').focus();

    });

    $(document).on('click', 'input[name="subcategory"]', function(e){

        $('.job-btn').removeClass('disabled');

    });