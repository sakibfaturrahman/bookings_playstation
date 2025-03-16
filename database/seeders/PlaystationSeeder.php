<?php

namespace Database\Seeders;

use App\Models\Playstation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlaystationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Playstation::create([
            'name' => 'PS 4',
            'harga_sewa' => 30000, 
            'deskripsi' => 'PlayStation 4 dengan berbagai game seru.',
            'gambar' => 'img-1742095857.jpg',
        ]);

        Playstation::create([
            'name' => 'PS 5',
            'harga_sewa' => 40000, 
            'deskripsi' => 'PlayStation 5 dengan grafis terbaik.',
            'gambar' => 'img-1742019028.jpg',
        ]);
    }
}
