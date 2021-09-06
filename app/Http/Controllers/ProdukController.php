<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\PembelianDetail;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\DB;
use PDF;

class ProdukController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        return view ('produk.index', compact('kategori'));
    }

    public function stok(Request $request)
    {
        $bulanSekarang = date('Y-m');
        if ($request->has('pilih_bulan') && $request->pilih_bulan != "") {
            $bulanSekarang = $request->pilih_bulan;
        }

        $stokMasuk = Produk::leftJoin('pembelian_detail', 'pembelian_detail.id_produk', 'produk.id_produk')
        ->select('produk.id_produk', 'kode_produk', 'nama_produk', 'produk.harga_beli', 'merk', 'stok', 'pembelian_detail.id_produk',
        DB::raw('SUM(pembelian_detail.jumlah) as stokMasuk'))
                        ->where('pembelian_detail.created_at', 'LIKE', "%$bulanSekarang%")

                            ->groupBy('pembelian_detail.id_produk', 'kode_produk', 'produk.id_produk', 'nama_produk', 'merk', 'produk.harga_beli', 'stok')
                            ->get();

        $stokTerjual = Produk::leftJoin('penjualan_detail', 'penjualan_detail.id_produk', 'produk.id_produk')
        ->select('produk.id_produk', 'kode_produk', 'nama_produk', 'merk', 'produk.harga_jual', 'stok', 'penjualan_detail.id_produk',
        DB::raw('SUM(penjualan_detail.jumlah) as stokTerjual'))
                        ->where('penjualan_detail.created_at', 'LIKE', "%$bulanSekarang%")

                            ->groupBy('penjualan_detail.id_produk', 'kode_produk', 'produk.id_produk', 'nama_produk', 'merk', 'produk.harga_jual', 'stok')
                            ->get();


        return view ('produk.stok', compact('bulanSekarang', 'stokMasuk', 'stokTerjual'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
        ->select('produk.*', 'nama_kategori')
        ->orderBy('kode_produk', 'asc')->get();

        return datatables()
        ->of($produk)
        ->addIndexColumn()
        ->addColumn('select_all', function ($produk){
            return '<input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">';
            
        })
        ->addColumn('kode_produk', function ($produk){
            return '<span class="label label-primary">'. $produk->kode_produk .'</span>';
        })
        ->addColumn('harga_beli', function ($produk){
            return 'Rp '. format_uang($produk->harga_beli);
        })
        ->addColumn('harga_jual', function ($produk){
            return 'Rp '. format_uang($produk->harga_jual);
        })
        ->addColumn('diskon', function ($produk){
            return $produk->diskon .'%';
        })
        ->addColumn('Action', function ($produk){
            return '
                <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class= "btn btn-xs btn-info"><i class= "fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['Action', 'kode_produk', 'select_all'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'KRENZ'. tambah_nol_didepan((int)$produk->id_produk+1, 6);
        $produk = Produk::create($request->all());

        return response()->json('Data berhasil Disimpan', 200);
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil Disimpan', 200);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
        return response()->json(null, 204);
    }
    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }
        return response()->json(null, 204);
    }
    public function cetakBarcode(Request $request)
    {
        $dataProduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataProduk[] = $produk;
        }
        $no = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataProduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }

}