@extends('layout')

@section('title', 'Livros')

@section('content')
    <a href="{{ route('livros.create') }}" class="btn btn-primary mb-3">Novo Livro</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Registro</th>
                <th>Gênero</th>
                <th>Situação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->registry_number }}</td>
                <td>{{ $book->genre->name }}</td>
                <td>{{ $book->status == 'available' ? 'Disponível' : 'Emprestado' }}</td>
                <td>
                    <a href="{{ route('livros.update', $book->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('livros.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
