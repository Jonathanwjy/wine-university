<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    /** @use HasFactory<\Database\Factories\PengumumanFactory> */
    protected $table = 'pengumumans';
    protected $fillable = [
        'judul',
        'tagline',
        'isi',
        'tanggal_dibuat',
    ];
    use HasFactory;
}
