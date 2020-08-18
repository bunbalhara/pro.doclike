<!DOCTYPE html>
<html lang="en-US">

    <head>

        @include('components.common.head')

        @yield('head')

        @yield('style')

    </head>

    <body class="">

        @yield('preloader')

        @yield('header')

        @yield('content')

        @yield('footer')

        @yield('js')

        @yield('script')

    </body>

</html>