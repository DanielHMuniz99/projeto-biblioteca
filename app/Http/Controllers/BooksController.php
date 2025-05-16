<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::with('genre')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('books.form', compact('genres'));
    }

    public function store(Request $request)
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

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $genres = Genre::all();
        return view('books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso.');
    }
}
