<?php

namespace Midtrans;

require_once '../config/koneksi.php';
require_once 'Midtrans.php';
$paket_id = $_GET['id'];
$paket = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM paket WHERE id_paket = '$paket_id'"));
$email = $paket['paket_email'];
$user = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users WHERE user_email = '$email'"));
if($paket['paket_status'] == 'Aktif'){
echo "<script>alert('Paket sudah dibayar'); window.location.href = '../memberarea/media.php?membermodule=paket'
</script>";
}
//Set Your server key
// Config::$serverKey = "Mid-server-p8SAdj8dDzWO2PMLU-5h1C04";
Config::$serverKey = "Mid-server-cwSdPpWNRHxTDBZDPpT25ndr";

// Uncomment for production environment
Config::$isProduction = true;
// Config::$isProduction = false;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;
$transaction_id = $paket['id_paket'];
$currentToken = $paket['mid_token'];
$transaction_details = array(
    'order_id' => $paket['id_paket'],
    'gross_amount' => $paket['paket_harga'], 
    // 'gross_amount' => 5000, 
);
// Optional
$customer_details = array(
    'first_name'    => $user['user_nama'],
    'country_code'  => 'IDN',
    'email' => $paket['paket_email']
);
// Fill transaction details
// Optional
$item1_details = array(
    'id' => $paket['id_paket'],
    'price' => $paket['paket_harga'],
    // 'price' => 5000,
    'quantity' => 1,
    'name' => "Paket ".$paket['paket']." Artikel"
);
// Optional
$item_details = array($item1_details);

$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);
if ($currentToken == '') {
    $snapToken = Snap::getSnapToken($transaction);
    // Update Transaction Mid_Snap
    mysqli_query($con,"UPDATE paket set mid_token = '$snapToken' where id_paket = '$transaction_id'");
    echo '<script>
    window.location.href="https://app.midtrans.com/snap/v2/vtweb/'.$snapToken.'"
    </script>';
    die();
} else {
    $snapToken = $currentToken;
    echo '<script>
    window.location.href="https://plagiarismcheck.denpasarinstitute.com/memberarea/media.php?module=home"
    </script>';
    die();
}
// echo
// echo "snapToken = " . $snapToken;

?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    html,
    body,
    .container-table {
        height: 100%;
    }

    .container-table {
        display: table;
    }

    .vertical-center-row {
        display: table-cell;
        vertical-align: middle;
    }
</style>

<body>
    <div class="container container-table">
        <div class="row vertical-center-row">
            <div class="alert alert-success">
                <div class="spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div> Your page will be redirect to payment page...
            </div>
        </div>
    </div>
    <div class="container my-auto">
    </div>
    <!-- <button id="pay-button">Pay!</button> -->
    <!-- <div class="loading"></div> -->
    <!-- <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> -->
    <!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-hBOW65FSvAnbcM1h"></script> -->
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-ZoZ_GI-Ot-NQuoh3"></script>
    <script type="text/javascript">
        setTimeout(() => {
            setInterval(() => {
                var iframes = document.getElementsByTagName('iframe');
                if (iframes.length == 0) {
                    window.location.href = "../memberarea/media.php?membermodule=paket"

                } else {
                    // $('.loading').hide()

                }
            }, 1000);
        }, 5000);
        // document.getElementById('pay-button').onclick = function() {
        // SnapToken acquired from previous step
        setTimeout(() => {
            window.location.href="https://app.midtrans.com/snap/v2/vtweb/<?php echo $snapToken ?>"
        }, 3000);
        // snap.pay('<?php echo $snapToken ?>', {
        //     // Optional
        //     onSuccess: function(result) {
        //                             window.location.href = "../memberarea/media.php?membermodule=paket"

        //     },
        //     // Optional
        //     onPending: function(result) {
        //                             window.location.href = "../memberarea/media.php?membermodule=paket"


        //     },  
        //     // Optional
        //     onError: function(result) {
        //                             window.location.href = "../memberarea/media.php?membermodule=paket"


        //     }
        // });
        // };
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>