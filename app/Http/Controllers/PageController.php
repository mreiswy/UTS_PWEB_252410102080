<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Data inventaris. Belum pakai database (sesuai ketentuan UTS),
     * jadi sumber datanya array biasa di controller.
     */
    private function inventaris(): array
    {
        $alat = [
            ['kode' => 'LAB-01', 'nama' => 'PC Workstation Ryzen 5', 'kategori' => 'Komputer', 'jumlah' => 20, 'kondisi' => 'Baik', 'lokasi' => 'Ruang Lab A'],
            ['kode' => 'LAB-02', 'nama' => 'Monitor 24 inci', 'kategori' => 'Komputer', 'jumlah' => 20, 'kondisi' => 'Baik', 'lokasi' => 'Ruang Lab A'],
            ['kode' => 'LAB-03', 'nama' => 'Switch 24 Port', 'kategori' => 'Jaringan', 'jumlah' => 3, 'kondisi' => 'Baik', 'lokasi' => 'Rak Server'],
            ['kode' => 'LAB-04', 'nama' => 'Kabel UTP Cat6 (roll)', 'kategori' => 'Jaringan', 'jumlah' => 2, 'kondisi' => 'Rusak Ringan', 'lokasi' => 'Gudang'],
            ['kode' => 'LAB-05', 'nama' => 'Proyektor Epson', 'kategori' => 'Presentasi', 'jumlah' => 1, 'kondisi' => 'Rusak Berat', 'lokasi' => 'Ruang Lab B'],
            ['kode' => 'LAB-06', 'nama' => 'Router Mikrotik RB750', 'kategori' => 'Jaringan', 'jumlah' => 4, 'kondisi' => 'Baik', 'lokasi' => 'Rak Server'],
            ['kode' => 'LAB-07', 'nama' => 'Kursi Lipat', 'kategori' => 'Furnitur', 'jumlah' => 35, 'kondisi' => 'Baik', 'lokasi' => 'Ruang Lab A'],
            ['kode' => 'LAB-08', 'nama' => 'Meja Komputer', 'kategori' => 'Furnitur', 'jumlah' => 20, 'kondisi' => 'Rusak Ringan', 'lokasi' => 'Ruang Lab A'],
            ['kode' => 'LAB-09', 'nama' => 'Stabilizer 1000VA', 'kategori' => 'Kelistrikan', 'jumlah' => 10, 'kondisi' => 'Baik', 'lokasi' => 'Gudang'],
            ['kode' => 'LAB-10', 'nama' => 'Printer Laser Mono', 'kategori' => 'Periferal', 'jumlah' => 2, 'kondisi' => 'Baik', 'lokasi' => 'Ruang Dosen'],
        ];

        // warna badge ditentukan di sini, bukan di view, supaya kondisinya cuma satu sumber
        foreach ($alat as &$item) {
            $item['badge'] = match ($item['kondisi']) {
                'Baik' => 'ok',
                'Rusak Ringan' => 'warn',
                default => 'bad',
            };
        }

        return $alat;
    }

    public function login()
    {
        return view('login');
    }

    /**
     * Simulasi login: tidak ada pengecekan password.
     * Username diteruskan ke halaman lain lewat query string (?username=...).
     */
    public function authenticate(Request $request)
    {
        // rapikan spasi di ujung sebelum divalidasi, supaya "  a  " tetap ditolak min:3
        $username = $request->input('username');
        $request->merge(['username' => is_string($username) ? trim($username) : $username]);

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:24',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 24 karakter.',
        ]);

        return redirect()->route('dashboard', ['username' => $validated['username']]);
    }

    /**
     * Ambil username dari query string. Kalau kosong, bukan string, atau
     * kepanjangan, kembalikan null supaya pemanggil redirect ke login.
     */
    private function usernameDari(Request $request): ?string
    {
        $username = $request->query('username');

        if (! is_string($username) || trim($username) === '') {
            return null;
        }

        return mb_substr(trim($username), 0, 24);
    }

    public function dashboard(Request $request)
    {
        $username = $this->usernameDari($request);

        if ($username === null) {
            return redirect()->route('login');
        }

        $alat = $this->inventaris();
        $perluPerbaikan = array_values(array_filter($alat, fn ($item) => $item['kondisi'] !== 'Baik'));

        return view('dashboard', [
            'username' => $username,
            'jumlahJenis' => count($alat),
            'totalUnit' => array_sum(array_column($alat, 'jumlah')),
            'jumlahKategori' => count(array_unique(array_column($alat, 'kategori'))),
            'jumlahPerbaikan' => count($perluPerbaikan),
            'perluPerbaikan' => $perluPerbaikan,
            'aktivitas' => [
                ['waktu' => 'Hari ini, 08.15', 'teks' => 'Monitor LAB-02 nomor 07 diganti ke unit cadangan.'],
                ['waktu' => 'Kemarin, 15.40', 'teks' => 'Kabel UTP Cat6 dirapikan ulang di Gudang.'],
                ['waktu' => 'Kemarin, 10.05', 'teks' => 'Proyektor Lab B dilaporkan mati total.'],
                ['waktu' => '2 hari lalu, 13.20', 'teks' => 'Stok kursi lipat ditambah 5 unit.'],
            ],
        ]);
    }

    public function pengelolaan(Request $request)
    {
        $username = $this->usernameDari($request);

        if ($username === null) {
            return redirect()->route('login');
        }

        $alat = $this->inventaris();

        return view('pengelolaan', [
            'username' => $username,
            'alat' => $alat,
            'jumlahJenis' => count($alat),
            'totalUnit' => array_sum(array_column($alat, 'jumlah')),
        ]);
    }

    public function profile(Request $request)
    {
        $username = $this->usernameDari($request);

        if ($username === null) {
            return redirect()->route('login');
        }

        return view('profile', [
            'username' => $username,
            'inisial' => mb_strtoupper(mb_substr($username, 0, 2)),
            'namaTampil' => ucfirst($username),
            'detail' => [
                'Nama lengkap' => ucfirst($username),
                'NIM' => '252410102080',
                'Kelas' => 'A',
                'Peran' => 'Administrator Lab',
                'Email' => $username.'@student.unej.ac.id',
                'Terdaftar sejak' => 'September 2024',
            ],
        ]);
    }
}
