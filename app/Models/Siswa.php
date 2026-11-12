<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nisn', 'qr_token', 'nama', 'kelas'];

    protected static function booted()
    {
        static::creating(function ($siswa) {
            if (empty($siswa->qr_token)) {
                $siswa->qr_token = 'ZI-' . strtoupper(Str::random(10));
            }
        });
    }
}