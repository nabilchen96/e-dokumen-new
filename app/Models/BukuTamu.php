<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    // Nama tabel yang kita buat di phpMyAdmin tadi
    protected $table = 'buku_tamus';

    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'jenis_tamu', 
        'nip', 
        'nama', 
        'instansi_asal', 
        'keperluan', 
        'id_tujuan', 
        'status'
    ];
}