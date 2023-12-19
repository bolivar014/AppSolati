<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;

class BookWSController extends Controller
{
    //    //
    public function index()
    {
        $books = Book::all();
        // // return view('books.index', compact('books'));
        // return response()->json($books);
        try {
            // ... lógica para obtener datos ...

            return response()->json(['data' => $books], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        Book::create($request->all());

        // return redirect()->route('books.index')->with('success', 'Libro creado correctamente.');
        return response()->json($request, 201); // 201 Created
    }

    public function show(Book $book)
    {
        // return view('books.show', compact('book'));
        return response()->json($book);
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $book->update($request->all());

        // return redirect()->route('books.index')->with('success', 'Libro actualizado correctamente.');
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Libro eliminado correctamente.');
    }
}
