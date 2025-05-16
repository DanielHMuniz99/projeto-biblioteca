<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
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
            'email' => 'required|email|unique:users',
            'registration_number' => 'required|unique:users',
        ]);

        User::create($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$id}",
            'registration_number' => "required|unique:users,registration_number,{$id}",
        ]);

        $user->update($request->all());
        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
