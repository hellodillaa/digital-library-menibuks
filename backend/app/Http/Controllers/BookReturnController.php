<?php

namespace App\Http\Controllers;

use App\Models\BookReturn;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookReturnController extends Controller
{
    // Aturan denda
    const LATE_FEE_PER_DAY = 2000;  // Rp2.000 per hari terlambat
    const DAMAGED_FEE      = 15000; // Buku rusak
    const LOST_FEE         = 50000; // Buku hilang

    public function index()
    {
        $returns = BookReturn::with(['loan.book', 'loan.member', 'admin', 'finePayments'])->get();
        return response()->json($returns, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_id'        => 'required|exists:loans,id|unique:book_returns,loan_id',
            'return_date'    => 'required|date',
            'book_condition' => 'required|in:Baik,Rusak,Hilang',
        ]);

        $loan = Loan::with('book')->find($request->loan_id);

        // Hitung jumlah hari terlambat (0 jika tepat waktu)
        $lateDays = (int) Carbon::parse($loan->due_date)
            ->diffInDays(Carbon::parse($request->return_date), false);
        $lateDays = max(0, $lateDays);

        // Denda keterlambatan + denda kondisi buku
        $conditionFee = match ($request->book_condition) {
            'Rusak'  => self::DAMAGED_FEE,
            'Hilang' => self::LOST_FEE,
            default  => 0,
        };
        $fine = ($lateDays * self::LATE_FEE_PER_DAY) + $conditionFee;

        $bookReturn = DB::transaction(function () use ($request, $loan, $fine) {
            $bookReturn = BookReturn::create([
                'loan_id'        => $loan->id,
                'admin_id'       => $request->user()->id,
                'return_date'    => $request->return_date,
                'fine_amount'    => $fine,
                'book_condition' => $request->book_condition,
            ]);

            // Tandai peminjaman sudah dikembalikan
            $loan->update([
                'return_date' => $request->return_date,
                'status'      => 'returned',
            ]);

            // Stok tersedia bertambah, kecuali buku hilang
            if ($request->book_condition !== 'Hilang') {
                $book = $loan->book;
                $book->update([
                    'available_stock' => min($book->stock, $book->available_stock + 1),
                ]);
            }

            return $bookReturn;
        });

        return response()->json($bookReturn->load(['loan', 'admin']), 201);
    }

    public function show($id)
    {
        $bookReturn = BookReturn::with(['loan.book', 'loan.member', 'admin', 'finePayments'])->find($id);

        if (!$bookReturn) {
            return response()->json(['message' => 'Data pengembalian tidak ditemukan'], 404);
        }

        return response()->json($bookReturn, 200);
    }
}
