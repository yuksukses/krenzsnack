<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'desc')->get();
        return datatables()
        ->of($user)
        ->addIndexColumn()
        ->addColumn('Action', function ($user){
            return '
                <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class= "btn btn-xs btn-info"><i class= "fa fa-pencil"></i></button>
                <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class= "btn btn-xs btn-danger"><i class= "fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['Action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = 'kasir';
        $user->foto = '/img/user.png';
        $user->save();

        return response()->json('Data Berhasil Disimpan', 200);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->update();
        
        return response()->json('Data Berhasil Disimpan', 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                }else {
                    return response()->json('Password Tidak Sesuai', 422);
                }
            } else {
                return response()->json('Password Tidak Sama', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'user-' . date('Y-m-d') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }
        $user->update();
        return response()->json($user, 200);
    }


}
