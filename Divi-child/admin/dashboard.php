<?php
/*
Template Name: Dashboard
*/
session_start();
global $wpdb;
$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'register_user';
$get_img = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id"); 
// get plan status  from admin  side 

$plan_name = $wpdb->prefix.'plan';
$plans = $wpdb->get_row("SELECT * FROM $plan_name WHERE plan_id = 1",ARRAY_A);  

//end plan status
if($_SESSION['user_id'] == NULL){
	echo '<script>window.location.href="'.home_url().'/user-login"</script>';
}

if(isset($_GET['payment'])){
	if($_GET['payment'] =="payeezy"){
		include( get_template_directory() . '-child/admin/payeezy_process.php' );
	}
	if($_GET['payment'] =="authorize"){
		include( get_template_directory() . '-child/admin/authorize_process.php' );
	}	
}
if(isset($_GET['page']) || isset($_GET['option'])){
	
	if($_GET['option'] == 'settings'){

		include( get_template_directory() . '-child/admin/setting/main_setting.php' );

	}
	if($_GET['option'] == 'leads'){
		include( get_template_directory() . '-child/admin/leads.php' );
	}
	if($_GET['option'] == 'earnings'){

		include( get_template_directory() . '-child/admin/earnings.php' );

	}
	
if($_GET['option'] == 'referrals'){

		include( get_template_directory() . '-child/admin/referrals.php' );

	}
	if($_GET['option'] == 'tutorials'){

		include( get_template_directory() . '-child/admin/video_tutorials/video_tutorials.php' );

	}
	if($_GET['page'] == 'auto_responder'){
		include( get_template_directory() . '-child/admin/autoresponder/auto_responder.php' );
	}
	if($_GET['option'] == 'media_library'){
		include( get_template_directory() . '-child/admin/media-library/media_library.php' );
	}
	if($_GET['option'] == 'subscription'){

		include( get_template_directory() . '-child/admin/subscription/subscriber.php' );

	}
	if($_GET['option'] == 'inviter_business'){

		include( get_template_directory() . '-child/admin/business/inviter_business.php' );

	}
	if($_GET['option'] == 'my_business'){

		include( get_template_directory() . '-child/admin/business/my_business.php' );

	}
	 
	if($_GET['page'] == 'ringless_voice_mail'){
		include( get_template_directory() . '-child/admin/ringless-voicemail/ringless_voice_mail.php' );		
	}  
	if($_GET['page'] == 'success'){
		include( get_template_directory() . '-child/admin/success.php' );		
	} 
	if($_GET['page'] == 'successs'){
		include( get_template_directory() . '-child/admin/successs.php' );		
	} 
	if($_GET['page'] == 'sms_voice_broadcast'){
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/sms_voice_broadcast.php' );
	}
	if($_GET['page'] == 'cancel'){
		include( get_template_directory() . '-child/admin/cancel.php' );		
	}
	if($_GET['page'] == 'view_phone_list'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/view_phone_list.php' );

	}
	if($_GET['page'] == 'capture_and_sales'){
		include( get_template_directory() . '-child/admin/capture_and_sales/capture_and_sales.php' );
	}
	if($_GET['page'] == 'capture_page_builder'){

		include( get_template_directory() . '-child/admin/capture_page_builder/capture_page_builder.php' );

	}
	if($_GET['page'] == 'reseller-licence'){
		include( get_template_directory() . '-child/admin/reseller-licence/reseller-licence.php' );
	}
	if($_GET['page'] == 'software'){
		include( get_template_directory() . '-child/admin/software/software.php' );
	}
	if($_GET['page'] == 'subscription'){

		include( get_template_directory() . '-child/admin/subscription/subscription.php' );
	}
	if($_GET['page'] == 'marketting-banner'){

		include( get_template_directory() . '-child/admin/marketting-banner/marketting-banner.php' );
	}
	if($_GET['page'] == 'paypal_success'){

		include( get_template_directory() . '-child/admin/paypal_success.php' );
	}
	if($_GET['page'] == 'traffic'){

		include( get_template_directory() . '-child/admin/traffic/traffic.php' );
	}
	if($_GET['page'] == 'getting_started'){

		include( get_template_directory() . '-child/admin/getting_started.php' );
	}
	if($_GET['page'] == 'offers'){

		include( get_template_directory() . '-child/admin/offers.php' );
	}
	
	if($_GET['page'] == 'tier1'){
		include( get_template_directory() . '-child/admin/tier1.php' );
	}	
	if($_GET['page'] == 'tier2'){
		include( get_template_directory() . '-child/admin/tier2.php' );
	}	
	if($_GET['page'] == 'contact'){
		include( get_template_directory() . '-child/admin/video_tutorials/contact.php' );
	}		
}
else{

	include( get_template_directory() . '-child/admin/header.php' );
?>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<style>
		.sidebar {
			background: #333;
			color: #fff;
			min-height: 808px;
		}
		
		
		div#paymentMethod .modal-dialog {
			width: 550px;
			margin-top: 7%;
		}
		div#paymentMethod .modal-header {
			padding: 8px 15px;
			background: #333;
			color: #fff;
		}
		div#paymentMethod .modal-header .close {
			margin-top: 3px;
			color: #fff;
			opacity: 1;
		}
		div#paymentMethod .modal-footer {
			padding: 12px 15px 10px;
		}
		div#paymentMethod .modal-content{border-radius: 0px}
		.panel-heading span {
			margin-top: -3px;
		}
		.panel-heading span {
				margin-top: -3px;
			}
			.expiration li {
			width: 50%;
			float: left;
		}
		.expiration:after {
			clear: both;
			content: "";
			display: table;
		}
		.panel-title label {
			font-size: 14px;
			font-weight: normal;
		}
		.panel-title a {
    color: #000;
    width: 96%;
    display: inline-block;
}
	.not-allowed {cursor: not-allowed;}
	.lead-btn {
    text-align: right;
}
.lead-btn i {
    position: relative;
    top: 0px;
    margin-left: 10px !important;
}
.referral-btn{text-align: right;}
.referral-btn i {
    position: relative;
    top: 0px;
    margin-left: 10px !important;
}

.start-here-button a {
    display: inline-block;
    background: #2dc0f0;
    color: #fff;
    min-width: 120px;
    text-align: center;
    line-height: 35px;
    border-radius: 3px;
    margin-top: 20%;
    font-size: 15px;
    text-transform: uppercase;
    box-shadow: 0px 2px 5px 0px #888888;
}
.start-here-button a:hover{color:#fff;background:#333333;}

.start-here-div p {
    font-size: 20px;
    margin-top: 30px;
    text-align: center;
    text-transform: uppercase;
    color: #fff;
}
.start-here-div i {
    margin-top: 25px;
    color: #4ff5b5;
}
.start-here-div {
    background: #008000!important;
    transition: all 300ms ease-in;
}
.start-here-div:hover {
    background: #2dc0f0 !important;transition: all 300ms ease-in;
}
.dashboard-inner {
    min-height: 64px;
}
.start-here-box a {
    padding: 0px;
    position: static;
}
.link-box {
    width: 60%;
    background: #fff;
    padding: 12px 20px;
    border-radius: 5px;
}

.link-box h3 {
    font-size: 18px;
    margin-top: 0px;
    position: relative;
    border-bottom: 1px solid #ccc;
    padding-bottom: 6px;
}

.link-box h3:after {
    content: "";
    display: table;
    width: 25px;
    height: 2px;
    background: #e3051c;
    position: absolute;
    bottom: 0px;
}
	</style>
	<section class="dashboard">
		<div class="container-fluid no-padding-right">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<div class="dashboard-main">
						<div class="custom-dropdown">
							<div class="dropdown-button">
								ACCOUNT OVERVIEW								
							</div>							
						</div>
						<?php 
							$refrer_table = $wpdb->prefix.'register_user';
							$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);					
							$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
						if($refrer_name->refrencename == 'easy') { 

								$size = 3; 
							}else{
								$size = 4;
							} ?>
						<div class="row">
						<div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-lg-<?php echo $size; ?> col-xs-12">
							
								<div class="small-boxes start-here-box">
									<a href="<?php echo $_SERVER['REQUEST_URI'];?>?page=getting_started" class="small-box-footer lead-btn">
									<div class="small-box bg-aqua start-here-div" style="height: 125px;border-radius: 5px;">
										<div class="inner">										
										  <p>Start Here</p>
										</div>
										<div class="icon">
										  <!--<i class="fa fa-clock-o"></i>-->
										</div>
										<!-- More info <i class="fa fa-arrow-right" style="color:#fff"></i></a> 										 -->
									  </div>	
									  </a>								
								</div>
							
							</div>
							<?php if($refrer_name->refrencename == 'easy') { 
								$size = 3; ?>
							<div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-lg-<?php echo $size; ?> col-xs-12">
							
								<div class="small-boxes start-here-box">
									<a href="<?php echo $_SERVER['REQUEST_URI'];?>?page=offers" class="small-box-footer lead-btn">
									<div class="small-box bg-aqua start-here-div" style="height: 125px;border-radius: 5px;">
										<div class="inner">										
										  <p>Special Offers</p>
										</div>
										<div class="icon">
										  <!--<i class="fa fa-clock-o"></i>-->
										</div>
										<!-- More info <i class="fa fa-arrow-right" style="color:#fff"></i></a> 										 -->
									  </div>	
									  </a>								
								</div>
							
							</div>
							<?php } ?>
							<div class="col-md-3 col-sm-<?php echo $size; ?> col-lg-<?php echo $size; ?> col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
											<?php				
												$key_word = $_SESSION['keyword'];
												$row = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_leads WHERE keyword='$key_word'",ARRAY_A);
					    // Associative array ?>
										  <h3><?php echo $row[0]['total'];?></h3>

										  <p>LEADS</p>
										</div>
										<div class="icon">
										  <i class="fa fa-users"></i>
										</div>
										<a href="<?php echo home_url();?>/dashboard/?option=leads" class="small-box-footer lead-btn">More info <i class="fa fa-arrow-right" style="color:#fff"></i></a> 
										
									  </div>
									
								</div>
							</div>
							<div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-lg-<?php echo $size; ?> col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
										<?php global $wpdb;
										 	$table_name = $wpdb->prefix.'register_user'; 
											$my_key = $_SESSION['keyword'];
											 $count = $wpdb->get_results("SELECT count(*) as total FROM $table_name WHERE refrencename= '$my_key'");
											 ?>
										  <h3><?php echo $count[0]->total; ?></h3>

										  <p>REFERRALS</p>
										</div>
										<div class="icon">
										  <i class="fa fa-users"></i>
										</div>
										<a href="<?php echo home_url();?>/dashboard/?option=referrals" class="small-box-footer referral-btn">More info  <i class="fa fa-arrow-right" style="color:#fff"></i></a>
										
									  </div>
								</div>
							</div>
						</div>
						<div class="">
						<?php
							$refrer_table = $wpdb->prefix.'register_user';
							$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);					
							$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
						 ?>
						<div class="dashboard-short">
						<?php if(paidStatus($user_id)->id != 1) { ?>
								<div class="row">
									<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
											<?php if($refrer_name->refrencename == 'easy') { ?>
											<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) { 											
												if(paidStatus($user_id)->r_licence == 1) { ?>
													<a href="<?php echo home_url();?>/dashboard/?page=reseller-licence" >													
											<?php }else{ ?>									
												<a href="#" data-toggle="modal" data-target="#paymentMethod_rliceence"  class="not-allowed">												
											<?php }
											}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
												<a href="<?php echo home_url();?>/dashboard/?page=reseller-licence" >	
											<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
												<a href="<?php echo home_url();?>/dashboard/?page=reseller-licence" >	
											<?php }else{  ?>
												<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
											<?php } ?>
											<?php } else{ 
												if(paidStatus($user_id)->r_licence == 1) { ?>
														<a href="<?php echo home_url();?>/dashboard/?page=reseller-licence" >													
											<?php }else{ ?>									
												<a href="#" data-toggle="modal" data-target="#paymentMethod_rliceence"  class="not-allowed">											
											<?php } } ?>
											<div class="dashboard-inner">
												<div class="icon-shadow">
													<i class="fa fa-handshake-o"></i>
												</div>
												<div class="dashboard-content">
													<h4>Reseller License - Hosting</h4>
												</div>
											</div>
										</a>
									</div>
								</div>
								<?php } ?>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
										<div class="tiers">
											<h3>Tier 1 Software</h3>
											<div class="row">
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
												<?php if($refrer_name->refrencename == 'easy') { ?>
												<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) { 
												if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
													<a href="<?php echo home_url();?>/dashboard/?page=capture_and_sales" >														
												<?php }else{ ?>									
													<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">													
												<?php } 
												}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
													<a href="<?php echo home_url();?>/dashboard/?page=capture_and_sales" >	
												<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
													<a href="<?php echo home_url();?>/dashboard/?page=capture_and_sales" >												
												<?php }else{  ?>
													<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
												<?php } ?>
												<?php }else{
													if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
														<a href="<?php echo home_url();?>/dashboard/?page=capture_and_sales" >														
													<?php }else{ ?>									
														<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">													
													<?php }  ?>

												<?php } ?>
													<div class="dashboard-inner">
														<div class="icon-shadow">
															<i class="fa fa-camera"></i>
														</div>
														<div class="dashboard-content">
															<h4>Capture &amp; Sales</h4>
														</div>
													</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
												<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) { 
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
															<a href="<?php echo home_url();?>/dashboard/?page=auto_responder" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">															
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/dashboard/?page=auto_responder" >
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/dashboard/?page=auto_responder" >																	
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
																<a href="<?php echo home_url();?>/dashboard/?page=auto_responder" >														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">													
															<?php }  ?>

														<?php } ?>														
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-share"></i>
															</div>
															<div class="dashboard-content">
																<h4>Auto Responder-Email Broadcaster</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
													<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) { 
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
															<a href="<?php echo home_url();?>/dashboard/?page=marketting-banner" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">															
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/dashboard/?page=marketting-banner" >
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/dashboard/?page=marketting-banner" >														
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
																<a href="<?php echo home_url();?>/dashboard/?page=marketting-banner" >													
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">													
															<?php }  ?>

														<?php } ?>
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-line-chart"></i>
															</div>
															<div class="dashboard-content">
																<h4>Marketing Banners</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
													<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) { 
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
															<a href="<?php echo home_url();?>/dashboard/?page=traffic" >														
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">															
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/dashboard/?page=traffic" >
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/dashboard/?page=traffic" >																															
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
																<a href="<?php echo home_url();?>/dashboard/?page=traffic" >
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">													
															<?php }  ?>

														<?php } ?>
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-lightbulb-o"></i>
															</div>
															<div class="dashboard-content">
																<h4>Traffic Source</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
														<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) {
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
															<a href="http://explosivegenealogyleads.com/xmc" target="_blank" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">															
														<?php } 
															}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
																<a href="http://explosivegenealogyleads.com/xmc" target="_blank"  >	
															<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
																<a href="http://explosivegenealogyleads.com/xmc" target="_blank" >																		
															<?php }else{  ?>
																<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
															<?php } ?>
															<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
																<a href="http://explosivegenealogyleads.com/xmc" target="_blank"  >														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">
															<?php }  ?>
														<?php } ?>
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-users"></i>
															</div>
															<div class="dashboard-content">
																<h4>Lead Source</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
														<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) {
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
															<a href="http://provensystem4success.com/xmc-home/" target="_blank" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">															
														<?php } 
															}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
																<a href="http://provensystem4success.com/xmc-home/" target="_blank"  >	
															<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
																<a href="http://provensystem4success.com/xmc-home/" target="_blank" >																		
															<?php }else{  ?>
																<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
															<?php } ?>
															<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier1_status == 1) { ?>
																<a href="http://provensystem4success.com/xmc-home/" target="_blank"  >														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier1"  class="not-allowed">
															<?php }  ?>
														<?php } ?>
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-envelope"></i>
															</div>
															<div class="dashboard-content">
																<h4>Post Card Marketing</h4>
															</div>
														</div>
													</a>
												</div>
											</div>                            
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
										<div class="tiers">
											<h3>Tier 2 Software</h3>
											<div class="row">
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
													<?php if($refrer_name->refrencename == 'easy') { ?>
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) {
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
															<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" >	
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" >																
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>	
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
																<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" >														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">
															<?php }  ?>

														<?php } ?>									
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-envelope"></i>
															</div>
															<div class="dashboard-content">
																<h4>SMS and Voice Broadcast</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
													<?php if($refrer_name->refrencename == 'easy') { ?>	
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) {
														 if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
															<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail" >														
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail" >	
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail" >																	
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
																<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail">														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">												
															<?php }  ?>

														<?php } ?>	
														<div class="dashboard-inner">
															<div class="icon-shadow">
																<i class="fa fa-phone-square"></i>
															</div>
															<div class="dashboard-content">
																<h4>Ringless Voicemail</h4>
															</div>
														</div>
													</a>
												</div>
												<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
												<?php if($refrer_name->refrencename == 'easy') { ?>	
														<?php if($plans['selected_plan'] == 1 && paidStatus($user_id)->all_puchased  == 0) {
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
															<a href="<?php echo home_url();?>/wp-admin" >															
														<?php }else{ ?>									
															<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">
														<?php } 
														}elseif($plans['selected_plan'] == 0 && paidStatus($user_id)->all_puchased  == 1){ ?> 
															<a href="<?php echo home_url();?>/wp-admin" >	
														<?php }elseif(paidStatus($user_id)->all_puchased  == 1){ ?>
															<a href="<?php echo home_url();?>/wp-admin" >																	
														<?php }else{  ?>
															<a href="#" data-toggle="modal" data-target="#paymentMethod_all"  class="not-allowed">	
														<?php } ?>
														<?php }else{
															if(paidStatus($user_id)->r_licence == 1 && paidStatus($user_id)->tier2_status == 1) { ?>
																<a href="<?php echo home_url();?>/wp-admin" >														
															<?php }else{ ?>									
																<a href="<?php echo $_SERVER['REQUEST_URI']?>?page=tier2"  class="not-allowed">													
															<?php }  ?>

														<?php } ?>	
													<div class="dashboard-inner">
														<div class="icon-shadow">
															<i class="fa fa-camera"></i>
														</div>
														<div class="dashboard-content">
															<h4>Page Builder</h4>
														</div>
													</div>
													</a>
												</div>
												
											
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php												
									//print_r("SELECT * FROM $refrer_table WHERE username=".$refrer_name->refrencename);exit;
											if($refrer_name->refrencename != ""){		
							?>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
									<div class="link-box">
										<h3>Your Affiliate Page URL</h3>
										<a href="<?php echo home_url();?>?username=<?php echo $_SESSION['keyword'];?>" target="_blank"><?php echo home_url();?>?username=<?php echo $_SESSION['keyword'];?></a>
									</div>		
								</div>
								<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<form action="" method="post" enctype="multipart/form-data">
									<div class="user-info">
										<div class="row">									 
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="row">
													<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12 padding-right-zero">
														<div class="user-pic">
														<img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'.$refrer_detail->user_image;?> " alt="Man" id ="input_image"/>
															<img id ="output_image"  class= "img-thumbnail hidden-man"/>
														</div>
													</div>
													<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">
														<div class="user-information">
														<p><b>Your Inviter is</b></p>
														<p><b>Name</b>: <?php echo ucwords($refrer_detail->fname.' '.$refrer_detail->lname);?></p>
														<p><b>Phone</b>: <?php echo $refrer_detail->mobile;?></p>
														<p><b>Email</b>: <?php echo $refrer_detail->email;?></p>
														<p><b>Keyword</b>: <?php echo $refrer_detail->username;?></p>
															<!-- <ul class="list-inline">
																<li><label class="btn btn-primary update-man" for="user_pic">Upload</label></li>
																<li><button type="submit" name="submit_profile" href="#" class="btn btn-danger">Submit</button></li>
															</ul>
															<input type="file" id="user_pic" accept="image/*" onchange="preview_image(event)" name="image_profile" style="opacity:0;height: 13px;"> -->
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									</form>
								</div>
							</div>
							
							<?php 
								  if(isset($_POST['submit_profile']))
								  {
								
									$img_name=$_FILES['image_profile']['name'];
									$img_tmp=$_FILES['image_profile']['tmp_name'];
									$img_error=$_FILES['image_profile']['error'];
									  $dir = get_template_directory().'-child/admin/profile_image/';
									  $move = move_uploaded_file($_FILES['image_profile']['tmp_name'],$dir.$_FILES['image_profile']['name']);
									
									if($img_error==0)
									{
										$wpdb->update($table,array('user_image' => $img_name),array('id' => $user_id));
										echo '<script>window.location.href="'.home_url().'/dashboard"</script>';
									}
								}
								}
								
							?>
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- payment modal 	 -->
	<div class="modal fade" id="paymentMethod_tier2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($refrer_detail->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOnetier2">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier2" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=authorize" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth"  required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" name="cvv_auth" required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount"  readonly value="$200" />
							</div>
						</div>
						<input type="hidden" name="software" value="tier2">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
							</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($refrer_detail->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($refrer_name->arb_login_key == "" && $refrer_name->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwotier2" aria-expanded="false" aria-controls="collapseTwotier2">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwotier2" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier2" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $refrer_detail->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
								<div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="40.00" type="text" class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($refrer_detail->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreetier2" aria-expanded="false" aria-controls="collapseThreetier2">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThreetier2" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=payeezy" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$200">								
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier2">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				<?php } if($refrer_detail->arb_login_key == null && $refrer_detail->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($refrer_name->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>	
	<!-- tier 2/.payment modal -->
<!-- r licence payment modal 	 -->
<?php 
$admin = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role ='admin'");								
?>
<div class="modal fade" id="paymentMethod_rliceence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method (Payment goes to admin)</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($admin->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOner" aria-expanded="true" aria-controls="collapseOne">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOner" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=authorize&role=admin" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no_auth" placeholder="xxxx xxxx xxxx"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM"  name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" name="cvv_auth" required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$97" />
							</div>
						</div>
						<input type="hidden" name="software" value="licence">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
							</div>
						</div>
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php }if($admin->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwoa" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwoa" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=licence" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $admin->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $admin->address;?>" type="hidden">
								<input name="city" value="<?php echo $admin->city;?>" type="hidden">
								<input name="country" value="<?php echo $admin->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $admin->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $admin->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $admin->lname;?>" type="hidden">
								<input name="state" value="<?php echo $admin->state;?>" type="hidden">
								<input name="zip" value="<?php echo $admin->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
								<div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="97.00" readonly type="text" class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($admin->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreer" aria-expanded="false" aria-controls="collapseThreea">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThreer" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=payeezy&role=admin" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="licence">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$97">								
								<input type="hidden" name="code" value="USD">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				<?php } 
				if($admin->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2all" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThree2all" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?payment=stripe&role=admin" method="post">
											<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $his_refrer_detail->stripe_primary; ?>"
												data-description="Access for a Reseller Licence"
												data-amount="9700"
												data-locale="auto">
											</script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="97">
												<input type="hidden" name="software" value="licence">												
									</form>					
								</div>					
							</div>
					</div>
				<?php } 
				if($admin->arb_login_key == null && $admin->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($refrer_name->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>	
<!-- end licence modal 
	star tier 1 modal
-->

<!-- pop up of all payments when basic plans occur -->
<div class="modal fade" id="paymentMethod_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method (Payment goes to admin)</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($admin->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOneadmin" aria-expanded="true" aria-controls="collapseOne">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOneadmin" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=authorize&role=admin" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no_auth" placeholder="xxxx xxxx xxxx" minlength=16 maxlength=16 required />
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="month_auth" placeholder="MM" minlength=2 maxlength=2 required />
									</li>
									<li>
										<input type="text" class="form-control" name="year_auth" placeholder="YYYY" minlength=4 maxlength=4 required />
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv_auth" placeholder="CVV" minlength=3 maxlength=3 required />
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount"  readonly value="$<?php echo $plans['basic_amount'];?>" />
							</div>
						</div>
						<input type="hidden" name="software" value="all">
						<input type="hidden" name="plan" value="<?php echo $plans['selected_plan'];?>">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
							</div>
						</div>
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php }if($admin->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwoadmin" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwoadmin" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=all&plan=<?php $plans['selected_plan'];?>" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $admin->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
								<div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" readonly value="<?php echo $plans['basic_amount'];?>" type="text" class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
								
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($admin->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreeall" aria-expanded="false" aria-controls="collapseThreea">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThreeall" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard?payment=payeezy&role=admin" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" required placeholder="John Smith">
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" required placeholder="xxxx xxxx xxxx" minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" required  placeholder="MM" minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" required placeholder="YY" maxlength=2 minlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" required minlength=3 maxlength=4 placeholder="CVV">
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="all">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$<?php echo $plans['basic_amount']; ?>">								
								<input type="hidden" name="code" value="USD">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				<?php } if($admin->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2all" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThree2all" class="panel-collapse collapse <?php if($admin->arb_login_key == "" && $admin->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?payment=stripe&role=admin" method="post">
											<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $his_refrer_detail->stripe_primary; ?>"
												data-description="Access for a All"
												data-amount=<?php echo $plans['basic_amount']*100; ?>
												data-locale="auto">
											</script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="<?php echo $plans['basic_amount']; ?>">
												<input type="hidden" name="software" value="all">												
									</form>					
								</div>					
							</div>
					</div>
				<?php } 
				 if($admin->arb_login_key == null && $admin->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($refrer_name->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>	

	<?php

	include( get_template_directory() . '-child/admin/footer.php' );
	

	 }
	?>
	<script>
	function preview_image(event) 
	{
	//alert('Hello');
	 var reader = new FileReader();//FileReader is used to read the contents of a Blob or File.
	 reader.onload = function()// it will fire after load the file.
	 {
	  var output = document.getElementById('output_image');// display output
	  output.src = reader.result;
	 }
	 reader.readAsDataURL(event.target.files[0]);//The readAsDataURL method is used to read the contents of the specified Blob or File.
												 // When the read operation is finished, the readyState becomes DONE, 
				 //and the loadend is triggered. At that time,
		 $("#input_image").hide();	
		 $("#output_image").removeClass('hidden-man');
	}
	$( "#all_auth_form" ).validate({
    rules: {
        card_no_auth: {
			required: true,
			number: true
        },    
		month_auth: {
			required: true,
			number: true
        },
		year_auth: {
			required: true,
			number: true
        },
		cvv_auth: {
			required: true,
			number: true
        },    
    }   
    });
	$( "#payeezy_all" ).validate({
    rules: {
        card_no: {
			required: true,
			number: true
        },    
		card_month: {
			required: true,
			number: true
        },
		card_year: {
			required: true,
			number: true
        },
		cvv: {
			required: true,
			number: true
        },  
    }   
    });
	
           
	</script>