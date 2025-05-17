<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $genres = Genre::all();

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'registry_number' => 'LIV-001',
            'status' => 'available',
            'genre_id' => $genres->where('name', 'Ficção')->first()->id,
        ]);

        Book::create([
            'title' => 'O Hobbit',
            'author' => 'J.R.R. Tolkien',
            'registry_number' => 'LIV-002',
            'status' => 'loaned',
            'genre_id' => $genres->where('name', 'Fantasia')->first()->id,
        ]);

        Book::create([
            'title' => 'It: A Coisa',
            'author' => 'Stephen King',
            'registry_number' => 'LIV-003',
            'status' => 'loaned',
            'genre_id' => $genres->where('name', 'Terror')->first()->id,
        ]);
    }
}
