<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playstation extends Model
{
   protected $table = 'playstation';
   protected $primaryKey = 'id';
   protected $fillable = ['name', 'harga_sewa', 'deskripsi', 'gambar'];

    public function bookings()
    {
         return $this->hasMany(Booking::class, 'playstation_id', 'id');
    }
}
