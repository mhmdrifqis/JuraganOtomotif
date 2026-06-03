<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Mobil;
use App\Models\Kategori;
use App\Models\Merek;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_beranda_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_katalog_page_can_be_rendered(): void
    {
        $response = $this->get('/katalog');
        $response->assertStatus(200);
    }

    public function test_bandingkan_page_can_be_rendered(): void
    {
        $response = $this->get('/bandingkan');
        $response->assertStatus(200);
    }

    public function test_tentang_page_can_be_rendered(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
    }

    public function test_kontak_page_can_be_rendered(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_mobil_detail_page_can_be_rendered(): void
    {
        // Setup data
        $kategori = Kategori::create(['nama_kategori' => 'SUV', 'slug' => 'suv']);
        $merek = Merek::create(['nama_merek' => 'Toyota', 'slug' => 'toyota']);

        $mobil = Mobil::create([
            'kategori_id' => $kategori->id,
            'merek_id' => $merek->id,
            'nama_mobil' => 'Toyota Fortuner',
            'slug' => 'toyota-fortuner',
            'kota' => 'Jakarta',
            'harga' => 500000000,
            'tahun' => 2020,
            'transmisi' => 'matic',
            'bahan_bakar' => 'diesel',
            'kapasitas_mesin' => 2400,
            'warna' => 'Hitam',
            'kilometer' => 50000,
            'deskripsi' => 'Mobil bagus',
            'status' => 'tersedia'
        ]);

        $response = $this->get('/mobil/' . $mobil->slug);
        $response->assertStatus(200);
        $response->assertSee('Toyota Fortuner');
    }
}
