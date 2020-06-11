<?php
session_start();
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
global $wpdb;
$user_id= $_SESSION['user_id'];
if(!isset($_GET['role'])){
$refrer_table = $wpdb->prefix.'register_user';
$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
$ref_name = $_POST['referer'];
$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$ref_name."'");

	//$serviceURL = 'https://api-cert.payeezy.com/v1/transactions';
$serviceURL = 'https://api.payeezy.com/v1/transactions';
$apiKey = $refrer_detail->hmac_key;
$apiSecret = $refrer_detail->payeezy_key_id;
$token = $refrer_detail->payeezy_gateway_id;
}elseif($_GET['role'] == 'admin'){
    $refrer_table = $wpdb->prefix.'register_user';
    $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
    $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='easy'");
    
    //$serviceURL = 'https://api-cert.payeezy.com/v1/transactions';
	$serviceURL = 'https://api.payeezy.com/v1/transactions';	
    $apiKey = $refrer_detail->hmac_key;
    $apiSecret = $refrer_detail->payeezy_key_id;
    $token = $refrer_detail->payeezy_gateway_id;
}
$post_value = $_POST;

if(isset($_POST['submit'])){
//setPrimaryTxPayload($post_value);
}else{
    
}
$nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
$timestamp = strval(time()*1000); //time stamp in milli seconds
$payload = getPayload(setPrimaryTxPayload($post_value));
function processInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return strval($data);
  }
  function setPrimaryTxPayload($post_value){
       //$post_value['card_name'];
       
        $amt = $post_value['amount'];    
        $fin_amt = (int)substr($amt, strpos($amt, "$") + 1); 
        $card_holder_name = $card_number = $card_type = $card_cvv = $card_expiry = $currency_code = $merchant_ref="";
        $card_holder_name = processInput($post_value['card_name']);
        $card_number = processInput($post_value['card_no']);
        $card_type = processInput($post_value['card_type']);
        $card_cvv = processInput($post_value['cvv']);
        $card_expiry = processInput($post_value['card_month'].$post_value['card_year']);
        $amount = processInput($fin_amt);
        $currency_code = processInput("USD");
       // $merchant_ref = processInput("Astonishing-Sale");
        $merchant_ref = processInput($_GET['page']);
        // $card_holder_name = processInput("John Smith");
        // $card_number = processInput("4788250000028291");
        // $card_type = processInput("visa");
        // $card_cvv = processInput("123");
        // $card_expiry = processInput("1218");
        // $currency_code = processInput("USD");
        // $amount = processInput("1200");
        
        $primaryTxPayload = array(
            "amount"=> $amount,
            "card_number" => $card_number,
            "card_type" => $card_type,
            "card_holder_name" => $card_holder_name,
            "card_cvv" => $card_cvv,
            "card_expiry" => $card_expiry,
            "merchant_ref" => $merchant_ref,
            "currency_code" => $currency_code,
        );
        // print_r($primaryTxPayload); exit;
        getPayload($primaryTxPayload);
        return $primaryTxPayload;
}
/**
   * Payeezy
   *
   * Generate Payload
   */
   function getPayload($args = array())
  { 
    $args = array_merge(array(
        "amount"=> "",
        "card_number" => "",
        "card_type" => "",
        "card_holder_name" => "",
        "card_cvv" => "",
        "card_expiry" => "",
        "merchant_ref" => "",
        "currency_code" => "",
        "transaction_tag" => "",
        "split_shipment" => "",
        "transaction_id" => "",
    ), $args);
    $data = "";    
    $data = array(
              'merchant_ref'=> $args['merchant_ref'],
              'transaction_type'=> "authorize",
              'method'=> 'credit_card',
              'amount'=> $args['amount'],
              'currency_code'=> strtoupper($args['currency_code']),
              'credit_card'=> array(
                      'type'=> $args['card_type'],
                      'cardholder_name'=> $args['card_holder_name'],
                      'card_number'=> $args['card_number'],
                      'exp_date'=> $args['card_expiry'],
                      'cvv'=> $args['card_cvv'],
                    )
    );       
    return json_encode($data, JSON_FORCE_OBJECT);
  }
// echo "<br><br> Request JSON Payload :" ;
// echo $payload ;
// echo "<br><br> Authorization :" ;


$data = $apiKey . $nonce . $timestamp . $token . $payload; 

$hashAlgorithm = "sha256";
### Make sure the HMAC hash is in hex -->
$hmac = hash_hmac ( $hashAlgorithm , $data , $apiSecret, false );
### Authorization : base64 of hmac hash -->
$hmac_enc = base64_encode($hmac);
echo "<br><br> " ;
echo $hmac_enc;
echo "<br><br>" ;
$curl = curl_init('https://api-cert.payeezy.com/v1/transactions');
$headers = array(
      'Content-Type: application/json',
      'apikey:'.strval($apiKey),
      'token:'.strval($token),
      'Authorization:'.$hmac_enc,
      'nonce:'.$nonce,
      'timestamp:'.$timestamp,
    );
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
curl_setopt($curl, CURLOPT_VERBOSE, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
$json_response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$response = json_decode($json_response, true);    
echo "<br><br> " ;
if ( $status != 201 ) {
  // global $wp;
  // wp_redirect(home_url().'/dashboard?page=cancel');
  die("Error: call to URL $serviceURL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
} 
curl_close($curl);
// echo "Response is: \n";
if($response['validation_status'] == 'success'){
  $amt = $_POST['amount'];    
  $fin_amt_1 = substr($amt, strpos($amt, "$") + 1);
    global $wp;
    $refrer_table = $wpdb->prefix.'register_user';
    $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);
    $data = array('paid_status'=>'paid');
    $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
    wp_redirect(home_url().'/dashboard');
    if($_POST['software']== 'tier2'){
      global $wpdb;
      $refrer_table = $wpdb->prefix.'register_user';
     
      $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	

      $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
      $his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");   
      $admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");                 
      //check for my refer first sales 
      if($refrer_detail->sales_ter2_count == 0) {
        $s_data = array('sales_ter2_count'=>$refrer_detail->sales_ter2_count+1);
        $data = array('tier2_status'=>'1','all_puchased' => 1);
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
        $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
        $mail_t1->addAddress($to,ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
        $mail_t1->Send();	
        //endd mail to referer
        if($update){
          $earing_table = $wpdb->prefix.'earnings';
              $ins = array('rec_id'=>$refrer_detail->id, 
                          'send_id'=>$_SESSION['user_id'],
                          'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                          'send_email'=>$refrer_name->email,
                          'send_amount'=>200,
                          'payment_method'=>'authorize',);
            $insert = $wpdb->insert($earing_table,$ins);
              global $wp;
              wp_redirect(home_url().'/dashboard/?page=successs');
        }

      }elseif($refrer_detail->sales_ter2_count == 1){
        //check for my refer second sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
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
          $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
          $mail_t1->addAddress($to,ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
          $mail_t1->Send();	
          //end my refere email
          if($update){
              
            $earing_table = $wpdb->prefix.'earnings';
                            $ins = array('rec_id'=>$his_refrer_detail->id, 
                                        'send_id'=>$_SESSION['user_id'],
                                        'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                        'send_email'=>$refrer_name->email,
                                        'send_amount'=>$amount,
                                        'payment_method'=>'authorize',);
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
                                          'payment_method'=>'authorize',);
                              $insert = $wpdb->insert($earing_table,$ins);
                  global $wp;
                  wp_redirect(home_url().'/dashboard/?page=successs');
            }        
        }
        if($refrer_name->paid_tier2_referer == 1 && $refrer_name->paid_tier2_admin == 1){
          $data = array('tier2_status'=>'1');
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
            $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
            $mail_t1->addAddress($to,ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
            $mail_t1->Send();	
            if($update){
              $earing_table = $wpdb->prefix.'earnings';
                  $ins = array('rec_id'    => $refrer_detail->id, 
                              'send_id'    => $_SESSION['user_id'],
                              'send_name'  => $refrer_name->fname.' '.$refrer_name->lname,
                              'send_email' => $refrer_name->email,
                              'send_amount'=> $amount,
                              'payment_method'=>'authorize',);
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
              $mail->addAddress($to,ucwords($his_efrer_detail->fname.' '.$his_efrer_detail->lname));
              $mail->Send();	
              
              $data = array('paid_tier2_his'=>'1');
              $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
            if($update){
              $earing_table = $wpdb->prefix.'earnirngs';
                      $ins = array('rec_id'=>$his_efrer_detail->id, 
                                  'send_id'=>$_SESSION['user_id'],
                                  'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                  'send_email'=>$refrer_name->email,
                                  'send_amount'=>$amount,
                                  'payment_method'=>'authorize',);
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
                                            'payment_method'=>'authorize',);
                                $insert = $wpdb->insert($earing_table,$ins);
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=successs');
              }        
          }
          if($refrer_name->paid_tier2_referer == 1 && $refrer_name->paid_tier2_his == 1){
            $data = array('tier2_status'=>'1');
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            global $wp;
            wp_redirect(home_url().'/dashboard/?page=successs');
          }    
          
      }      
      exit;     
      // $data = array('tier2_status'=>'1');                    
      // $update = $wpdb->update($table,$data,array('id'=>$user_id));  
        
    } 
      if($_POST['software']== 'tier1'){
        global $wpdb;
        $refrer_table = $wpdb->prefix.'register_user';
       
        $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
        $admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");                 
        $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
        $his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");

        //check for my refer first sales 
        if($refrer_detail->sales_count == 0) {
          $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
          $data = array('tier1_status'=>'1','all_puchased' => 1);
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
          $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
          $mail_t1->addAddress($to,ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
          $mail_t1->Send();	
          //endd mail to referer
          if($update){
            $earing_table = $wpdb->prefix.'earnings';
                $ins = array('rec_id'=>$refrer_detail->id, 
                            'send_id'=>$_SESSION['user_id'],
                            'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                            'send_email'=>$refrer_name->email,
                            'send_amount'=>$fin_amt_1,
                            'payment_method'=>'payeezy',);
              $insert = $wpdb->insert($earing_table,$ins);
                global $wp;
                wp_redirect(home_url().'/dashboard/?page=success');
          }

        }elseif($refrer_detail->sales_count == 1){
          //check for my refer second sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
          if($refrer_detail->username == $_POST['referer'] && $refrer_name->paid_tier1_referer == 0){ 
           
            $data = array('paid_tier1_referer'=>'1');
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            
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
            $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
            $mail_t1->addAddress($to,ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
            $mail_t1->Send();	
            //end my refere email
            if($update){
              $earing_table = $wpdb->prefix.'earnings';
                  $ins = array('rec_id'=>$refrer_detail->id, 
                              'send_id'=>$_SESSION['user_id'],
                              'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                              'send_email'=>$refrer_name->email,
                              'send_amount'=>$fin_amt_1,
                              'payment_method'=>'payeezy',);
                  $insert = $wpdb->insert($earing_table,$ins);
                  global $wp;
                  wp_redirect(home_url().'/dashboard/?page=success');
            }
          }
          if(isset($_GET['role'])){      
            $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
            $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));      
            $data = array('paid_tier1_admin'=>'1','tier1_status'=>'1','all_puchased' => 1);
            if($update){
              $earing_table = $wpdb->prefix.'earnings';
                  $ins = array('rec_id'=>$admin->id, 
                              'send_id'=>$_SESSION['user_id'],
                              'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                              'send_email'=>$refrer_name->email,
                              'send_amount'=>$fin_amt_1,
                              'payment_method'=>'payeezy',);
                  $insert = $wpdb->insert($earing_table,$ins);
                  global $wp;
                  wp_redirect(home_url().'/dashboard/?page=success');
            }     
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));  
                      
          }
          if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_admin == 1){
            $data = array('tier1_status'=>'1','all_puchased' => 1);
            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
            global $wp;
            wp_redirect(home_url().'/dashboard/?page=success');
            exit;
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
              $mail->addAddress($to,ucwords($refrer_name->fname.' '.$refrer_name->lname));
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
              $mail_t1->addAddress($to,ucwords($refrer_detail->fname.' '.$refrer_detail->lname));
              $mail_t1->Send();	
              if($update){
                $earing_table = $wpdb->prefix.'earnings';
                                $ins = array('rec_id'=>$refrer_detail->id, 
                                            'send_id'=>$_SESSION['user_id'],
                                            'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                            'send_email'=>$refrer_name->email,
                                            'send_amount'=>$fin_amt_1,
                                            'payment_method'=>'payeezy',);
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
                $mail->addAddress($to,ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
                $mail->Send();	
                $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
              $s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));
              $data = array('paid_tier1_his'=>'1','tier1_status'=>'1','all_puchased' => 1);
              $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
              if($update){
                $earing_table = $wpdb->prefix.'earnings';
                    $ins = array('rec_id'=>$his_refrer_detail->id, 
                                'send_id'=>$_SESSION['user_id'],
                                'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                                'send_email'=>$refrer_name->email,
                                'send_amount'=>$fin_amt_1,
                                'payment_method'=>'payeezy',);
                    $insert = $wpdb->insert($earing_table,$ins);
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=success');
              }              
            }
            if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_his == 1){
              $data = array('tier1_status'=>'1','all_puchased' => 1);
              $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
              global $wp;
              wp_redirect(home_url().'/dashboard/?page=success');
            }    
            
        }   
        global $wp;
            wp_redirect(home_url().'/dashboard/?page=success');
            exit;                                    
      } 
      if($_POST['software']== 'licence'){
        $data = array('r_licence'=>'1','date_purch_rlicence'=>date('Y-m-d', strtotime('+1 year')));
        $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
        $admin_table = $wpdb->prefix.'register_user';
        $admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");    
        $refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	             
        if($update){
          $earing_table = $wpdb->prefix.'earnings';
            $ins = array('rec_id'=>$admin->id, 
                        'send_id'=>$_SESSION['user_id'],
                        'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                        'send_email'=>$refrer_name->email,
                        'send_amount'=>$fin_amt_1,
                        'payment_method'=>'payeezy',);
            $insert = $wpdb->insert($earing_table,$ins);
              global $wp;
              wp_redirect(home_url().'/dashboard/?page=success');
        }             
            exit;
      } 
      if($_POST['software']== 'all'){
        $data = array('all_puchased'=>'1');
        $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
        $admin_table = $wpdb->prefix.'register_user';
        $admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");  
        $refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	               
        if($update){
          $earing_table = $wpdb->prefix.'earnings';
            $ins = array('rec_id'=>$admin->id, 
                        'send_id'=>$_SESSION['user_id'],
                        'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
                        'send_email'=>$refrer_name->email,
                        'send_amount'=>$fin_amt_1,
                        'payment_method'=>'payeezy',);
            $insert = $wpdb->insert($earing_table,$ins);
              global $wp;
              wp_redirect(home_url().'/dashboard/?page=success');
        }     
      } 
      
}else{
  echo "JSON response is: ".$json_response."\n"; exit;
    global $wp;
    wp_redirect(home_url().'/dashboard?page=cancel');
}
?>