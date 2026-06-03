<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Setting;

class AdminSystemTest extends TestCase
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

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/settings');
        $response->assertStatus(200);
    }

    public function test_admin_can_update_settings(): void
    {
        $response = $this->actingAs($this->admin)->from('/admin/settings')->post('/admin/settings', [
            'whatsapp_number' => '628123456789',
            'whatsapp_message' => 'Halo min',
            'hero_title' => 'Juragan',
            'hero_subtitle' => 'Otomotif'
        ]);
        
        $this->assertDatabaseHas('settings', [
            'key' => 'whatsapp_number',
            'value' => '628123456789'
        ]);
        
        $response->assertRedirect('/admin/settings');
    }

    public function test_admin_can_export_booking(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/booking/export');
        
        // Cek apakah mengembalikan file download
        $response->assertHeader('Content-Disposition');
    }
}
