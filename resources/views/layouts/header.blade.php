<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>@yield('title')</title>
    <base href="{{ asset('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" media="screen" href="{{ asset('assets/css/bootstrap.min.css') }}" />

    <!-- Google Webfont -->
    <link href='https://www.google.com/fonts#UsePlace:use/Collection:Open+Sans:400,300,400italic,600,700,800,800italic' rel='stylesheet' type='text/css'>

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/color1.css') }}" rel="stylesheet" media="screen" id="color">
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/jquery.fancybox.css') }}" rel="stylesheet">

    <!-- Font Icon -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>
