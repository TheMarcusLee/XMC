<?php 
/*
 * Template Name: SMS Follow up Twilio
 * Cron job setup for follow up messages on create of campaing
*/
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the twilio library
use Twilio\Rest\Client;
global $wpdb;
$table_name = $wpdb->prefix.'sms_crone'; //main table data is gathering from this table "root";
$sub_table = $wpdb->prefix.'svb_subscriber'; //sub table
$twilio = $wpdb->prefix.'twilio_detail'; //twilio detail 
$campaign = $wpdb->prefix.'svb_campaings'; //campaign table
$query = $wpdb->get_results("SELECT * FROM  $table_name", ARRAY_A);
date_default_timezone_set('America/Chicago'); // CDT
$cur_date = date('Y-m-d');        
echo $cur_time =  date('h:i A');
foreach($query as $que){
    $get_twilio = $wpdb->get_row("SELECT * FROM $twilio WHERE registereduser_id =".$que['user_id']);	 // get twilio creditionals        
    $sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
    $token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
    $client = new Twilio\Rest\Client($sid, $token); // store twilio library in a variable
    // get campdetails for sender no 
    $get_camp = $wpdb->get_row("SELECT * FROM $campaign WHERE id =".$que['sms_camp_id']);	 // get campaign details
    $twilio_number = $get_camp->phone_number;
    $txt = $que['crone_sms_text'];
    if($cur_date == $que['crone_date'] && $cur_time == $que['crone_time']){                        
        $subscribers = $wpdb->get_results("SELECT * FROM $sub_table WHERE campaign = ".$que['sms_camp_id']." AND status = 0 AND registereduser_id =".$que['user_id'],ARRAY_A); 
        // o count($subscribers);
        if($subscribers){            
            foreach($subscribers as $sub){
                
                $rec_no = $sub['phone_number'];
                //code for send twilio message using cron job and its being scheduled by date and time 
                $messages = $client->messages->create(
                    // the number you'd like to send the message to
                        ''.$rec_no.'',
                    array(
                        // A Twilio phone number you purchased at twilio.com/console
                        //'from' => '+13143100397 ',
                        'from' => $twilio_number,
                        // the body of the text message you'd like to send
                        'body' => $txt
                    )
                );
            }        
        }
    }

}
?>