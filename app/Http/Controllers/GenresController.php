<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GenresController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $genres = Genre::all();
        return view('genres.index', compact('genres'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('genres.form');
    }

    /**
     * @param Request $request
     * 
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:genres'
        ]);

        Genre::create($request->all());
        return redirect()->route('generos.index')->with('success', 'Gênero cadastrado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return View
     */
    public function edit(int $id): View
    {
        $genre = Genre::findOrFail($id);
        return view('genres.form', compact('genre'));
    }

    /**
     * @param Request $request
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:genres,name,' . $id,
        ]);

        $genre->update($request->all());
        return redirect()->route('generos.index')->with('success', 'Gênero atualizado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $genre = Genre::withCount('books')->findOrFail($id);

        if ($genre->books_count > 0) {
            return redirect()->route('generos.index')
                ->with('error', 'Este gênero não pode ser excluído pois ainda possui livros associados.');
        }

        $genre->delete();
        return redirect()->route('generos.index')->with('success', 'Gênero excluído com sucesso.');
    }
}
