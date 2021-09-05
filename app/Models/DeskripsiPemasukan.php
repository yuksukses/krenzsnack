<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskripsiPemasukan extends Model
{
    use HasFactory;
    protected $table = 'deskripsi_pemasukan';
    protected $primaryKey = 'id_deskripsi_pemasukan';
    protected $guarded = [];
}
