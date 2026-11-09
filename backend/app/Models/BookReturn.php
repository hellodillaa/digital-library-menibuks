<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'admin_id',
        'return_date',
        'fine_amount',
        'book_condition',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function finePayments()
    {
        return $this->hasMany(FinePayment::class);
    }
}
