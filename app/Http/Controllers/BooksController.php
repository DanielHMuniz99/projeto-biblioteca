<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BooksController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $books = Book::with('genre')->get();
        return view('books.index', compact('books'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $genres = Genre::all();
        return view('books.form', compact('genres'));
    }

    /**
     * @param Request $request
     * 
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'registry_number' => 'required|unique:books',
            'genre_id' => 'required|exists:genres,id',
            'status' => 'in:available,loaned'
        ]);

        Book::create($request->all());
        return redirect()->route('livros.index')->with('success', 'Livro cadastrado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return View
     */
    public function edit(int $id): View
    {
        $book = Book::findOrFail($id);
        $genres = Genre::all();
        return view('books.edit', compact('book', 'genres'));
    }

    /**
     * @param Request $request
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'registry_number' => "required|unique:books,registry_number,{$id}",
            'genre_id' => 'required|exists:genres,id',
            'status' => 'in:available,loaned'
        ]);

        $book->update($request->all());
        return redirect()->route('livros.index')->with('success', 'Livro atualizado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Book::destroy($id);
        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso.');
    }
}
