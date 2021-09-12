<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('kode_member', 'asc')->get();

        return datatables()
        ->of($member)
        ->addIndexColumn()
        ->addColumn('select_all', function ($member){
            return '<input type="checkbox" name="id_member[]" value="'. $member->id_member .'">';
            
        })
        ->addColumn('kode_member', function ($member){
            return '<span class="label label-primary">'. $member->kode_member .'</span>';
        })
        ->addColumn('Action', function ($member){
            return '
                <button type="button" onclick="editForm(`'. route('member.update', $member->id_member) .'`)" class= "btn btn-xs btn-info"><i class= "fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`'. route('member.destroy', $member->id_member) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['Action', 'kode_member', 'select_all'])
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
        $member = Member::latest()->first() ?? new Member();
        $kode_member = (int) $member->kode_member +1 ?? 1;
        
        $member = new Member();
        $member->kode_member = tambah_nol_didepan($kode_member, 5);
        $member->nama = $request->nama;
        $member->telepon = $request->telepon;
        $member->email = $request->email;
        $member->alamat = $request->alamat;
        $member->save();

        return response()->json('Data berhasil Disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
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
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id)
        ->update($request->all());

        return response()->json('Data berhasil Disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        return response()->json(null, 204);
    }
    public function cetakMember(Request $request)
    {
        $dataMember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $dataMember[] = $member;
        }
        $dataMember = $dataMember->chunk(2);
        $setting = Setting::first();
        $no = 1;
        $pdf = PDF::loadView('member.cetak', compact('dataMember', 'no', 'setting'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
        return $pdf->stream('member.pdf');
    }
}
