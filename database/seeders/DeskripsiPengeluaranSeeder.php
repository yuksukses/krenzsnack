<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeskripsiPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deskripsi_pengeluaran')->insert([[
                'kode_transaksi' => '1-10002',
                'deskripsi_pengeluaran' => 'Transfer Pribadi',

            ],
            [
                'kode_transaksi' => '1-10003',
                'deskripsi_pengeluaran' => 'Hutang Reseller Belum di Bayar',

            ],
            [
                'kode_transaksi' => '1-10301',
                'deskripsi_pengeluaran' => 'Karyawan Hutang',

            ],
            [
                'kode_transaksi' => '1-10500',
                'deskripsi_pengeluaran' => 'PPn Pajak Usaha',

            ],
            [
                'kode_transaksi' => '1-10501',
                'deskripsi_pengeluaran' => 'Pajak Dibayar Di Muka - PPh 22',

            ],
            [
                'kode_transaksi' => '1-10502',
                'deskripsi_pengeluaran' => 'Pajak Dibayar Di Muka - PPh 23',

            ],
            [
                'kode_transaksi' => '1-10503',
                'deskripsi_pengeluaran' => 'Pajak Dibayar Di Muka - PPh 25',

            ],
            [
                'kode_transaksi' => '1-10800',
                'deskripsi_pengeluaran' => 'Investasi Crypto',

            ],
            [
                'kode_transaksi' => '2-20100',
                'deskripsi_pengeluaran' => 'Pembayaran Hutang Usaha',

            ],
            [
                'kode_transaksi' => '2-20402',
                'deskripsi_pengeluaran' => 'Tambahan Bahan Packing',

            ],
            [
                'kode_transaksi' => '2-20700',
                'deskripsi_pengeluaran' => 'Kewajiban Manfaat Karyawan',

            ],
            [
                'kode_transaksi' => '4-40200',
                'deskripsi_pengeluaran' => 'Retur Penjualan',

            ],
            [
                'kode_transaksi' => '5-50300',
                'deskripsi_pengeluaran' => 'Pengiriman & Pengangkutan',

            ],
            [
                'kode_transaksi' => '5-50400',
                'deskripsi_pengeluaran' => 'Biaya Impor',

            ],
            [
                'kode_transaksi' => '6-60001',
                'deskripsi_pengeluaran' => 'Iklan & Promosi',

            ],
            [
                'kode_transaksi' => '6-60003',
                'deskripsi_pengeluaran' => 'Bensin, Tol dan Parkir - Penjualan',

            ],
            [
                'kode_transaksi' => '6-60004',
                'deskripsi_pengeluaran' => 'Perjalanan Dinas - Penjualan',

            ],
            [
                'kode_transaksi' => '6-60005',
                'deskripsi_pengeluaran' => 'Komunikasi - Pulsa - Internet - dll',

            ],
            [
                'kode_transaksi' => '6-60101',
                'deskripsi_pengeluaran' => 'Gaji Karyawan',

            ],
            [
                'kode_transaksi' => '6-60102',
                'deskripsi_pengeluaran' => 'Gaji Freelancer',

            ],
            [
                'kode_transaksi' => '6-60103',
                'deskripsi_pengeluaran' => 'Makanan & Transportasi',

            ],
            [
                'kode_transaksi' => '6-60104',
                'deskripsi_pengeluaran' => 'Lembur Karyawan',

            ],
            [
                'kode_transaksi' => '6-60105',
                'deskripsi_pengeluaran' => 'Pengobatan',

            ],
            [
                'kode_transaksi' => '6-60106',
                'deskripsi_pengeluaran' => 'THR / Bonus Lainya',

            ],
            [
                'kode_transaksi' => '6-60107',
                'deskripsi_pengeluaran' => 'Jamsostek',

            ]
        ]);
    }
}
