<?php

namespace App\Observers;

use App\Models\Loan;
use Illuminate\Support\Facades\Log;

class LoanObserver
{
    public function created(Loan $loan)
    {
        Log::info('Loan created', [
            'id' => $loan->id,
            'user_id' => $loan->user_id,
            'book_id' => $loan->book_id,
            'due_date' => $loan->due_date->toDateString(),
        ]);
    }

    public function updated(Loan $loan)
    {
        Log::info('Loan updated', [
            'id' => $loan->id,
            'status' => $loan->status,
        ]);
    }

    public function deleted(Loan $loan)
    {
        Log::warning('Loan deleted', [
            'id' => $loan->id,
            'user_id' => $loan->user_id,
            'book_id' => $loan->book_id,
        ]);
    }
}
