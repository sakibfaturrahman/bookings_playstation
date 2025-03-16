<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = ['booking_id', 'transaction_id', 'payment_method', 'payment_status', 'payment_date'];
   
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
