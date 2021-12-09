@extends('layouts.admin')

@section('page-header-right')
    
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <form action="" method="post" enctype="multipart/form-data"> @csrf
                @if($data->count())
                    <table class="table table-bordered admin-categories-list">
                        <thead>
                        <tr>
                            <td>Sl</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Phone</td>
                            <td>Subject</td>
                            <td>Message</td>

                        </tr>

                        </thead>

                        <tbody>
                        @foreach($data as $key =>$contact)
                           <tr>
                               <td>{{$key+1}}</td>
                               <td>{{$contact->name}}</td>
                               <td>{{$contact->email}}</td>
                               <td>{{$contact->phone}}</td>
                               <td>{{$contact->subject}}</td>
                               <td>{{$contact->message}}</td>

                           </tr>
                        @endforeach
                        </tbody>


                    </table>

                @else

                    {!! no_data() !!}

                @endif

            </form>

          

        </div>

    </div>


@endsection


@section('page-js')
    <script type="text/javascript">
        $(document).on('click', '.btn_delete', function(e){
            e.preventDefault();

            var checked_values = [];
            $('.category_check:checked').each(function(index){
                checked_values.push(this.value);
            });

            if (checked_values.length){
                if ( ! confirm('@lang('admin.deleting_confirm')')){
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route('delete_category')}}',
                    data: { categories: checked_values, _token: pageData.csrf_token},
                    success: function(data){
                        if (data.success){
                            window.location.reload(true);
                        }
                    }
                });
            }
        });

        $(document).on('change', '#category_check_all', function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
