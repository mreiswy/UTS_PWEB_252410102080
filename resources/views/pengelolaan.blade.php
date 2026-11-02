@extends('layouts.app')

@section('title', 'Pengelolaan')

@section('content')
    <section class="page-head">
        <div>
            <p class="eyebrow">Pengelolaan</p>
            <h1>Data inventaris</h1>
            <p class="muted">{{ $jumlahJenis }} jenis alat tercatat. Halaman ini hanya menampilkan data.</p>
        </div>
    </section>

    <section class="card">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama alat</th>
                        <th>Kategori</th>
                        <th class="right">Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alat as $i => $item)
                        <tr>
                            <td class="muted">{{ $i + 1 }}</td>
                            <td class="mono">{{ $item['kode'] }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td class="right">{{ $item['jumlah'] }}</td>
                            <td><span class="badge badge-{{ $item['badge'] }}">{{ $item['kondisi'] }}</span></td>
                            <td>{{ $item['lokasi'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total unit</td>
                        <td class="right">{{ $totalUnit }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection
