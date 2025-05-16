<?php

namespace App\Services;

use App\Models\Loan;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoanService
{
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

        $hasLateLoans = Loan::where('user_id', $loan->user_id)
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
}
