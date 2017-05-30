<html lang="{{ config('app.locale') }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('app_title')</title>
        @section('app_css')
            <!-- Bootstrap -->
            <link href="{{ asset('controlassets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
            <!-- Font Awesome -->
            <link href="{{ asset('controlassets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
            <!-- NProgress -->
            <link href="{{ asset('controlassets/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
        @show
    </head>
    @yield('app_body')
</html>