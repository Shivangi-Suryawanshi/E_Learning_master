@extends(theme('dashboard.layouts.dashboard'))

@section('content')

            
<div class="page-header">
    <h5 class="page-header-left mt5"> Company Request </h5>
    <hr>
</div>

            
            
                @if($comapanyRequest->count())
                <table class="table table-bordered bg-white table-striped">
                        <thead>
                        <tr>
                           <td>Sl</td>
                            <td><strong>{{__t('company_name')}}</strong></td>
                            <td><strong>{{__t('action')}}</strong></td>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($comapanyRequest as $key =>$requestComapny)
                          
                            <tr>
                                <td>{{$key+1}}</td>
                               <td>@if($requestComapny->companyName) {{$requestComapny->companyName->name}} @endif</td>
                               @if($requestComapny->request_status == 1)
                               <td> <p>Rejected</p> </td>
                               @elseif($requestComapny->request_status ==2)
                                <td><p>Accpted</p> </td>
                                @else
                               <td>
                                <a class="btn btn-success status-change" data-id="{{$requestComapny->id}}"  data-content="accept"> Accept </a>
                                <a class="btn btn-danger status-change" data-id="{{$requestComapny->id}}" data-content="reject"> Reject </a> 
                               </td>
                             @endif
                            </tr>
                            
                          @endforeach
                        </tbody>


                    </table>

                @else

                    {!! no_data() !!}

                @endif

           

       


@endsection

    @section('page-css')
    @endsection

@section('page-js')
 <script>
        $('.status-change').on('click', function()
        {
            var id = $(this).data('id');
            var status = $(this).data('content')
            $.ajax({
                type :"post",
                url: "status-chage-assigned-individual",
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
