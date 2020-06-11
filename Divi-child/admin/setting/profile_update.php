<?php 
global $wpdb;
$table = $wpdb->prefix.'register_user';
$user_id= $_SESSION['user_id'];
if(isset($_POST['profile'])){    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pro_mobile = $_POST['pro_mobile'];
    $data = array('fname'=>$fname,
                  'lname' => $lname,     
		  'email' => $email,             
                  'mobile' => $pro_mobile);
    $where = array('id'=>$user_id);
    $update = $wpdb->update($table,$data,$where);
    if($_SESSION['role'] == 'admin'){
        echo "<script>window.location.href='".home_url()."/my-dashboard/?option=settings';</script>";
    }else{ 
        echo "<script>window.location.href='".home_url()."/dashboard/?option=settings';</script>";
    }
}

?>