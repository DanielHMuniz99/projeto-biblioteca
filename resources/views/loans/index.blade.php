@extends('layout')

@section('title', 'Empréstimos')

@section('content')
    <a href="{{ route('emprestimos.create') }}" class="btn btn-primary mb-3">Novo Empréstimo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Devolução</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->book->title }}</td>
                <td>{{ $loan->due_date }}</td>
                <td>{{ $loan->getTranslatedStatus() }}</td>
                <td>
                    <form action="{{ route('emprestimos.markAsReturned', $loan->id) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-success">Devolver</button>
                    </form>
                    <form action="{{ route('emprestimos.markAsLate', $loan->id) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-warning">Atrasado</button>
                    </form>
                    <form action="{{ route('emprestimos.renew', $loan->id) }}" method="POST" style="display:inline;">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-info">Renovar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
