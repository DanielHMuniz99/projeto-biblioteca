<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Genre;
use App\Observers\BookObserver;
use App\Observers\LoanObserver;
use App\Observers\UserObserver;
use App\Observers\GenreObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Book::observe(BookObserver::class);
        Loan::observe(LoanObserver::class);
        User::observe(UserObserver::class);
        Genre::observe(GenreObserver::class);
    }
}
