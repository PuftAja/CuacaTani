<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    // user_id disertakan agar bisa di-assign saat store
    protected $fillable = ['user_id', 'kota', 'komoditas', 'luas_lahan'];

    /**
     * Setiap lahan dimiliki oleh satu user (petani).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
