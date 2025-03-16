<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'playstation_id', 'booking_date', 'total_price', 'status','snap_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function playstation()
    {
        return $this->belongsTo(Playstation::class, 'playstation_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }
}
