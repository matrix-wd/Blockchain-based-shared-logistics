<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <title>共享物流平台</title>
    <style>
        html, body,#app {
            height: 100%;
        }
    </style>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>