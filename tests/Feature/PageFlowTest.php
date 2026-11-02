<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageFlowTest extends TestCase
{
    public function test_halaman_login_tampil(): void
    {
        $this->get('/login')->assertOk()->assertSee('Masuk ke Dashboard');
    }

    public function test_username_diteruskan_ke_dashboard_dan_profile(): void
    {
        $this->post('/login', ['username' => 'reihan'])
            ->assertRedirect('/dashboard?username=reihan');

        $this->get('/dashboard?username=reihan')->assertOk()->assertSee('Halo, reihan');
        $this->get('/profile?username=reihan')->assertOk()->assertSee('reihan@student.unej.ac.id');
        $this->get('/pengelolaan?username=reihan')->assertOk()->assertSee('LAB-10');
    }

    public function test_halaman_dalam_menolak_tanpa_username(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/profile')->assertRedirect('/login');
        $this->get('/pengelolaan')->assertRedirect('/login');
    }

    public function test_username_terlalu_pendek_ditolak(): void
    {
        $this->from('/login')->post('/login', ['username' => 'ab'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('username');
    }

    public function test_kondisi_rusak_berat_merah_di_semua_halaman(): void
    {
        $this->get('/dashboard?username=reihan')
            ->assertSee('badge-bad">Rusak Berat', false);

        $this->get('/pengelolaan?username=reihan')
            ->assertSee('badge-bad">Rusak Berat', false)
            ->assertSee('badge-warn">Rusak Ringan', false)
            ->assertSee('badge-ok">Baik', false);
    }

    public function test_query_username_aneh_tidak_bikin_error_500(): void
    {
        // array di query string dulu bikin 500 karena masuk ke substr()
        $this->get('/profile?username[]=a')->assertRedirect('/login');
        $this->get('/dashboard?username[]=a&username[]=b')->assertRedirect('/login');

        // emoji kepanjangan dulu motong karakter di tengah byte
        $this->get('/profile?username='.str_repeat('😀', 30))
            ->assertOk()
            ->assertDontSee('�');
    }
}
