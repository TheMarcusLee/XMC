<?php
if(isset($_GET['sub-page'])){

	if($_GET['sub-page'] == 'phone_list'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/phone_list.php' );

	}
	if($_GET['sub-page'] == 'audio_list'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/audio_list.php' );

	}
	if($_GET['sub-page'] == 'campaigns'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/campaign_list.php' );

	}
	if($_GET['sub-page'] == 'settings'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/settings.php' );

	}
}
else{
	include( get_template_directory() . '-child/admin/header.php' );
	$user_id= $_SESSION['user_id'];
	if(paidStatus($user_id)->tier2_status == 0) { 
		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
	}
	global $wpdb;
	$table_name = $wpdb->prefix.'register_user';
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
							<h3 style="border-bottom: 1px solid #ca1302;color: #ca1302;padding-bottom: 15px">Campaign Managment</h3>
						</div>
						<div class="dashboard-short">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=audio_list">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-volume-up"></i>
											</div>
											<div class="dashboard-content">
												<h4>All Audio List</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=phone_list">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-phone-square"></i>
											</div>
											<div class="dashboard-content">
												<h4>All Contact List</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<?php
                                $user_id = $_SESSION['user_id'];
								$campaign_value = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $user_id",ARRAY_A);								
								if($campaign_value['slybroadcast_username'] == ''){
								
								?>
									<a href="javscript:void(0)" data-toggle="modal" data-target="#exampleModalLong">
								<?php	} 
								else{
								echo '<a href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=campaigns">';
								}
								?>
								
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
					You don't have slybroadcast account. Please first setup your <a href="<?php echo home_url();?>/dashboard/?option=settings#sly-broadcast">Account</a> to create a campaign.
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