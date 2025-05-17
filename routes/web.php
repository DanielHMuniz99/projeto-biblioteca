<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryUsersController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\LoansController;

Route::prefix('usuarios')->group(function () {
    Route::get('/', [LibraryUsersController::class, 'index'])->name('usuarios.index');
    Route::get('/create', [LibraryUsersController::class, 'create'])->name('usuarios.create');
    Route::post('/', [LibraryUsersController::class, 'store'])->name('usuarios.store');
    Route::get('/{id}/edit', [LibraryUsersController::class, 'edit'])->name('usuarios.edit');
    Route::put('/{id}', [LibraryUsersController::class, 'update'])->name('usuarios.update');
    Route::delete('/{id}', [LibraryUsersController::class, 'destroy'])->name('usuarios.destroy');
});

Route::prefix('livros')->group(function () {
    Route::get('/', [BooksController::class, 'index'])->name('livros.index');
    Route::get('/create', [BooksController::class, 'create'])->name('livros.create');
    Route::post('/', [BooksController::class, 'store'])->name('livros.store');
    Route::get('/{id}/edit', [BooksController::class, 'edit'])->name('livros.edit');
    Route::put('/{id}', [BooksController::class, 'update'])->name('livros.update');
    Route::delete('/{id}', [BooksController::class, 'destroy'])->name('livros.destroy');
});

Route::prefix('generos')->group(function () {
    Route::get('/', [GenresController::class, 'index'])->name('generos.index');
    Route::get('/create', [GenresController::class, 'create'])->name('generos.create');
    Route::post('/', [GenresController::class, 'store'])->name('generos.store');
    Route::get('/{id}/edit', [GenresController::class, 'edit'])->name('generos.edit');
    Route::put('/{id}', [GenresController::class, 'update'])->name('generos.update');
    Route::delete('/{id}', [GenresController::class, 'destroy'])->name('generos.destroy');
});

Route::prefix('emprestimos')->group(function () {
    Route::get('/', [LoansController::class, 'index'])->name('emprestimos.index');
    Route::get('/create', [LoansController::class, 'create'])->name('emprestimos.create');
    Route::post('/', [LoansController::class, 'store'])->name('emprestimos.store');
    Route::put('/{id}', [LoansController::class, 'update'])->name('emprestimos.update');
    Route::patch('/{id}/devolver', [LoansController::class, 'markAsReturned'])->name('emprestimos.markAsReturned');
    Route::patch('/{id}/atrasado', [LoansController::class, 'markAsLate'])->name('emprestimos.markAsLate');
    Route::patch('/emprestimos/{id}/renovar', [LoansController::class, 'renew'])->name('emprestimos.renew');
});
