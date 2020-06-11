<?php
session_start();

include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');

global $wpdb;
$user_id= $_SESSION['user_id'];
$refrer_table = $wpdb->prefix.'register_user';

$my_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);


$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
			
$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
$his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");

if(isset($_GET['role'])){	
    $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role='admin'");
    $secret = $refrer_detail->stripe_secret;
    $primary = $refrer_detail->stripe_primary;   
    // $data = array('all_puchased'=>'1');
    //                 $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
    //                 echo "<script>window.location.href='".home_url()."/dashboard/?page=success'</script>";
}else{
    //$refrer_table = $wpdb->prefix.'register_user';    
    $ref_name = $_POST['referer'];
    $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$ref_name."'");   
    $secret = $refrer_detail->stripe_secret;
    $primary = $refrer_detail->stripe_primary;    
} 
require_once(get_template_directory().'-child/admin/stripe/autoload.php');

$stripe = array(
    "secret_key"      => $secret,
    "publishable_key" => $primary
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);

$token  = $_POST['stripeToken'];
$email  = $_POST['stripeEmail'];
$amount  = $_POST['amount'];
$software  = $_POST['software'];
$referer  = $_POST['referer'];

$customer = \Stripe\Customer::create(array(
    'email' => $email,
    'source'  => $token
));

$charge = \Stripe\Charge::create(array(
    'customer' => $customer->id,
    'amount'   => $amount*100,
    'currency' => 'usd'
));

if($charge){
    //for tier 2 packages start 
    global $wpdb;
    global $wp;
   if($software == 'tier2'){
       global $wpdb;
       $refrer_table = $wpdb->prefix.'register_user';
      
       $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	                    
       $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");                    
       $his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");   
       $admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");             
       //check for my refer first sales 
       if($refrer_detail->sales_ter2_count == 0) {
         $s_data = array('sales_ter2_count'=>$refrer_detail->sales_ter2_count+1);
         $data = array('tier2_status'=>'1','all_puchased'=>1);
         $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
         $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
         //mail 
         $message = '<!DOCTYPE html>
         <html lang="en">
         <head>
         <title>Xtreme Marketing Code</title>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="Content-Language" content="en-us" />
         </head><body> 
         <p>Congratulations, you are now a paid member of XMC’s Tier 2.  Now you have key tools to market your business and maximize sales. Build your team and collect commissions from their sales.</p>          
         <p>Remind Your Team Members below you in Tier 1 to upgrade when it is possible so that the earnings and commissions soar. </p>                                             
         <br>
         To Your Success,<br>
         Xtreme Marketing Code Site Administration
         ';
         $subject = 'Welcome to XMC Tier 2';															
         $message .= '</body></html>';																											  													
         $to     = $refrer_name->email; 
         $mail   = new PHPMailer();
         $mail->SMTPAuth   = true;                                                                                                                             														
         $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
         $mail->Subject = $subject;
         $mail->MsgHTML($message); //$mail->Body    = $content;
         $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
         $mail->Send();	
         //end mail 
         $message1 = '<!DOCTYPE html>
         <html lang="en">
         <head>
         <title>Xtreme Marketing Code</title>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta http-equiv="Content-Language" content="en-us" />
         </head><body> 
         <p>Congratulations, you are now a paid member of XMC’s Tier 2.  Now you have key tools to market your business and maximize sales. Build your team and collect commissions from their sales.</p>          
         <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
         <p>'.$refrer_name->email.'</p>                                              
         <p>'.$refrer_name->mobile.'</p>
         <p>Has become a paid member of Tier 2. Take a moment to say hello and share your Team blueprint of success.</p>                                          
         <br>
         Cheers,<br>
         Xtreme Marketing Code Site Administration
         ';
         $subject1 = 'Congrats You Just Made $200';															
         $message1 .= '</body></html>';																											  													
         $to     = $refrer_detail->email; 
         $mail_t1   = new PHPMailer();
         $mail_t1->SMTPAuth   = true;                                                                                                                             														
         $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
         $mail_t1->Subject = $subject1;
         $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
         $mail_t1->addAddress($to, ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
         $mail_t1->Send();	
         //endd mail to referer
         if($update){
           $earing_table = $wpdb->prefix.'earnings';
               $ins = array('rec_id'=>$refrer_detail->id, 
                           'send_id'=>$_SESSION['user_id'],
                           'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                           'send_email'=>$refrer_name->email,
                           'send_amount'=>200,
                           'payment_method'=>'stripe',);
             $insert = $wpdb->insert($earing_table,$ins);
               global $wp;
               wp_redirect(home_url().'/dashboard/?page=successs');
         }

       }elseif($refrer_detail->sales_ter2_count == 1){
           
         //check for my refer second sales  and check paid to him and also confirm that i paid to him by flag paid_tier2_referer and i paid to his referer
         if($his_refrer_detail->username == $_POST['referer'] && $refrer_name->paid_tier2_referer == 0){                         
           // $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
           $data = array('paid_tier2_his'=>'1');
           $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
           //$s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
           //my email
           $message = '<!DOCTYPE html>
           <html lang="en">
           <head>
           <title>Xtreme Marketing Code</title>
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
           <meta http-equiv="Content-Language" content="en-us" />
           </head><body> 
           <p>Congratulations, you are now a paid member of XMC’s Tier 2.  Now you have key tools to market your business and maximize sales. Build your team and collect commissions from their sales.</p>          
           <p>Remind Your Team Members below you in Tier 1 to upgrade when it is possible so that the earnings and commissions soar. </p>                                             
           <br>
           To Your Success,<br>
           Xtreme Marketing Code Site Administration
           ';
           $subject = 'Welcome to XMC Tier 2';															
           $message .= '</body></html>';																											  													
           $to     = $refrer_name->email; 
           $mail   = new PHPMailer();
           $mail->SMTPAuth   = true;                                                                                                                                     														
           $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
           $mail->Subject = $subject;
           $mail->MsgHTML($message); //$mail->Body    = $content;
           $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
           $mail->Send();	
           //end my email start email to my refeerer
           $message1 = '<!DOCTYPE html>
           <html lang="en">
           <head>
           <title>Xtreme Marketing Code</title>
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
           <meta http-equiv="Content-Language" content="en-us" />
           </head><body> 
           <p>Congratulations, you just made a $150 commission!</p>          
           <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
           <p>'.$refrer_name->email.'</p>                                              
           <p>'.$refrer_name->mobile.'</p>
           <p>Has become a paid member of Tier 2.  Take a moment to say hello and share your Team blueprint of success.</p>                                          
           <br>
           Cheers,<br>
           Xtreme Marketing Code Site Administration
           ';
           $subject1 = 'Congrats You Just Made $150';															
           $message1 .= '</body></html>';																											  													
           $to     = $his_refrer_detail->email; 
           $mail_t1   = new PHPMailer();
           $mail_t1->SMTPAuth   = true;                                                                                                                                     														
           $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
           $mail_t1->Subject = $subject1;
           $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
           $mail_t1->addAddress($to, ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
           $mail_t1->Send();	
           //end my refere email
           if($update){
               
             $earing_table = $wpdb->prefix.'earnings';
                             $ins = array('rec_id'=>$his_refrer_detail->id, 
                                         'send_id'=>$_SESSION['user_id'],
                                         'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                         'send_email'=>$refrer_name->email,
                                         'send_amount'=>$amount,
                                         'payment_method'=>'stripe',);
                             $insert = $wpdb->insert($earing_table,$ins);
                 global $wp;
                 wp_redirect(home_url().'/dashboard/?page=successs');
           }
         }
         if(isset($_GET['role'])){                                
             $s_data = array('sales_ter2_count'=>$refrer_detail->sales_ter2_count+1);
           $data = array('paid_tier2_admin'=>'1','tier2_status' => 1,'all_puchased'=>1);
           $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id'])); 
           $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));   
           
           if($update){
               $earing_table = $wpdb->prefix.'earnings';
                               $ins = array('rec_id'=>$admin->id, 
                                           'send_id'=>$_SESSION['user_id'],
                                           'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                           'send_email'=>$refrer_name->email,
                                           'send_amount'=>$amount,
                                           'payment_method'=>'stripe',);
                               $insert = $wpdb->insert($earing_table,$ins);
                   global $wp;
                   wp_redirect(home_url().'/dashboard/?page=successs');
             }        
         }
         if($refrer_name->paid_tier2_referer == 1 && $refrer_name->paid_tier2_admin == 1){
           $data = array('tier2_status'=>'1','all_puchased'=>1);
           $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
           global $wp;
           wp_redirect(home_url().'/dashboard/?page=successs');
         }           
       }elseif($refrer_detail->sales_ter2_count >= 2){
            //check for my refer third or more sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
            if($refrer_detail->username == $_POST['referer'] && $refrer_name->paid_tier2_referer == 0){ 
             
             $data = array('paid_tier2_referer'=>'1');
             $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            
             $message = '<!DOCTYPE html>
               <html lang="en">
               <head>
               <title>Xtreme Marketing Code</title>
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               <meta http-equiv="Content-Language" content="en-us" />
               </head><body> 
               <p>Congratulations, you are now a paid member of XMC’s Tier 2.  Now you have key tools to market your business and maximize sales. Build your team and collect commissions from their sales.</p>          
               <p>Remind Your Team Members below you in Tier 1 to upgrade when it is possible so that the earnings and commissions soar. </p>                                             
               <br>
               To Your Success,<br>
               Xtreme Marketing Code Site Administration
               ';
               $subject = 'Welcome to XMC Tier 2';															
             $message .= '</body></html>';																											  													
             $to     = $refrer_name->email; 
             $mail   = new PHPMailer();
             $mail->SMTPAuth   = true;                                          													
             $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
             $mail->Subject = $subject;
             $mail->MsgHTML($message); //$mail->Body    = $content;
             $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
             $mail->Send();
             //end mail sendd mail to my refer
                         //end my email start email to my refeerer
             $message1 = '<!DOCTYPE html>
             <html lang="en">
             <head>
             <title>Xtreme Marketing Code</title>
             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
             <meta http-equiv="Content-Language" content="en-us" />
             </head><body> 
             <p>Congrats You Just Made a $100 commission! </p>          
             <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
             <p>'.$refrer_name->email.'</p>                                              
             <p>'.$refrer_name->mobile.'</p>
             <p>Has become a paid member of Tier 2.  Take a moment to say hello and share your Team blueprint of success.</p>                                          
             <br>
             Cheers,<br>
             Xtreme Marketing Code Site Administration
             ';
             $subject1 = ' Congrats You Just Made $100';															
             $message1 .= '</body></html>';																											  													
             $to     = $refrer_detail->email; 
             $mail_t1   = new PHPMailer();
             $mail_t1->SMTPAuth   = true;                                                                                                                                             														
             $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
             $mail_t1->Subject = $subject1;
             $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
             $mail_t1->addAddress($to, ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
             $mail_t1->Send();	
             if($update){
               $earing_table = $wpdb->prefix.'earnings';
                   $ins = array('rec_id'    => $refrer_detail->id, 
                               'send_id'    => $_SESSION['user_id'],
                               'send_name'  => $refrer_name->fname.' '.$refrer_name->lname,
                               'send_email' => $refrer_name->email,
                               'send_amount'=> $amount,
                               'payment_method'=>'stripe',);
                   $insert = $wpdb->insert($earing_table,$ins);
                   global $wp;
                   wp_redirect(home_url().'/dashboard/?page=successs');
             }
           }
           //check and confirm that i paid to my referer to his referer and check flag 'paid_tier1_his'
           if($his_refrer_detail->username ==  $_POST['referer'] && $refrer_name->paid_tier2_his == 0){
               //end my email 
               $message1 = '<!DOCTYPE html>
               <html lang="en">
               <head>
               <title>Xtreme Marketing Code</title>
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               <meta http-equiv="Content-Language" content="en-us" />
               </head><body> 
               <p>Congratulations, you just earned a $50 residual commission!</p>   
               <p>Your Team Member</p>       
               <p>'.$refrer_detail->fname.' '.$refrer_detail->lname.'</p>          
               <p>'.$refrer_detail->email.'</p>                                              
               <p>'.$refrer_detail->mobile.'</p>
               <p>Has just referred a new member to XMC .</p>                                          
               <br>
               Cheers,<br>
               Xtreme Marketing Code Site Administration
               ';
               $subject1 = 'Congrats You Just Made a $50 Residual';															
               $message1 .= '</body></html>';																											  													
               $to     = $his_refrer_detail->email; 
               $mail   = new PHPMailer();
               $mail->SMTPAuth   = true;                                                                                                                                                     														
               $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
               $mail->Subject = $subject1;
               $mail->MsgHTML($message1); //$mail->Body    = $content;
               $mail->addAddress($to, ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
               $mail->Send();                            
               $data = array('paid_tier2_his'=>'1');
               $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
             if($update){
               $earing_table = $wpdb->prefix.'earnings';
                       $ins = array('rec_id'=>$his_refrer_detail->id, 
                                   'send_id'=>$_SESSION['user_id'],
                                   'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                   'send_email'=>$refrer_name->email,
                                   'send_amount'=>$amount,
                                   'payment_method'=>'stripe',);
                       $insert = $wpdb->insert($earing_table,$ins);
                   global $wp;
                   wp_redirect(home_url().'/dashboard/?page=successs');
             }              
           }
           if(isset($_GET['role'])){                                
             $s_data = array('sales_ter2_count'=>$refrer_detail->sales_ter2_count+1);
             $data = array('paid_tier2_admin'=>'1','tier2_status' => 1,'all_puchased' => 1);
             $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id'])); 
             $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));                         
             if($update){
                 $earing_table = $wpdb->prefix.'earnings';
                                 $ins = array('rec_id'=>$admin->id, 
                                             'send_id'=>$_SESSION['user_id'],
                                             'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                             'send_email'=>$refrer_name->email,
                                             'send_amount'=>$amount,
                                             'payment_method'=>'stripe',);
                                 $insert = $wpdb->insert($earing_table,$ins);
                     global $wp;
                     wp_redirect(home_url().'/dashboard/?page=successs');
               }        
           }
           if($refrer_name->paid_tier2_referer == 1 && $refrer_name->paid_tier2_his == 1){
             $data = array('tier2_status'=>'1','all_puchased'=>1);
             $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
             global $wp;
             wp_redirect(home_url().'/dashboard/?page=successs');
           }    
           
       }      
       exit;     
       // $data = array('tier2_status'=>'1','all_puchased'=>1);                    
       // $update = $wpdb->update($table,$data,array('id'=>$user_id));
     }     
    //end tier 2
    //for tier 1 packages start
    if($software == 'tier1'){                   
        global $wpdb;
        $refrer_table = $wpdb->prefix.'register_user';
       
        $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	

        $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
        $his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");   
        $admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");                 
        //check for my refer first sales 
        if($refrer_detail->sales_count == 0) {
          $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
          $data = array('tier1_status'=>'1','all_puchased'=>1);
          $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
          $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
          //mail 
          $message = '<!DOCTYPE html>
          <html lang="en">
          <head>
          <title>Xtreme Marketing Code</title>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta http-equiv="Content-Language" content="en-us" />
          </head><body> 
          <p>Congratulations and welcome to XMC Tier 1.  Here you have the tools available to start marketing like a pro and build your current business, no matter what your business is.</p>          
          <p>We Encourage you to upgrade to Tier 2 to maximize your earnings and the marketing software. </p>          
          <p>Just go into your back office to upgrade! </p>                    
          <br>
          Cheers,<br>
          Xtreme Marketing Code Site Administration
          ';
          $subject = 'Welcome to Tier 1 of XMC';															
          $message .= '</body></html>';																											  													
          $to     = $refrer_name->email; 
          $mail   = new PHPMailer();
          $mail->SMTPAuth   = true;                                                                                                                             														
          $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
          $mail->Subject = $subject;
          $mail->MsgHTML($message); //$mail->Body    = $content;
          $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
          $mail->Send();	
          //end mail 
          $message1 = '<!DOCTYPE html>
          <html lang="en">
          <head>
          <title>Xtreme Marketing Code</title>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta http-equiv="Content-Language" content="en-us" />
          </head><body> 
          <p>Congratulations, you just made a $40 commission!.</p>          
          <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
          <p>'.$refrer_name->email.'</p>                                              
          <p>'.$refrer_name->mobile.'</p>
          <p>Has become a paid member.  Take a moment to say hello and share your Team blueprint of success.</p>                                          
          <br>
          Cheers,<br>
          Xtreme Marketing Code Site Administration
          ';
          $subject1 = 'Congrats You Just Made $40';															
          $message1 .= '</body></html>';																											  													
          $to     = $refrer_detail->email; 
          $mail_t1   = new PHPMailer();
          $mail_t1->SMTPAuth   = true;                                                                                                                             														
          $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
          $mail_t1->Subject = $subject1;
          $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
          $mail_t1->addAddress($to, ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
          $mail_t1->Send();	
          //endd mail to referer
          if($update){
            $earing_table = $wpdb->prefix.'earnings';
                $ins = array('rec_id'=>$refrer_detail->id, 
                            'send_id'=>$_SESSION['user_id'],
                            'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                            'send_email'=>$refrer_name->email,
                            'send_amount'=>40,
                            'payment_method'=>'stripe',);
              $insert = $wpdb->insert($earing_table,$ins);
                global $wp;
                wp_redirect(home_url().'/dashboard/?page=success');
          }

        }elseif($refrer_detail->sales_count == 1){
          //check for my refer second sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
          if($refrer_detail->username == $_POST['referer'] && $refrer_name->paid_tier1_referer == 0){ 
            // $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
            $data = array('paid_tier1_referer'=>'1');
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            //$s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
            //my email
            $message = '<!DOCTYPE html>
            <html lang="en">
            <head>
            <title>Xtreme Marketing Code</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta http-equiv="Content-Language" content="en-us" />
            </head><body> 
            <p>Congratulations and welcome to XMC Tier 1.  Here you have the tools available to start marketing like a pro and build your current business, no matter what your business is.</p>          
            <p>We Encourage you to upgrade to Tier 2 to maximize your earnings and the marketing software. </p>          
            <p>Just go into your back office to upgrade! </p>                    
            <br>
            Cheers,<br>
            Xtreme Marketing Code Site Administration
            ';
            $subject = 'Welcome to Tier 1 of XMC';															
            $message .= '</body></html>';																											  													
            $to     = $refrer_name->email; 
            $mail   = new PHPMailer();
            $mail->SMTPAuth   = true;                                                                                                                                     														
            $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
            $mail->Subject = $subject;
            $mail->MsgHTML($message); //$mail->Body    = $content;
            $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
            $mail->Send();	
            //end my email start email to my refeerer
            $message1 = '<!DOCTYPE html>
            <html lang="en">
            <head>
            <title>Xtreme Marketing Code</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta http-equiv="Content-Language" content="en-us" />
            </head><body> 
            <p>Congratulations, you just made a $20 commission!.</p>          
            <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
            <p>'.$refrer_name->email.'</p>                                              
            <p>'.$refrer_name->mobile.'</p>
            <p>Has become a paid member.  Take a moment to say hello and share your Team blueprint of success.</p>                                          
            <br>
            Cheers,<br>
            Xtreme Marketing Code Site Administration
            ';
            $subject1 = 'Congrats You Just Made $20';															
            $message1 .= '</body></html>';																											  													
            $to     = $refrer_detail->email; 
            $mail_t1   = new PHPMailer();
            $mail_t1->SMTPAuth   = true;                                                                                                                                     														
            $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
            $mail_t1->Subject = $subject1;
            $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
            $mail_t1->addAddress($to, ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
            $mail_t1->Send();	
            //end my refere email
            if($update){
                
              $earing_table = $wpdb->prefix.'earnings';
                              $ins = array('rec_id'=>$refrer_detail->id, 
                                          'send_id'=>$_SESSION['user_id'],
                                          'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                          'send_email'=>$refrer_name->email,
                                          'send_amount'=>$amount,
                                          'payment_method'=>'stripe',);
                              $insert = $wpdb->insert($earing_table,$ins);
                  global $wp;
                  wp_redirect(home_url().'/dashboard/?page=success');
            }
          }
          if(isset($_GET['role'])){                                
              $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
            $data = array('paid_tier1_admin'=>'1','tier1_status' => 1,'all_puchased' => 1);
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id'])); 
            $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));                          
            if($update){
                $earing_table = $wpdb->prefix.'earnings';
                                $ins = array('rec_id'=>$admin->id, 
                                            'send_id'=>$_SESSION['user_id'],
                                            'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                            'send_email'=>$refrer_name->email,
                                            'send_amount'=>$amount,
                                            'payment_method'=>'stripe',);
                                $insert = $wpdb->insert($earing_table,$ins);
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=success');
              }        
          }
          if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_admin == 1){
            $data = array('tier1_status'=>'1','all_puchased'=>1);
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            global $wp;
            wp_redirect(home_url().'/dashboard/?page=success');
          }           
        }elseif($refrer_detail->sales_count >= 2){
             //check for my refer third or more sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
             if($refrer_detail->username == $_POST['referer'] && $refrer_name->paid_tier1_referer == 0){ 
              
              $data = array('paid_tier1_referer'=>'1');
              $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
             
              $message = '<!DOCTYPE html>
              <html lang="en">
              <head>
              <title>Xtreme Marketing Code</title>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <meta http-equiv="Content-Language" content="en-us" />
              </head><body> 
              <p>Congratulations and welcome to XMC Tier 1.  Here you have the tools available to start marketing like a pro and build your current business, no matter what your business is.</p>          
              <p>We Encourage you to upgrade to Tier 2 to maximize your earnings and the marketing software. </p>          
              <p>Just go into your back office to upgrade! </p>                    
              <br>
              Cheers,<br>
              Xtreme Marketing Code Site Administration
              ';
              $subject = 'Welcome to Tier 1 of XMC';															
              $message .= '</body></html>';																											  													
              $to     = $refrer_name->email; 
              $mail   = new PHPMailer();
              $mail->SMTPAuth   = true;                                          													
              $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
              $mail->Subject = $subject;
              $mail->MsgHTML($message); //$mail->Body    = $content;
              $mail->addAddress($to, ucwords($refrer_name->fname.' '.$refrer_name->lname));
              $mail->Send();
              //end mail sendd mail to my refer
                          //end my email start email to my refeerer
              $message1 = '<!DOCTYPE html>
              <html lang="en">
              <head>
              <title>Xtreme Marketing Code</title>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <meta http-equiv="Content-Language" content="en-us" />
              </head><body> 
              <p>Congratulations, you just made a $20 commission!.</p>          
              <p>'.$refrer_name->fname.' '.$refrer_name->lname.'</p>          
              <p>'.$refrer_name->email.'</p>                                              
              <p>'.$refrer_name->mobile.'</p>
              <p>Has become a paid member.  Take a moment to say hello and share your Team blueprint of success.</p>                                          
              <br>
              Cheers,<br>
              Xtreme Marketing Code Site Administration
              ';
              $subject1 = 'Congrats You Just Made $20';															
              $message1 .= '</body></html>';																											  													
              $to     = $refrer_detail->email; 
              $mail_t1   = new PHPMailer();
              $mail_t1->SMTPAuth   = true;                                                                                                                                             														
              $mail_t1->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
              $mail_t1->Subject = $subject1;
              $mail_t1->MsgHTML($message1); //$mail->Body    = $content;
              $mail_t1->addAddress($to, ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
              $mail_t1->Send();	
              if($update){
                $earing_table = $wpdb->prefix.'earnings';
                    $ins = array('rec_id'    => $refrer_detail->id, 
                                'send_id'    => $_SESSION['user_id'],
                                'send_name'  => $refrer_name->fname.' '.$refrer_name->lname,
                                'send_email' => $refrer_name->email,
                                'send_amount'=> $amount,
                                'payment_method'=>'stripe',);
                    $insert = $wpdb->insert($earing_table,$ins);
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=success');
              }
            }
            //check and confirm that i paid to my referer to his referer and check flag 'paid_tier1_his'
            if($his_refrer_detail->username ==  $_POST['referer'] && $refrer_name->paid_tier1_his == 0){
                //end my email 
                $message1 = '<!DOCTYPE html>
                <html lang="en">
                <head>
                <title>Xtreme Marketing Code</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta http-equiv="Content-Language" content="en-us" />
                </head><body> 
                <p>Congratulations, you just earned a $20 residual commission!.</p>   
                <p>Your Team Member</p>       
                <p>'.$refrer_detail->fname.' '.$refrer_detail->lname.'</p>          
                <p>'.$refrer_detail->email.'</p>                                              
                <p>'.$refrer_detail->mobile.'</p>
                <p>Has just referred a new member to XMC .</p>                                          
                <br>
                Cheers,<br>
                Xtreme Marketing Code Site Administration
                ';
                $subject1 = 'Congrats You Just Made a $20 Residual';															
                $message1 .= '</body></html>';																											  													
                $to     = $his_refrer_detail->email; 
                $mail   = new PHPMailer();
                $mail->SMTPAuth   = true;                                                                                                                                                     														
                $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
                $mail->Subject = $subject1;
                $mail->MsgHTML($message1); //$mail->Body    = $content;
                $mail->addAddress($to, ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
                $mail->Send();	
                $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
                $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
                $data = array('paid_tier1_his'=>'1','tier1_status'=>'1','all_puchased'=>1);
                $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
              if($update){
                $earing_table = $wpdb->prefix.'earnings';
                        $ins = array('rec_id'=>$his_refrer_detail->id, 
                                    'send_id'=>$_SESSION['user_id'],
                                    'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                    'send_email'=>$refrer_name->email,
                                    'send_amount'=>$amount,
                                    'payment_method'=>'stripe',);
                        $insert = $wpdb->insert($earing_table,$ins);
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=success');
              }              
            }
            if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_his == 1){
              $data = array('tier1_status'=>'1','all_puchased'=>1);
              $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
              global $wp;
              wp_redirect(home_url().'/dashboard/?page=success');
            }    
            
        }      
        exit;                                 
      }     
    //end tier 1 packages 
    //start reseller license purchased
    if($software== 'licence'){                    
        $data_l = array('r_licence'=>'1','date_purch_rlicence'=>date('Y-m-d', strtotime('+1 year')));                    
        $update = $wpdb->update($table,$data_l,array('id'=>$user_id));
        $admin_table = $wpdb->prefix.'register_user';
        $admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");    
        $refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	             
        if($update){
            $earing_table = $wpdb->prefix.'earnings';
                            $ins = array('rec_id'=>$admin->id, 
                                        'send_id'=>$_SESSION['user_id'],
                                        'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                        'send_email'=>$refrer_name->email,
                                        'send_amount'=>$amount,
                                        'payment_method'=>'stripe',);
                            $insert = $wpdb->insert($earing_table,$ins);
                global $wp;
                wp_redirect(home_url().'/dashboard/?page=success');
          }     
            exit;
      } 
          //end 
    //start basic plan software
      if($software== 'all'){
        $data = array('all_puchased'=>'1');
        $admin_table = $wpdb->prefix.'register_user';
        $admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");
        $refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	
        $update = $wpdb->update($table,$data,array('id'=>$user_id));
        if($update){
            $earing_table = $wpdb->prefix.'earnings';
                            $ins = array('rec_id'=>$admin->id, 
                                        'send_id'=>$_SESSION['user_id'],
                                        'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                        'send_email'=>$refrer_name->email,
                                        'send_amount'=>$amount,
                                        'payment_method'=>'stripe',);
                            $insert = $wpdb->insert($earing_table,$ins);
                global $wp;
                wp_redirect(home_url().'/dashboard/?page=success');
          }     
        global $wp;
        wp_redirect(home_url().'/dashboard/?page=success');
        exit;
      } 
    //end 
    //start basic plan software
}else{
  global $wp;
  wp_redirect(home_url().'/dashboard?page=cancel');
}
// echo '<h1>Successfully charged $50.00!</h1>';