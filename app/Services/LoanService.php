<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Exception;

class LoanService
{
    /**
     * @param Loan $loan
     * 
     * @return void
     */
    public function renewLoan(Loan $loan): void
    {
        if ($loan->status !== 'pending') {
            throw ValidationException::withMessages([
                'loan' => 'Apenas empréstimos pendentes podem ser renovados.',
            ]);
        }

        if (now()->gt($loan->due_date)) {
            throw ValidationException::withMessages([
                'loan' => 'Não é possível renovar empréstimos vencidos.',
            ]);
        }

        $hasLateLoans = Loan::where('library_user_id', $loan->library_user_id)
            ->where('status', 'late')
            ->where('id', '!=', $loan->id)
            ->exists();

        if ($hasLateLoans) {
            throw ValidationException::withMessages([
                'loan' => 'O usuário possui empréstimos atrasados e não pode renovar.',
            ]);
        }

        $loan->update([
            'due_date' => $loan->due_date->addDays(7),
        ]);
    }

    /**
     * @param array $data
     * 
     * @return Loan
     */
    public function createLoan(array $data): Loan
    {
        $hasLateLoan = Loan::where('library_user_id', $data['library_user_id'])
            ->where('status', 'late')
            ->exists();

        if ($hasLateLoan) {
            throw new Exception('Este usuário possui empréstimos atrasados e não pode alugar novos livros.');
        }

        return DB::transaction(function () use ($data) {
            $loan = Loan::create([
                'library_user_id'    => $data['library_user_id'],
                'book_id'    => $data['book_id'],
                'start_date' => $data['start_date'],
                'due_date'   => $data['due_date'],
                'status'     => 'pending',
            ]);
            Book::findOrFail($data['book_id'])->update(['status' => 'loaned']);
            return $loan;
        });
    }
}
