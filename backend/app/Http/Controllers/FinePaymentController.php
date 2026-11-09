<?php

namespace App\Http\Controllers;

use App\Models\FinePayment;
use Illuminate\Http\Request;

class FinePaymentController extends Controller
{
    public function index()
    {
        $payments = FinePayment::with('bookReturn')->get();
        return response()->json($payments, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_return_id' => 'required|exists:book_returns,id',
            'payment_date'   => 'required|date',
            'amount'         => 'required|integer|min:1',
            'method'         => 'nullable|string|max:255',
            'status'         => 'required|in:Lunas,Belum Lunas',
        ]);

        $payment = FinePayment::create($request->all());
        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = FinePayment::with('bookReturn')->find($id);

        if (!$payment) {
            return response()->json(['message' => 'Data pembayaran denda tidak ditemukan'], 404);
        }

        return response()->json($payment, 200);
    }
}
