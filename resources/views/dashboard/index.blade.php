@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total de Livros</h5>
                    <p class="card-text fs-3">{{ $data['books_total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Emprestados</h5>
                    <p class="card-text fs-3">{{ $data['books_loaned'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pendentes</h5>
                    <p class="card-text fs-3">{{ $data['loans_pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Atrasados</h5>
                    <p class="card-text fs-3">{{ $data['loans_late'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
