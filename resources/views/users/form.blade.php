@extends('layout')

@section('title', isset($user) ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
    <form action="{{ isset($user) ? route('usuarios.update', $user->id) : route('usuarios.store') }}" method="POST">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Número de Cadastro</label>
            <input type="text" name="registration_number" value="{{ old('registration_number', $user->registration_number ?? '') }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
