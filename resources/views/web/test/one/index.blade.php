<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link href="{{asset('assets/plugins/jquery-mobile/css/jquery.mobile-1.4.5.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('assets/plugins/jquery-mobile/js/jquery.mobile-1.4.5.min.js') }}" type="text/javascript"></script>
    <title>Document</title>

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .MainClass{
            width: 100%;
            height: 100vh;
            background-color: aquamarine;
        }
    </style>
</head>
<body>
    <div class="MainClass"></div>
</body>
<script>
    $(document).ready(function(){
        $(document).on("pagebeforeload", function( event ) {
            alert('a');
        });
        $(document).on("swipeleft", function( event ) {
            alert('b');
        });
    });
</script>
</html>