<?php
/*
 * Template Name: capture 1
 * */
global $wp;
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
if(!isset($_GET['sales'])){
	wp_redirect(home_url().'/dashboard/?page=capture_and_sales');
}
if(isset($_POST['submit'])){
	
	global $wpdb;
	global $wp;
	$table = $wpdb->prefix.'leads';
	$email_address = $_POST['email'];
	$fname = $_POST['fname'];
	$last_name = $_POST['lname'];
	$keyword =$_GET['keyword'];
	$refrer_table = $wpdb->prefix.'register_user';
	$affiliates  = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$keyword."'");	
	
	$admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");  
	
	$phonenumber = $_POST['phonenumber'];
			$data = array('leads_fname' => $_POST['fname'],
						'leads_lname' => $_POST['lname'],						
						'leads_email' => $_POST['email'],
						'leads_phonenumber' => $_POST['phonenumber'],
						'keyword' => $_GET['keyword'], 
						'join_date' => date('Y-m-d')
						);			
			$wp = $wpdb->insert($table,$data);
			$message = '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body><b> Hello '.ucwords($affiliates->fname.' '.$affiliates->lname).',</b> 

			<p>A visitor was at your site and has filled out your capture page.  Below is their information</p>
			
			<p>'.ucwords($fname.' '.$last_name).'</p>
			<p>'.$phonenumber.'</p>
			<p>'.$email_address.'</p>						
			
			<p>Congrats</p>
			<br>			
			Xtreme Marketing Code Admin
			';
			$subject = 'You just received a new XMC Lead';															
			$message .= '</body></html>';																											  													
			$to     = $affiliates->email; 
			$mail   = new PHPMailer();
			$mail->SMTPAuth   = true;                 
			$mail->Host       = "mail.xtrememarketingcode.com"; 
			$mail->Port       = 587;                    
			$mail->Username   = "info@xtrememarketingcode.com"; 
			$mail->Password   = "4Dm!n@9870";      														
			$mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));
			$mail->Subject = $subject;
			$mail->MsgHTML($message); //$mail->Body    = $content;
			$mail->addAddress($to, ucwords($affiliates->fname.' '.$affiliates->lname));
			$mail->Send();			

			//wp_redirect(home_url());
			$message1 = '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body><b>'.ucwords($fname.' '.$last_name).',</b> 

			<p>Making money from home has never sounded better but when it comes to choosing HOW to make money and make it FAST, you might have come up with some illegitimate ideas. This happens - theyre out there. </p>
			
			<p>THATS NOT THIS.</p>
			
			<p>You become a part of a team, a part of an affiliate program where your work is valued. It is wanted by those that we work with. </p>
			
			<p>Residual income is where it is at when it comes to working with us and making money right from home. It is a super simple plan that actually works for those out there. </p>
			
			<p>We are all about MAKING YOU MONEY.</p>
			
			<p>When you sign up, you work towards residual income - income that is generated repeatedly. Sign up, be an affiliate, use products, sell products, make money - over and over again.</p>
			
			<p>Super SIMPLE! It is for EVERYONE you know! </p>
			
			<p>Go to the top, make the top of the money, and know you are covered when it comes to the in-come you want to earn, RIGHT NOW. </p>
			
			<p>We want everyone to be involved with building an empire. We want to show everyone what it means to actually make money for themselves. </p>
			
			<p>Never listen to the big man EVER AGAIN. </p>
			
			<p>You are in charge, in control and have everything you need to build, create your own business for yourself and grab a great paycheck daily, weekly, or monthly.</p>
			
			<p>Sign up with our program now and LEARN MORE…</p>
			
			<p>>>>>> <a href="'.$sales.'">CLICK HERE</a> <<<</p>
			
			<p>Let us help you get the paychecks you want and need… </p>
			
			<p>Heres to your success with us, making money for the future ahead,</p>
			
			<p>PS. This is for YOU. It is easy, it is beneficial, and it will make YOU MONEY! Just <a href="'.$sales.'">Click Here to Join</a></p>
			<br>
			To Your Success<br>
			Xtreme Marketing Code Admin
			';																	
			$message1 .= '</body></html>';																											  													
			$subject1 = ucwords($fname.' '.$last_name).', Become an Affiliate and START MAKING MONEY NOW';
			$to     = $email_address; 
			$mail_1   = new PHPMailer();
			$mail_1->SMTPAuth   = true;                 
			$mail_1->Host       = "mail.xtrememarketingcode.com"; 
			$mail_1->Port       = 587;                    
			$mail_1->Username   = "info@xtrememarketingcode.com"; 
			$mail_1->Password   = "4Dm!n@9870";      														
			$mail_1->SetFrom($affiliates->email, ucwords($affiliates->fname.' '.$affiliates->lname)); 
			$mail_1->Subject = $subject1;
			$mail_1->MsgHTML($message1); //$mail->Body    = $content;
			$mail_1->addAddress($to, ucwords($fname.' '.$last_name));
			$mail_1->Send();
			if($_GET['sales'] == 1 ){
				$sales = home_url().'/sales-1/?keyword='.$_GET['keyword'];
				wp_redirect(home_url().'/sales-1/?keyword='.$_GET['keyword']);
			}
			if($_GET['sales'] == 2 ){
				$sales = home_url().'/sales2/?keyword='.$_GET['keyword'];
				wp_redirect(home_url().'/sales2/?keyword='.$_GET['keyword']);
			}							  			
			//wp_redirect(home_url());			
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Capture 1</title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/capture-one.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<section class="capture-one full-height" style="background:url(<?php echo  get_template_directory_uri().'-child'; ?>/img/mountain.jpg);background-size:cover;">
		<div class="container">
			<div class="capture-box">
				<h3>Xtremely Simple Residual System Generates $500 - $1000 A Day</h3>
				<h4>Take Your Next Step TO Finacial Freedom</h4>
				<form method="post">
        <div class="form-group">
						<input type="text" class="form-control" name="fname" placeholder="First Name" required="" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="lname" placeholder="Last Name" required="" />
					</div>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email Address" required="" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="phonenumber" placeholder="Mobile Phone Number" required="" maxlength=10 minlength=10 />
					</div>  
					<button type="submit" class="btn btn-block btnCapture" name="submit">Get Started NOW!</button>
				</form>
			</div>
		</div>
	</section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>