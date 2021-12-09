@extends(theme('dashboard.layouts.dashboard'))

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">Bidding Request </h4>

    </div>


    <table class="table table-bordered bg-white">
        @if (count($bidding) >0 )
        <tr>
            <th>Sl</th>
            <th>Course</th>
            <th>Company</th>
            <th>No.of Employee</th>
            <th>Bidding Price</th>
            <th>DeadLine</th>
            <th>Action</th>

        </tr>
       
            @foreach ($bidding as $key => $biddingRequest)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>
                        @if ($biddingRequest->biddingRequestCourse)
                            {{ $biddingRequest->biddingRequestCourse->title }}
                        @endif
                    </td>
                    <td>
                        @if ($biddingRequest->companyDetails)
                            {{ $biddingRequest->companyDetails->name }}
                        @endif
                    </td>
                    <td>{{ $biddingRequest->number_of_employees }}</td>
                    <td>{{ $biddingRequest->bidding_price }}</td>
                    <td>{{ $biddingRequest->deadline }}</td>
                    <td>
                        @if ($biddingRequest->accepatnce_status != 1)
                            <button class="btn btn-block btn-primary status-model bidding_id status-change"
                                data-id="{{ $biddingRequest->id }}" data-toggle="modal">Status</button>
                        @endif
                        @if ($biddingRequest->accepatnce_status == 1 && $biddingRequest->is_genarate_coupon == 0)
                            <button class="btn btn-block btn-primary coupon-model coupon_code"
                                data-id="{{ $biddingRequest->id }}" data-toggle="modal">Coupen Code</button>
                        @endif
                        @if ($biddingRequest->is_genarate_coupon == 1)
                            <p>Coupon Gerated</p>
                            <small>
                                @if ($biddingRequest->couponCodeCheck)
                            <a target="_blank" href="{{url('dashboard/coupons?type='.$biddingRequest->couponCodeCheck->coupon_code)}}">  <span style="color: #ec0625">{{ $biddingRequest->couponCodeCheck->coupon_code }} </span>  </a>
                                
                                   @endif
                            </small>
                        @endif
                    </td>
                </tr>
            @endforeach
            @else 
            {!! no_data(null, null, 'my-5' ) !!}
        @endif

    </table>
    {{-- status model start --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="bid-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content mdc">
                <form method="POST" enctype="multipart/form-data" id="bidcForm" @if(isset($biddingRequest)) action="{{url('dashboard/accept-bidding-request', $biddingRequest->id)}} " @endif>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header mdh">
                        <h5 class="modal-title mdh2"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                                <path
                                    d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
                            </svg>
                        </button>
                    </div>
                   {{-- {{$biddingRequest->id}} --}}
                  <input type="text" class="status-change-bidding-id" hidden @if(isset($biddingRequest)) value="{{$biddingRequest->id}}" @endif>
                    <div class="modal-body mdb bidModal">
                        <p>
                            <label>Accepted Price</label>
                            <input type="text" id="accept_price" name="accept_price"
                                class="form-control form-control-lg accept_price">
                        </p>
                        <p>
                            <label>Message</label>
                            <input type="text" id="accept_message" name="accept_message"
                                class="form-control form-control-lg accept_message">
                        </p>
                        <p>
                            <label>Document</label>
                            <input type="file" id="document" name="document"
                                class="form-control form-control-lg document">
                        </p>
                    </div>
                    <div class="modal-footer">
                        {{-- <div class="col-md-4 px-2">
                            <button type="button" class="btn my-1 btn-danger btn-block accept-delete"
                                data-dismiss="modal">Reject</button>
                        </div> --}}
                        <div class="col-md-4 px-2">
                            <input type="submit" type="button" id="accepted" data-id="1" @if(isset($biddingRequest)) data-content="{{$biddingRequest->id}}" @endif
                                class="btn my-1 btn-success btn-block acceptedd" value="Accept">
                        </div>
                        <input type="hidden" name="bid_course_id" id="bid_course_id" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- status model end --}}

    {{-- coupon model start --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="coupon-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content mdc">
                <form method="POST" enctype="multipart/form-data" id="bidForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-header mdh">
                        <h5 class="modal-title mdh2"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24" width="30" height="30">
                                <path
                                    d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body mdb bidModal">
                        <p>
                            <label>Title</label>
                            <input type="text" name="title" class="form-control form-control-lg title">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>
                        </p>
                        <p>
                            <label>Discount</label>
                            <input type="text" name="discount" class="form-control form-control-lg discount">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>

                        </p>
                        <p>
                            <label>Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control form-control-lg code">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>

                        <div class="col-md-3 landiv sub-pad  text-right">
                            <input type="button" value="Generate Code" class="btn btn-warning"
                                onclick="randomStringToInput(this)">

                        </div>
                        </p>
                        <p>
                            <label>Description</label>
                            <input type="text" name="description" class="form-control form-control-lg description">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>

                        </p>
                        <p>
                            <label>Validity From</label>
                            <input type="date" name="validity_from" class="form-control form-control-lg validity_from">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>

                        </p>
                        <p>
                            <label>Validity To</label>
                            <input type="date" name="validity_to" class="form-control form-control-lg validity_to">
                            <span class="error" style="color: #ec0625; font-size:18px;"></span>

                        </p>
                    </div>
                    <div class="modal-footer">
                        {{-- <div class="col-md-4 px-2">
                            <button type="button" class="btn my-1 btn-danger btn-block accept-delete"
                                data-dismiss="modal">Reject</button>
                        </div> --}}
                        <div class="col-md-4 px-2">
                            <button type="button" id="accepted" data-id="1" @if(isset($biddingRequest)) data-content="{{$biddingRequest->id}}" @endif
                                class="btn my-1 btn-success btn-block coupon-code-btn ">Submit</button>
                        </div>
                        <input type="hidden" name="bid_course_id" id="bid_course_id" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- coupon model end --}}
@endsection
@section('page-js')
    <script>
        $('.accept-delete').prop('disabled', true)
        $('.accept_price').on('change', function() {
            $('.accept-delete').prop('disabled', false)
        })
        $('.status-model').on('click', function() {
            $('#bid-modal').modal('show');
        })

        $('.coupon-model').on('click', function() {
            $('#coupon-modal').modal('show');
        })

    </script>
    {{-- accept bidding request --}}
    <script>
//         $('.accepted').on('click', function() {
//             var status = $(this).data('id');
//             var biddingId = $('.status-change-bidding-id').val();
//             // alert(biddingId);
//             var acceptPrice = $('.accept_price').val();
//             var acceptMessage = $('.accept_message').val();
//             var document = $('.document').prop('files')[0]; 
//             // var form_data = new FormData();    
// //   console.log(file_data);              
  
//             var url = "accept-bidding-request";
//             $.ajax({
//                 type: "post",
//                 url: url,
//                 data: {
//                     status: status,
//                     biddingId: biddingId,
//                     acceptPrice: acceptPrice,
//                     acceptMessage: acceptMessage,
//                    form_data,
                   
//                 },
//                 success: function(data) {
//                     if (data.status == true) {
//                         window.location.reload();
//                         $('.coupon_code').show();
//                     }
//                 },
//                 error: function() {
//                     alert('server error');
//                 }
//             })
//         })

    </script>
    {{-- accept end --}}
    <script>
        $('.coupon-code-btn').on('click', function() {
            //  alert('hai');
            var biddingId = $('.coupon_code').data('id');
            var title = $('.title').val();
            var discount = $('.discount').val();
            var code = $('.code').val();
            var description = $('.description').val();
            var validity_from = $('.validity_from').val();
            var validity_to = $('.validity_to').val();

            var url = "coupon-code-create";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    biddingId: biddingId,
                    title: title,
                    discount: discount,
                    coupon_code: code,
                    validity_from: validity_from,
                    validity_to: validity_to,
                    description: description,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.status == true) {
                        window.location.reload();

                    }
                },
                error: function(data) {
                    $('span.error').html('');
                    $.each(data.responseJSON.errors, function(key, value) {
                        field = $('[name="' + key + '"]');
                        field.next('span.error').html(value);
                    });

                }
            })
        });

    </script>
    {{-- coupon code genaration --}}
    <script>
        function randomStringToInput(clicked_element) {
            //  alert('hai');
            // var self = $(clicked_element);
            var random_string = generateRandomString(7);
            $('input[name=coupon_code]').val(random_string);
            //  self.remove();
        }

        function generateRandomString(string_length) {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var string = '';
            for (var i = 0; i <= string_length; i++) {
                var rand = Math.round(Math.random() * (characters.length - 1));
                var character = characters.substr(rand, 1);
                string = string + character;
            }
            return string;
        }

    </script>
    <script>
       $('.status-change').on('click', function()
       {
          var id = $(this).data('id');
        $('.status-change-bidding-id').val(id);
       })
    </script>
@endsection
