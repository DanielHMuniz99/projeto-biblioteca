<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\LibraryUser;
use App\Models\Book;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = LibraryUser::where('email', 'daniel@test.com')->first();
        $user2 = LibraryUser::where('email', 'maria@test.com')->first();

        $book1 = Book::where('registry_number', 'LIV-002')->first();
        $book2 = Book::where('registry_number', 'LIV-003')->first();

        Loan::create([
            'library_user_id' => $user1->id,
            'book_id' => $book1->id,
            'start_date' => now()->subDays(2),
            'due_date' => now()->addDays(5),
            'status' => 'pending',
        ]);

        Loan::create([
            'library_user_id' => $user2->id,
            'book_id' => $book2->id,
            'start_date' => now()->subDays(15),
            'due_date' => now()->subDays(5),
            'status' => 'late',
        ]);
    }
}
