<?php

namespace App\Observers;

use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class GenreObserver
{
    public function created(Genre $genre)
    {
        Log::info('Genre created', [
            'id' => $genre->id,
            'name' => $genre->name,
        ]);
    }

    public function updated(Genre $genre)
    {
        Log::info('Genre updated', [
            'id' => $genre->id,
            'name' => $genre->name,
        ]);
    }

    public function deleted(Genre $genre)
    {
        Log::warning('Genre deleted', [
            'id' => $genre->id,
            'name' => $genre->name,
        ]);
    }
}
