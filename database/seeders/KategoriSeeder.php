<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Snacks'
            ],
            [
                'nama_kategori' => 'Makanan'
            ],
            [
                'nama_kategori' => 'Minuman'
            ]
        ]);
    }
}
