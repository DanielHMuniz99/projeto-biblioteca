<?php

namespace App\Http\Controllers;

use App\Models\LibraryUser;
use Illuminate\Http\Request;

class LibraryUsersController extends Controller
{
    public function index()
    {
        $users = LibraryUser::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:library_users',
            'registration_number' => 'required|unique:library_users',
        ]);

        LibraryUser::create($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit($id)
    {
        $user = LibraryUser::findOrFail($id);
        return view('users.form', compact('user'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        LibraryUser::destroy($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
