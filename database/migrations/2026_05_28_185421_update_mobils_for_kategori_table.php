<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('merek_id')->constrained('kategoris')->onDelete('restrict');
        });

        // Migrate existing data
        $mobils = \Illuminate\Support\Facades\DB::table('mobil')->get();
        foreach ($mobils as $mobil) {
            $kategoriStr = $mobil->kategori;
            $kategoriId = null;
            if ($kategoriStr) {
                $kategori = \Illuminate\Support\Facades\DB::table('kategoris')->where('nama_kategori', $kategoriStr)->first();
                if (!$kategori) {
                    $kategoriId = \Illuminate\Support\Facades\DB::table('kategoris')->insertGetId([
                        'nama_kategori' => $kategoriStr,
                        'slug' => \Illuminate\Support\Str::slug($kategoriStr),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $kategoriId = $kategori->id;
                }
            }
            if ($kategoriId) {
                \Illuminate\Support\Facades\DB::table('mobil')->where('id', $mobil->id)->update(['kategori_id' => $kategoriId]);
            }
        }

        Schema::table('mobil', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobil', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('merek_id');
        });

        $mobils = \Illuminate\Support\Facades\DB::table('mobil')->get();
        foreach ($mobils as $mobil) {
            if ($mobil->kategori_id) {
                $kategori = \Illuminate\Support\Facades\DB::table('kategoris')->where('id', $mobil->kategori_id)->first();
                if ($kategori) {
                    \Illuminate\Support\Facades\DB::table('mobil')->where('id', $mobil->id)->update(['kategori' => $kategori->nama_kategori]);
                }
            }
        }

        Schema::table('mobil', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
