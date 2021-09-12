<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
class PaymentController extends Controller
{
    public function index()
    {
        // return view('Penjualan.index');
        echo "ntebbb";
    }
    public function pay($id_penjualan=''){
        echo $id_penjualan;
    }
}
