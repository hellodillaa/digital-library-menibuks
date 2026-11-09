<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // 1. Tampilkan semua data penulis
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors, 200);
    }

    // 2. Simpan data penulis baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string',
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    // 3. Tampilkan detail 1 penulis
    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Penulis tidak ditemukan'], 404);
        }

        return response()->json($author, 200);
    }

    // 4. Update/ubah data penulis
    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Penulis tidak ditemukan'], 404);
        }

        $author->update($request->all());
        return response()->json($author, 200);
    }

    // 5. Hapus data penulis
    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Penulis tidak ditemukan'], 404);
        }

        $author->delete();
        return response()->json(['message' => 'Penulis berhasil dihapus'], 200);
    }
}