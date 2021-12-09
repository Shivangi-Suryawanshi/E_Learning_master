<style type="text/css">
    .card.card-products .card-footer .btn {
        padding: 5px !important;
        border-top-left-radius: 0px !important;
        border-top-right-radius: 0px !important;
    }

    .btn-block+.btn-block {
        margin-top: 0px !important;
    }

</style>
@if (count($data) > 0)
    @foreach ($data as $item)
        <div class="col-md-4 mt-24">
            <div class="card card-products shadow">
                <div class="card-img resimg">
                    <img src="{{ $item->thumbnail_url }}">
                </div>
                <div class="card-body">
                    <h6 class="product-name">{{ $item->title }}</h6>
                    <p>Provider name</p>
                    @if ($item->price_plan == 'paid')
                        <span class="product-price text-primary">$ {{ $item->sale_price }}</span>
                    @elseIf($item->price_plan == "free")
                        <span class="product-price text-primary">Free </span>

                    @endif
                </div>
                <div class="card-footer">

                    <div class="row">
                        @if (Auth::user()->user_type == 'project-manager')
                            <div class="col-md-6">
                                <button class="btn btn-block btn-primary ">Request to Buy</button>
                            </div>
                        @else
                            <div class="col-md-6">
                                <button class="btn btn-block btn-primary" data-toggle="modal"
                                    data-id="{{ $item->id }}" data-content="{{ $item->slug }}"
                                    data-price="{{ $item->cost_per_person }}" onclick="return showBuyModal(this)">Buy
                                    Now</button>
                            </div>
                        @endif
                        @if (Auth::user()->user_type == 'company' || Auth::user()->user_type == 'project-manager')
                            <div class="col-md-6">
                                @if (chkBidding($item->id, Session::get('company_id')))
                                    <span class="btn btn-block btn-warning">Waiting</span>
                                @else
                                    <span class="btn btn-block btn-warning waiting{{ $item->id }}"
                                        style="display: none">Waiting</span>

                                    <button class="btn btn-block btn-primary find-btn{{ $item->id }}"
                                        data-toggle="modal" data-id="{{ $item->id }}"
                                        onclick="return showBidModal(this)">Bid Now</button>
                                @endif
                            </div>
                        @endif
                        <div class="col-md-4" style="    position: absolute;
    top: 135px;
    left: 2px;">
                            <a href="{{ env('ASSET_URL') . ('/courses/' . $item->slug) }}" target="_blank"><button
                                    class="btn btn-danger btn-xs" data-toggle="modal" data-id="{{ $item->id }}"
                                    style="border-radius: 0px !important; font-size: 12px;">Preview</button></a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endforeach
@else
    <p> no data found</p>
@endif
