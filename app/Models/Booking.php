<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'nama_pemesan',
        'email',
        'jumlah_orang',
        'tanggal',
    ];

    // Definisikan relasi dengan model Tour
    public function tour()
    {
        return $this->belongsTo(Tours::class);
    }

}
