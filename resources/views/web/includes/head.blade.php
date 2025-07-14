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
