<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Ambil data buku beserta relasi ke author dan publisher
        $books = Book::with(['author', 'publisher'])->get();
        return response()->json($books, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'isbn'           => 'required|string|unique:books',
            'author_id'      => 'required|exists:authors,id',
            'publisher_id'   => 'required|exists:publishers,id',
            'category'       => 'nullable|string|max:255',
            'stock'          => 'required|integer|min:0',
            'available_stock' => 'nullable|integer|min:0|lte:stock',
            'published_year' => 'nullable|digits:4',
        ]);

        // Jika stok tersedia tidak diisi, anggap semua stok tersedia
        $data = $request->all();
        $data['available_stock'] = $request->input('available_stock', $request->input('stock'));

        $book = Book::create($data);
        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'publisher'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($book, 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $book->update($request->all());
        return response()->json($book, 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}