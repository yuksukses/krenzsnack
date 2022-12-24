<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;

class PembelianController extends Controller
{

    public function index()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->first();
        $supplier = Supplier::orderBy('nama')->get();
        if ($pembelian != null && $pembelian->total_item == 0) {
            $pembelian->delete();
        }
        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {

        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
        ->of($pembelian)
        ->addIndexColumn()
        ->addColumn('total_item', function ($pembelian) {
            return $pembelian->total_item;
        })
        ->addColumn('total_harga', function ($pembelian) {
            return 'Rp '. format_uang($pembelian->total_harga);
        })
        ->addColumn('bayar', function ($pembelian) {
            return 'Rp '. format_uang($pembelian->bayar);
        })
        ->addColumn('tanggal', function ($pembelian) {
            return tanggal_indonesia($pembelian->created_at, false);
        })
        ->addColumn('supplier', function ($pembelian) {
            return $pembelian->supplier->nama ?? '-';
        })
        ->editColumn('diskon', function ($pembelian) {
            return $pembelian->diskon . '%';
        })
        ->addColumn('Action', function ($pembelian){
            return '
                <button type="button" onclick="showDetail(`'. route('pembelian.show', $pembelian->id_pembelian) .'`)" class= "btn btn-xs btn-info"><i class= "fa fa-eye"></i></button>
                <button type="button" onclick="deleteData(`'. route('pembelian.destroy', $pembelian->id_pembelian) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
                ';
        })
        ->rawColumns(['Action'])
        ->make(true);
    }

    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->id_supplier = $id;
        $pembelian->total_item = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon = 0;
        $pembelian->bayar = 0;
        $pembelian->save();
        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_supplier' => $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update();
        }
        return redirect()->route('pembelian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $detail = PembelianDetail::with('produk')->where('id_pembelian', $id)->get();
        return datatables()
        ->of($detail)
        ->addIndexColumn()
        ->addColumn('kode_produk', function ($detail) {
            return '<span class="label label-primary">'. $detail->produk->kode_produk .'</span>';
        })
        ->addColumn('nama_produk', function ($detail) {
            return $detail->produk->nama_produk;
        })
        ->addColumn('harga_beli', function ($detail) {
            return 'Rp '. format_uang($detail->harga_beli);
        })
        ->addColumn('jumlah', function ($detail) {
            return $detail->jumlah;
        })
        ->addColumn('subtotal', function ($detail) {
            return 'Rp '. format_uang($detail->subtotal);
        })
        ->rawColumns(['kode_produk'])
        ->make(true);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
