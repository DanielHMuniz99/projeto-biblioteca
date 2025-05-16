<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        return view('genres.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:genres'
        ]);

        Genre::create($request->all());
        return redirect()->route('generos.index')->with('success', 'Gênero cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('genres.form', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:genres,name,' . $id,
        ]);

        $genre->update($request->all());
        return redirect()->route('generos.index')->with('success', 'Gênero atualizado com sucesso.');
    }

    public function destroy($id)
    {
        Genre::destroy($id);
        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso.');
    }
}
