<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');
        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function data($awal, $akhir)
    {

        $no = 1;
        $data = array();

        $pendapatan = 0;
        $total_pendapatan = 0;

        $totalPengeluaran = 0;
        $totalPembelian = 0;
        $totalPemasukan = 0;

        $totalPenjualan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal%")->sum('nominal');
            $total_pemasukan = Pemasukan::where('created_at', 'LIKE', "%$tanggal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran + $total_pemasukan;
            $total_pendapatan += $pendapatan;

            $totalPengeluaran += $total_pengeluaran;
            $totalPembelian += $total_pembelian;
            $totalPenjualan += $total_penjualan;
            $totalPemasukan += $total_pemasukan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['penjualan'] = format_uang($total_penjualan);
            $row['pembelian'] = format_uang($total_pembelian);
            $row['pemasukan'] = format_uang($total_pemasukan);
            $row['pengeluaran'] = format_uang($total_pengeluaran);
            $row['pendapatan'] = format_uang($pendapatan);

            $data[] = $row;

        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '<strong>TOTAL</strong>',
            'penjualan' => '<strong>'. format_uang($totalPenjualan) .'</strong>',
            'pembelian' => '<strong class="text-danger">'. format_uang($totalPembelian) .'</strong>',
            'pemasukan' => '<strong>'. format_uang($totalPemasukan) .'</strong>',
            'pengeluaran' => '<strong class="text-danger">'. format_uang($totalPengeluaran) .'</strong>',
            'pendapatan'=> '<strong class="text-navy">'. format_uang($total_pendapatan) .'</strong>',

        ];
        return datatables()
            ->of($data)
            ->rawColumns(['tanggal', 'penjualan', 'pembelian','pemasukan', 'pengeluaran', 'pendapatan'])
            ->make(true);
    }

}
