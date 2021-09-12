<?php


use Illuminate\Support\Facades\DB;

namespace Midtrans;



require_once 'midtrans/Midtrans.php';

//Set Your server key

Config::$serverKey ='Mid-server-BDACo9gGvfhmKkkaBF1tezRi';

// Config::$serverKey = "SB-Mid-server-Kz_JhN8if3KD_RDRTQnxOuXZ";



// Uncomment for production environment

Config::$isProduction = true;

// Config::$isProduction = false;



// Enable sanitization

Config::$isSanitized = true;



// Enable 3D-Secure

Config::$is3ds = true;

$transaction_id = $id;

$currentToken = $transaksi->mid_token;

$transaction_details = array(

    'order_id' => $id,

    // 'gross_amount' =>1, // no decimal allowed for creditcard

    'gross_amount' => $transaksi->nominal, // no decimal allowed for creditcard

);

$enable_payments = array($transaksi->metode);

// $enable_payments = array('gopay');

// Optional

$customer_details = array(

    'first_name'    => $transaksi->name,

    'country_code'  => 'IDN',

    'email' => $transaksi->email

);

// Fill transaction details

// Optional

$item1_details = array(

    'id' => $id,

    // 'price' =>str_replace("rp","",str_replace(".","",strtolower($transaksi->jumlah))),

    'price' => $transaksi->nominal,

    'quantity' => 1,

    'name' => "Pembayaran transaksi pembelian No Invoice : #".$id

);

// Optional

$item_details = array($item1_details);



$transaction = array(

    'transaction_details' => $transaction_details,

    'customer_details' => $customer_details,

    'enabled_payments' => $enable_payments,

    'item_details' => $item_details,

);

if ($currentToken == '' || empty($currentToken)) {

    $snapToken = Snap::getSnapToken($transaction);
    \DB::table('transaksis')
              ->where('id', $id)
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
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-AZOymlle-g39fJI8"></script>
  </head>
  <body>
    <script type="text/javascript">
      snap.pay('<?= $snapToken ?>', {
        onSuccess: function(result) {
            window.location.href = "/transaksi/redirect_midtrans/success"
        },
        onPending: function(result) {
            window.location.href = "/transaksi/redirect_midtrans/pending"

        },
        onError: function(result) {
            window.location.href = "/transaksi/redirect_midtrans/error"
        },
        onClose: function(){ window.location.href = "/transaksi"}

        });
    </script>
  </body>
</html>



