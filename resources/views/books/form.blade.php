@extends('layout')

@section('title', isset($book) ? 'Editar Livro' : 'Novo Livro')

@section('content')
    <form action="{{ isset($book) ? route('livros.update', $book->id) : route('livros.store') }}" method="POST">
        @csrf
        @if(isset($book)) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Autor</label>
            <input type="text" name="author" value="{{ old('author', $book->author ?? '') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Número de Registro</label>
            <input type="text" name="registry_number" value="{{ old('registry_number', $book->registry_number ?? '') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gênero</label>
            <select name="genre_id" class="form-control" required>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" @if(isset($book) && $book->genre_id == $genre->id) selected @endif>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('livros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
