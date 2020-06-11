<?php 
/*Template Name: unsubscribe
 
*/
global $wpdb;
if(isset($_GET['email'])){
$email = $_GET['email'];
$table = $wpdb->prefix.'leads';

$get = $wpdb->get_row("SELECT * FROM wp_leads WHERE `leads_email` = '$email'",ARRAY_A);

if($get > 0 ){
    if($get['leads_email'] == $email)
    {
        global $wp;
        $wpdb->update($table, array( 'status' => '1','unsub_date'=>date('Y-m-d')),array('leads_email' => $email) );
        wp_redirect(home_url().'/thank-you?email='.$email);
    } 
}
}
?>