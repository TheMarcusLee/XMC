<?php
$error = 0;
$success = 0;
if(isset($_POST['reset_password'])){

    global $wpdb;
    $email_id = $_POST['reset_email'];
    $table_name = $wpdb->prefix.'register_user';
    $check_email = $wpdb->get_row( "SELECT * FROM $table_name WHERE email = '$email_id'" );
    //print_r($check_email);
    if($check_email == true){

        include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
        include(get_template_directory().'-child/PHPMailer/class.smtp.php');
        
        function random_password( $length = 15 ) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;,.?";
            $password = substr( str_shuffle( $chars ), 0, $length );
            return $password;
        }
        $success = 1;
        $new_password = random_password(15);
        $data = array(
            'password' => $new_password,
        );
        $where = array(
                'email'=> $email_id,
            );
        $wpdb->update($table_name,$data,$where);
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <title>Xtreme Marketing Code</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        </head><body>';
        $subject = 'Welcome for successfull registration with xmc';	
        $message .= 'Thank you for contacting <b>Xtreme Marketing Code</b> <br> Your New Password is : '.$new_password;
        $message .= "<br><a href='".home_url()."'/user-login'>Please Login</a> to reset your password<br>";
        $message .= 'Regards<br> Xtreme Marketing Code';		
        $message .= '</body></html>';
        $to     = $email_id; 
        $mail   = new PHPMailer();
        $mail->SMTPAuth   = true;                       	
        $mail->SetFrom('admin@xtrememarketingcode.com', 'Xtreme Marketing Code');  
        $mail->Subject = $subject;
        $mail->MsgHTML($message); //$mail->Body    = $content;
        $mail->addAddress($to, 'Xtreme Marketing Code');
        $mail->Send();
		// mail($email_id,'Reset Password at xmc',$message12,'Content-Type: text/html; charset=ISO-8859-1\r\n');
		
        // mail( $email_id, 'Reset Password from xmc', $message12 );
		
		
    }
    else{
        $error = 1;
    }

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forgot Password</title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/pricing.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/registeration.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<section class="registeration">
        <div class="site_logo">
           <a href="<?php echo home_url();?>"> <img src="<?php echo home_url();?>/wp-content/uploads/2018/03/logo.png" alt=""></a>
        </div>
        
	    <div class="container">
			<div class="col-md-4">

			</div>
			<div class="col-md-4">
                
				<div class="login_area">
                
				<h3>Forgot Password</h3>
                <?php if($error == 1){ ?>
                    <div class="alert alert-danger" style="margin-top:15px;">
                        Email is not registered with us.
                    </div>
                <?php   } ?>
                <?php if($success == 1){ ?>
                    <div class="alert alert-info" style="margin-top:15px;">
                        Password has been sent at your email.
                    </div>
                <?php   } ?>
					<form action="" method="post">
					  <div class="form-group">
						<p><label>Enter Your Email</label></p>
						<input type="email" name="reset_email" class="form-control" required value="<?php if(isset($_POST['reset_password'])){ echo $_POST['reset_email'];}?>" placeholder="Email">
					  </div>
					  
					 <input type="submit" name="reset_password" value="Submit" class="submit_login">
						<div class="popup-footer"><p><a href="<?php echo home_url();?>/user-login"> <i class="fa fa-arrow-left"></i> Back to login</a></p></div>
					</form>
				</div>
                
			</div>
			<div class="col-md-4">
			</div>
		</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 2000);


</script>
</body>

</html>
<?php
if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    global $wpdb;

    $table_name = $wpdb->prefix.'register_user';
    $query = "SELECT * FROM $table_name WHERE email = '$email' AND password = '$password'";
    $result = $wpdb->get_row($query,ARRAY_A);
    if(count($result) > 0){
      session_start();
      $_SESSION['user_id'] = $result['id'];

        echo '<script>window.location.href="'.home_url().'/dashboard/"</script>';
    }
    else{
        echo '<script>alert("User Name and Password is incorrect."); window.location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
    }
}
?>