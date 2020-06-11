<?php 
global $wpdb;
$table = $wpdb->prefix.'register_user';
$user_id= $_SESSION['user_id'];
if(isset($_POST['business_field'])){
	
    $custom_video= $_POST['custom_video'];
    $custom_video_text = $_POST['custom_video_text'];
    $my_custom_link = $_POST['my_custom_link'];
    $my_button_text = $_POST['my_button_text'];
    $custom_description = $_POST['custom_description'];
    $activate_primary= $_POST['activate_primary'];
    $data = array('custom_video'=>$custom_video,
                  'custom_video_text' => $custom_video_text,
                  'activate_primary' => $activate_primary,
                  'my_custom_link' => $my_custom_link,
                  'my_button_text' => $my_button_text,
                  'custom_description' => $custom_description);
    $where = array('id'=>$user_id);
    $update = $wpdb->update($table,$data,$where);
    if($_SESSION['role'] == 'admin'){
        echo "<script>window.location.href='".home_url()."/my-dashboard/?option=settings';</script>";
    }else{ 
        echo "<script>window.location.href='".home_url()."/dashboard/?option=settings';</script>";
    }
}   

?>