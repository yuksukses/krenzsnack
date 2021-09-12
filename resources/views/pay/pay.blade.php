<?php


use Illuminate\Support\Facades\DB;

namespace Midtrans;



require_once 'midtrans/Midtrans.php';

//Set Your server key

Config::$serverKey ='Mid-server-g4E-MLjXkzqy4sBNGzZ1otu9';

// Config::$serverKey = "SB-Mid-server-Kz_JhN8if3KD_RDRTQnxOuXZ";



// Uncomment for production environment

Config::$isProduction = true;

// Config::$isProduction = false;



// Enable sanitization

Config::$isSanitized = true;



// Enable 3D-Secure

Config::$is3ds = true;

$transaction_id = $id_penjualan;

$currentToken = $transaksi->mid_token;

$transaction_details = array(

    'order_id' => $id_penjualan,

    // 'gross_amount' =>1, // no decimal allowed for creditcard

    'gross_amount' => $transaksi->bayar, // no decimal allowed for creditcard

);

// $enable_payments = array($transaksi->metode); 

// $enable_payments = array('gopay');

// Optional

$customer_details = array(

    'first_name'    => $transaksi->nama,

    'country_code'  => 'IDN',

    'email' => $transaksi->email

);

// Fill transaction details

// Optional

$item1_details = array(

    'id' => $id_penjualan,

    // 'price' =>str_replace("rp","",str_replace(".","",strtolower($transaksi->jumlah))),

    'price' => $transaksi->bayar,

    'quantity' => 1,

    'name' => "Pembayaran transaksi pembelian No Invoice : #".$id_penjualan

);

// Optional

$item_details = array($item1_details);



$transaction = array(

    'transaction_details' => $transaction_details,

    'customer_details' => $customer_details,

    // 'enabled_payments' => $enable_payments,

    'item_details' => $item_details,
  
);

if ($currentToken == '' || empty($currentToken)) {

    $snapToken = Snap::getSnapToken($transaction);
    \DB::table('penjualan')
              ->where('id_penjualan', $id_penjualan)
              ->update(['mid_token' => $snapToken]);

} else {

    $snapToken = $currentToken;

}

// echo

// echo "snapToken = " . $snapToken;



?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-_d4b731naUOBYsOz"></script>
  </head>
  <body>
    <script type="text/javascript">
      snap.pay('<?= $snapToken ?>', {
        onSuccess: function(result) {
            window.location.href = "/penjualan"
        },
        onPending: function(result) {
            window.location.href = "/penjualan"
  
        },
        onError: function(result) {
            window.location.href = "/penjualan"
        },
        onClose: function(){ window.location.href = "/penjualan"}

        });
    </script>
  </body>
</html>



