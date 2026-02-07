<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'pendaftaran_id',
        'user_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
