@extends('company.layouts.app-company')
@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('users/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')
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

                            @if (Auth::user()->company_logos) <img
                                    src="{{ asset('uploads/company_logos') }}/@{{ results . logo }}"
                                    class="avatar avatar-4 rounded-circle" alt="">
                            @else
                                <img src="{{ asset('uploads/company_logos/avatar.png') }}"
                                    class="avatar avatar-4 rounded-circle" alt="">

                            @endif
                        </div>
                        {{-- <svg viewBox="0 0 36 36" width="100" height="100" class="donut">
                            <circle class="donut-ring" cx="18" cy="18" r="15.91549430918952" fill="transparent"
                                stroke="#eeeeee" stroke-width="2"></circle>
                            <circle class="donut-segment" cx="18" cy="18" r="15.91549430918952" fill="transparent"
                                stroke="#06c48c" stroke-width="2" stroke-dasharray="70 30" stroke-dashoffset="25"></circle>
                        </svg> --}}
                        {{-- <p><stron g>70%</strong> of profile information provided.</p> --}}
                    </div>
                </div>
                <div class="col col-info">
                    <div class="row">
                        <div class="col">
                            <div class="d-inline-block mr-4">
                                <h6 class="user-fullname">@{{ results . en_company_name }} </h6>


                            </div>
                            <a href="@{{ results . website }}" target="_blank"> <span
                                    class="badge badge-pill badge-outline-info align-top">Visit Website</span></a>
                        </div>
                        <div class="col col-message-btn">
                            <div class="btn-group" role="group">
                                <a href="{{ url('company/add-profile') }}" class="btn btn-icon btn-secondary-light">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row row-stats mtm8">
                        <div class="col col-stats">

                            <a class="user-name"><i class="fas fa-map-marker"></i> @{{ results . country_name }}</a>


                            <a href="tel:@{{ results . phone }}">
                                <i class="fas fa-phone"></i>
                                +@{{ results . phonecode }} @{{ results . phone }}
                            </a>
                            <a href="#">
                                <i class="fas fa-envelope"></i>
                                @{{ results . email }}
                            </a>

                            <a class="user-name"><i class="fas fa-building"></i> @{{ results . address }}</a>


                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <p class="text-muted mb-0 biob">@{{ results . en_about_company }}</p>
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
                            <span v-for="language in languages">
                                @{{ language . en_language }}
                            </span>
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
                                @{{ industry . en_industry }}
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
                        <h5 class="card-title">Which positions do your company have? </h5>
                        <p class="card-text">
                            <span v-for="position in positions">
                                @{{ position . position_en }}
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
                                @{{ occupation . en_occupation }},
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-6">
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
            <div class="col-md-6">
                <div class="card card-horizontal card-help-center">
                    <div class="card-img">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Subscription </h5>
                        <p class="card-text">
                            @if ($subscription)
                                @foreach ($subscription as $subscriptionItem)
                                    @if ($subscriptionItem->packages)
                                        Package : {{ ucwords($subscriptionItem->packages->title) }}
                                    @endif
                                    @if ($subscriptionItem->functionality)
                                        <br>
                                        Functionality :
                                        @foreach ($subscriptionItem->functionality as $functionality)
                                            <br>

                                            @if ($functionality->functionality)
                                                {{ $functionality->functionality->title }} =>
                                                {{ $functionality->count }}
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
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
                                                {{-- @{{ results.contact_first_name}} @{{ results.contact_last_name}} --}}
                                                {{ Auth::user()->name }}
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
                                                @{{ results . position }}
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
                                                @{{ results . gender }}


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
                                                @{{ results . dob }}
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
@endsection
@section('additional_scripts')
    <script type="text/javascript">
        var app1 = new Vue({
            el: '#loadData',
            data: {
                results: [],
                gender: '',
                positions: [],
                languages: [],
                industries: [],
                occupations: []
            },
            methods: {
                myFunctionOnLoad: function() {
                    axios.get(COMPANY_URL + 'get-profile-data').then(response => {
                        //console.log(response.data.basic_data.gender);
                        if (response.data) {
                            this.results = response.data.basic_data
                            this.positions = response.data.positions
                            this.languages = response.data.languages
                            this.industries = response.data.industries
                            this.occupations = response.data.occupations
                            var gval = response.data.basic_data.gender;

                            if (gval) {
                                switch (gval) {
                                    case "1":
                                        this.gender = "Female"
                                        break;
                                    case "2":
                                        this.gender = "Male"
                                        break;

                                    case "3":
                                        this.gender = "Other"
                                        break;

                                    case "4":
                                        this.gender = "I'd rather not say"
                                        break;

                                    default:
                                        break;
                                }
                            }
                        }
                    })
                }
            },
            created: function() {
                this.myFunctionOnLoad()
            }
        })

    </script>
@endsection
