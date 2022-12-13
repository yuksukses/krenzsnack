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
                'nama_kategori' => 'Obat Sirup'
            ],
            [
                'nama_kategori' => 'Obat Tablet'
            ],
            [
                'nama_kategori' => 'Obat Granul/Serbuk'
            ],
            [
                'nama_kategori' => 'Obat Tetes'
            ],
            [
                'nama_kategori' => 'Obat Salep'
            ]
        ]);
    }
}
