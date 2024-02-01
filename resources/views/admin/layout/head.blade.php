<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-theme-path="../../theme/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('theme/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset("theme/vendor/fonts/flag-icons.css")}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset("theme/vendor/css/rtl/core.css")}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset("theme/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('theme/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <script src="{{asset('theme/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('theme/js/config.js')}}"></script>


    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('theme/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{asset('theme/vendor/libs/%40form-validation/umd/styles/index.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('theme/vendor/css/pages/page-auth.css')}}">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />

    @yield('style')

    <style>


        #layout-menu::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #1a202c !important;
            background: url({{asset('theme/images/layouts/sidebar-bg.png')}}) center center no-repeat;
            background-size: cover;
            background-attachment: scroll;
        }


    </style>
</head>
