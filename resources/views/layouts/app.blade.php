<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Title -->
    <title>@yield('title', '') | {{ config('app.name', 'Liris') . ' Application'}} </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900|Material+Icons' rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <v-app id="app">
        <app-top-bar :user="{{Auth::user()}}" :route-logout="'{{ route('logout') }}'"></app-top-bar>
        <div class="clearfix"></div>
        @yield('content')
        <div class="clearfix"></div>
        <app-bottom-bar :route-create-lawsuit="'{{route('lawsuits.create')}}'"
                        :route-create-document="'{{route('documents.create', 0)}}'"
                        :route-list-type-lawsuits="'{{route('type-lawsuits.index')}}'"
        >
        </app-bottom-bar>
    </v-app>
</body>
</html>
