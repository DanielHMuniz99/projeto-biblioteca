@extends('layout')

@section('title', 'Gêneros')

@section('content')
    <a href="{{ route('generos.create') }}" class="btn btn-primary mb-3">Novo Gênero</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $genre)
            <tr>
                <td>{{ $genre->name }}</td>
                <td>
                    <a href="{{ route('generos.edit', $genre->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('generos.destroy', $genre->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
