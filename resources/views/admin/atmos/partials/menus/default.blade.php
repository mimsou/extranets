<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <!-- begin sidebar branding-->

        <img class="admin-brand-logo" src="{{ asset('assets/ImmigrEmploi_Blanc.png') }}" alt="" style="max-height: 30px;">

        {{-- <img class="admin-brand-logo" src="{{ asset('atmos-assets/img/logo.svg') }}" width="40" alt="atmos Logo"> --}}
        {{-- <span class="admin-brand-content"><a href="/">{{ env('APP_NAME') }}</a></span> --}}

    </div>
    <div class="admin-sidebar-wrapper js-scrollbar">
        <!-- Menu List Begins-->
        <ul class="menu">

            @yield('menu-items')

        </ul>
        <!-- Menu List Ends-->
    </div>

</aside>
<!--sidebar Ends-->
