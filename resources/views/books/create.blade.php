<!-- resources/views/books/create.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Crear Libro</h1>

        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" required minlength="1" maxlength="30">
                <!-- maxlength="255" especifica la longitud máxima permitida -->
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control" minlength="1" maxlength="500"></textarea>
                <!-- maxlength="1000" especifica la longitud máxima permitida -->
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
@endsection
