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
 }
 else{
	include( get_template_directory() . '-child/admin/header.php' );
 
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
									<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=buy_numbers">
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
								
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=allcampaign">
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
<!-- 								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								
								<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_page=subscriber">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-file"></i>
											</div>
											<div class="dashboard-content">
												<h4>Subscriber</h4>
											</div>
										</div>
									</a>
								</div> -->
								
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
 }
?>

 