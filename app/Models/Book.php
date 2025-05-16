<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'registry_number',
        'genre_id',
        'status'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
