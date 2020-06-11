<?php
include( get_template_directory() . '-child/admin/header.php' );

global $wpdb;

$table_name = $wpdb->prefix.'svb_subscriber';

if(isset($_GET['id'])){
	$id = $_GET['id'];		
	
}
if(isset($_POST['svb_name'])){
    $name = $_POST['svb_name'];
    $svb_phone_number = $_POST['svb_phone_number'];
    $svb_campaign = $_POST['svb_campaign'];
		$svb_status = $_POST['svb_status'];
		$camp_title = ucwords(getCampaignName($svb_campaign)->title);
		$cheeck_exist = $wpdb->get_row("SELECT * FROM $table_name WHERE phone_number=$svb_phone_number AND campaign = $svb_campaign ");    	
	  if($cheeck_exist > 0 ){
			flash('msgc','<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Alert!</strong> '.$svb_phone_number.' already existing in selected Group..
		</div>');
		}else{
    $data = array(
                'name' => $name,
                'phone_number' => $svb_phone_number,
								'campaign' => $svb_campaign,
								//'sub_group_id'=>$id,
								'campaign_title' => $camp_title,
								'registereduser_id'=>$_SESSION['user_id'],
                 'status' => $svb_status,
                
						);
						$wpdb->insert($table_name,$data);

						echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription"</script>';
						
		}
   
}

?>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
						<a href="<?php echo home_url();?>/dashboard/?option=subscription" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
                    <div class="setting-divs" style="margin-top:40px;">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
												<div class="profile-box">
													<h3>Add Subscriber</h3>
													<?php echo 	flash('msgc');?>
													<div  class="form-horizontal profile-form">
													<form action="" method="post">
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Name:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="svb_name"  class="form-control"  />
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Phone Number:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="svb_phone_number" class="form-control"  />
														</div>
													  </div>
														<div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Select Campaign:</label>
													   <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control" name="svb_campaign" required>
																<option value="">Select Campaign</option>
																<?php 
																  $sess_id = $_SESSION['user_id'];
																	$camp_table_name = $wpdb->prefix.'svb_campaings';
																	$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $sess_id");
																	foreach($camp_list as $list){
																	?>
																		<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>																	
																	<?php } ?>
														  </select>
														</div>
													  </div> 
													   <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Status:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control" name="svb_status">
															<option value="Active">Active</option>
															<option value="Block">Block</option>
														  </select>
														</div>
													  </div>
													  <div class="form-group">
														<div class="col-sm-12 text-left">
														  <button type="submit" class="btn btn-primary previewBtn"><i class="fa fa-floppy-o"></i> Save</button>
																	<a href="<?php echo home_url();?>/dashboard/?option=subscription" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
																</div>
													  </div>
													  </form>
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