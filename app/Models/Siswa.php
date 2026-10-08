<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Absensi
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    // Relasi ke Nilai (E-Raport)
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    // Backup relasi jika controller kamu ada yang memanggil $siswa->nilais
    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }
}