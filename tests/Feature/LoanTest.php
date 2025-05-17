<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\LibraryUser;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoanTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_loan_can_be_created()
    {
        $user = LibraryUser::create([
            'name' => 'Carlos',
            'email' => 'carlos@example.com',
            'registration_number' => 'U-003',
        ]);

        $genre = Genre::create(['name' => 'Terror']);
        $book = Book::create([
            'title' => 'It',
            'author' => 'Stephen King',
            'registry_number' => 'LIV-003',
            'status' => 'available',
            'genre_id' => $genre->id,
        ]);

        $response = $this->post('/emprestimos', [
            'library_user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertRedirect('/emprestimos');
        $this->assertDatabaseHas('loans', ['library_user_id' => $user->id]);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'status' => 'loaned']);
    }
}
