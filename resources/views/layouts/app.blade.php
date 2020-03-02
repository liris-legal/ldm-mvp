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
    <!-- Hiragino Sans GB Fonts -->
    <link rel="stylesheet" href="{{asset('css/fonts.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div id="app">
        <v-app>
            <div id="app-overlay"></div>
            <app-top :authenticated-user="{{Auth::user()}}" :route-logout="'{{ route('logout') }}'"></app-top>
            <div class="clearfix"></div>
            <v-content class="content-wrapper">
                @yield('content')
                <app-modal></app-modal>
            </v-content>
            <div class="clearfix"></div>
            <app-bottom
                :route-create-lawsuit="'{{route('lawsuits.create')}}'"
                :route-create-document="'{{route('documents.create', 0)}}'"
                :route-list-type-lawsuits="'{{route('type-lawsuits.index')}}'"
            ></app-bottom>
        </v-app>
    </div>
</body>
</html>
