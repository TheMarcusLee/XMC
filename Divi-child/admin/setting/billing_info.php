<?php 
global $wpdb;
$table = $wpdb->prefix.'register_user';
$user_id= $_SESSION['user_id'];
if(isset($_POST['billing_field'])){    
    
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $address = $_POST['address'];
    $data = array('country'=>$country,
                  'city' => $city,                  
                  'address' => $address,                  
                  'state' => $state,                  
                  'zipcode' => $zip);
    $where = array('id'=>$user_id);
    $update = $wpdb->update($table,$data,$where);
    if($_SESSION['role'] == 'admin'){
        echo "<script>window.location.href='".home_url()."/my-dashboard/?option=settings';</script>";
    }else{ 
        echo "<script>window.location.href='".home_url()."/dashboard/?option=settings';</script>";
    }
}

?>