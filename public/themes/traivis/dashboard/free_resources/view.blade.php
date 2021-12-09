@extends('layouts.app')

@section('additional_styles')
   
  
@endsection

@section('main_content')

<div class="container"><br><br>
    <div class="page-content" id="loadData">
   <header>
      <div class="row">
         <div class="col-md-6">
            <h1 class="mb-0">Company Profile</h1>
         </div>
      </div>
   </header>

   <div class="card mt-24 card-user-profile-wide">
      <div class="row no-gutters">
         <div class="col col-avatar py-3 py-md-0">
            <div class="user-avatar-inside-svg">
               <div class="user-avatar">
                  <img src="@if(isset($basic_data->logo)){!! asset('uploads/company_logos/'.$basic_data->logo) !!} @else {!! asset('images/noimage.jpg') !!} @endif" class="avatar avatar-4 rounded-circle" alt="">
               </div>
               <svg viewBox="0 0 36 36" width="100" height="100" class="donut">
                  <circle class="donut-ring" cx="18" cy="18" r="15.91549430918952" fill="transparent" stroke="#eeeeee" stroke-width="2"></circle>
                  <circle class="donut-segment" cx="18" cy="18" r="15.91549430918952" fill="transparent" stroke="#06c48c" stroke-width="2" stroke-dasharray="70 30" stroke-dashoffset="25"></circle>
               </svg>
               <p><strong>70%</strong> of profile information provided.</p>
            </div>
         </div>
         <div class="col col-info">
            <div class="row">
               <div class="col">
                  <div class="d-inline-block mr-4">
                  <h6 class="user-fullname">@if(isset($basic_data->en_company_name)) {{ $basic_data->en_company_name}} @endif</h6>
                     <h6 class="user-name"><i class="fas fa-map-marker"></i> @if(isset($basic_data->country_name)) {{ $basic_data->country_name}} @endif</h6>
                     <h6 class="user-name">@if(isset($basic_data->address)) {{ $basic_data->address}} @endif</h6>
                  </div>
                  <a href="@{{ results.website}}" target="_blank"> <span class="badge badge-pill badge-outline-info align-top">Visit Website</span></a>
               </div>
               <div class="col col-message-btn">
                  <div class="btn-group" role="group">
                     <button type="button" class="btn btn-icon btn-secondary-light">
                     <i class="fas fa-edit"></i>
                     </button>
                  </div>
               </div>
            </div>
            <div class="row row-stats">
               <div class="col col-stats">
                  <a href="tel:@{{ results.phone}}">
                  <i class="fas fa-phone"></i> 
                 @if(isset($basic_data->phone)) {{ $basic_data->phone}} @endif
                  </a>
                  <a href="#">
                  <i class="fas fa-envelope"></i>
               @if(isset($basic_data->email))  {{ $basic_data->email}} @endif
                  </a>
               </div>
            </div>
            <div class="row mt-3">
               <div class="col">
                  <p class="text-muted mb-0"> @if(isset($basic_data->en_about_company))  {{ $basic_data->en_about_company}} @endif</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--2nd section-->
   <div class="row mt-24">
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-language" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Prefered Teaching languages </h5>
               <p class="card-text">
                  @foreach($languages as $lan)
                  {{ $lan->en_language }}            
                  @endforeach
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-building" aria-hidden="true"></i>   
            </div>
            <div class="card-body">
               <h5 class="card-title">Industry</h5>
               <p class="card-text">
                  <span v-for="industry in industries">
                    @foreach($industries as $ind)
                  {{ $ind->en_industry }}            
                  @endforeach
                  </span>
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Which positions do your company have?  </h5>
               <p class="card-text">
                  <span v-for="position in positions">
                    @if(isset($basic_data->position)) {{ $basic_data->position}} @endif
                  </span>
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-address-book-o" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Occupation</h5>
               <p class="card-text">
                  <span v-for="occupation in occupations">
                    @foreach($occupations as $occ)
                  {{ $occ->en_occupation }}            
                  @endforeach
                  </span>
               </p>
            </div>
         </div>
      </div>
      {{-- <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-graduation-cap" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Training Name </h5>
               <p class="card-text">
                  Lorem ipsum dolor sit.
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-calendar" aria-hidden="true"></i>   
            </div>
            <div class="card-body">
               <h5 class="card-title">Validity</h5>
               <p class="card-text">
                  12 Months
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-bullhorn" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Is it delivered internally or externally or both?  </h5>
               <p class="card-text">
                  Lorem ipsum dolor sit.
               </p>
            </div>
         </div>
      </div> --}}
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-credit-card-alt" aria-hidden="true"></i>   
            </div>
            <div class="card-body">
               <h5 class="card-title">Payment Details</h5>
               <p class="card-text">
                  
               </p>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-horizontal card-help-center">
            <div class="card-img">
               <i class="fa fa-envelope" aria-hidden="true"></i>
            </div>
            <div class="card-body">
               <h5 class="card-title">Newsletter Subscription </h5>
               <p class="card-text">
                  Subscribed.
               </p>
            </div>
         </div>
      </div>

   </div>
   <!-- User Profile -->
   <div class="panel panel-light h-auto">
      <div class="panel-header">
         <h1 class="panel-title">Contactable Person's More Information</h1>
      </div>
      <div class="panel-body">
         <div class="tab-content">
            <div class="tab-pane fade show active" id="user-profile-tab-1" aria-expanded="true">
               <div class="mx-auto">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="card card-horizontal card-help-center">
                           <div class="card-img">
                              <i class="fa fa-user" aria-hidden="true"></i>   
                           </div>
                           <div class="card-body">
                              <h5 class="card-title">Name</h5>
                              <p class="card-text">
                            @if(isset($basic_data->contact_first_name))   {{ $basic_data->contact_first_name}} @endif
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="card card-horizontal card-help-center">
                           <div class="card-img">
                              <i class="fa fa-suitcase" aria-hidden="true"></i>  
                           </div>
                           <div class="card-body">
                              <h5 class="card-title">Position</h5>
                              <p class="card-text">
                              @if(isset($basic_data->position))   {{ $basic_data->position}} @endif
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="card card-horizontal card-help-center">
                           <div class="card-img">
                              <i class="fa fa-user-circle-o" aria-hidden="true"></i> 
                           </div>
                           <div class="card-body">
                              <h5 class="card-title">Gender</h5>
                              <p class="card-text">
                                 @if(isset($basic_data->gender))    {{ $basic_data->gender}} @endif
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="card card-horizontal card-help-center">
                           <div class="card-img">
                              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                           </div>
                           <div class="card-body">
                              <h5 class="card-title">Date of Birth</h5>
                              <p class="card-text">
                                @if(isset($basic_data->dob))     {{ $basic_data->dob}} @endif
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- User Profile -->
</div>
</div>
@endsection

@section('additional_scripts')


    
@endsection