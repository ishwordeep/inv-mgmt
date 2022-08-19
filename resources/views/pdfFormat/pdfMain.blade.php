<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        .header{
            height:100px;
        }
        hr{
            border-top: 1px solid black;
        }
        .bold{
            font-weight: bold;
        }
    </style>
    @yield('styles')
</head>
<body>
    @include('pdfFormat.header')
    @yield('content')
</body>
</html>