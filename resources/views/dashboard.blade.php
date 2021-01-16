<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kuoz') }}</title>
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <!-- Vuetify style -->
        <link rel="stylesheet" href="{{ asset('css/vuetify.min.css') }}">
        <!-- my personal style -->
        <link rel="stylesheet" href="{{ asset('css/my.css') }}">

        <!-- this css file contains Tailwind style, do not include it because it conflicts with vuetify style -->
        <!-- Tailwind style is necessary only for all the "auth" views (login, register, etc) -->
        <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

    </head>

    <body>
        <div id="app">  
            <!-- pass current logged user to vue front-end -->
            <app :uid="{{ Auth::user()->id }}"></app>
        </div>
    </body>
</html>


