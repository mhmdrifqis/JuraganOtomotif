<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Merek extends Model
{
    use HasFactory;

    protected $fillable = ['nama_merek', 'slug', 'logo_path'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_merek);
            }
        });
    }

    public function mobils()
    {
        return $this->hasMany(Mobil::class);
    }
}
