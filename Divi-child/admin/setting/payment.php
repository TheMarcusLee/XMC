<?php 
global $wpdb;
$table = $wpdb->prefix.'register_user';

$user_id= $_SESSION['user_id'];
if(isset($_POST['payment_field'])){ 
       
    $credit_card = $_POST['credit_card'];
    $arb_transaction_key = $_POST['credit_card'];
    $arb_transaction_key = $_POST['arb_transaction_key'];
    $hmac_key = $_POST['hmac_key'];
    $payeezy_key_id = $_POST['payeezy_key_id'];
    $payeezy_gateway_id = $_POST['payeezy_gateway_id'];
    $Payeezy_gateway_password = $_POST['Payeezy_gateway_password'];
    $paypal_check = $_POST['paypal_check'];
    $paypal_email_id = $_POST['paypal_email_id'];
    $stripe_primary = $_POST['stripe_primary'];
    $stripe_secret = $_POST['stripe_secret'];

    $data = array('credit_card'=>$credit_card,
                   'arb_login_key' =>$_POST['arb_login_key'],
                  'arb_transaction_key' => $arb_transaction_key,                  
                  'hmac_key' => $hmac_key,
                  'payeezy_key_id' => $payeezy_key_id,
                  'payeezy_gateway_id' => $payeezy_gateway_id,
                  'Payeezy_gateway_password' => $Payeezy_gateway_password,
                  'paypal_check' => $paypal_check,
                  'paypal_email_id' => $paypal_email_id,
                  'stripe_primary' => $stripe_primary,
                  'stripe_secret' => $stripe_secret,
                );
    $where = array('id'=>$user_id);
    $update = $wpdb->update($table,$data,$where);
    if($_SESSION['role'] == 'admin'){
        echo "<script>window.location.href='".home_url()."/my-dashboard/?option=settings';</script>";
    }else{ 
        echo "<script>window.location.href='".home_url()."/dashboard/?option=settings';</script>";
    }
}

?>