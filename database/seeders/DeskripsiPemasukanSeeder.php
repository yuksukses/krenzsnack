<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeskripsiPemasukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deskripsi_pemasukan')->insert([
            [
                'kode_transaksi' => '1-10001',
                'deskripsi_pemasukan' => 'Penambahan Kas',
            ],
            [
                'kode_transaksi' => '1-10100',
                'deskripsi_pemasukan' => 'Hutang Pengembangan Usaha',
            ],
            [
                'kode_transaksi' => '1-10300',
                'deskripsi_pemasukan' => 'Pembayaran Hutang Reseller',
            ],
            [
                'kode_transaksi' => '1-10400',
                'deskripsi_pemasukan' => 'Pembayaran Hutang Karyawan',
            ],
            [
                'kode_transaksi' => '2-20401',
                'deskripsi_pemasukan' => 'Hasil Hutang Bank',
            ],
            [
                'kode_transaksi' => '2-20600',
                'deskripsi_pemasukan' => 'Hutang dari Pemegang Saham',
            ],
            [
                'kode_transaksi' => '5-50200',
                'deskripsi_pemasukan' => 'Retur Pembelian',
            ],
            [
                'kode_transaksi' => '7-70000',
                'deskripsi_pemasukan' => 'Pendapatan Bunga - Bank',
            ],
            [
                'kode_transaksi' => '7-70001',
                'deskripsi_pemasukan' => 'Pendapatan Bunga - Deposito',
            ]
        ]);
    }
}
