<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Kategori;
use App\Models\Merek;

class AdminMobilTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Kategori $kategori;
    private Merek $merek;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->kategori = Kategori::create(['nama_kategori' => 'SUV', 'slug' => 'suv']);
        $this->merek = Merek::create(['nama_merek' => 'Toyota', 'slug' => 'toyota']);
    }

    public function test_admin_can_access_mobil_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/mobil');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_mobil(): void
    {
        $data = [
            'kategori_id' => $this->kategori->id,
            'merek_id' => $this->merek->id,
            'nama_mobil' => 'Honda CR-V',
            'harga' => 450000000,
            'tahun' => 2021,
            'transmisi' => 'matic',
            'bahan_bakar' => 'bensin',
            'kapasitas_mesin' => 1500,
            'kota' => 'Jakarta',
            'warna' => 'Putih',
            'kilometer' => 20000,
            'deskripsi' => 'Kondisi mulus.',
            'status' => 'tersedia',
            'is_featured' => 1,
            'bisa_nego' => 0
        ];

        $response = $this->actingAs($this->admin)->post('/admin/mobil', $data);
        
        if ($response->status() !== 302 || $response->headers->get('Location') === 'http://localhost' || $response->headers->get('Location') === url('/')) {
            $response->dumpSession();
        }

        $this->assertDatabaseHas('mobil', [
            'nama_mobil' => 'Honda CR-V',
            'is_featured' => 1
        ]);
        
        $response->assertRedirect('/admin/mobil');
    }

    public function test_admin_can_update_mobil(): void
    {
        $mobil = Mobil::create([
            'kategori_id' => $this->kategori->id,
            'merek_id' => $this->merek->id,
            'nama_mobil' => 'Old Name',
            'slug' => 'old-name',
            'kota' => 'Jakarta',
            'kapasitas_mesin' => 1500,
            'harga' => 100,
            'tahun' => 2000,
            'transmisi' => 'manual',
            'bahan_bakar' => 'bensin',
            'warna' => 'Merah',
            'kilometer' => 100,
            'deskripsi' => 'Old',
            'status' => 'tersedia'
        ]);

        $updateData = [
            'kategori_id' => $this->kategori->id,
            'merek_id' => $this->merek->id,
            'nama_mobil' => 'New Name',
            'harga' => 200,
            'tahun' => 2001,
            'kota' => 'Bandung',
            'kapasitas_mesin' => 1600,
            'transmisi' => 'matic',
            'bahan_bakar' => 'diesel',
            'warna' => 'Biru',
            'kilometer' => 200,
            'deskripsi' => 'New',
            'status' => 'terjual'
        ];

        $response = $this->actingAs($this->admin)->put('/admin/mobil/' . $mobil->id, $updateData);

        if ($response->status() !== 302 || $response->headers->get('Location') === 'http://localhost' || $response->headers->get('Location') === url('/')) {
            $response->dumpSession();
        }

        $this->assertDatabaseHas('mobil', [
            'id' => $mobil->id,
            'nama_mobil' => 'New Name',
            'status' => 'terjual'
        ]);
        
        $response->assertRedirect('/admin/mobil');
    }

    public function test_admin_can_delete_mobil(): void
    {
        $mobil = Mobil::create([
            'kategori_id' => $this->kategori->id,
            'merek_id' => $this->merek->id,
            'nama_mobil' => 'To Delete',
            'slug' => 'to-delete',
            'kota' => 'Jakarta',
            'kapasitas_mesin' => 1500,
            'harga' => 100,
            'tahun' => 2000,
            'transmisi' => 'manual',
            'bahan_bakar' => 'bensin',
            'warna' => 'Merah',
            'kilometer' => 100,
            'deskripsi' => 'Old',
            'status' => 'tersedia'
        ]);

        $response = $this->actingAs($this->admin)->from('/admin/mobil')->delete('/admin/mobil/' . $mobil->id);
        
        $this->assertSoftDeleted('mobil', [
            'id' => $mobil->id
        ]);
        
        $response->assertRedirect('/admin/mobil');
    }

    public function test_admin_can_toggle_featured_status(): void
    {
        $mobil = Mobil::create([
            'kategori_id' => $this->kategori->id,
            'merek_id' => $this->merek->id,
            'nama_mobil' => 'Test Toggle',
            'slug' => 'test-toggle',
            'kota' => 'Jakarta',
            'kapasitas_mesin' => 1500,
            'harga' => 100,
            'tahun' => 2000,
            'transmisi' => 'manual',
            'bahan_bakar' => 'bensin',
            'warna' => 'Merah',
            'kilometer' => 100,
            'deskripsi' => 'Old',
            'status' => 'tersedia',
            'is_featured' => 0
        ]);

        $response = $this->actingAs($this->admin)->from('/admin/mobil')->post("/admin/mobil/{$mobil->id}/toggle-featured");
        
        $this->assertDatabaseHas('mobil', [
            'id' => $mobil->id,
            'is_featured' => 1
        ]);
        
        $response->assertRedirect('/admin/mobil');
    }
}
