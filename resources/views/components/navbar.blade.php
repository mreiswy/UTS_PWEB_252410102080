@props(['username' => null])

<header class="nav">
    <div class="nav-inner">
        <a class="brand" href="{{ $username ? route('dashboard', ['username' => $username]) : route('login') }}">
            @if (file_exists(public_path('images/logo.jpg')))
                <img class="brand-logo" src="{{ asset('images/logo.jpg') }}" alt="Logo LabKom">
            @else
                <span class="brand-mark">LK</span>
            @endif
            <span>
                <strong>LabKom</strong>
                <small>Inventaris Laboratorium</small>
            </span>
        </a>

        @if ($username)
            <nav class="nav-links">
                <a href="{{ route('dashboard', ['username' => $username]) }}"
                   class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('pengelolaan', ['username' => $username]) }}"
                   class="{{ request()->routeIs('pengelolaan') ? 'is-active' : '' }}">Pengelolaan</a>
                <a href="{{ route('profile', ['username' => $username]) }}"
                   class="{{ request()->routeIs('profile') ? 'is-active' : '' }}">Profil</a>
                <a class="btn btn-ghost" href="{{ route('login') }}">Keluar</a>
            </nav>
        @endif
    </div>
</header>
