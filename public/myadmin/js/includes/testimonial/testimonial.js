
function changeTestimonialStatus(e, type) {

    if (e.checked) {

        var s = "1";

    } else {
        var s = "0";

    }

    var url = "ajax/changeTestimonialStatus";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: url,
        data: { id: e.id, status: s },
        success: function (result) {

            if(result.exist == true) {
                iziToast.error({
                    title: '',
                    targetFirst: true,
                    toastOnce:true,
                    message: result.msg
                });
            }


            else if (result.s == false) {
                iziToast.error({
                    title: 'Status',
                    targetFirst: true,
                    toastOnce:true,
                    message: result.msg
                });

            }
            else {
                iziToast.success({
                    title: 'Status',
                    targetFirst: true,
                    toastOnce:true,
                    message: result.msg
                });
            }

            table.draw();

        },
        error: function (e) {
        }

    });
}

