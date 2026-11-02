@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <section class="page-head">
        <div>
            <p class="eyebrow">Profil</p>
            <h1>Akun pengelola</h1>
            <p class="muted">Data akun yang sedang masuk melalui form login.</p>
        </div>
    </section>

    <div class="two-col">
        <section class="card">
            <div class="profile-head">
                <div class="avatar">{{ $inisial }}</div>
                <div>
                    <h2>{{ $namaTampil }}</h2>
                    <p class="muted">{{ $detail['Peran'] }}</p>
                </div>
            </div>

            <dl class="detail">
                @foreach ($detail as $label => $value)
                    <div class="detail-row">
                        <dt>{{ $label }}</dt>
                        <dd>{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        <section class="card">
            <h2>Hak akses</h2>
            <ul class="checklist">
                <li>Melihat ringkasan inventaris</li>
                <li>Melihat data seluruh alat</li>
                <li>Melihat daftar alat yang perlu diperbaiki</li>
            </ul>
            <p class="hint">
                Perubahan data belum tersedia karena aplikasi ini belum memakai database.
            </p>
        </section>
    </div>
@endsection
