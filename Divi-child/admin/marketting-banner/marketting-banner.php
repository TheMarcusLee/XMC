<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
?>
<link rel='stylesheet' href='<?php echo get_template_directory_uri();?>-child/css/ryxren.css'>
<style>
	/* .marketing-banners .capture-box:hover img{opacity:0.6;} */
	.marketing-banners .capture-data button {
		margin-top: 14px;
	}
	.sidebar {
		background: #333;
		color: #fff;
		min-height: 1550px;
	}
	.marketing-banners .capture-image{position: relative;}
	.hover-box {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 100%;
		height: 100%;
		text-align: center;
		background: rgba(0,0,0,0.2);
		opacity: 0;
	}
	.capture-box:hover .hover-box{opacity:1;}
	.hover-box a {
		background: rgba(0,0,0,0.5);
		width: 35px;
		display: inline-block;
		height: 35px;
		line-height: 35px;
		border-radius: 50%;
		color: #fff;
		margin-top: 33%;
	}
	

	.marketing-banners .capture-data a {
		margin-top: 14px;
	}
	.marketing-banners .capture-data a {
		margin-bottom: 15px;
		background: #333;
		color: #fff;
		border: 1px solid #333;
		padding: 4px 12px;
		border-radius: 20px;
		display: inline-block;
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
													<h3>Marketing Banners</h3>
													<div class="row">
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-1.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-1.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-1.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-2.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-2.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a  href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-2.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-3.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-3.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-3.jpg" downloadclass="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-4.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-4.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-4.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-5.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-5.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-5.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-6.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-6.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a hreef="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-6.jpg"  download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-7.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-7.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-7.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-8.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-8.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a hreef="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-8.jpg" download  class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-9.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-9.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a hreef="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-9.jpg" download class="copylink">Dowload</a></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-10.jpg" alt="Capture Image" class="full-width" />
																	
																	<div class="hover-box">
																		<a class="two" href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-10.jpg" data-fancybox="filter"><i class="fa fa-eye"></i></a>
																	</div>
																</div>
																<div class="capture-data">
																	<div class="text-center"><a  href="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/marketting-banner/screenshots/marketing-banner-10.jpg" download class="copylink">Dowload</a></div>
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

<script src='<?php echo get_template_directory_uri();?>-child/js/ryxren.js'></script>
<!-- <script  src="<?php //echo get_template_directory_uri();?>-child/js/index.js"></script> -->