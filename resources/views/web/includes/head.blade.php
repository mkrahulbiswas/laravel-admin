<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Course Project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{config('app.name')}}</title>
<link rel="icon" type="image/x-icon" href="{{ $reqData['favIcon'] }}">

@php
    $urlArray = explode('/', url()->current());
@endphp

{{-- <link href="{{ asset('assets/web/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&amp;display=swap" rel="stylesheet">
<link href="{{ asset('assets/web/../../../../cdn.jsdelivr.net/npm/bootstrap-icons%401.7.2/font/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/web/plugins/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/web/plugins/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/web/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/web/css/dark-theme.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/sweet-alert2/css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.2.0/css/ionicons.min.css" integrity="sha256-F3Xeb7IIFr1QsWD113kV2JXaEbjhsfpgrKkwZFGIA4E=" crossorigin="anonymous" />
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" /> --}}