<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kode',
        'jumlah',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function kursi($id)
    {
        $data = json_decode($id, true);
        $kursi = Pemesanan::where('tempat_id', $data['tempat'])->where('waktu', $data['waktu'])->where('kursi', $data['kursi'])->count();
        if ($kursi > 0) {
            return null;
        } else {
            return $id;
        }
    }

    protected $table = 'tiket';
}
