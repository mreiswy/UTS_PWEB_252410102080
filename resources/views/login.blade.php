@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <section class="login-grid">
        <div class="login-intro">
            <p class="eyebrow">Laboratorium Komputer</p>
            <h1>Catat semua alat lab dalam satu tempat.</h1>
            <p class="lead">
                LabKom mencatat kondisi, jumlah, dan lokasi setiap perangkat di laboratorium
                komputer. Masuk dengan username praktikum untuk melihat ringkasan dan
                melakukan pengelolaan data.
            </p>

            <ul class="checklist">
                <li>Ringkasan jumlah unit dan kondisi alat</li>
                <li>Daftar alat yang perlu diperbaiki</li>
                <li>Pengelolaan data per kategori</li>
            </ul>
        </div>

        <div class="card login-card">
            <h2>Masuk</h2>
            <p class="muted">Tidak perlu password. Cukup username.</p>

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}"
                       placeholder="mis. reihan" autocomplete="username" autofocus>
                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-primary">Masuk ke Dashboard</button>
            </form>

            <p class="hint">Data yang tampil adalah data contoh, bukan database.</p>
        </div>
    </section>
@endsection
