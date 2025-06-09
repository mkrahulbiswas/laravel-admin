@php
    $urlArray = explode('/', url()->current());
    $x = 0;
    $count = 0;
    foreach ($urlArray as $key => $value) {
        $x = $value == 'admin' ? $x + 1 : $x;
        $count = $x >= 1 ? $count + 1 : 0;
    }
    $checkFor = $count >= 2 ? 'dashboardPage' : 'loginPage';
@endphp

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    @include('admin.includes.head', ['checkOne' => $checkFor])
    @yield('headStyle')
</head>

@if ($count >= 2)

    <body>
        @if (in_array('pdf', $urlArray) || in_array('print', $urlArray))
            @yield('content')
        @else
            <div id="layout-wrapper">
                @include('admin.includes.dynamic_html_css_js', [
                    'checkOne' => $checkFor,
                    'checkTwo' => 'loader',
                ])
                @include('admin.includes.header')
                @include('admin.includes.sidebar')
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid" id="container-fluid-inside" data-pageType="">
                            {{-- @include('admin.includes.dynamic_html_css_js', [
                                'checkOne' => $checkFor,
                                'checkTwo' => 'alertMessage',
                            ]) --}}
                            @yield('content')
                        </div>
                    </div>
                    @include('admin.includes.footer')
                </div>
            </div>
            @include('admin.includes.common', [
                'checkOne' => $checkFor,
                'checkTwo' => 'afterLogin',
            ])
            @include('admin.includes.foot', ['checkOne' => 'dashboardPage'])
            @include('admin.includes.dynamic_html_css_js', [
                'checkOne' => $checkFor,
                'checkTwo' => 'cssJs',
            ])
            @yield('footScripts')
        @endif
    </body>
@else

    <body>
        @include('admin.includes.dynamic_html_css_js', ['checkOne' => $checkFor, 'checkTwo' => 'loader'])
        @include('admin.includes.dynamic_html_css_js', [
            'checkOne' => $checkFor,
            'checkTwo' => 'alertMessage',
        ])
        <div class="auth-page-wrapper pt-5">
            @include('admin.includes.header')
            @yield('content')
            @include('admin.includes.footer')
        </div>
        @include('admin.includes.foot', ['checkOne' => 'loginPage'])
        @include('admin.includes.dynamic_html_css_js', [
            'checkOne' => $checkFor,
            'checkTwo' => 'cssJs',
        ])
    </body>
@endif

</html>
