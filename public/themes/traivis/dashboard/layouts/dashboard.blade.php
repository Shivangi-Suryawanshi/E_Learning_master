@include(theme('dashboard.layouts.components.header'))


<!-- Page Wrapper -->
<div id="wrapper">

    @include(theme('dashboard.sidebar-menu'))


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="pb20 mt55">

            <!-- Begin Page Content -->
            <div class="container-fluid">


                @include('inc.flash_msg')
                @yield('content')

            </div>
        </div>
        <!-- Main Content -->

    </div>
    <!-- Content Wrapper -->


</div>
<!-- Page Wrapper -->
@include(theme('dashboard.layouts.components.footer'))
