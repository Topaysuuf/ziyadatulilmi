<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke tabel Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}