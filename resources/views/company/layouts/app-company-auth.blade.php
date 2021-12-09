<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>Train Eaze - Login</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" type="image/png" href="{{asset('users/assets/favicon.png')}}">
        <link rel="apple-touch-icon" href="{{asset('users/assets/apple-touch-icon.png')}}">

        <link rel="stylesheet" href="{{asset('users/css/vendor.css')}}">
        <link rel="stylesheet" href="{{asset('users/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('users/layouts/layout-1/css/app.css')}}">
        <link rel="stylesheet" href="{{asset('users/css/auth.css')}}">

            <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"/>
        <!-- Dosis & Poppins Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;523;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
        <script type="text/javascript">
         var COMPANY_URL = location.origin+"/";
         
        </script>

    </head>
    <body>
      @yield('content')
    <script src="{{asset('users/js/vendor.js')}}"></script>
    <script src="{{asset('users/js/app.js')}}"></script>
    @yield('additional_scripts')

    </body>
</html>
