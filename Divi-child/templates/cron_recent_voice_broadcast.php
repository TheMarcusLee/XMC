<?php 
/*
 * Template Name: Recent Voice brodcst Twilio
 * Cron job setup for recent Voice broadcasting 
*/
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the twilio library
use Twilio\Rest\Client;
global $wpdb;
$table_name = $wpdb->prefix.'svb_recent_voice'; //main table data is gathering from this table "root";
$sub_table = $wpdb->prefix.'svb_subscriber'; //sub table
$twilio = $wpdb->prefix.'twilio_detail'; //twilio detail 
$campaign = $wpdb->prefix.'svb_campaings'; //campaign table
$query = $wpdb->get_results("SELECT * FROM  $table_name WHERE type = 0", ARRAY_A);  // get details of recent broadcast
date_default_timezone_set('America/Chicago'); // CDT
$cur_date = date('m/d/Y');        
$cur_time =  date('H:i');    
$fin_arr = array();
foreach($query as $que){                 
    $get_twilio = $wpdb->get_row("SELECT * FROM $twilio WHERE registereduser_id =".$que['registereduser_id']);  // get twilio creditionals        
    $sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
    $token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
    $client = new Twilio\Rest\Client($sid, $token); // store twilio library in a variable
    // get campdetails for sender no 
    $get_camp = $wpdb->get_row("SELECT * FROM $campaign WHERE id =".$que['select_camp']);  // get campaign details
    // $twilio_number = $get_camp->phone_number;
    $ph_no = explode(',',$que['phone_number']);	    
    //$txt = $que['sms_text'];		
    $camp_ids = explode(',',$que['select_camp']);
    $voice_id = $que['recent_voice_id'];        
    if($cur_date == $que['sch_date'] && $cur_time == $que['sch_time']){		
        $user_id = $que['registereduser_id'];
        foreach ($camp_ids as $camp_id) {
             // get there subscribers details on behalf of camp id 
            $subscribers = $wpdb->get_results("SELECT * FROM $sub_table WHERE campaign = ".$camp_id." AND status = 0 AND registereduser_id =".$user_id,ARRAY_A);  			
            $all_arr = array_filter($subscribers);
            foreach($all_arr as $sub_ph){						
                $fin_arr[] = $sub_ph;
                //print_r($sub_ph);
            }	
        }                 
        //foreach($ph_no as $twilio_number){                                   
        for($i=0;$i<count($ph_no)+1;$i++){        
            foreach($fin_arr as $sub){                 
            //$rec_no = $sub['phone_number'];				                                  
                //code for send twilio message using cron job and its being scheduled by date and time 
                    $call = $client->calls->create(
                        // the number you'd like to call
                            ''.$sub.'',						
                            // A Twilio phone number you purchased at twilio.com/console
                            //'from' => '+13143100397 ',
                            $ph_no[$i],
                            // the body of the text message you'd like to send
                            array(                                        
                                'url' => 'https://www.xtrememarketingcode.com/call/?id='.$voice_id,
                            )
                    );   
                //print($call.sid);                      
            }
        }        
    }
}
?>