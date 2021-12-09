@extends('company.layouts.app-company')
@section('additional_styles')
<link rel="stylesheet" href="{{asset('users/vendor/jquery-dataTables/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')

<div class="page-content">
  <header>
     <div class="row">
        <div class="col-md-8">
           <h1 class="mb-0" id="hedn">Search for individual</h1>
        </div>



     </div>
  </header>
  <div class="panel panel-light">

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
  </div>
</div>

     
  @endsection
@section('additional_scripts')
<script>
    $('.search-trainer').on('click', function() {
        var search = $('.search-value').val();
        $.ajax({
            url: "search-indidual",
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
                url: "request-to-individual",
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