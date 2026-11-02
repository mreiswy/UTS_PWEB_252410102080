<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventaris Lab') &middot; LabKom</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <x-navbar :username="$username ?? null" />

    <main class="wrap">
        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>
