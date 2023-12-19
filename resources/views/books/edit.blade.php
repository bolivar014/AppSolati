<!-- resources/views/books/edit.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Editar Libro</h1>

        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control">{{ $book->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('books.index') }}" class="btn btn-primary">Volver al Listado</a>
        </form>
        </div>
    </div>
@endsection
