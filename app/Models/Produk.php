<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // nama tabel sesuai di database mysql

    // Ensure the spelling is correct here
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'deskripsi', // Corrected spelling
        'harga',
        'jumlah_produk',
        'image',
        'created_at',
        'updated_at' // Corrected the property name to 'updated_at'
    ];
}
