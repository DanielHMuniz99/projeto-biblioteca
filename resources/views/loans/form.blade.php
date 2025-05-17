@extends('layout')

@section('title', 'Novo Empréstimo')

@section('content')
    <form action="{{ route('emprestimos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Usuário</label>
            <select name="library_user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Livro</label>
            <select name="book_id" class="form-control" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Data da Retirada</label>
            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Data de Devolução</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Confirmar Empréstimo</button>
        <a href="{{ route('emprestimos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
