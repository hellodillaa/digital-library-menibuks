<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();
        return response()->json($publishers, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
        ]);

        $publisher = Publisher::create($request->all());
        return response()->json($publisher, 201);
    }

    public function show($id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['message' => 'Penerbit tidak ditemukan'], 404);
        }

        return response()->json($publisher, 200);
    }

    public function update(Request $request, $id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['message' => 'Penerbit tidak ditemukan'], 404);
        }

        $publisher->update($request->all());
        return response()->json($publisher, 200);
    }

    public function destroy($id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['message' => 'Penerbit tidak ditemukan'], 404);
        }

        $publisher->delete();
        return response()->json(['message' => 'Penerbit berhasil dihapus'], 200);
    }
}