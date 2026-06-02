<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'slug', 'gambar_path'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class);
    }
}
