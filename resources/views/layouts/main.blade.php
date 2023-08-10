<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category CRUD | @yield('title')</title>
    @include('layouts.head')
</head>

<body>
    <div class="container mt-5">
        @include('layouts.message')
        @yield('content')
    </div>
    @include('layouts.footer')
</body>

</html>
