<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;

class DashboardService
{
    public function getDashboardData(): array
    {
        return [
            'books_total' => Book::count(),
            'books_loaned' => Book::where('status', 'loaned')->count(),
            'loans_pending' => Loan::where('status', 'pending')->count(),
            'loans_late' => Loan::where('status', 'late')->count(),
        ];
    }
}
