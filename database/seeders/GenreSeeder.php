<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Ficção', 'Fantasia', 'Romance', 'Suspense', 'Terror'];

        foreach ($genres as $name) {
            Genre::create(['name' => $name]);
        }
    }
}
