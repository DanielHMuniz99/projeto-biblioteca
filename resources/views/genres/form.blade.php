@extends('layout')

@section('title', 'Novo Empréstimo')

@section('content')
    <form action="{{ isset($genre) ? route('generos.update', $genre->id) : route('generos.store') }}" method="POST">
        @csrf
        @if(isset($genre)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Nome do Gênero</label>
            <input type="text" name="name" value="{{ old('name', $genre->name ?? '') }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('generos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
