<?php
/*
 * Template Name: Sales Lead
 * */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Xpress Feeders</title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/header.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/footer.css" rel="stylesheet">
<!--     <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/dashboard.css" rel="stylesheet"> -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/new-dashboard.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/setting.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/registeration.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/steps.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive-table.css" rel="stylesheet">
	
	
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
		.sidebar {
			min-height: 1996px;
		}
	</style>
  </head>
  <body>
	
	<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-lg-2 col-xs-12"></div>
					<div class="col-md-8 col-sm-8 col-lg-8 col-xs-12">
						<div class="setting-divs" style="margin-top: 40px;">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="text-right"><a href="#" class="member-login">MEMBER LOGIN</a></div>
										<div class="text-center step-head-one">
											<h2>Earn up to $1,750 a day</h2>
											<h4>with our stupid simple system!</h4>
											<div class="arows">
												<span class="fa fa-long-arrow-down"></span>
												<span class="fa fa-long-arrow-down"></span>
												<span class="fa fa-long-arrow-down"></span>
											</div>
											<h4><b>Step 1:</b> Watch Intro Video Below</h4>
											<div class="video-box" class="full-width">
												<video> 
												  <source src="<?php echo get_template_directory_uri();?>-child/img/video.mov" type="video/mp4">
												</video>
												 <div class="hover-play">
													<a href="javascript: void(0);" data-toggle="modal" data-target="#videoPopup"><i class="fa fa-play"></i></a>
												  </div>
											</div>
											
											<h4><b>Step 2:</b> Watch Comp Plan Video Below</h4>
											<div class="video-box" class="full-width">
												<video> 
												  <source src="<?php echo get_template_directory_uri();?>-child/img/video.mov" type="video/mp4">
												</video>
												 <div class="hover-play">
													<a href="javascript: void(0);" data-toggle="modal" data-target="#videoPopup"><i class="fa fa-play"></i></a>
												  </div>
											</div>
											<h4>Choose Your Membership</h4>
											<div class="arows">
												<span class="fa fa-long-arrow-down"></span>
												<span class="fa fa-long-arrow-down"></span>
												<span class="fa fa-long-arrow-down"></span>
											</div>
											<div class="text-center"><a href="https://www.xtrememarketingcode.com/registration/?username=<?php echo $_GET['keyword'];?>" class="getStareted">GET STARTED NOW</a></div>
											<div class="video-box" class="full-width">
												<video> 
												  <source src="<?php echo get_template_directory_uri();?>-child/img/video.mov" type="video/mp4">
												</video>
												 <div class="hover-play">
													<a href="javascript: void(0);" data-toggle="modal" data-target="#videoPopup"><i class="fa fa-play"></i></a>
												  </div>
											</div>
										</div>
									</div>
								</div>
							  </div>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-lg-2 col-xs-12"></div>
				</div>
			</div>
		</div>
	</section>
	