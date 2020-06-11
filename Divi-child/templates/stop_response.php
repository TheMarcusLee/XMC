<?php 
/*
Template Name: Stop Response
*/

header('content-type:text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$number = $_POST['From'];
$body = $_POST['Body'];
// $number = '+18454941599';
// $body = 'start';

if(!empty($body)){
    if(strtolower($body) == 'stop'){
        global $wpdb;
        
        //UPDATE wp_svb_subscriber SET status = '1' WHERE phone_number = '+917895526889'  <Message>                
        $sub_table = $wpdb->prefix.'svb_subscriber';
        
        $check = $wpdb->get_results("SELECT COUNT(*) as total FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);    
        
          
        // update status 
        if($check[0]['total'] > 0){
                global $wpdb;
                $sub_table = $wpdb->prefix.'svb_subscriber';  //subscriber table
                $camp_table = $wpdb->prefix.'svb_campaings';  //campaign table 
                $sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table 
                //get campaign id on behalf of number
                $campaign = $wpdb->get_row("SELECT * FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);        
                $camp_id = $campaign['campaign'];    //campaign id
                $camp_msg = $wpdb->get_row("SELECT * FROM $camp_table WHERE id = '$camp_id'",ARRAY_A); //get campaign ddetails for our record
                //insert stop in db                
                $inbox = array('phone_number' => $number,
                               'reply'        => $body,
                               'user_id'      => $camp_msg['registereduser_id'],
                               'sent_date'    => date('Y-m-d'),
                        );    
                         
                $data = array('status' => '1'); //0-> active | 1->block
                $wpdb->update($sub_table,$data,array('phone_number'=>$number));
                echo $wpdb->insert($sms_inbox,$inbox);
        ?>
        <Response>
            <Message>
                You are unsubscribe, successfully.
            </Message>
        </Response>
        <?php }else{ 
                global $wpdb;
                $sub_table = $wpdb->prefix.'svb_subscriber';  //subscriber table
                $camp_table = $wpdb->prefix.'svb_campaings';  //campaign table 
                $sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table 
                //get campaign id on behalf of number
                $campaign = $wpdb->get_row("SELECT * FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);        
                $camp_id = $campaign['campaign'];    //campaign id
                $camp_msg = $wpdb->get_row("SELECT * FROM $camp_table WHERE id = '$camp_id'",ARRAY_A); //get campaign ddetails for our record
                //insert stop in db                
                $inbox = array('phone_number' => $number,
                                'reply'        => $body,
                                'user_id'      => $camp_msg['registereduser_id'],
                                'sent_date'    => date('Y-m-d'),
                        );
                $wpdb->insert($sms_inbox,$inbox);
             ?>

            <!-- <Response>
                <Message>
                    Wrong keywords
                </Message>
            </Response> -->

    <?php   }
    }elseif(strtolower($body) == 'start'){        
            global $wpdb;
            
            //UPDATE wp_svb_subscriber SET status = '1' WHERE phone_number = '+917895526889'  <Message>                
            $sub_table = $wpdb->prefix.'svb_subscriber';
            
            $check = $wpdb->get_results("SELECT COUNT(*) as total FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);    
            
            //   print_r($camp_msg['camp_sms']);   exit;
            // update status 
            if($check[0]['total'] > 0){
                    global $wpdb;
                    $sub_table = $wpdb->prefix.'svb_subscriber';  //subscriber table
                    $camp_table = $wpdb->prefix.'svb_campaings';  //campaign table 
                    $sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table 
                    //get campaign id on behalf of number
                    $campaign = $wpdb->get_row("SELECT * FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);        
                    $camp_id = $campaign['campaign'];    //campaign id
                    $camp_msg = $wpdb->get_row("SELECT * FROM $camp_table WHERE id = '$camp_id'",ARRAY_A); //get campaign ddetails for our record
                    //inset start in db                
                    $inbox = array('phone_number' => $number,
                                   'reply'        => $body,
                                   'user_id'      => $camp_msg['registereduser_id'],
                                   'sent_date'    => date('Y-m-d'),
                            );             
                    $data = array('status' => '0'); //0-> active | 1->block
                    $wpdb->update($sub_table,$data,array('phone_number'=>$number));
                    $wpdb->insert($sms_inbox,$inbox);
            ?>
                <Response>
                    <Message>
                        You are subscribe, successfully.
                    </Message>
                </Response>
    
            <?php }else{ ?>
    
                <Response>
                    <Message>
                         Wrong keywords
                    </Message>
                </Response>
    
    <?php   }
    }else{
        global $wpdb;
        $sub_table = $wpdb->prefix.'svb_subscriber';
        $camp_table = $wpdb->prefix.'svb_campaings';
        $camp_msg_1 = $wpdb->get_row("SELECT * FROM $camp_table WHERE keyword = '$body'",ARRAY_A);  
        if($camp_msg_1){ 
            $camp_title = ucwords(getCampaignName($camp_msg_1['id'])->title);
            $ins = array(                
                'phone_number' => $number,
                'campaign' => $camp_msg_1['id'],                
                'campaign_title' => $camp_title,
                'registereduser_id'=>$camp_msg_1['registereduser_id'],                            
			);
		    $wpdb->insert($sub_table,$ins);
            ?>
            <Response>
                <Message>
                    <?php echo $camp_msg_1['camp_sms']; ?>
                </Message>
            </Response>
        <?php }else{ 
             $sub_table = $wpdb->prefix.'svb_subscriber';
            
             $check = $wpdb->get_results("SELECT COUNT(*) as total FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);    
             
             //   print_r($camp_msg['camp_sms']);   exit;
             // update status 
             if($check[0]['total'] > 0){
                     global $wpdb;
                     $sub_table = $wpdb->prefix.'svb_subscriber';  //subscriber table
                     $camp_table = $wpdb->prefix.'svb_campaings';  //campaign table 
                     $sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table 
                     //get campaign id on behalf of number
                     $campaign = $wpdb->get_row("SELECT * FROM $sub_table WHERE phone_number = '$number'",ARRAY_A);        
                     $camp_id = $campaign['campaign'];    //campaign id
                     $camp_msg = $wpdb->get_row("SELECT * FROM $camp_table WHERE id = '$camp_id'",ARRAY_A); //get campaign ddetails for our record
                     //inset start in db                
                     $inbox = array('phone_number' => $number,
                                    'reply'        => $body,
                                    'user_id'      => $camp_msg['registereduser_id'],
                                    'sent_date'    => date('Y-m-d'),
                             );             
                     $data = array('status' => '0'); //0-> active | 1->block
                     $wpdb->update($sub_table,$data,array('phone_number'=>$number));
                     $wpdb->insert($sms_inbox,$inbox);
            } ?>
            <!-- <Response>
                <Message>
                    Wrong keywords
                </Message>
            </Response> -->
        <?php }
    } 
} 
?>