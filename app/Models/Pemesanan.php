<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'kursi',
        'waktu',
        'total',
        'status',
        'tempat_id',
        'pemesan_id',
        'petugas_id'
    ];

    public function tempat()
    {
        return $this->belongsTo('App\Models\Tempat', 'tempat_id');
    }

    public function penumpang()
    {
        return $this->belongsTo('App\Models\User', 'pemesan_id');
    }

    public function petugas()
    {
        return $this->belongsTo('App\Models\User', 'petugas_id');
    }

    protected $table = 'pemesanan';
}
