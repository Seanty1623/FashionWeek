<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OOTD - Fashion Week')</title>
    <link rel="stylesheet" href="{{ asset('css/fashion.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield('styles')
</head>
<body>
    @include('fashion.partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('fashion.partials.footer')
    
    <script src="{{ asset('js/fashion.js') }}"></script>
    @yield('scripts')
</body>
</html>
