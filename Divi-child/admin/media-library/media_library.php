<?php
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
						<!-- <div class="setting-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile Setting</a></li>
								<li role="presentation"><a href="#sly-broadcast" aria-controls="sly-broadcast" role="tab" data-toggle="tab">Sly-Broadcast</a></li>
								<li role="presentation"><a href="#twilio" aria-controls="twilio" role="tab" data-toggle="tab">Twilio</a></li>
							  </ul>
						</div> -->
						<div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-7 col-sm-12 col-lg-7 col-xs-12">
												<div class="profile-box">
													<h3>Coming Soon</h3>
													
													   <div class="media-uploader">
														   
														   <div class="video-uploader">
															  <p>We will get back to you as soon as possible.</p>																
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