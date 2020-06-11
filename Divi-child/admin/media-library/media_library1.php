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
													<h3>Media Library</h3>
													
													   <div class="media-uploader">
														   <h4><i class="fa fa-film"></i> Upload Media</h4>
														   <div class="video-uploader">
															  <form action="#">
																  <div class="input-file-container">  
																	<input class="input-file" id="my-file" type="file">
																	<label tabindex="0" for="my-file" class="input-file-trigger">Choose File</label>
																	 <p class="file-return"></p>
																	 <button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-floppy-o"></i> Save</button>
																  </div>
																</form>
														   </div>
													   </div>
												</div>
											</div>
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="media-show">
														<div class="row">
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-sm-4 col-lg-3 col-xs-12">
																<div class="media-pic">
																	<img src="<?php echo home_url(); ?>/wp-content/themes/Divi-child/admin/media-library/images/doremon.jpg" alt="Media Pic" />
																	<div class="hover-pic">
																		<a href="#" class="delete"><i class="fa fa-trash"></i></a>
																		<p>Doremon Animated</p>
																	</div>
																</div>
															</div>
														</div>
												   </div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="sly-broadcast">
									<div class="sly-broadcast profile-div">
										<div class="custom-dropdown">
											<div class="dropdown-button">
												Create SlybroadCast Account<a href="#" class="pull-right btn btn-default btnRegister">Registeration</a>
											</div>
										</div>
										<form class="form-horizontal profile-form slybroadcast-form">
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label">Username:</label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="text" class="form-control">
											</div>
										  </div>
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label">Password</label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="text" class="form-control">
											</div>
										  </div>
										  
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label">Caller Id</label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="text" class="form-control">
											</div>
										  </div>
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label"></label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <button class="btn btn-primary btn-red">Save</button>
											</div>
										  </div>
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="twilio">
									<div class="sly-broadcast profile-div">
										Twillo Code Here
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