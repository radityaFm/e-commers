<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landingpage extends Model
{
    use HasFactory;

    protected $table = 'page_users'; // Nama tabel di database
    protected $fillable = ['name', 'email']; // Kolom-kolom yang dapat diisi
}
