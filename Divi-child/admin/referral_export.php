<?php
session_start();
if($_GET['action'] == 'export'){  
    global $wpdb;
    $table_name = $wpdb->prefix.'register_user'; 
    echo $my_key = $_SESSION['keyword'];
    $result = $wpdb->get_results("SELECT fname,lname,email,mobile,time,username FROM $table_name WHERE refrencename= '$my_key'",ARRAY_A);        
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=referral'.time().'.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output, array('First Name','Last Name', 'Email','Phone','Date','Keyword'));  
    $conteent = array();
    foreach($result as $row){
        fputcsv($output, $row);  
       
    }                       
    fclose($output);             
    exit;
}
if($_GET['action'] == 'lead_export'){  
    global $wpdb;
    // $con = mysqli_connect("localhost","s63","qIpNApiJRXlcGwFQb7y6cVmRNONtgq4VFqGdYbvb1jvRuctiXFm","s63");

	// // Check connection
	// if (mysqli_connect_errno())
	//   {
	//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	//   }
	//   $my_key = $_SESSION['keyword'];
	// $sql="SELECT user_fname,user_lname,user_email,user_phonenumber,time FROM wp_refrerral_detail WHERE refreral_keyword = '$my_key'";
    $key_word = $_SESSION['keyword'];
    $result = $wpdb->get_results("SELECT leads_fname,leads_lname,leads_email,leads_phonenumber,time FROM wp_leads WHERE keyword='$key_word'",ARRAY_A);		
    header('Content-Type: text/csv; charset=utf-8');  
    header('Content-Disposition: attachment; filename=leads'.time().'.csv');  
    $output = fopen("php://output", "w");  
    fputcsv($output, array('First Name','Last Name', 'Email','Phone','Date'));         
    $conteent = array();
    foreach($result as $row){
        fputcsv($output, $row);  
       
    }                       
    fclose($output); 
    exit;
}