<!DOCTYPE html>
<html>

    <head>
        @include('web.includes.head')
    </head>

    <body class="fixed-left">
        <div class="page-content">
        @include('web.includes.header')

        @yield('content')

        @include('web.includes.footer')
        @include('web.includes.initialize')
        
        @include('web.includes.foot')
        </div>
    </body>


</html>
