<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $id_pembelian = session('id_pembelian');
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
        ->select('produk.*', 'nama_kategori')
        ->orderBy('kode_produk', 'asc')->get();
        $supplier = Supplier::find(session('id_supplier'));
        // $supplier = Supplier::find($supplier);
        $diskon = Pembelian::find($id_pembelian)->diskon ?? 0;

        if (! $supplier) {
            abort(404);
        }
        return view('pembelian_detail.index', compact('id_pembelian', 'produk', 'supplier', 'diskon'));
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal Disimpan', 400);
        }
        $detail = new PembelianDetail();
        $detail->id_pembelian = $request->id_pembelian;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_beli = $produk->harga_beli;
        $detail->jumlah = 1;
        $detail->subtotal = $produk->harga_beli;
        $detail->save();

        return response()->json('Data berhasil Disimpan', 200);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
        ->where('id_pembelian', $id)
        ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row ['kode_produk'] = '<span class="label label-primary">'. $item->produk['kode_produk'] .'</span>';
            $row ['nama_produk'] = $item->produk['nama_produk'];
            $row ['harga_beli']  = 'Rp '. format_uang($item->harga_beli);
            $row ['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'" >';
            $row ['subtotal']    = 'Rp '. format_uang($item->subtotal);
            $row ['action']      = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
                                    </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_produk' => '<div class="total hide">'. $total .'</div>
                            <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli' => '',
            'jumlah' => '',
            'subtotal' => '',
            'action' => '',
        ];


        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->rawColumns(['action', 'kode_produk', 'harga_beli', 'subtotal', 'jumlah'])
        ->make(true);
    }

    public function show(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();
        return response()->json(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar).' Rupiah')
        ];
        return response()->json($data);
    }
}
