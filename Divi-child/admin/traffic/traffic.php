<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier1_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
?>
<style>
	.marketing-banners .capture-box:hover img{opacity:0.6;}
	.marketing-banners .capture-data button {
		margin-top: 14px;
	}
	.sidebar {
		background: #333;
		color: #fff;
		min-height: 1550px;
	}
	.marketing-banners .capture-image{position: relative;}
	.traffic-heading {
		background: #333;
		padding: 9px 15px;
		color: #fff;
		border-radius: 0px 0px 5px 5px;
	}
	.traffic-heading h5 {
		margin: 0px;
		font-size: 17px;
		text-align: center;
	}
</style>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<div class="setting-divs" style="margin-top: 40px;">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div links-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box link-boxes marketing-banners">
													<h3>Traffic</h3>
													<div class="row">
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<a href="https://www.trafficforme.com/SD43" target="_blank">
																		<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/traffic/screenshots/trafficforme.png" alt="Capture Image" class="full-width" />
																	</a>
																</div>
																<div class="traffic-heading">
																	<h5>Traffic For Me</h5>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<a href="https://udimi.com/" target="_blank">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/traffic/screenshots/udimi.png" alt="Capture Image" class="full-width" />
																	</a>
																</div>
																<div class="traffic-heading">
																	<h5>UDIMI</h5>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>