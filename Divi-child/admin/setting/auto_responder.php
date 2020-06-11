<?php 
global $wpdb;
$table = $wpdb->prefix.'register_user';
$user_id= $_SESSION['user_id'];
if(isset($_POST['responder_submit'])){
     
    $auto_integration= $_POST['auto_integration'];
    $get_response_api_key = $_POST['get_response_api_key'];
    $life_campaign_name = $_POST['life_campaign_name'];
    $affliate_name = $_POST['affliate_name'];
    $user_name = $_POST['user_name'];
    $activate_autoresponder = $_POST['activate_autoresponder'];
    $data = array('auto_integration'=>$auto_integration,
                  'get_response_api_key' => $get_response_api_key,
                  'activate_autoresponder' => $activate_autoresponder,
                  'life_campaign_name' => $life_campaign_name,
                  'affliate_name' => $affliate_name,
                  'user_name' => $user_name);
    $where = array('id'=>$user_id);
    $update = $wpdb->update($table,$data,$where);
    echo "<script>window.location.href='".home_url()."/dashboard/?option=settings';</script>";
}   

?>