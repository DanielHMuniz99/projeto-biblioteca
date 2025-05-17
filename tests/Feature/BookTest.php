<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BookTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    
    public function test_user_can_create_a_book()
    {
        $genre = Genre::create(['name' => 'Ficção']);

        $response = $this->post('/livros', [
            'title' => '1984',
            'author' => 'George Orwell',
            'registry_number' => 'LIV-001',
            'status' => 'available',
            'genre_id' => $genre->id,
        ]);

        $response->assertRedirect('/livros');
        $this->assertDatabaseHas('books', ['title' => '1984']);
    }
}
