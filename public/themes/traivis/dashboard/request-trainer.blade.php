
{{-- {{dd($courseSlug)}} --}}
@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('request_by_training_center')}} </h4>
       
    </div>

    @if(count($requestTrainer) > 0)
        <table class="table table-bordered bg-white">

            <tr>
                <th>Sl</th>
                <th>{{__t('training_center')}}</th>
                <th>{{__t('action')}}</th>
            </tr>

            @foreach($requestTrainer as $key => $requestTrainer)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
             @if($requestTrainer->Instructor)
                        <strong>{{ucwords($requestTrainer->Instructor->name)}}</strong>
                        @endif
                     
                    </td>

                    
                    <td>
                        <p class="mb-3">
                         
                            @if($requestTrainer->request_status == 1) 
                            <strong>Accepted </strong>
                            @elseif($requestTrainer->request_status == 2)
                            <strong> Rejected <strong>
                            @else
                            <a class="btn btn-success status-change" data-id="{{$requestTrainer->id}}" data-content="accept"> Accept </a>
                            <a class="btn btn-danger status-change" data-id="{{$requestTrainer->id}}" data-content="reject"> Reject </a> 
                        @endif
                        </p>
                    </td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
       
    @endif

@endsection
@section('page-js')
    <script>
        $('.status-change').on('click', function()
        {
            var id = $(this).data('id');
            var status = $(this).data('content')
            $.ajax({
                type :"post",
                url: "status-chage-training-center",
                data:{id:id,status:status, "_token": "{{ csrf_token() }}",},
                success:function(data)
                {
                     window.location.reload();
                },error:function()
                {

                }
            });
        })
    </script>
@endsection
