<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Banner;
use Illuminate\Http\UploadedFile;

class AdminMasterDataTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    // --- Kategori Tests ---
    public function test_admin_can_create_kategori(): void
    {
        $response = $this->actingAs($this->admin)->from('/admin/kategori')->post('/admin/kategori', [
            'nama_kategori' => 'Sedan Baru',
        ]);
        
        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Sedan Baru',
        ]);
        $response->assertRedirect('/admin/kategori');
    }

    public function test_admin_can_update_kategori(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Old Kat', 'slug' => 'old-kat']);
        
        $response = $this->actingAs($this->admin)->from('/admin/kategori')->put('/admin/kategori/' . $kategori->id, [
            'nama_kategori' => 'New Kat',
        ]);
        
        $this->assertDatabaseHas('kategoris', [
            'id' => $kategori->id,
            'nama_kategori' => 'New Kat',
        ]);
    }

    // --- Merek Tests ---
    public function test_admin_can_create_merek(): void
    {
        $response = $this->actingAs($this->admin)->from('/admin/merek')->post('/admin/merek', [
            'nama_merek' => 'Honda Baru',
        ]);
        
        $this->assertDatabaseHas('mereks', [
            'nama_merek' => 'Honda Baru',
        ]);
        $response->assertRedirect('/admin/merek');
    }

    public function test_admin_can_update_merek(): void
    {
        $merek = Merek::create(['nama_merek' => 'Old Mer', 'slug' => 'old-mer']);
        
        $response = $this->actingAs($this->admin)->from('/admin/merek')->put('/admin/merek/' . $merek->id, [
            'nama_merek' => 'New Mer',
        ]);
        
        $this->assertDatabaseHas('mereks', [
            'id' => $merek->id,
            'nama_merek' => 'New Mer',
        ]);
    }

    // --- Banner Tests ---
    public function test_admin_can_create_banner(): void
    {
        $image = UploadedFile::fake()->image('banner.jpg');
        
        $response = $this->actingAs($this->admin)->from('/admin/banner')->post('/admin/banner', [
            'image' => $image,
            'title' => 'Promo Lebaran',
            'subtitle' => 'Diskon besar besaran',
            'urutan' => 1,
            'is_active' => 1
        ]);
        
        $this->assertDatabaseHas('banners', [
            'title' => 'Promo Lebaran',
            'is_active' => 1
        ]);
    }
}
