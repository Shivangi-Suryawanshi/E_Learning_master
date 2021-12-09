@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('css/jquery.rateyo.min.css') }}">

        <!-- Search Box Layout -->
        <div class="search-overlay">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    <div class="search-overlay-layer"></div>
                    
                    <div class="search-overlay-close">
                        <span class="search-overlay-close-line"></span>
                        <span class="search-overlay-close-line"></span>
                    </div>

                    <div class="search-overlay-form">
                        <form>
                            <input type="text" class="input-search" placeholder="Search here...">
                            <button type="submit"><i class='bx bx-search-alt'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <section class="checkout-area ptb-1100">
            <div class="container">

               <div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="about-text">
                                <h3>Checkout</h3>
                                <br>
                                </div>
                                </div>
                                </div>
                                </div>


              



            </div>
            <div class="container">
                <form>
                    <div class="cart-table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Course Name</th>
                                    <th scope="col"></th>
                                    <th scope="col">Price</th>
                                    
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="product-thumbnail">
                                        <a href="#">
                                            <img src="@if($checkCourse->image){!! asset('uploads/course_images/'.$checkCourse->image) !!} @else {!! asset('images/noimage.jpg') !!} @endif" alt="item">
                                        </a>
                                    </td>

                                    <td class="product-name">
                                        <a href="{{ URL::to('/course-detail/'.$checkCourse->id) }}">{!! $checkCourse->title !!}</a>
                                    </td>

                                    <td class="product-price">
                                        <span class="unit-amount">{{ $checkCourse->cost_per_person }}</span>
                                    </td>


                                    <td class="product-subtotal">
                                        <span class="subtotal-amount"><b>{{ $checkCourse->cost_per_person }}</b></span>

                                        <a href="#" class="remove"><i class="bx bx-trash"></i></a>
                                    </td>
                                </tr>

                               
                            </tbody>
                        </table>
                    </div>

                   
                    
                </form>
            </div>
            <div class="container">
                
            <br><br>
                <form>
                    <div class="row mt10">
                        <div class="col-lg-6 col-md-12">
                            <div class="billing-details">
                                <h3 class="title">Billing Details</h3>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label>Country <span class="required">*</span></label>
                                        
                                            <div class="select-box">
                                                <select class="form-control" style="display: none;">
                                                    <option>United Arab Emirates</option>
                                                    <option>China</option>
                                                    <option>United Kingdom</option>
                                                    <option>Germany</option>
                                                    <option>France</option>
                                                    <option>Japan</option>
                                                </select><div class="nice-select form-control" tabindex="0"><span class="current">United Arab Emirates</span><ul class="list"><li data-value="United Arab Emirates" class="option selected">United Arab Emirates</li><li data-value="China" class="option">China</li><li data-value="United Kingdom" class="option">United Kingdom</li><li data-value="Germany" class="option">Germany</li><li data-value="France" class="option">France</li><li data-value="Japan" class="option">Japan</li></ul></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label>Address <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label>Town / City <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>State / County <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Postcode / Zip <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Email Address <span class="required">*</span></label>
                                            <input type="email" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="create-an-account">
                                            <label class="form-check-label" for="create-an-account">Create an account?</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="ship-different-address">
                                            <label class="form-check-label" for="ship-different-address">Ship to a different address?</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Order Notes" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="order-details">
                                <h3 class="title">Summary</h3>

                                <div class="order-table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td class="product-name">
                                                    <a href="#">{!! $checkCourse->title !!}</a>
                                                </td>

                                                <td class="product-total">
                                                    <span class="subtotal-amount">{{ $checkCourse->cost_per_person }}</span>
                                                </td>
                                            </tr>

                                          

                                       

                                         


                                            <tr>
                                                <td class="total-price">
                                                    <span>Order Total</span>
                                                </td>

                                                <td class="product-subtotal">
                                                    <span class="subtotal-amount">{{ $checkCourse->cost_per_person }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>

                                         <!------------------------------------->

                                 <div class="align-items-center cart-buttons">
                            <div>
                                <div class="shopping-coupon-code">
                                    <input type="text" class="form-control" placeholder="Voucher Discount" name="coupon-code" id="coupon-code">
                                    <button type="submit">Voucher Discount </button>
                                </div>
                            </div>

                          
                        </div>

                                 <!------------------------------------->

                                <div class="payment-box">

                                    <div class="payment-method">
                                        <p>
                                            <input type="radio" id="direct-bank-transfer" name="radio-group" checked="">
                                            <label for="direct-bank-transfer">Direct Bank Transfer</label>
    
                                            Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                                        </p>
                                        <p>
                                            <input type="radio" id="paypal" name="radio-group">
                                            <label for="paypal">PayPal</label>
                                        </p>
                                        <p>
                                            <input type="radio" id="cash-on-delivery" name="radio-group">
                                            <label for="cash-on-delivery">Cash on Delivery</label>
                                        </p>
                                    </div>
    
                                    <a href="{{ URL::to('complete-payment?ctype='.$checkCourse->id) }}" class="default-btn"><i class="bx bx-paper-plane icon-arrow before"></i><span class="label">Complete Payment</span><i class="bx bx-paper-plane icon-arrow after"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
 

@endsection
@section('additional_scripts')

@endsection