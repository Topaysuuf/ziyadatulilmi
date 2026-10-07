<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = ['siswa_id', 'mata_pelajaran', 'jenis_ujian', 'nilai'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}