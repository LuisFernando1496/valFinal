<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">
            <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo_val.svg') }}" width="85"
                alt="Infyom Logo">
        </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ asset('img/logo_val.svg') }}" width="45px" alt="" />
        </a>
    </div>

    <ul class="sidebar-menu" style="margin-top: 20px">
        <hr>
        @include('layouts.menu')
    </ul>
</aside>
