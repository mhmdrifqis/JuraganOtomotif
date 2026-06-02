<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('merek_id')->constrained('mereks')->onDelete('cascade');
            $table->enum('kategori', ['SUV', 'MPV', 'Sedan', 'Hatchback', 'Pickup']);
            $table->string('nama_mobil'); // Avanza 1.3 G MT
            $table->bigInteger('harga'); // dalam Rupiah
            $table->boolean('bisa_nego')->default(false);
            $table->string('kota');
            $table->smallInteger('tahun');
            $table->enum('transmisi', ['manual', 'matic']);
            $table->enum('bahan_bakar', ['bensin', 'diesel', 'hybrid', 'listrik']);
            $table->integer('kapasitas_mesin'); // CC
            $table->integer('kilometer'); // Odometer
            $table->string('warna');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'terjual', 'reservasi'])->default('tersedia');
            $table->string('foto_utama')->nullable(); // path foto cover
            $table->json('foto_galeri')->nullable(); // array path foto tambahan
            $table->unsignedInteger('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
