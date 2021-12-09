$(document).ready(function() {
    var keywords = ""
    // $(".chat_list").click(function() {
        $("body").on("click", ".chat_list", function () {

           


      var receverId = $(this).data('id');
        chatList(receverId);
    });
});

function chatList(receverId) {
    
    var r_userId = receverId ;
    // alert(r_userId);
    // $(".chat_list").removeClass("active_chat");
    // $(this).addClass("active_chat");
    $.ajax({
        type: 'POST',
        url: 'get_messages',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "r_userId": r_userId
        },
        success: function(data) {
            // console.log(data.returnHTML);
            if (data.success == true) {
                $('#sendMsg').trigger("reset");
              // $('.write_msg').removeAttr("disabled"); 
                // console.log(data);
                $("#receiver_id").val(data.receiver_id);
                $("#msg_history").html(data.returnHTML);
                $('.type_msg').show()
                $('.hide-count' + r_userId).hide()
                $("html, body.down-message").animate({ scrollTop: $(document).height() }, 1000);
                // $('body,html').animate({    
                //     // scrollTop: $('.down-message').height() 
                //     scrollBottom: $('.down-message').offset().bottom
                // }, 500);
        //         var scrolled=scrolled-300;
        //     $(".down-message").animate({
        //         scrollBottom:  scrolled
        //  });
                // $('html, body').animate({
                //     scrollTop: $(".down-message").offset().down
                //  }, 500);
            //      scrolled=scrolled-300;
            //      $(".cover").animate({
            //        scrollTop:  scrolled
            //   });
              
                if(data.totalCountMsg == 0)
                {
                    $('.hide-count').hide()
                }
                else{
                    $('.hide-count').html(data.totalCountMsg)
                }
            
            } else {
                $("#receiver_id").val(data.receiver_id);
                $("#msg_history").html('');
            }

        }
    });
}
$('#sendMsg').on('submit', function(event) {
    event.preventDefault();
    let message = $('#msg').val();
    var receiver_id = $('#receiver_id').val();
    $.ajax({
        url: "send_message",
        type: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            message: message,
            receiver_id: receiver_id
        },
        success: function(response) {
          $('#sendMsg').trigger("reset");
           chatList(receiver_id) ;
            // location.reload();
        },
    });
});
$(".search-user").keyup(function() {
    var keywords = $(this).val();

    $.ajax({
        url: "search-user",
        type: "post",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            keywords: keywords
        },
        success: function(data) {
            console.log(data.returnHTML);
          $('.inbox_chat').html(data.returnHTML);
        },
        error: function(dat) {

        }
    })

});

// $('.livesearch').select2({
//     placeholder: 'Select movie',
//     ajax: {
//         url: '/search-result',
//         dataType: 'json',
//         delay: 250,
//         processResults: function(data) {
//             return {
//                 results: $.map(data, function(item) {
//                     return {
//                         text: item.name,
//                         id: item.id
//                     }
//                 })
//             };
//         },
//         cache: true
//     }
// });



