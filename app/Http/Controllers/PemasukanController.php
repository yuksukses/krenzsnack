<?php

namespace App\Http\Controllers;

use App\Models\DeskripsiPemasukan;
use App\Models\Pemasukan;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deskripsi = DeskripsiPemasukan::all();

        return view('pemasukan.index', compact('deskripsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $pemasukan = Pemasukan::leftJoin('deskripsi_pemasukan', 'deskripsi_pemasukan.id_deskripsi_pemasukan', 'pemasukan.id_deskripsi_pemasukan')
            ->select('pemasukan.*', 'deskripsi_pemasukan')
            ->orderBy('deskripsi_pemasukan', 'asc')->get();

        return datatables()
            ->of($pemasukan)
            ->addIndexColumn()
            ->addColumn('created_at', function ($pemasukan) {
                return tanggal_indonesia($pemasukan->created_at, false);
            })
            ->addColumn('nominal', function ($pemasukan) {
                return 'Rp ' . format_uang($pemasukan->nominal);
            })
            ->addColumn('Action', function ($pemasukan) {
                return '
                <button type="button" onclick="editForm(`' . route('pemasukan.update', $pemasukan->id_pemasukan) . '`)" class= "btn btn-xs btn-info"><i class= "fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`' . route('pemasukan.destroy', $pemasukan->id_pemasukan) . '`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
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
        $pemasukan = Pemasukan::create($request->all());

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
        $pemasukan = Pemasukan::find($id);
        return response()->json($pemasukan);
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
        $pemasukan = Pemasukan::find($id)->update($request->all());

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
        $pemasukan = Pemasukan::find($id);
        $pemasukan->delete();
        return response(null, 204);
    }
}
