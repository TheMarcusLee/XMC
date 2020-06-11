<?php 
session_start();
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
global $wpdb;
$user_id= $_SESSION['user_id'];

include( get_template_directory() . '-child/admin/header.php' );
$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);					
$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
$his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");
?>
	<style>
		.sidebar {
			background: #333;
			color: #fff;
			min-height: 600px;
		}
		.payment-icon {
			font-size: 45px;
		}
		.payment-status h3 {
			margin-top: 0px;
		}
		.payment-status {
			background: #fff;
			width: 35%;
			margin: auto;
			text-align: center;
			padding: 15px 35px 14px;
			margin-top: 10%;
			border-radius: 5px;
			border: 1px solid #ccc;
		}
		
		.paymentBtn {
			padding: 6px 15px;
			display: inline-block;
			border-radius: 20px;
			border: 1px solid;
			margin-top: 10px;
			margin-bottom: 15px;
		}
		.success-payment .payment-icon i {
			color: green;
		}
		.successBtn {
			border-color: green;
			color: green;
		}
		.successBtn:hover , .successBtn:focus{
			border-color: green;
			color: #fff;
			background: green;
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 767px) and (orientation: landscape) {
		.payment-status {
				width: 100% !important;
				margin-bottom: 40px !important;
			}
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 767px) and (orientation: portrait) {
			.payment-status {
				width: 100% !important;
				margin-bottom: 40px !important;
			}
		}
	</style>
<section class="dashboard">
    <div class="container-fluid">
        <div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
            <div class="row">
            <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
                    <?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                    <div class="payment-status success-payment">
                        <!-- Modal -->
                        <div class="payment-icon">
                            <i class="fa fa-check-circle-o"></i>
                        </div>
                        <h3>Payment Success</h3>
                        <p>Thank you, for payment </p>
                        <a href="<?php echo home_url();?>/dashboard" class="paymentBtn successBtn">Dashboard</a>
                    </div>
                </div>
                <?php $refrer_table = $wpdb->prefix.'register_user';
					  $refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);
					  if($_GET['software']== 'tier2'){
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
						  $mail->SetFrom( $admin->email , ucwords($admin->fname.' '.$admin->lname));  
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
						  if($his_refrer_detail->username == $_GET['referer'] && $refrer_name->paid_tier2_referer == 0){ 
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
							$data = array('tier2_status'=>'1','all_puchased' => 1);
							$update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
							global $wp;
							wp_redirect(home_url().'/dashboard/?page=successs');
						  }           
						}elseif($refrer_detail->sales_ter2_count >= 2){
							 //check for my refer third or more sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
							 if($refrer_detail->username == $_GET['referer'] && $refrer_name->paid_tier2_referer == 0){ 
							  
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
							if($his_refrer_detail->username ==  $_GET['referer'] && $refrer_name->paid_tier2_his == 0){
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
								$mail->addAddress($to,ucwords($his_refrer_detail->fname.' '.$his_refrer_detail->lname));
								$mail->Send();	
								
								$data = array('paid_tier2_his'=>'1','tier2_status'=>'1');
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
					  if($_GET['software']== 'tier1'){
						global $wpdb;
						$refrer_table = $wpdb->prefix.'register_user';
					   
						$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);	
				
						$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
						$his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");
						$admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");
				
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
											'send_amount'=>$_GET['amount'],
											'payment_method'=>'paypal',);
							  $insert = $wpdb->insert($earing_table,$ins);
								global $wp;
								wp_redirect(home_url().'/dashboard/?page=success');
						  }
				
						}elseif($refrer_detail->sales_count == 1){
						  //check for my refer second sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
						  if($refrer_detail->username == $_GET['referer'] && $refrer_name->paid_tier1_referer == 0){ 
							
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
							$mail->Host       = "mail.xtrememarketingcode.com"; 							  														
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
							$mail_t1->Host       = "mail.xtrememarketingcode.com"; 							     													
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
												'send_amount'=>$_GET['amount'],
												'payment_method'=>'paypal',);
									$insert = $wpdb->insert($earing_table,$ins);
								  global $wp;
								  wp_redirect(home_url().'/dashboard/?page=success');
							}
						  }
						  if(isset($_GET['role'])){      
							$s_data = array('sales_count'=>$refrer_detail->sales_count+1);
							$s_update = $wpdb->update($refrer_table,$s_data,array('username'=>$refrer_name->refrencename));      
							$data = array('paid_tier1_admin'=>'1','tier1_status'=>'1','all_puchased' => 1);
							$update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));    
							if($update){
								$earing_table = $wpdb->prefix.'earnings';
												$ins = array('rec_id'=>$admin->id, 
															'send_id'=>$_SESSION['user_id'],
															'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
															'send_email'=>$refrer_name->email,
															'send_amount'=>$amount,
															'payment_method'=>'paypal',);
												$insert = $wpdb->insert($earing_table,$ins);
									global $wp;
									wp_redirect(home_url().'/dashboard/?page=success');
							  }         
						  }
						  if($refrer_name->paid_tier1_referer == 1 && $refrer_name->paid_tier1_admin == 1){
							$data = array('tier1_status'=>'1','all_puchased' => 1);
							$update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
							global $wp;
							wp_redirect(home_url().'/dashboard/?page=success');
						  }           
						}elseif($refrer_detail->sales_count >= 2){
							 //check for my refer third or more sales  and check paid to him and also confirm that i paid to him by flag paid_tier1_referer
							 if($refrer_detail->username == $_GET['referer'] && $refrer_name->paid_tier1_referer == 0){ 
							  
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
															'send_amount'=>$_GET['amount'],
															'payment_method'=>'paypal',);
												$insert = $wpdb->insert($earing_table,$ins);
									global $wp;
									wp_redirect(home_url().'/dashboard/?page=success');
							  }
							}
							//check and confirm that i paid to my referer and check flag 'paid_tier1_his'
							if($his_refrer_detail->username ==  $_GET['referer'] && $refrer_name->paid_tier1_his == 0){
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
								$mail->Host       = "mail.xtrememarketingcode.com"; 														
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
													'send_amount'=>$_GET['amount'],
													'payment_method'=>'paypal',);
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
							exit;
						}                                       
					  } 					  
					  if($_GET['software']== 'licence'){
						$data = array('r_licence'=>'1','date_purch_rlicence'=>date('Y-m-d', strtotime('+1 year')));
						$update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
						$admin_table = $wpdb->prefix.'register_user';
						$admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");    
						$refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	
						$ins = array('rec_id'=>$admin->id, 
									'send_id'=>$_SESSION['user_id'],
									'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
									'send_email'=>$refrer_name->email,
									'send_amount'=>$amount,
									'payment_method'=>'paypal',);
						$insert = $wpdb->insert($earing_table,$ins);             
						global $wp;
						wp_redirect(home_url().'/dashboard/?page=success');
						exit;
					  } 
					  if($_GET['software']== 'all'){
						$data = array('all_puchased'=>'1');
						$update = $wpdb->update($refrer_table,$data,array('id'=>$_SESSION['user_id']));
						$admin_table = $wpdb->prefix.'register_user';
						$admin = $wpdb->get_row("SELECT * FROM $admin_table WHERE role ='admin'");  
						$refrer_name = $wpdb->get_row("SELECT * FROM $admin_table WHERE id=".$_SESSION['user_id']);	
						$ins = array('rec_id'=>$admin->id, 
									'send_id'=>$_SESSION['user_id'],
									'send_name'=>$refrer_name->fname.' '.$refrer_name->lname,
									'send_email'=>$refrer_name->email,
									'send_amount'=>$amount,
									'payment_method'=>'paypal',);
                 		$insert = $wpdb->insert($earing_table,$ins);               
						global $wp;
						wp_redirect(home_url().'/dashboard/?page=success');
						exit;
					  } 
					  if($update){
							global $wp;
							wp_redirect(home_url().'/dashboard/?page=success');
					  }
					  ?>
				</div>
			</div>
		</div>
	</section>                
<?php
  include( get_template_directory() . '-child/admin/footer.php' );
?>