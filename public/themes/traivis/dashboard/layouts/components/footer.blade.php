
<footer class="sticky-footer bg-black">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span class="text-white">Copyright © Traivis 2020</span>
                    </div>
                </div>
            </footer>



<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    {{ csrf_field() }}
</form>

@if( ! auth()->check() && request()->path() != 'login')
    @include(theme('template-part.login-modal-form'))
@endif

<!-- jquery latest version -->
<script src="{{asset('assets/js/vendor/jquery-1.12.0.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

@yield('page-js')

<!-- main js -->
<script src="{{theme_asset('js/main.js')}}"></script>
<script type="text/javascript">
    var base_url    = "{{env('ASSET_URL')}}";
    
 </script>



</body>
</html>
