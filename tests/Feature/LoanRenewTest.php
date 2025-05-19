<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\Book;
use App\Models\LibraryUser;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoanRenewTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_loan_can_be_renewed()
    {
        $user = LibraryUser::create([
            'name' => 'Fulano',
            'email' => 'fulano@example.com',
            'registration_number' => 'U-1001',
        ]);

        $genre = Genre::create(['name' => 'Ficção']);

        $book = Book::create([
            'title' => 'Livro de Teste',
            'author' => 'Autor',
            'registry_number' => 'LIV-1001',
            'genre_id' => $genre->id,
            'status' => 'loaned',
        ]);

        $loan = Loan::create([
            'library_user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now()->subDays(3),
            'due_date' => now()->addDays(4),
            'status' => 'pending',
        ]);

        $response = $this->patch("/emprestimos/{$loan->id}/renovar");

        $response->assertRedirect('/emprestimos');
        $response->assertSessionHas('success', 'Empréstimo renovado com sucesso por mais 7 dias.');

        $loan->refresh();
        $this->assertEquals(
            now()->addDays(11)->toDateString(),
            $loan->due_date->toDateString()
        );
    }
}
