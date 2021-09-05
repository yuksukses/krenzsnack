<?php

namespace App\Http\Controllers;

use App\Models\DeskripsiPengeluaran;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;


class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deskripsi = DeskripsiPengeluaran::all();

        return view ('pengeluaran.index',compact('deskripsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $pengeluaran = Pengeluaran::leftJoin('deskripsi_pengeluaran', 'deskripsi_pengeluaran.id_deskripsi_pengeluaran', 'pengeluaran.id_deskripsi_pengeluaran')
        ->select('pengeluaran.*', 'deskripsi_pengeluaran')
        ->orderBy('deskripsi_pengeluaran', 'asc')->get();

        return datatables()
        ->of($pengeluaran)
        ->addIndexColumn()
        ->addColumn('created_at', function ($pengeluaran){
            return tanggal_indonesia($pengeluaran->created_at, false);
        })
        ->addColumn('nominal', function ($pengeluaran){
            return 'Rp '. format_uang($pengeluaran->nominal);
        })
        ->addColumn('Action', function ($pengeluaran){
            return '
                <button type="button" onclick="editForm(`'. route('pengeluaran.update', $pengeluaran->id_pengeluaran) .'`)" class= "btn btn-xs btn-info"><i class= "fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`'. route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['Action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengeluaran = Pengeluaran::create($request->all());

        return response()->json('Data berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        return response()->json($pengeluaran);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::find($id)->update($request->all());

        return response()->json('Data berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $pengeluaran->delete();
        return response(null, 204);
    }
}
