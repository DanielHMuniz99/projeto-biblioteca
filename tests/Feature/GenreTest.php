<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Genre;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GenreTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_genre_can_be_created()
    {
        $response = $this->post('/generos', [
            'name' => 'Romance'
        ]);

        $response->assertRedirect('/generos');
        $this->assertDatabaseHas('genres', ['name' => 'Romance']);
    }

    public function test_genre_cannot_be_deleted_if_books_exist()
    {
        $genre = Genre::create(['name' => 'Fantasia']);
        Book::create([
            'title' => 'Livro X',
            'author' => 'Autor Y',
            'registry_number' => 'LIV-001',
            'status' => 'available',
            'genre_id' => $genre->id,
        ]);

        $response = $this->delete("/generos/{$genre->id}");

        $response->assertRedirect('/generos');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('genres', ['id' => $genre->id]);
    }

    public function test_genre_can_be_deleted_if_no_books()
    {
        $genre = Genre::create(['name' => 'Suspense']);

        $response = $this->delete("/generos/{$genre->id}");

        $response->assertRedirect('/generos');
        $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
    }
}
