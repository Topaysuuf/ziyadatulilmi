<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // Menegaskan nama tabel di database
    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'tanggal',
    ];
}