    
<script>
    $(document).on('click', '.hide-show-toggler', function() {
        var type = $(this).data('type');
        var date = $(this).data('date');

        var item = $(this).closest('.nav-item');
        var total = item.find('.dropdown-menu').find('.justify-content-between').find('small').find('span');
        var count = Number(total.text()) - 1;
        if (count <= 0) {
            count = 0;
            item.find('a').removeClass('nav-link-notify');
        }
        total.html(count);
        $(this).remove();

        $.ajax({
            url: '/dashboard/notify/click',
            type: 'get',
            data: {type: type, date: date}
        });
    });

    $(document).on('click', '.all-read-btn', function() {
        var item = $(this).closest('.nav-item');
        item.find('.dropdown-scroll').remove();
        var total = item.find('.dropdown-menu').find('.justify-content-between').find('small').find('span');
        total.html(0);
        item.find('a').removeClass('nav-link-notify');

        $.ajax({
            url: '/dashboard/notify/readAll',
            type: 'get'
        });
    });
    // var x = document.getElementById("alertAudio"); 

    // $(document).on('click','#notification_section', function(){
    //     $.ajax({
    //         url: '/dashboard/notify/modal',
    //         type: 'get',
    //         success: function(res) {
    //             $('#notify_modal').html(res.view);
    //         },
    //         error: function(err) {console.log(err)}
    //     });
    // });    

    setInterval(function() {
        $.ajax({
            url: '/dashboard/notify/modal',
            type: 'get',
            success: function(res) {
                $('#notify_modal').html(res.notifyView);
                $('#chat_modal').html(res.chatView);
                $('#chat-list').html(res.chatListView);
                $('#unread_chat_count').html(res.chatCount);
            }
            ,error: function(err) {console.log(err)}
        });
    }, 5000);
    
    // setInterval(function() {
    //     $.ajax({
    //         url: '/dashboard/notify/video',
    //         type: 'get',
    //         success: function(res) {
    //             if (res.id) {
    //                 swal({
    //                     title: res.name,
    //                     text: "Calling ...",
    //                     imageUrl: res.image,
    //                     imageWidth: 160,
    //                     imageHeight: 160,
    //                     imageAlt: "User Photo",
    //                     imageClass: 'bg-back rounded-circle p-2',
    //                     showCancelButton: true,
    //                     cancelButtonText: '<i class="fa fa-ban font-larger" aria-hidden="true"></i>',
    //                     cancelButtonClass: 'btn btn-danger btn-lg-large btn-floating btn-pulse mx-2',
    //                     confirmButtonText: '<i class="fa fa-video-camera font-larger" aria-hidden="true"></i>',
    //                     confirmButtonClass: 'btn btn-success btn-lg-large btn-floating btn-pulse mx-2',
    //                     focusConfirm: false,
    //                 }).then(result => {
    //                     if (result.dismiss == 'cancel') {
    //                         var status = 2
    //                     } else {
    //                         var status = 1
    //                     }

    //                     $.ajax({
    //                         url: '/dashboard/notify/call',
    //                         type: 'get',
    //                         data: {id: res.id, status: status}
    //                     });

    //                     if (result.value) {
    //                         location.replace('/dashboard/video/call/' + res.jobId)
    //                     }
    //                 });
    //             }
    //         }
    //     });
    // }, 5000);

</script>