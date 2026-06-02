<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@juraganotomotif.com'],
            [
                'name' => 'Admin Juragan',
                'password' => bcrypt('admin123456'),
            ]
        );

        $this->call([
            SettingSeeder::class,
        ]);
    }
}
