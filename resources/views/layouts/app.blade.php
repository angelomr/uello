<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.title', 'Criação de Rotas') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        @include('layouts.menu')

        <main class="py-4 main-general">
            <div class="container-fluid">
                @include('layouts.alerts')
                @yield('content')
            </div>
        </main>
        
        <script src="{{ asset('js/app.js') }}" defer></script>

        @yield('scripts')

    </div>
</body>

</html>