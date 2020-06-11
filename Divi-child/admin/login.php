<?php
/*
Template Name: Login Form
*/
session_start();
if(isset($_SESSION['user_id'])){
	
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';
}
else{
	
if(isset($_GET['login_action'])){
  if($_GET['login_action'] == 'reset_password'){
      include(get_template_directory().'-child/admin/forgot_password.php');
  }
}
else{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url();?>/wp-content/themes/Divi-child/img/favicon.ico">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login-Xtrememarketing</title>

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
				<h3>Login</h3>
					<form action="" method="post">
					  <div class="form-group">
						<p><label>Keyword or Email</label></p>
						<input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Keyword/Email">
					  </div>
					  <div class="form-group">			
						<!-- <p><label>Password</label><i style="float: right; color: #f00;">Forgot Password</i></p> -->
						<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					  </div>
					 <input type="submit" name="submit" value="Submit" class="submit_login">
					  <div class="popup-footer"><p><a href="<?php echo home_url();?>/user-login/?login_action=reset_password"> <i class="fa fa-arrow-right"></i> Forgot Password</a></p></div>
					</form>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
</section>
</body>
</html>
<?php
if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    global $wpdb;

    $table_name = $wpdb->prefix.'register_user';
	 if (strpos($email, '@') !== false) {
		 $query = "SELECT * FROM $table_name WHERE email = '$email' AND password = '$password'";
	 }else{
	 	 $query = "SELECT * FROM $table_name WHERE username = '$email' AND password = '$password'";
	 }
   
    $result = $wpdb->get_row($query,ARRAY_A);
    if(count($result) > 0){      
      session_start();
      $_SESSION['user_id'] = $result['id'];
      $_SESSION['keyword'] = $result['username'];
      $_SESSION['role'] = $result['role'];
       if($result['role'] == 'admin'){
        echo '<script>window.location.href="'.home_url().'/my-dashboard/"</script>';
       }else{
        echo '<script>window.location.href="'.home_url().'/dashboard/"</script>';
       }
    }
    else{
        echo '<script>alert("User Name and Password is incorrect."); window.location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
    }
}
}
}
?>