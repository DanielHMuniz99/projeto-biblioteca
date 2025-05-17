<?php

namespace App\Observers;

use App\Models\LibraryUser;
use Illuminate\Support\Facades\Log;

class LibraryUserObserver
{
    public function created(LibraryUser $user)
    {
        Log::info('User created', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function updated(LibraryUser $user)
    {
        Log::info('User updated', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function deleted(LibraryUser $user)
    {
        Log::warning('User deleted', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }
}
