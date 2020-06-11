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

    $data = array(
                'name' => $name,
                'phone_number' => $svb_phone_number,
								//'campaign' => $svb_campaign,
								'sub_group_id'=>$id,
								'registereduser_id'=>$_SESSION['user_id'],
                // 'status' => $svb_status,
                
            );

    $wpdb->insert($table_name,$data);

    echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription&new_action=subscriber&imsg=1&id='.$id.'"</script>';
    
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
						<a href="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&id=<?php echo $id;?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
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
													<div  class="form-horizontal profile-form">
													<form action="" method="post">
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Name:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="svb_name" required class="form-control"  />
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Phone Number:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="svb_phone_number" class="form-control"  />
														</div>
													  </div>
														<!--   <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Select Campaign:</label>
													   <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control"  name="svb_campaign">
															<option value="2139">Select Campaign</option>
															<?php 
																$camp_table_name = $wpdb->prefix.'svb_campaings';
																$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name");
																foreach($camp_list as $list){
																?>
																<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
																
																<?php } ?>
														  </select>
														</div>
													  </div> -->
													  <!-- <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Status:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control" name="svb_status">
															<option value="Active">Active</option>
															<option value="Block">Block</option>
														  </select>
														</div>
													  </div> -->
													  <div class="form-group">
														<div class="col-sm-12 text-left">
														  <button type="submit" class="btn btn-primary previewBtn"><i class="fa fa-floppy-o"></i> Save</button>
																	<a href="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&id=<?php echo $id;?>" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
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