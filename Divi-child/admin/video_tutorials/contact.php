<?php
include( get_template_directory() . '-child/admin/header.php' );

include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
?>
<style>
.contact-box {
    width: 60%;
    margin: 8% auto 0px;
    padding: 10px 25px;
	background: #fff;
	border-radius: 5px;
}
.contact-box h5 {
    font-size: 20px;
    margin-bottom: 15px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 7px;
	position: relative;
}
.contact-box h5:after {
    content: "";
    display: table;
    width: 80px;
    height: 2px;
    background: #CA1302;
    position: absolute;
    left: 0px;
    bottom: 0px;
}
.contact-box textarea {
    height: 110px;
}
.btnContact {
    margin-bottom: 14px;
    font-size: 15px;
    background: #e4041c;
    color: #fff;
    min-width: 90px;
}
.btnContact:hover, .btnContact:focus{background: #e4041c;color: #fff;}
</style>
<?php 
	global $wpdb;
	$refrer_table = $wpdb->prefix.'register_user';
	$user_id =$_SESSION['user_id'];
	$my_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);
	if(isset($_POST['submit'])){		
		$cont_tabl = $wpdb->prefix.'contact';
		$un_tic = md5(uniqid($user_id, true));
		$check_un_tick = $wpdb->get_row("SELECT * FROM $cont_tabl WHERE ticket=".$un_tic,ARRAY_A);
		if($check_un_tick){
			$ticket = md5(uniqid($user_id, true));
		}else{
			$ticket = $un_tic;
		}
		$name    = $_POST['full_name'];
		$email   = $_POST['email'];
		$my_subject = $_POST['subject'];
		$my_message = $_POST['my_message'];		

		$message = '<!DOCTYPE html>
		<html lang="en">
		<head>
		<title>Xtreme Marketing Code</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		</head><body>';	
		$message .= $my_message;												
		$message .= '</body></html>';																											  													
		$to     = 'support@xtrememarketingcode.com';
		// $to     = 'testwpf777@gmail.com';
		$mail   = new PHPMailer();
		$mail->SMTPAuth   = true;                 															
		$mail->setFrom($email,$name);  
		$mail->AddReplyTo($email, $name);
		$mail->Subject = $my_subject;
		$mail->MsgHTML($message); //$mail->Body    = $content;
		$mail->addAddress($to, 'Xtreme Marketing Code');
		$sent = $mail->Send();		
		if($sent){
			global $wpdb;
			$cont_tabl = $wpdb->prefix.'contact';
			$data = array('registeereed_id' => $_SESSION['user_id'], 
							'name'  => $name,
							'email'  => $email,
							'subject'  => $my_subject,
							'message'  => $my_message,
							'ticket'  => $ticket,
							'status'  => 'sent',
							'date_created' => date('Y-m-d')
			  );			
			  
			$ins = $wpdb->insert($cont_tabl,$data);
			$message = '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body>';															
			$message .= '<p>Thank you for contacting Xtreme Marketing Code support.  A service ticket has been opened on your account
			Allow up to 24 hours for an email regarding this issue.</p></br>
			Regards</br>
			Xtreme Marketing Code Support
			';
			$message .= '</body></html>';
			$to     = $email;
			$mail   = new PHPMailer();
			$mail->SMTPAuth   = true;                 															
			$mail->setFrom('support@xtrememarketingcode.com','Xtreme Marketing Code'); 
			$mail->AddReplyTo('support@xtrememarketingcode.com','Xtreme Marketing Code');	
			$mail->Subject = 'Your Support Request';
			$mail->MsgHTML($message); //$mail->Body    = $content;
			$mail->addAddress($to, 'Xtreme Marketing Code');
			$sent = $mail->Send();	
			// $mail_2   = new PHPMailer();
			// $mail_2->SMTPAuth   = true;    
			// $mail_2->setFrom('support@xtrememarketingcode.com','Xtreme Marketing Code');  
			// $mail_2->AddReplyTo('support@xtrememarketingcode.com','Xtreme Marketing Code');						     													
			// //$mail_2->SetFrom('info@xtrememarketingcode.com', 'Xtreme Marketing Code');  
			// $mail_2->Subject = $my_subject;
			// $mail_2->MsgHTML($message); //$mail->Body    = $content;
			// $mail_2->addAddress($to, 'Xtreme Marketing Code');
			// $mail_2 = $mail->Send();	
			flash('msg','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success!</strong> Thank you for contacting us.
			</div>');
			echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?option=tutorials" }, 3000);</script>';				
		}else{
			global $wpdb;
			$cont_tabl = $wpdb->prefix.'contact';
			$data = array('registeereed_id' => $_SESSION['user_id'], 
						'name'  => $name,
						'email'  => $email,
						'subject'  => $my_subject,
						'message'  => $my_message,
						'ticket'  => $ticket,
						'status'  => 'not sent',
						'date_created' => date('Y-m-d')
			);			
			$ins = $wpdb->insert($cont_tabl,$data);
		}
	}
?>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
						<div class="contact-box">
							<h5>Get in touch</h5>
							<form method="post" >
								<div class="row">
								<?php flash('msg');?>
									<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<input type="text" class="form-control"  placeholder="Name" name="full_name" readonly required value="<?php echo ucwords($my_name->fname.' '.$my_name->lname);?>"/>
										</div>
									</div>
									<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<input type="email" class="form-control" placeholder="Email Address" name="email" readonly  required value="<?php echo $my_name->email;?>"/>
										</div>
									</div>
									<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Subject" required name="subject">
										</div>
									</div>
									<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group">
											<textarea class="form-control" placeholder="Message" name="my_message" required></textarea>
										</div>
									</div>
								</div>
								<div class="text-left">
									<button type="submit" class="btn btn-default btnContact" name="submit">Submit</button>
								</div>
							</form>
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>