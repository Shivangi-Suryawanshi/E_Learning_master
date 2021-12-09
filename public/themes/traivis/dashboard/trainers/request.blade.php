{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <style>
        .mt10 {
            margin-top: 5px;
        }

        .mr10 {
            margin-right: 20px !important;
        }

    </style>

    <div class="curriculum-top-nav d-flex bg-white p-2 mb-3 border">
        <h4 class="flex-grow-1">{{ __t('request_trainer') }} </h4>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-3">
                <input type="text" class="form-control search-value search-value">

                &nbsp;
                &nbsp;
                <a class="btn btn-primary search-trainer"> Search </a>
            </div>
            <span style="color: red;font-size: 15px;" class="error">
        </div>
    </div>

    <div class="no-data-wrap text-center other-user">
        {!! no_data(null, null, 'my-5') !!}


    </div>


@endsection
@section('page-js')
    <script>
        $('.search-trainer').on('click', function() {
            var search = $('.search-value').val();
            $.ajax({
                url: "search-trainer",
                type: "post",
                data: {
                    search: search,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    // console.log(data);
                    $('.error').html("");
                    $('.other-user').html("")
                    if (data.status == true) {
                        $('.other-user').html(data.html);
                    } else {
                        $('.other-user').html(data.message);
                    }
                },
                error: function(data) {

                    var errorValue = data.responseJSON.errors.search;
                    // console.log(errorValue);
                    $('.error').html("");
                    $('.other-user').html("");
                    $('.error').html(errorValue)
                }

            })
        });

    </script>
    {{-- request instructor --}}
    <script>
        $("body").on("click", ".request-trainer", function() {
            {
                var id = $(this).data('id');
                $.ajax({
                    url: "request-to-another-trainer",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    type: "post",
                    success: function(data) {
                        if(data.status == true)
                        {
                            $('.request-success').show();
                            $('.request-trainer').hide()
                        }
                    },
                    error: function() {

                    }
                })
            }
        });

    </script>
@endsection
