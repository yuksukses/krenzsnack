<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskripsiPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'deskripsi_pengeluaran';
    protected $primaryKey = 'id_deskripsi_pengeluaran';
    protected $guarded = [];
}
