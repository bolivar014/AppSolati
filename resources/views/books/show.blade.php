<!-- resources/views/books/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>
        <p><strong>ID:</strong> {{ $book->id }}</p>
        <p><strong>Descripción:</strong> {{ $book->description }}</p>
        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este libro?')">Eliminar</button>
        </form>
        <a href="{{ route('books.index') }}" class="btn btn-primary">Volver al Listado</a>
    </div>
@endsection
