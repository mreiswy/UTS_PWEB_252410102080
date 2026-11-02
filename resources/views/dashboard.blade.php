@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="page-head">
        <div>
            <p class="eyebrow">Dashboard</p>
            <h1>Halo, {{ $username }}</h1>
            <p class="muted">Ringkasan inventaris laboratorium komputer per hari ini.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('pengelolaan', ['username' => $username]) }}">Kelola Data</a>
    </section>

    <section class="stats">
        <div class="card stat">
            <span class="stat-label">Jenis alat</span>
            <strong class="stat-value">{{ $jumlahJenis }}</strong>
            <span class="stat-note">tercatat di sistem</span>
        </div>
        <div class="card stat">
            <span class="stat-label">Total unit</span>
            <strong class="stat-value">{{ $totalUnit }}</strong>
            <span class="stat-note">seluruh laboratorium</span>
        </div>
        <div class="card stat">
            <span class="stat-label">Kategori</span>
            <strong class="stat-value">{{ $jumlahKategori }}</strong>
            <span class="stat-note">komputer, jaringan, dll.</span>
        </div>
        <div class="card stat">
            <span class="stat-label">Perlu perbaikan</span>
            <strong class="stat-value">{{ $jumlahPerbaikan }}</strong>
            <span class="stat-note">kondisi tidak baik</span>
        </div>
    </section>

    <div class="two-col">
        <section class="card">
            <h2>Alat perlu perbaikan</h2>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama alat</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perluPerbaikan as $alat)
                            <tr>
                                <td class="mono">{{ $alat['kode'] }}</td>
                                <td>{{ $alat['nama'] }}</td>
                                <td><span class="badge badge-{{ $alat['badge'] }}">{{ $alat['kondisi'] }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="muted">Semua alat dalam kondisi baik.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card">
            <h2>Aktivitas terakhir</h2>
            <ul class="timeline">
                @foreach ($aktivitas as $item)
                    <li>
                        <span class="timeline-time">{{ $item['waktu'] }}</span>
                        <span>{{ $item['teks'] }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
