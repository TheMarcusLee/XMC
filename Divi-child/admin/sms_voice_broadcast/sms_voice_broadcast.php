<?php
 
 if(isset($_GET['sms_page'])){

	if($_GET['sms_page'] == 'allcampaign'){
		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/campaign_list.php' );
	}
	if($_GET['sms_page'] == 'buy_numbers'){
		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/buy_numbers.php' );
	}
	if($_GET['sms_page'] == 'existing_numbers'){
		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/existing_numbers.php' );
	}
	if($_GET['sms_page'] == 'subscriber'){
		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/subscriber.php' );
	}
	if($_GET['sms_page'] == 'sms_log'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/smslog.php' );
		exit;
	}
	if($_GET['sms_page'] == 'recent_broad'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/recent_broad.php' );
		exit;
	}	
	if($_GET['sms_page'] == 'create_sms_broadcast'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/add_scheduler.php' );
		exit;
	}	
	if($_GET['sms_page'] == 'sms_inbox'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/sms_inbox.php' );
		exit;
	}	
	//voice brod
	if($_GET['sms_page'] == 'create_voice_brodcast'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/add_voice_brodcast.php' );
		exit;
	}	
	if($_GET['sms_page'] == 'recent_voice_brodcast'){		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/view_voice_brodcast.php' );
		exit;
	}	
	
	
 }
 else{
	include( get_template_directory() . '-child/admin/header.php' );
	$user_id= $_SESSION['user_id'];
	if(paidStatus($user_id)->tier2_status == 0) { 
		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
	}
global $wpdb;

?>
   <section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
						
						<div class="row">
						<h4 style="text-align:right; margin-top:3%;">
						<a href="<?php echo home_url();?>/dashboard/" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
							<h3 style="border-bottom: 1px solid #ca1302;color: #ca1302;padding-bottom: 15px">SMS And Voice Broadcast</h3>
						</div>
						<div class="dashboard-short">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php				
								$table_name = $wpdb->prefix.'twilio_detail';				
                                $user_id = $_SESSION['user_id'];
								$campaign_value = $wpdb->get_row("SELECT * FROM $table_name WHERE registereduser_id = $user_id",ARRAY_A);	
											
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=buy_numbers">
									<!-- echo '<a href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=buy_numbers">';								 -->
								<?php }  ?>
									<!-- <a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=buy_numbers"> -->
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-cart-plus"></i>
											</div>
											<div class="dashboard-content">
												<h4>Buy Numbers</h4>
											</div>
										</div>
									</a>
								</div>
								
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
									<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=existing_numbers">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-phone-square"></i>
											</div>
											<div class="dashboard-content">
												<h4>Existing Numbers</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php				
								$table_name = $wpdb->prefix.'twilio_detail';				
                                $user_id = $_SESSION['user_id'];
								$campaign_value = $wpdb->get_row("SELECT * FROM $table_name WHERE registereduser_id = $user_id",ARRAY_A);	
											
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
									<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=allcampaign">
								<?php }  ?>
								<!-- <a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=allcampaign"> -->
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-bullhorn"></i>
											</div>
											<div class="dashboard-content">
												<h4>Campaigns</h4>
											</div>
										</div>
									</a>
								</div>
 								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=sms_log">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-file"></i>
											</div>
											<div class="dashboard-content">
												<h4>Sms Log</h4>
											</div>
										</div>
									</a>
								</div> 		
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=recent_broad">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-rocket"></i>
											</div>
											<div class="dashboard-content">
												<h4>Recent SMS Broadcasts</h4>
											</div>
										</div>
									</a>
								</div> 	
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=create_sms_broadcast">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-plus"></i>
											</div>
											<div class="dashboard-content">
												<h4>Create SMS Broadcast</h4>
											</div>
										</div>
									</a>
								</div> 	
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=sms_inbox">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-inbox"></i>
											</div>
											<div class="dashboard-content">
												<h4>SMS Inbox</h4>
											</div>
										</div>
									</a>
								</div> 
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=recent_voice_brodcast">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-volume-up"></i>
											</div>
											<div class="dashboard-content">
												<h4>Recent Voice Broadcasts</h4>
											</div>
										</div>
									</a>
								</div> 	
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
								if(count($campaign_value) == 0){ ?>									
										<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php } 
								else{ ?>
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=create_voice_brodcast">
								<?php } ?>
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-plus"></i>
											</div>
											<div class="dashboard-content">
												<h4>Create Voice Broadcast</h4>
											</div>
										</div>
									</a>
								</div> 																		
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	<!-- Campaign ALert box-->

		<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalLongTitle" style="width:80%; float:left;">It seems that </h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" style="font-size:30px;">&times;</span>
					</button>
				</div>
				<h4 class="modal-body">
					You don't have twilio account. Please first setup your <a href="<?php echo home_url();?>/dashboard/?option=settings#twilio">Account</a> to create a campaign.
				</h4>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				</div>
				</div>
			</div>
		</div>

	<!--End Campaign Alert Box-->
<?php
include( get_template_directory() . '-child/admin/footer.php' );
 }
?>