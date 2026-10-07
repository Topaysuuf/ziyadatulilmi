<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppdb extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'jenis_kelamin',
        'no_wa',
        'status',
    ];
}