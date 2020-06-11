<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];		
		
}
global $wpdb;

if(isset($_POST['exp_sub_mit'])){

// $checklist = implode(',',$_POST['check_list_ho_ja']);
$myArray = array();
foreach($_POST['check_list_ho_ja'] as $check){
    $myArray[] = strstr($check,'|',true);                
}
$checklist = implode(',',$myArray);    
$table_name = $wpdb->prefix.'svb_subscriber';
//$result = $wpdb->get_results("SELECT * FROM $table_name");

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=subscription'.time().'.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array('Name', 'phone Number'));  

$result = $wpdb->get_results("SELECT name,phone_number FROM $table_name WHERE id IN ($checklist)",ARRAY_A);
foreach($result as $row){
    fputcsv($output, $row);  
}     
fclose($output); 
}
if(isset($_POST['delete_sub'])){
  
    $myArray = array();
    foreach($_POST['check_list_ho_ja'] as $check){
        $myArray[] = strstr($check,'|',true);                
    }
    $checklist = implode(',',$myArray);    
    
    $table_name = $wpdb->prefix.'svb_subscriber';
    $delete = $wpdb->query("DELETE FROM $table_name WHERE id IN ($checklist)");
    if($delete > 0 ){        
        echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription&delete=1"</script>';
    }
}