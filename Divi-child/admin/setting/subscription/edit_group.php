<?php
include( get_template_directory() . '-child/admin/header.php' );

global $wpdb;

$table_name = $wpdb->prefix.'subscriber_group';
if(isset($_GET['id'])){
    $id = $_GET['id'];
		$single = $wpdb->get_row("SELECT * FROM $table_name WHERE group_id = $id");
		
}

if(isset($_POST['group_name'])){
    $name = $_POST['group_name'];    
  //  $group_campaign = $_POST['group_campaign'];
    $group_status = $_POST['group_status'];

    $data = array(
                'group_name' => $name,                
                //'campaign_id' => $group_campaign,
                'status' => $group_status,                
            );
		$where = array('group_id'=>$id);
		$wpdb->update($table_name,$data,$where);
	
    echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription&umsg=1";</script>';
    
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
													<h3>Edit Group</h3>
													<div  class="form-horizontal profile-form">
													<form action="" method="post">
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Group Name:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="group_name" required class="form-control" value="<?php echo $single->group_name;?>"  />
														</div>
													  </div>													 
													  <!-- <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Select Campaign:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control"  name="group_campaign">
															<option value="2139">Select Campaign</option>
															<?php 
																$camp_table_name = $wpdb->prefix.'svb_campaings';
																$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name");
																foreach($camp_list as $list){
																?>
																    <option value="<?php echo $list->id;?>" <?php if($single->campaign_id == $list->title){ echo "selected";} ?>><?php echo $list->title;?></option>
																
																<?php } ?>
														  </select>
														</div>
													  </div> -->
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Status:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select class="form-control" name="group_status">
															<option value="Active" <?php if($single->campaign_id == 'Active'){ echo "selected";} ?> >Active</option>
															<option value="Block" <?php if($single->campaign_id == 'Block'){ echo "selected";} ?> >Block</option>
														  </select>
														</div>
													  </div>
													  <div class="form-group">
														<div class="col-sm-12 text-left">
														  <button type="submit" class="btn btn-primary previewBtn"><i class="fa fa-floppy-o"></i> Update</button>
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