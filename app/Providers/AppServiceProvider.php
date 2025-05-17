<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LibraryUser;
use App\Models\Genre;
use App\Observers\BookObserver;
use App\Observers\LoanObserver;
use App\Observers\LibraryUserObserver;
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
        LibraryUser::observe(LibraryUserObserver::class);
        Genre::observe(GenreObserver::class);
    }
}
