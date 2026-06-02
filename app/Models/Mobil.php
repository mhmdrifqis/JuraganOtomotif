<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Mobil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mobil';

    protected $fillable = [
        'slug', 'merek_id', 'kategori_id', 'nama_mobil', 'harga', 'bisa_nego',
        'kota', 'tahun', 'transmisi', 'bahan_bakar', 'kapasitas_mesin',
        'kilometer', 'warna', 'deskripsi', 'status', 'foto_utama',
        'foto_galeri', 'views_count', 'is_featured',
    ];

    protected $casts = [
        'foto_galeri'  => 'array',
        'bisa_nego'    => 'boolean',
        'is_featured'  => 'boolean',
        'views_count'  => 'integer',
        'harga'        => 'integer',
        'tahun'        => 'integer',
        'kapasitas_mesin' => 'integer',
        'kilometer'    => 'integer',
    ];

    // Auto-generate slug from nama_mobil
    protected static function booted(): void
    {
        static::creating(function (Mobil $mobil) {
            if (empty($mobil->slug)) {
                $mobil->slug = static::generateUniqueSlug($mobil->nama_mobil);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::withTrashed()->where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Helper: formatted harga
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Helper: semua foto (utama + galeri)
    public function getAllFotosAttribute(): array
    {
        $all = [];
        if ($this->foto_utama) {
            $all[] = $this->foto_utama;
        }
        if ($this->foto_galeri) {
            $all = array_merge($all, $this->foto_galeri);
        }
        return $all;
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'like', "%{$search}%")
                  ->orWhereHas('merek', function($qm) use ($search) {
                      $qm->where('nama_merek', 'like', "%{$search}%");
                  })
                  ->orWhereHas('kategori', function($qk) use ($search) {
                      $qk->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        });

        $query->when($filters['merek'] ?? null, function ($q, $merek) {
            $q->whereHas('merek', function($qm) use ($merek) {
                $qm->whereIn('id', (array) $merek)->orWhereIn('slug', (array) $merek);
            });
        });

        $query->when($filters['kategori'] ?? null, function ($q, $kategori) {
            $q->whereHas('kategori', function($qk) use ($kategori) {
                $qk->whereIn('id', (array) $kategori)->orWhereIn('slug', (array) $kategori);
            });
        });

        $query->when($filters['transmisi'] ?? null, function ($q, $transmisi) {
            $q->where('transmisi', $transmisi);
        });

        $query->when($filters['bahan_bakar'] ?? null, function ($q, $bb) {
            $q->whereIn('bahan_bakar', (array) $bb);
        });

        $query->when($filters['kota'] ?? null, function ($q, $kota) {
            $q->where('kota', $kota);
        });

        $query->when($filters['harga_min'] ?? null, function ($q, $min) {
            $q->where('harga', '>=', $min);
        });

        $query->when($filters['harga_max'] ?? null, function ($q, $max) {
            $q->where('harga', '<=', $max);
        });

        $query->when($filters['tahun_min'] ?? null, function ($q, $min) {
            $q->where('tahun', '>=', $min);
        });

        $query->when($filters['tahun_max'] ?? null, function ($q, $max) {
            $q->where('tahun', '<=', $max);
        });

        $query->when($filters['warna'] ?? null, function ($q, $warna) {
            $q->whereIn('warna', (array) $warna);
        });

        return $query;
    }
}
