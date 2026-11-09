<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        // Tampilkan data peminjaman beserta relasi book dan member
        $loans = Loan::with(['book', 'member'])->get();
        return response()->json($loans, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'     => 'required|exists:books,id',
            'member_id'   => 'required|exists:members,id',
            'loan_date'   => 'required|date',
            'due_date'    => 'required|date|after_or_equal:loan_date',
        ]);

        // Tolak peminjaman jika stok tersedia sudah habis
        $book = Book::find($request->book_id);

        if ($book->available_stock <= 0) {
            return response()->json(['message' => 'Stok buku sedang habis'], 422);
        }

        // Simpan peminjaman dan kurangi stok tersedia dalam satu transaksi
        $loan = DB::transaction(function () use ($request, $book) {
            $book->decrement('available_stock');
            return Loan::create($request->all());
        });

        return response()->json($loan, 201);
    }

    public function show($id)
    {
        $loan = Loan::with(['book', 'member'])->find($id);

        if (!$loan) {
            return response()->json(['message' => 'Data peminjaman tidak ditemukan'], 404);
        }

        return response()->json($loan, 200);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['message' => 'Data peminjaman tidak ditemukan'], 404);
        }

        $loan->update($request->all());
        return response()->json($loan, 200);
    }

    public function destroy($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json(['message' => 'Data peminjaman tidak ditemukan'], 404);
        }

        // Jika peminjaman belum dikembalikan, stok tersedia dikembalikan dulu
        if ($loan->status === 'borrowed') {
            Book::where('id', $loan->book_id)->increment('available_stock');
        }

        $loan->delete();
        return response()->json(['message' => 'Data peminjaman berhasil dihapus'], 200);
    }
}