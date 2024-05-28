<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/jpg" href="{{ asset('img/ico.png?v2') }}" />
    <uses-permission android:name="android.permission.INTERNET" />
    <uses-permission android:name="android.permission.CAMERA" />
    <title>@yield('title') Valparaiso</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <!--<script src="https://kit.fontawesome.com/a985f22f2f.js" crossorigin="anonymous"></script>-->
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    @yield('page_css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css?v61') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css') }}">
    @yield('page_css')

    @yield('css')
</head>

<body {{-- class="sidebar-mini" --}}>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar" style="background-color: #ed5a14">
                @include('layouts.header')

            </nav>
            <div class="main-sidebar main-sidebar-postion">
                @include('layouts.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <footer class="main-footer">
                @include('layouts.footer')
            </footer>
        </div>
    </div>

    @include('profile.change_password')
    @include('profile.edit_profile')

</body>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/profile.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('js/searchController.js') }}"></script>

<script src="{{ asset('js/filesaver.js') }}"></script>
<script src="{{ asset('js/html2canvas.js') }}"></script>
@yield('page_js')
@yield('scripts')
<script>
    const loading = () => {
        Swal.fire({
            title: 'Cargando...',
            text: 'Espere por favor...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    }
    let loggedInUser = @json(\Illuminate\Support\Facades\Auth::user());
    let loginUrl = '{{ route('login') }}';
    const userUrl = '{{ url('users') }}';
    // Loading button plugin (removed from BS4)
    (function($) {
        $.fn.button = function(action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
    const show_list = item => (item.removeClass("hide"), item.addClass("show"));
    const hide_list = item => (item.removeClass("show"), item.addClass("hide"),
        setTimeout(() => item.removeClass("hide"), 400));
    const hide_glist = item => item.removeClass("show");
    const item = (id, val = false) => (val == false ? id.parent("li").children(".list-items") : id.hasClass("show"));
    $('.nav-link').click(function() {
        const glist = item($('.nav-link')),
            list = item($(this)),
            gval = item(glist, true),
            val = item(list, true);
        val ? (hide_list(list), hide_glist($(this))) : (gval ? (hide_glist(glist), show_list(list),
            hide_glist($('.nav-link')), show_list($(this))) : (show_list(list), show_list($(this))));
    });
</script>

</html>
