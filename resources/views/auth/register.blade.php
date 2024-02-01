<!DOCTYPE html>
<html lang="en" class="light-style  customizer-hide" dir="ltr" data-theme="theme-default" data-admin-path="../../admin/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{asset('admin/vendor/fonts/boxicons.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/vendor/fonts/fontawesome.css')}}"/>
    <link rel="stylesheet" href="{{asset("admin/vendor/fonts/flag-icons.css")}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset("admin/vendor/css/rtl/core.css")}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset("admin/vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('admin/css/demo.css')}}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>
    <link rel="stylesheet" href="{{asset("admin/vendor/libs/typeahead-js/typeahead.css")}}"/>
    <link rel="stylesheet" href="{{asset("admin/vendor/libs/apex-charts/apex-charts.css")}}"/>


    <script src="{{asset('admin/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('admin/js/config.js')}}"></script>

    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/%40form-validation/umd/styles/index.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/vendor/css/pages/page-auth.css')}}">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
</head>

<body>

<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8" style="padding: 0;">
            <div class="">
                <img src="{{asset('admin/images/login.jpg')}}" class="img-fluid" alt="Login image" style="width: 100%;height: 100%;object-fit: cover">
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
                <!-- Logo -->
                <div class="app-brand mb-5">
                    <a href="" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                <img src="{{asset('admin/images/logo4980416.png')}}" style="width: 100px">
            </span>
                    </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-2">Welcome 👋</h4>
                <p class="mb-4">Please register your account and start the work</p>

                <form id="formAuthentication" class="mb-3" action="{{ route('post.register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email">
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter your Password">
                        </div>
                    </div>
                    <button class="btn btn-primary d-grid w-100">
                        Sign up
                    </button>
                </form>

            </div>
        </div>
        <!-- /Login -->
    </div>
</div>


<script src="{{asset('admin/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('admin/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('admin/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('admin/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('admin/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('admin/vendor/js/menu.js')}}"></script>
<script src="{{asset('admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<script src="{{asset('admin/js/main.js')}}"></script>


<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('admin/vendor/libs/%40form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('admin/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('admin/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

<script src="{{asset('admin/js/pages-auth.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

    $(document).ready(function() {
        toastr.options.timeOut = 5000;
        @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('message'))
        toastr.success('{{ Session::get('message') }}');
        @elseif(Session::has('errors'))
        @foreach($errors->default->messages() as $messages)
        toastr.error(' {{$messages[0]}}');
        @endforeach
        @endif
    });
</script>
</body>
</html>

