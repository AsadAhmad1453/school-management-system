@include('admin.layout.head')
<body>

<div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
        @include('admin.layout.sidebar')
        <div class="layout-page">
            @include('admin.layout.header')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
            </div>
            </div>
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        © <script>
                            document.write(new Date().getFullYear())

                        </script>
                        , Developed by <a href="#" target="_blank" class="footer-link fw-medium"> me</a>
                    </div>
                </div>
            </footer>
            <!-- / Footer -->


            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
</div>

<script src="{{asset('theme/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('theme/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('theme/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('theme/vendor/js/menu.js')}}"></script>

<script src="{{asset('theme/js/main.js')}}"></script>

<script src="{{asset("theme/vendor/libs/flatpickr/flatpickr.js")}}"></script>
<script src="{{asset('theme/vendor/libs/%40form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('theme/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('theme/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>

<script src="{{asset('theme/js/form-validation.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
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
@yield('script')
</body>
</html>
