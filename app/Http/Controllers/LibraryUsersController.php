<?php

namespace App\Http\Controllers;

use App\Models\LibraryUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LibraryUsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $users = LibraryUser::all();
        return view('users.index', compact('users'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('users.form');
    }

    /**
     * @param Request $request
     * 
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:library_users',
            'registration_number' => 'required|unique:library_users',
        ]);

        LibraryUser::create($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return View
     */
    public function edit(int $id): View
    {
        $user = LibraryUser::findOrFail($id);
        return view('users.form', compact('user'));
    }

    /**
     * @param Request $request
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = LibraryUser::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:library_users,email,{$id}",
            'registration_number' => "required|unique:library_users,registration_number,{$id}",
        ]);

        $user->update($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = LibraryUser::findOrFail($id);
        $hasActiveLoans = $user->loans()
            ->whereIn('status', ['pending', 'late'])
            ->exists();

        if ($hasActiveLoans) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'Este usuário possui empréstimos pendentes ou atrasados e não pode ser excluído.');
        }

        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
