<?php
include( get_template_directory() . '-child/admin/header.php' );
?>
<style>
.follow-steps {
	padding-left: 0px;
	list-style: none;
}
.follow-steps li:after{content:"";display:table;clear:both;}
.follow-steps i {
    float: left;
    width: 25px;
    color: #da524e;
    font-size: 17px;
    margin-top: 2px;
}
.follow-steps span {
    padding-left: 25px;
    float: left;
}

.follow-steps span {
    padding-left: 25px;
    float: left;
    font-size: 15px;
}
.follow-steps li {
    margin-bottom: 7px;
}

.follow-steps a {
    color: #da524e;
}
</style>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/mediaelementplayer.css">
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
						<div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box">
													<h3>Start Here</h3>
												</div>
											</div>
										</div>
										<div class="row">
										<?php                                                        
											$started = get_posts(array(
												'post_type'   => 'start_here',
												'post_per_page' => -1,
											));
										// print_r($tutorials);
										foreach($started as $tutorial){
											
									?>
											<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">
												<div class="my-video">
												<section style="display:none">
													<form action="#" method="get">
														<label>Language
															<select name="lang">
																<option value="ca">Català / Catalan (ca)</option>
															</select>
														</label>
														<label>Stretching (Video Only)
															<select name="stretching">
																<option value="auto" selected>Auto (default)</option>
																<option value="responsive">Responsive</option>
																<option value="fill" selected>Fill</option>
																<option value="none" selected>None (original dimensions)</option>
															</select>
														</label>
													</form>
												</section>									
												<div class="players" id="player1-container">
													<div class="media-wrapper">
														<video id="player1" width="640" height="360" style="max-width:100%;" preload="none" controls playsinline webkit-playsinline>
															<source src="<?php echo get_post_meta($tutorial->ID,'video_url',true);?>" type="video/mp4">
															<track srclang="en" kind="subtitles" src="mediaelement.vtt">
															<track srclang="en" kind="chapters" src="chapters.vtt">
														</video>
													</div>
												</div>
											
											</div>
											</div>
											<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
												<ul class="follow-steps">																																				
													<?php echo $tutorial->post_content; ?>																									
												</ul>												
											</div>
											<?php } ?>
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
<script src="<?php echo get_template_directory_uri();?>-child/js/mediaelement-and-player.js"></script>
<script src="<?php echo get_template_directory_uri();?>-child/js/demo.js"></script>