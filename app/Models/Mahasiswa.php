<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas'; // <--- sesuaikan dengan nama tabel
    
    protected $fillable = [
        'nim',
        'nama',
        'email'
    ];
}
