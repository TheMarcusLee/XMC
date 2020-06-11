<?php
/*
   Template Name: My Registration
*/
session_start();
global $wp;
if($_SESSION['role']!= 'admin') { 
    wp_redirect(home_url());
}
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');


if(isset($_GET['username'])){

	
if(isset($_POST['register'])){
	$refrence_name = $_GET['username'];
	$first_name = $_POST['fname'];
	$lname_name = $_POST['lname'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$zipcode = $_POST['zipcode'];
	$username = $_POST['username'];
	global $wpdb;
	$table_name = $wpdb->prefix.'register_user';
	$success = 0;
	$data = array(
				'refrencename' => strtolower($refrence_name),
				'fname'	=> $first_name,
				'lname'	=>  $lname_name,
				'email'	=>  $email,
				'username' => strtolower($username),
				'mobile'	=> $mobile,
				'password'	=> $password,
				'address'	=> $address,
				'country'	=> $country,
				'city'	=>  $city,
				'state'	=> $state,
				'join_date' => date('Y-m-d'),
                'zipcode'	=> $zipcode,
                'tier1_status' => 1,
                'tier2_status' => 1,
                'r_licence' => 1,
                'all_puchased' => 1,
                'date_purch_rlicence'=>date('Y-m-d', strtotime('+1 year')),
            );	
    
	global $wpdb;
	$table_name = $wpdb->prefix.'register_user';
	$check_key = $wpdb->get_row("SELECT * FROM $table_name WHERE username='".$username."'");		
	if( count($check_key) == 0 ){
		$submit = $wpdb->insert($table_name,$data);	
		$lastid = $wpdb->insert_id;
	}else{		
		flash('msg','<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Error!</strong> This Username is already exist. </div>');
	}
	
	if($submit == true){
		
		// Wordpress Registeration as well as
		
		$user_id = wp_create_user( $username, $password, $email );
		$user_id_role = new WP_User($user_id);
		$user_id_role->set_role('editor');
		global $wpdb;
		$table_name = $wpdb->prefix.'register_user';
		$refrer_detail = $wpdb->get_row("SELECT * FROM $table_name WHERE username='".$refrence_name."'");		
		//add data
		$responder = $wpdb->get_results("SELECT * FROM `wp_auto_responder` ORDER BY `wp_auto_responder`.`responder_id` ASC LIMIT 29",ARRAY_A);
		$admin = $wpdb->get_row("SELECT * FROM $table_name WHERE role ='admin'");     
		$leads = $wpdb->get_results("SELECT * FROM $lead_table WHERE keyword = '$refrence_name' AND status = 0",ARRAY_A);            		
		$i = 2;
		foreach($responder as $res){
			$data = ['registered_userid' => $lastid, 
					 'subject'  =>   $res['subject'], 
					 'body'     => $res['body'],
                     //'date' => date("m/d/Y",strtotime("+".$i." days")) 
                    ];
			$wpdb->insert('wp_auto_responder',$data);
			$i = $i+2;
		}
		// Wordpress Registeration as well as
			$message = '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body>';
			$subject = 'Welcome to Xtreme Marketing Code!';	
			$message .= '<p>Congratulations and welcome aboard to Xtreme Marketing Code. This is the premier marketing solutions suite in the industry. <p>';
			$message .= '<p>Your Keyword Code is  '.$username. '<p>'; 	
			$message .= '<p>Your Password is    '.$password. '<p>'; 
			$message .= '<p>Please be sure to reach out to your inviter to get on the track to success <p>'; 
			$message .= '<p>Your inviter is:<p>';
			$message .= '<p>'.ucwords($refrer_detail->fname.' '.$refrer_detail->lname).'<p>';
			$message .= '<p>'.$refrer_detail->email.'<p>';
			$message .= '<p>'.$refrer_detail->mobile.'<p>';
			$message .= '<p>Their Link to get started at is “https://www.xtrememarketingcode.com/sales-1/?keyword='.$refrence_name.'”<p>'; 
			$message .= '<p>To Your Success<p>'; 
			$message .= '<p>Xtreme Marketing Code Site Administration <p>'; 
			$message .= '</body></html>';
			$to     = $email; 
			$mail   = new PHPMailer();
			$mail->SMTPAuth   = true;                       	
			$mail->SetFrom($admin->email,ucwords($admin->fname.' '.$admin->lname));  
			$mail->Subject = $subject;
			$mail->MsgHTML($message); //$mail->Body    = $content;
			$mail->addAddress($to, ucwords($first_name.' '.$lname_name));
			$mail->Send();
			
			$success = 1;
		// mail($email,'Welcome for successfull registration with xmc',$message,$headers);
			//Admin registration mail			
			$subject_a = 'New User registration';	
			$admin_message .= '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body>';
			$admin_message .= '<p>Hello <b>Admin</b>,</p>';
			$admin_message .= '<p>'.ucwords($first_name.' '.$lname_name).' has registered an account</p>';
			$admin_message .= '<p>Their Inviter is'.ucwords($refrer_detail->fname.' '.$refrer_detail->lname). '<p>'; 
			$admin_message .= '<p>Phone Number is '.$mobile. '<p>'; 
			$admin_message .= '<p>Email is '.$email. '<p>'; 
			$admin_message .= '<p>Keyword code is  '.$username. '<p>'; 
			$admin_message .= 'Regards<br> Xtreme Marketing Code';
			$admin_message .= '</body></html>';
			//$to     = 'sdarvid@gmail.com'; 
			$to     = $admin->email;
			$mail_a   = new PHPMailer();
			$mail_a->SMTPAuth   = true;                       	
			$mail_a->SetFrom($admin->email,ucwords($admin->fname.' '.$admin->lname));  
			$mail_a->Subject = $subject_a;
			$mail_a->MsgHTML($admin_message); //$mail->Body    = $content;
			$mail_a->addAddress($to,  ucwords($first_name.' '.$lname_name));
			$mail_a->Send();	
		// mail('testwpf777@gmail.com','New User registration',$admin_message,$headers);

		echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/user-login"; }, 3000);</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url();?>/wp-content/themes/Divi-child/img/favicon.ico">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Registration</title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/pricing.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/registeration.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet">
		<style>
			.registeration-box h4 {
					text-align: left;
					margin-bottom: 0px;
					background: #222;
					color: #fff;
					padding: 10px 35px;
			}
			.btn-login {
					margin-right: 45px;
			}
			.btnRegister {
					margin-top: 25px;
			}
			.faq {
				padding-top: 40px;
				background: #efefef;
				margin-top: 0px;
		}
		</style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
  </head>
  <body>
	<section class="registeration">
		<div class="container">
		<div class="col-md-12" style="margin-top:15px;">
			<a href="<?php echo home_url();?>"><img src="<?php echo home_url();?>/wp-content/uploads/2018/03/logo.png" alt="Logo" width="200px"  ></a>
			<a href="<?php echo home_url();?>/my-dashboard/" class="btn btn-danger btn-login pull-right" style="margin-top: 14px;background-color: #e00719;"> <i class="fa fa-angle-left"></i> Back</a>
		</div>
			
			<div class="registeration-box" style="padding-top:35px;">
			<?php 
				if($success == 1){
			?>
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				You have Successfully Registered.
			</div>
				<?php } ?>
				<form  method="post" id="form">
				<?php flash('msg'); ?>
					<h4>Accounts Information</h4>
					<hr />
					<div class="register-bg">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">First Name <i style="color: red;">*</i></label>
								  <input type="text" name="fname" class="form-control"   aria-describedby="inputSuccess2Status" placeholder="Enter First Name" required value="<?php if(isset($_POST['xtrem_first_name'])){ echo $_POST['xtrem_first_name']; }?>">
								  <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Last Name <i style="color: red;">*</i></label>
								  <input type="text" name="lname" class="form-control"   aria-describedby="inputSuccess2Status" placeholder="Enter Last Name" value="<?php if(isset($_POST['xtrem_last_name'])){ echo $_POST['xtrem_last_name']; }?>" />
								  <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
							<div id="merror"></div>
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Email <i style="color: red;">*</i></label>
								  <input type="email" name="email" onchange= "getusername(this.value); checkemail(this.value);" class="form-control" required  aria-describedby="inputSuccess2Status" placeholder="Enter Email ID" value="<?php if(isset($_POST['xtrem_email_address'])){ echo $_POST['xtrem_email_address']; }?>" >
								  <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div id="error"></div>
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Keyword <i style="color: red;">*</i></label>
								  <input type="text" name="username" class="form-control" id="get_username" required onkeyup = "checkusername(this.value);" aria-describedby="inputSuccess2Status" placeholder="Enter your keyword code" />
								  <span class="fa fa-user form-control-feedback" aria-hidden="true"></span1>
								</div>
							</div>
						</div>
						<div class="row">
						<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Mobile <i style="color: red;">*</i></label>
								  <input type="telephone" name="mobile" class="form-control" required data-digits=true aria-describedby="inputSuccess2Status" placeholder="Enter Mobile Number" value="<?php if(isset($_POST['xtrem_phone_number'])){ echo $_POST['xtrem_phone_number']; }?>" minlength=10 maxlength=15 />
								  <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Password <i style="color: red;">*</i></label>
								  <input type="password" name="password" class="form-control"   aria-describedby="inputSuccess2Status" placeholder="Enter Password" required minlength=6>
								  <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<!-- <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Confirm Password  <i style="color: red;">*</i></label>
								  <input type="password" name="confirm_password" class="form-control"   aria-describedby="inputSuccess2Status" placeholder="Enter Confirm Password" />
								  <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
								</div>
							</div> -->
						</div>
					</div>	
					<h4>Billing Information</h4>
					<hr />
					<div class="register-bg">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Address <i style="color: red;">*</i></label>
								  <input type="text" name="address" class="form-control"   aria-describedby="inputSuccess2Status" required placeholder="Enter Address" />
								  <span class="fa fa-home form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Country <i style="color: red;">*</i></label>
								  <select class="form-control" name="country" required>
									<option value="">Select Country</option>
									<?php
									foreach($countries as $code => $value){
										echo '<option value="'.$code.'">'.$value.'</option>';
									}
									?>
								  </select>
								  <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">City <i style="color: red;">*</i></label>
								  <input type="text" class="form-control" name="city" required aria-describedby="inputSuccess2Status" placeholder="Enter City">
								  <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">State <i style="color: red;">*</i></label>
								  <input type="text" class="form-control" name="state" required  aria-describedby="inputSuccess2Status" placeholder="Enter State" />
								  <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="form-group has-success has-feedback">
								  <label class="control-label">Zip <i style="color: red;">*</i></label>
								  <input type="text" class="form-control" name="zipcode" required  aria-describedby="inputSuccess2Status" placeholder="Enter Zip">
								  <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
							
							</div>
						</div>
						<div class="row">
						    <div class="col-md-4">
							</div>
							<div class="col-md-4">
							<button type="submit" class="btn btn-danger btnRegister btn-block" style="background-color:#e00719;" name="register"> Register </button>
							</div>
							
							
							<div class="col-md-4">
							</div>
						</div>
						
					</div>
					
				</form>
			</div>
		</div>
	</section>

  </body>
</html>
<?php
	
}
else{
	echo '<script>window.location.href="'.home_url().'";</script>';
}
?>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script>
     /*** get username from email */
		 function getusername(params) {
        var stringVariable = params,
            text = stringVariable.substring(0, stringVariable.indexOf('@'));
				$("#get_username").val(text);				
				ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';				
					data = {
					'action' : 'uniqueUsername',
					'val' : text,
					};
					jQuery.post(ajax_url,data,function(response) {
						console.log(response);
						if(response == 'succsess'){
								var error = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
										error += '<strong>Error!</strong> This keyword is already exist. </div>';  
								$("#error").html(error);
								$("#get_username").focus();
						}	
					});					
		}
		function checkusername(text) {							
				ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';				
					data = {
					'action' : 'uniqueUsername',
					'val' : text,
					};
					jQuery.post(ajax_url,data,function(response) {
						console.log(response);
						if(response == 'succsess'){
							
								var error = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
										error += '<strong>Error!</strong> This keyword is already exist. </div>';  
								$("#error").html(error);
								$("#get_username").focus();
						}else if(response == "no"){
							
						}
					});					
		}
		function checkemail(email){
			ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';				
					data = {
					'action' : 'uniqueEmail',
					'val' : email,
					};
					jQuery.post(ajax_url,data,function(response) {
						console.log(response);
						if(response == 'succsess'){
								var error = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
										error += '<strong>Error!</strong> This email is already exist. </div>';  
								$("#merror").html(error);
								$("#get_username").focus();
						}else if(response == "no"){
							
						}
					});		
		}
		$(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
		$( "#form" ).validate({
    rules: {
        mobile: {
			required: true,
			number: true
        },    		
    }   
    });
 </script>