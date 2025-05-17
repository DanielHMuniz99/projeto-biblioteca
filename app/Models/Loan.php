<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'start_date',
        'due_date',
        'status',
    ];   

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }    

    public function getTranslatedStatus(): string
    {
        return match ($this->status) {
            'pending' => 'Pendente',
            'returned' => 'Devolvido',
            'late' => 'Atrasado',
            default => ucfirst($this->status),
        };
    }    

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
        ];
    }    
}
