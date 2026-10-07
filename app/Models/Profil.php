<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_yayasan',
        'pimpinan',
        'nsp',
        'alamat',
        'no_wa',
        'visi',
        'misi',
    ];
}