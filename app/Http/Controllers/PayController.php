<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use PDF;

class PayController extends Controller
{

    public function index($id_penjualan = '')
    {
        // return view('penjualan.index');
        // echo $id_penjualan;
        $data['id_penjualan']=$id_penjualan;
        $data['transaksi']= DB::table('penjualan')
        ->join('member', 'penjualan.id_member', '=', 'member.id_member')
        ->select('penjualan.*', 'member.*')
        ->where('penjualan.id_penjualan',$id_penjualan)
        ->first();
        // echo var_dump($data);
        // die();
        // $data['penjualan']= DB::table('penjualan')->where('id', $id)->first();
        // echo var_dump($data);
        // echo $data['penjualan']->id;
        return view ('pay.pay',$data);
    }
    public function notification_payment()
    {
       
        date_default_timezone_set("Asia/Bangkok");
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        $data = [
            'mid_transaction_id'=>"tesss"
        ];
        // echo "ntab ntul";
        DB::table('penjualan')
        ->where('id_penjualan', 20)
        ->update($data);
        if ($result) {
            $transaction_id = $result->order_id;
            $data = [
                'mid_transaction_id' => $result->transaction_id,
                'mid_transaction_status' => $result->transaction_status,
                'mid_signature_key' => $result->signature_key,
                'mid_payment_type' => $result->payment_type,
                'mid_order_id' => $result->order_id,
                'mid_gross_amount' => $result->gross_amount
            ];
            
            // Update With penyesuaian Status dari midtrans
            $transaction_status = $result->transaction_status;
            if ($transaction_status == 'settlement') {
                $data['status'] = 'Sudah Bayar';
                $data['diterima'] = $result->gross_amount;
                $detail = PenjualanDetail::where('id_penjualan', $transaction_id)->get();
                foreach ($detail as $item) {
                    $produk = Produk::find($item->id_produk);
                    $produk->stok -= $item->jumlah;
                    $produk->update();
                }
            } else if ($transaction_status == 'expire') {
                $data['status'] = 'Pembayaran Dibatalkan';
            } else if ($transaction_status == 'deny') {
                $data['status'] = 'Pembayaran Dibatalkan';
            } else if ($transaction_status == 'cancel') {
                $data['status'] = 'Pembayaran Dibatalkan';
            }
            // $data['status'] = 'Sudah Bayar';
            // $data['diterima'] = $result->gross_amount;
            // $detail = PenjualanDetail::where('id_penjualan', $transaction_id)->get();
            // foreach ($detail as $item) {
            //     $produk = Produk::find($item->id_produk);
            //     $produk->stok -= $item->jumlah;
            //     $produk->update();
            // }
            DB::table('penjualan')
            ->where('id_penjualan', $transaction_id)
            ->update($data);
        }

        
        error_log(print_r($result, TRUE));
        // redirect('user/profile');
    
    }

}