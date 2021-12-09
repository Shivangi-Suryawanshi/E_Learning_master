<nav id="sidebar" class="sidebar">
    <div class="sidebar-user">
       @if( Auth::user()->user_type != "admin")
       @if(Auth::user()->profile_pic != null )
       <img src="{!! asset('uploads/company_logos/'.Auth::user()->profile_pic) !!}" class="avatar rounded-circle" alt="Avatar image">

       @else 
       <img src="{{asset('users/assets/avatars/1.jpg')}}" class="avatar rounded-circle" alt="Avatar image">

       @endif


       <div>
          <span class="user-name">@if(Auth::check()) {{ ucwords(Auth::user()->name) }} @endif</span>
          <a href="{{ URL::to('company/profile')}}" target="_blank"><span class="badge badge-dark">
            @if(Auth::user()->user_type == 'company')Company Profile 
            @elseif(Auth::user()->user_type == "contractor") Contractor Profile  @else Project Manager @endif</span></a>
       </div>
       @endif
    </div>
   
    <ul class="sidebar-menu">
      @if(Auth::user()->verification_status == 1 && Auth::user()->profile_completion_status	 ==1 && Auth::user()->user_type != "admin")

       <li class="{{ (request()->is('company')) ? 'active current' : '' }}" >
          <a href="{{url('company')}}">
          <i class="fa fa-server" aria-hidden="true"></i>
          <span>Dashboard</span>
       
          </a>
       </li>
       <li class="">
         <a href="#!">
            <i class="fa fa-user" aria-hidden="true"></i>
            <!--  Uncomment this when working -->
            <!-- <span>User Management</span> -->
            <!--  Uncomment this when working -->
            <!--  Remove this after development -->
            <span data-toggle="tooltip" data-placement="right" title="" >Organization Structure</span>
            <!--  Remove this after development -->
            <i class="chevron">
               <svg fill="#ffffff" viewBox="0 0 1024 1024">
                  <path class="path1" d="M256 1024c-6.552 0-13.102-2.499-18.101-7.499-9.998-9.997-9.998-26.206 0-36.203l442.698-442.698-442.698-442.699c-9.998-9.997-9.998-26.206 0-36.203s26.206-9.998 36.203 0l460.8 460.8c9.998 9.997 9.998 26.206 0 36.203l-460.8 460.8c-5 5-11.55 7.499-18.102 7.499z"></path>
               </svg>
            </i>
         </a>
         <ul class="sidebar-submenu" style="display: none;">
            <li class="{{ (request()->is('company/positions')) ? 'active current' : '' }}">
               <a href="{{ URL::to('company/positions')}}">
               Positions
               </a>
            </li>
            <li class="{{ (request()->is('company/departments')) ? 'active current' : '' }}">
               <a href="{{ URL::to('company/departments')}}">
               Departments
               </a>
            </li>
            <li class="{{ (request()->is('company/projects')) ? 'active current' : '' }}">
             <a href="{{ URL::to('company/projects')}}">
             Projects
             </a>
          </li>
          <li class="{{ (request()->is('company/workforces')) ? 'active current' : '' }}">
             <a  href="{{ URL::to('company/workforces')}}">
             Workforce
             </a>
          </li>
          @if(Auth::user()->user_type == "company")
          <li >
            <a    
            href="{{ route('sub-contractor')}}"
               >
               <i  aria-hidden="true"></i>
              
               <span data-toggle="tooltip" data-placement="right" title="" >Contractor</span>
            </a>
         </li>
         <li >
            <a    
            href="{{ route('project-manager')}}"
               >
               <i  aria-hidden="true"></i>
              
               <span data-toggle="tooltip" data-placement="right" title="" >Project Manager</span>
            </a>
         </li>
         @endif 
         </ul>
      </li>
       {{-- @endif
       @if(Auth::user()->verification_status == 1 && Auth::user()->profile_completion_status	 ==1) --}}
       {{-- <li class="">
          <a href="#!">
             <i class="fa fa-user" aria-hidden="true"></i>
             <!--  Uncomment this when working -->
             <!-- <span>User Management</span> -->
             <!--  Uncomment this when working -->
             <!--  Remove this after development -->
             <span data-toggle="tooltip" data-placement="right" title="" >User Management</span>
             <!--  Remove this after development -->
             <i class="chevron">
                <svg fill="#ffffff" viewBox="0 0 1024 1024">
                   <path class="path1" d="M256 1024c-6.552 0-13.102-2.499-18.101-7.499-9.998-9.997-9.998-26.206 0-36.203l442.698-442.698-442.698-442.699c-9.998-9.997-9.998-26.206 0-36.203s26.206-9.998 36.203 0l460.8 460.8c9.998 9.997 9.998 26.206 0 36.203l-460.8 460.8c-5 5-11.55 7.499-18.102 7.499z"></path>
                </svg>
             </i>
          </a> --}}
          {{-- <ul class="sidebar-submenu {{ (request()->segment(2) == 'company/workforces') ? 'active' : '' }}" style="display: none;">
             <li class="{{ (request()->is('company/workforces')) ? 'active current' : '' }}">
                <a  href="{{ URL::to('company/workforces')}}">
                Workforce
                </a>
             </li>
             @if(Auth::user()->user_type == "company")
             <li >
               <a    
               href="{{ route('sub-contractor')}}"
               
                  >
                  <i  aria-hidden="true"></i>
                 
                  <span data-toggle="tooltip" data-placement="right" title="" >Contractor</span>
               </a>
            </li>
            @endif
          </ul> --}}
       {{-- </li> --}}
       <li class="">
          <a href="#!">
             <i class="fa fa-book" aria-hidden="true"></i>
             <!--  Uncomment this when working -->
             <!--   <span>Course Management</span> -->
             <!--  Uncomment this when working -->
             <!--  Remove this after development -->
             <span data-toggle="tooltip" data-placement="right" title="" >Course Management</span>
             <!--  Remove this after development -->
             <i class="chevron">
                <svg fill="#ffffff" viewBox="0 0 1024 1024">
                   <path class="path1" d="M256 1024c-6.552 0-13.102-2.499-18.101-7.499-9.998-9.997-9.998-26.206 0-36.203l442.698-442.698-442.698-442.699c-9.998-9.997-9.998-26.206 0-36.203s26.206-9.998 36.203 0l460.8 460.8c9.998 9.997 9.998 26.206 0 36.203l-460.8 460.8c-5 5-11.55 7.499-18.102 7.499z"></path>
                </svg>
             </i>
          </a>
          <ul class="sidebar-submenu" style="display: none;">
         
            <li class="{{ (request()->is('company/search-courses')) ? 'active current' : '' }}">
               <a href="{{ route('search-courses')}}">
                 <span data-toggle="tooltip" data-placement="right" title="">Search Courses</span>

               </a>
            </li>
            
             <li class="{{ (request()->is('company/purchased-courses')) ? 'active current' : '' }}"> 
                <a href="{{ route('purchased-courses')}}" >
                  <span data-toggle="tooltip" data-placement="right" title="">Purchased Courses</span>

                </a>
             </li>
             <li class="{{ (request()->is('company/enrolled-courses')) ? 'active current' : '' }}"> 
               <a href="{{ route('company-enrolled-course')}}" >
                 <span data-toggle="tooltip" data-placement="right" title="">Enrolled Courses</span>

               </a>
            </li>
             <li>
                <a href="{{ route('certificate-view')}}">
                  <span data-toggle="tooltip" data-placement="right" title="" >Certificates</span>

                </a>
             </li>
             <li>
                <a href="{{route('exam-result')}}">
                  <span data-toggle="tooltip" data-placement="right" title="" >Exam Results</span>

                </a>
             </li>
          </ul>
       </li>
       <li>
          <a href="#!">
             <i class="fa fa-cube" aria-hidden="true"></i>
             <!--  Uncomment this when working -->
             <!--  <span>Notifications</span> -->
             <!--  Uncomment this when working -->
             <!--  Remove this after development -->
             <span data-toggle="tooltip" data-placement="right" title="" >Training Matrix</span>
             <!--  Remove this after development -->
             <i class="chevron">
                <svg fill="#ffffff" viewBox="0 0 1024 1024">
                   <path class="path1" d="M256 1024c-6.552 0-13.102-2.499-18.101-7.499-9.998-9.997-9.998-26.206 0-36.203l442.698-442.698-442.698-442.699c-9.998-9.997-9.998-26.206 0-36.203s26.206-9.998 36.203 0l460.8 460.8c9.998 9.997 9.998 26.206 0 36.203l-460.8 460.8c-5 5-11.55 7.499-18.102 7.499z"></path>
                </svg>
             </i>
          </a>
          <ul class="sidebar-submenu" style="display: none;">
            <li class="{{ (request()->is('company/training-matrix-structure')) ? 'active current' : '' }}">
               <a href="{{ URL::to('company/training-matrix-structure')}}">
                  Training Matrix Structure
               </a>
            </li>
            <li class="{{ (request()->is('company/training-matrix')) ? 'active current' : '' }}">
               <a href="{{ URL::to('company/training-matrix')}}">
               Training Matrix
               </a>
            </li>
         </ul>
       </li>
        {{-- <li class="{{ (request()->is('company/graphs')) ? 'active current' : '' }}">
          <a href="{{ URL::to('company/graphs') }}">
             <i class="fa fa-database" aria-hidden="true"></i>
               <span data-toggle="tooltip" data-placement="right" title="" >Graphs</span>           
          </a>
       </li> --}}
{{--       <li>--}}
{{--          <a href="#!">--}}
{{--             <i class="fa fa-database" aria-hidden="true"></i>--}}
{{--             <!--  Remove this after development -->--}}
{{--             <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Work in Progress">Projects</span>--}}
{{--             <!--  Remove this after development -->--}}
{{--             <!--  <span>Projects</span>  -->--}}
{{--          </a>--}}
{{--       </li>--}}
{{--       <li>--}}
{{--          <a href="#!">--}}
{{--             <i class="fa fa-address-card" aria-hidden="true"></i>--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  <span>Trainer/Training Institute View</span> -->--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  Remove this after development -->--}}
{{--             <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Work in Progress">Trainer/Training Institute View</span>--}}
{{--             <!--  Remove this after development -->--}}
{{--          </a>--}}
{{--       </li>--}}
       {{-- <li  class="{{ (request()->is('company/bidding')) ? 'active current' : '' }}">
          <a href="{{ route('bidding')}}"   >
             <i class="fa fa-cubes" aria-hidden="true"></i>
             <!--  Uncomment this when working -->
             <!--  <span>Bidding</span> -->
             <!--  Uncomment this when working -->
             <!--  Remove this after development -->
             <span data-toggle="tooltip" data-placement="right" title="" >Bidding</span>
             <!--  Remove this after development -->
          </a>
       </li> --}}
       @if(Auth::user()->user_type == "company")
       <li>
         <a href="#!">
            <i class="fa fa-cube" aria-hidden="true"></i>
            <span data-toggle="tooltip" data-placement="right" title="" >Bidding Management</span>
            <!--  Remove this after development -->
            <i class="chevron">
               <svg fill="#ffffff" viewBox="0 0 1024 1024">
                  <path class="path1" d="M256 1024c-6.552 0-13.102-2.499-18.101-7.499-9.998-9.997-9.998-26.206 0-36.203l442.698-442.698-442.698-442.699c-9.998-9.997-9.998-26.206 0-36.203s26.206-9.998 36.203 0l460.8 460.8c9.998 9.997 9.998 26.206 0 36.203l-460.8 460.8c-5 5-11.55 7.499-18.102 7.499z"></path>
               </svg>
            </i>
         </a>
         <ul class="sidebar-submenu" style="display: none;">
       <li  class="{{ (request()->is('company/bidding-list')) ? 'active current' : '' }}">
         <a href="{{ route('bidding_list')}}"   >
            <i  aria-hidden="true"></i>
            <span data-toggle="tooltip" data-placement="right" title="" >Bidding Result</span>
         </a>
      </li>
      @if(Auth::user()->user_type == "company")
      <li  class="{{ (request()->is('company/bidding-request-list')) ? 'active current' : '' }}">
         <a href="{{ route('bidding_request_list')}}"   >
            <i  aria-hidden="true"></i>
            <span data-toggle="tooltip" data-placement="right" title="" > Bidding Request from Project Manager</span>
         </a>
      </li>
      @endif
         </ul>
       </li>
       @endif
       
      @if(Auth::user()->user_type == "company")
      <li >
         <a href="{{ route('messages')}}"   >
            <i class="fa fa-cubes" aria-hidden="true"></i>
            <!--  Uncomment this when working -->
            <!--  <span>Bidding</span> -->
            <!--  Uncomment this when working -->
            <!--  Remove this after development --> 
            <span data-toggle="tooltip" data-placement="right" title="" >Message</span>
            @if(unreadMessages())   <span class='badge badge-warning float-right hide-count'> {{unreadMessages()}} </span> @endif
            <!--  Remove this after development -->
         </a>
      </li>
      @endif
{{--       <li>--}}
{{--          <a href="#!">--}}
{{--             <i class="fa fa-bell" aria-hidden="true"></i>--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  <span>Notifications</span> -->--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  Remove this after development -->--}}
{{--             <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Work in Progress">Notifications</span>--}}
{{--             <!--  Remove this after development -->--}}
{{--          </a>--}}
{{--       </li>--}}
{{--       <li>--}}
{{--          <a href="#!">--}}
{{--             <i class="fa fa-envelope" aria-hidden="true"></i>--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  <span>Message </span> -->--}}
{{--             <!--  Uncomment this when working -->--}}
{{--             <!--  Remove this after development -->--}}
{{--             <span data-toggle="tooltip" data-placement="right" title="" data-original-title="Work in Progress">Message</span>--}}
{{--             <!--  Remove this after development -->--}}
{{--          </a>--}}
{{--       </li>--}}
       
   
     <li>
      <a>
         <i class="fa fa-phone" aria-hidden="true"></i>
         <!--  Remove this after development -->
         <span data-toggle="tooltip" data-placement="right" title="" >Contact :@if(contactSupport()) {{contactSupport()->option_value}} @endif</span>
         <!--  Remove this after development -->
         <!--  <span>Projects</span>  -->
      </a>
   </li>
     <li>
      @if(contactSupport())     <a href="mailto:{{contactSupport()->option_value}}?Subject=neew%20support" class="btn btn-primary" style="font-size:smaller;"target="_blank" > Support </a> @endif
     </li>
     
     @endif

    </ul>
    <hr>
 </nav>
 <!-- / Sidebar -->
