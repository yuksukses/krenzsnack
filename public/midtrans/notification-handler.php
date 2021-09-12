<?php
$con = mysqli_connect("localhost","denpasarinstitut","Denpasar1","denpasarinstitut_plagiarismcheck");
 date_default_timezone_set("Asia/Bangkok");
 $json_result = file_get_contents('php://input');
 $result = json_decode($json_result);
 if ($result) {
     // $stellaShop = $this->load->database('db_stellashop', TRUE);
     $transaction_id = $result->order_id;
         mysqli_query($con,"INSERT into notification_midtrans VALUES ('$result->transaction_id','$result->transaction_status','$result->transaction_time','$result->signature_key',' $result->payment_type','$result->order_id','$result->merchant_id','$result->gross_amount')");

         mysqli_query($con,"UPDATE paket set mid_transaction_id = '$result->transaction_id',mid_transaction_status = '$result->transaction_status', mid_signature_key = '$result->signature_key',  mid_payment_type = '$result->payment_type',  mid_order_id = '$result->order_id', mid_gross_amount = '$result->gross_amount' WHERE id_paket = '$transaction_id'");

         if ($result->transaction_status == 'settlement') {
            mysqli_query($con,"UPDATE paket set paket_status = 'Aktif' WHERE id_paket = '$transaction_id'");
         }
         
     error_log(print_r($result, TRUE));
 }else{
     echo "non notif";
 }