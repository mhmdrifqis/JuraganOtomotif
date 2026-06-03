<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Kategori;
use App\Models\Merek;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_booking_page(): void
    {
        $response = $this->get('/booking');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_booking_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/booking');
        $response->assertStatus(200);
    }

    public function test_user_can_submit_booking(): void
    {
        $user = User::factory()->create();

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

        $bookingData = [
            'mobil_id' => $mobil->id,
            'nama_pembeli' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'tanggal_test_drive' => now()->addDays(2)->format('Y-m-d'),
            'jam_preferred' => '09:00:00',
            'catatan' => 'Test drive hari sabtu'
        ];

        $response = $this->actingAs($user)->post('/booking', $bookingData);

        $this->assertDatabaseHas('bookings', [
            'nama_pembeli' => 'Budi Santoso',
            'mobil_id' => $mobil->id,
            'catatan' => 'Test drive hari sabtu'
        ]);

        $response->assertRedirect(); // Usually redirects to success page
    }

    public function test_user_can_view_booking_history(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/riwayat-booking');
        $response->assertStatus(200);
    }
}
