<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Mobil;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobil_belongs_to_kategori(): void
    {
        $mobil = new Mobil();
        $this->assertInstanceOf(BelongsTo::class, $mobil->kategori());
    }

    public function test_mobil_belongs_to_merek(): void
    {
        $mobil = new Mobil();
        $this->assertInstanceOf(BelongsTo::class, $mobil->merek());
    }

    public function test_mobil_has_many_bookings(): void
    {
        $mobil = new Mobil();
        $this->assertInstanceOf(HasMany::class, $mobil->bookings());
    }

    public function test_kategori_has_many_mobils(): void
    {
        $kategori = new Kategori();
        $this->assertInstanceOf(HasMany::class, $kategori->mobils());
    }

    public function test_merek_has_many_mobils(): void
    {
        $merek = new Merek();
        $this->assertInstanceOf(HasMany::class, $merek->mobils());
    }


}
