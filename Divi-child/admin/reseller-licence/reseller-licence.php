<?php
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->r_licence == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
$table = $wpdb->prefix.'register_user';
$get = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id",ARRAY_A); 
?>
<style>
	
.marketing-banners b {
    color: #e4041c;
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
													<h3>Reseller License - Hosting</h3>
													<p>
													You now have full resale right's to Xtreme Marketing Code Software Products, please see below.</p>
													<p>Tier 1 paid member can only resell Tier 1 Xtreme Marketing Code Software Products.</p>
													<p>Any affiliate can upgrade to Tier 2 status at any given point of time and have FULL Resale rights to all of Xtreme Marketing Code Software Products. Therefore after you have purchased Tier 1 Software and upgrade to Tier 2 the Resale Right License is good for both Tier's of Software Products
													You now have Resale Rights for as long as your an Affiliate of Xtreme Marketing Code. Your next Yearly Hosting payment of $50 will be due on <b><?php echo $get['date_purch_rlicence']; ?></b>. This is a yearly fee which allows you to utilize the Software and Products of Xtreme Marketing Code on the server</p>
													</p>
													<!-- <p>You have purchased the Reseller Licence for 1 year. Your next renewal date is .   From next year onward you will be charged <b>$50</b> for Reseller Licence.</p> -->
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