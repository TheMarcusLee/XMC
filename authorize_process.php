<?php
session_start();
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
require_once "authorize/autoload.php";
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
global $wpdb;
$user_id= $_SESSION['user_id'];
$refrer_table = $wpdb->prefix.'register_user';
$my_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);


$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
			
$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
$his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");

if(isset($_GET['role'])){
	
$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role='admin'");
$api_login = $refrer_detail->arb_login_key;
$api_transaction_key = $refrer_detail->arb_transaction_key;   
// $data = array('all_puchased'=>'1');
//                 $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
//                 echo "<script>window.location.href='".home_url()."/dashboard/?page=success'</script>";
}else{
    //$refrer_table = $wpdb->prefix.'register_user';    
    $ref_name = $_POST['referer'];
    $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$ref_name."'");   
   $api_login = $refrer_detail->arb_login_key;
    $api_transaction_key = $refrer_detail->arb_transaction_key;    
} 

if(isset($_POST['submit_auth'])){
    $amt = $_POST['amount_auth'];    
$amount = substr($amt, strpos($amt, "$") + 1);    
$arr_user_info = [
    'card_number' => $_POST['card_no_auth'],
    'exp_date' => $_POST['year_auth'].'-'.$_POST['month_auth'],
    'card_code' => $_POST['cvv_auth'],
    'product' => $_GET['page'],
	//'product' => 'Test Plugin',	
    'fname' => $my_detail->fname,
    'lname' => $my_detail->lname,
    'address' => $my_detail->address,
    'city' => $my_detail->city,
    'state' => $my_detail->state,
    'zip' => $my_detail->zipcode,
    'country' => $my_detail->country,
    'email' => $my_detail->email,
    'amount' => $amount,
    'software' => $_POST['software'],
    'plan' => $_POST['plan'],
    'table' => $wpdb->prefix.'register_user',
    'rec_id' => $refrer_detail->id,
    'send_id' => $my_detail->id,
];
}
echo "<pre>";

chargeCreditCard($arr_user_info,$api_login,$api_transaction_key,$user_id);

function chargeCreditCard($arr_data = [],$api_login,$api_transaction_key,$user_id)
{
    extract($arr_data);
    /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName($api_login);
    $merchantAuthentication->setTransactionKey($api_transaction_key);
    
    // Set the transaction's refId
    $refId = 'ref' . time();
    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber($card_number);
    $creditCard->setExpirationDate($exp_date);
    $creditCard->setCardCode($card_code);
    // Add the payment data to a paymentType object
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);
    // Create order information
    $order = new AnetAPI\OrderType();
    $order->setInvoiceNumber(mt_rand(10000, 99999)); //generate random invoice number
    $order->setDescription($product);
    // Set the customer's Bill To address
    $customerAddress = new AnetAPI\CustomerAddressType();
    $customerAddress->setFirstName($fname);
    $customerAddress->setLastName($lname);
    //$customerAddress->setCompany("Souveniropolis");
    $customerAddress->setAddress($address);
    $customerAddress->setCity($city);
    $customerAddress->setState($state);
    $customerAddress->setZip($zip);
    $customerAddress->setCountry($country);
    // Set the customer's identifying information
    $customerData = new AnetAPI\CustomerDataType();
    $customerData->setType("individual");
    $customerData->setId(mt_rand(10000, 99999)); //try to set unique id here
    $customerData->setEmail($email);

    // Create a TransactionRequestType object and add the previous objects to it
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType("authCaptureTransaction");
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setOrder($order);
    $transactionRequestType->setPayment($paymentOne);
    $transactionRequestType->setBillTo($customerAddress);
    $transactionRequestType->setCustomer($customerData);

    // Assemble the complete transaction request
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($refId);
    $request->setTransactionRequest($transactionRequestType);
    // Create the controller and get the response
    $controller = new AnetController\CreateTransactionController($request);
  //  $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
    
    if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
        if ($response->getMessages()->getResultCode() == 'Ok') {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
            $tresponse = $response->getTransactionResponse();
        
            if ($tresponse != null && $tresponse->getMessages() != null) {
                //  echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
                //  echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                //  echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                //  echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
                //  echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                 
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
                                        'payment_method'=>'authorize',);
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
                                                      'payment_method'=>'authorize',);
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
                                                        'payment_method'=>'authorize',);
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
                      $data = array('tier1_status'=>'1');
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
                                        'payment_method'=>'authorize',);
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
                                                      'payment_method'=>'authorize',);
                                          $insert = $wpdb->insert($earing_table,$ins);
                              global $wp;
                              wp_redirect(home_url().'/dashboard/?page=success');
                        }
                      }
                      if(isset($_GET['role'])){                                
                          $s_data = array('sales_count'=>$refrer_detail->sales_count+1);
                        $data = array('paid_tier1_admin'=>'1','tier1_status' => 1);
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
                                wp_redirect(home_url().'/dashboard/?page=success');
                          }        
                      }
                      if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_admin == 1){
                        $data = array('tier1_status'=>'1');
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
                                            'payment_method'=>'authorize',);
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
                            $data = array('paid_tier1_his'=>'1','tier1_status'=>'1');
                            $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
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
                                wp_redirect(home_url().'/dashboard/?page=success');
                          }              
                        }
                        if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_his == 1){
                          $data = array('tier1_status'=>'1');
                          $update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
                          global $wp;
                          wp_redirect(home_url().'/dashboard/?page=success');
                        }    
                        
                    }      
                    exit;                                 
                  }            
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
                                                    'payment_method'=>'authorize',);
                                        $insert = $wpdb->insert($earing_table,$ins);
                            global $wp;
                            wp_redirect(home_url().'/dashboard/?page=success');
                      }     
                        exit;
                  } 
                  if($software== 'all'){
                    $data = array('all_puchased'=>'1','r_licence'=>'1','tier1_status'=>'1','tier2_status'=>'1',);
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
                                                    'payment_method'=>'authorize',);
                                        $insert = $wpdb->insert($earing_table,$ins);
                            global $wp;
                            wp_redirect(home_url().'/dashboard/?page=success');
                      }     
                    global $wp;
                    wp_redirect(home_url().'/dashboard/?page=success');
                    exit;
                  } 
                //   if($update){
                //         $earing_table = $wpdb->prefix.'earnings';
                //         $ins = array('rec_id'=>$rec_id, 
                //                     'send_id'=>$send_id,
                //                     'send_name'=>$fname.' '.$lname,
                //                     'send_email'=>$email,
                //                     'send_amount'=>$amount,
                //                     'payment_method'=>'authorize',);
                //         $insert = $wpdb->insert($earing_table,$ins);
                        
                //         global $wp;
                //         wp_redirect(home_url().'/dashboard/?page=success');
                //   }
                  
                 $data = array('all_puchased'=>'1','r_licence'=>'1','tier1_status'=>'1','tier2_status'=>'1',);
                $update = $wpdb->update($table,$data,array('id'=>$user_id));
                echo "<script>window.location.href='".home_url()."/dashboard/?page=success'</script>";
                
            } else {
                global $wp;
                wp_redirect(home_url().'/dashboard?page=cancel');
                // echo "Transaction Failed \n";
                // if ($tresponse->getErrors() != null) {
                //     echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
                //     echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                // }
            }
            // Or, print errors if the API request wasn't successful
        } else {
          global $wp;
           wp_redirect(home_url().'/dashboard?page=cancel');
            // echo "Transaction Failed \n";
            // $tresponse = $response->getTransactionResponse();
        
            // if ($tresponse != null && $tresponse->getErrors() != null) {
            //     echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
            //     echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
            // } else {
            //     echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
            //     echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
            // }
        }
    } else {
        //echo  "No response returned \n"; exit;
        global $wp;
        wp_redirect(home_url().'/dashboard?page=cancel');
    }
    return $response;
}
?>