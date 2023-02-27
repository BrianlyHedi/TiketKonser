<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    use HasFactory;

    protected $fillable = [
        'tujuan',
        'harga',
        'jam',
        'tiket_id'
    ];

    public function tiket()
    {
        return $this->belongsTo('App\Models\Tiket', 'tiket_id');
    }

    protected $table = 'tempat';
}
