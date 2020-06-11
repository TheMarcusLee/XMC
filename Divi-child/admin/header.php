<?php
if(isset($_GET['log_action'])){
		if($_GET['log_action'] == 'logout'){

			session_start();
			session_destroy();
			echo '<script>window.location.href="'.home_url().'"</script>';
		}
	}
	if($_SESSION['user_id'] == NULL){
		echo '<script>window.location.href="'.home_url().'/user-login"</script>';
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
    <title><?php the_title();?></title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/dashboard.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/registeration.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    		<?php 
			global $wp;
			$current_url = home_url(add_query_arg(array(),$wp->request));						
			if($current_url == home_url().'/dashboard'){ ?>

			
			<?php }else{ ?>
				<link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/profile.css" rel="stylesheet">
			<?php } ?>
		<link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/new-dashboard.css" rel="stylesheet">
		<link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/custom.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/custom-file.css" rel="stylesheet">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/earning.css" rel="stylesheet">		
		<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/setting.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo  get_template_directory_uri().'-child'; ?>/css/preloader.css">

  </head>
  <body>
<?php
	  global $wpdb;
	  $register_table = $wpdb->prefix.'register_user';
	  $userid = $_SESSION['user_id'];
	  $user_data = $wpdb->get_row("SELECT * FROM $register_table WHERE id = $userid");
	  
	  ?>
		<!-- <section class="preloader-overlay" id="overlay">
				<div class="preader-box">
				<div class="sk-circle">
					<div class="sk-circle1 sk-child"></div>
					<div class="sk-circle2 sk-child"></div>
					<div class="sk-circle3 sk-child"></div>
					<div class="sk-circle4 sk-child"></div>
					<div class="sk-circle5 sk-child"></div>
					<div class="sk-circle6 sk-child"></div>
					<div class="sk-circle7 sk-child"></div>
					<div class="sk-circle8 sk-child"></div>
					<div class="sk-circle9 sk-child"></div>
					<div class="sk-circle10 sk-child"></div>
					<div class="sk-circle11 sk-child"></div>
					<div class="sk-circle12 sk-child"></div>
				</div>
				</div>
		</section> -->
	<section class="header">
		<div class="container-fluid">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <a  class="navbar-toggle sidebar_menus">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				  <a class="navbar-brand" href="<?php echo home_url();?>"><img src="<?php echo home_url();?>/wp-content/uploads/2018/03/logo.png" alt="Logo" /></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav navbar-right dashboard-header">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?php echo ucwords($user_data->fname.' '.$user_data->lname);?>  <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<?php if($_SESSION['role'] == 'admin') { ?>
							<li><a href="<?php echo home_url();?>/my-dashboard/?option=settings"><i class="fa fa-user"></i>My Profile</a></li>
							<li><a href="<?php echo home_url();?>/my-dashboard?log_action=logout"><i class="fa fa-sign-out"></i>Log Out</a></li>
						<?php }else { ?> 
							<li><a href="<?php echo home_url();?>/dashboard/?option=settings"><i class="fa fa-user"></i>My Profile</a></li>
							<li><a href="<?php echo home_url();?>/dashboard?log_action=logout"><i class="fa fa-sign-out"></i>Log Out</a></li>
						<?php } ?>						
					  </ul>
					</li>
				  </ul>
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
		</div>
	</section>
	<?php
	if($_GET['log_action'] == 'logout'){

		session_start();
		session_destroy();
		echo '<script>window.location.href="'.home_url().'"</script>';
	}
	?>