<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_return_id',
        'payment_date',
        'amount',
        'method',
        'status',
    ];

    public function bookReturn()
    {
        return $this->belongsTo(BookReturn::class);
    }
}
