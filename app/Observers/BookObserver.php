<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookObserver
{
    public function created(Book $book)
    {
        Log::info('Book created', ['id' => $book->id, 'title' => $book->title]);
    }

    public function updated(Book $book)
    {
        Log::info('Book updated', ['id' => $book->id]);
    }

    public function deleted(Book $book)
    {
        Log::warning('Book deleted', ['id' => $book->id, 'title' => $book->title]);
    }
}
