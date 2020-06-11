<?php
if(isset($_GET['action'])){
	if($_GET['action'] == 'edit'){
		
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/edit_voice_broadcast.php' );
		exit;
	}
	if($_GET['action'] == 'delete'){
		$id = $_GET['row_id']; 
		global $wpdb;
		global $wp;
		$table_name = $wpdb->prefix.'svb_recent_voice';
		$audio_name = "SELECT media_loc FROM $table_name WHERE recent_voice_id = $id";
		$get_audio_name = $wpdb->get_row($audio_name);
		$audio = $get_audio_name->audio_file;
		if($audio != null){
			$audio_dir = get_template_directory().'-child/admin/sms_voice_broadcast/audio_files/'.$audio;
			unlink($audio_dir);
		}
		$where = array(
				'recent_voice_id' => $id,                        
				);

		$wpdb->delete($table_name,$where);
		 echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast&del=1";</script>';
		//wp_redirect($_SERVER['REQUEST_URI']);
	}
}
else { include( get_template_directory() . '-child/admin/header.php' );
	$user_id= $_SESSION['user_id'];
	if(paidStatus($user_id)->tier2_status == 0) { 
		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
	}
?>
<style>
.subsciber-heading h5 {
    padding-bottom: 10px;
}


.subsciber-heading select {
    background: #d9534f;
    color: #fff;
    border: 1px solid #d987b5;
    padding: 3px 5px;
    border-radius: 2px;
}

.subsciber-heading select option {
    margin: 40px;
    background: #fff;
    color: #000;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
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
						<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading subsciber-heading">
									<h5>Voice Broadcasts 
										<small class="pull-right heading-earnings add-earning subsciber-link">
										<font color="#007803">
                                        <form style="display:inline;" action="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast" method="post">
                                            <select class="" name="drop_campaign" onchange="form.submit();" >
                                                <option value="">Select Campaigns</option>
                                                <?php 
                                                	$camp_table_name = $wpdb->prefix.'svb_campaings';
                                                	$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $user_id");
                                                	foreach($camp_list as $list){
                                                ?>
                                                	<option value="<?php echo $list->id;?>" <?php if($list->id == $_POST['drop_campaign']){ echo "selected"; } ?> ><?php echo $list->title;?></option>                                                
                                                <?php } ?>
                                            </select>
                                            </form>                     
                                            <a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=create_voice_brodcast"><i class="fa fa-plus"></i> Create Voice Broadcast</a>                      
                                        </font>
                                    </small>
									</h5>
									<hr />
								</div>
								<?php if(isset($_GET['del'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Deleted Succcesfully!
											</code>
										</div>
								<?php }?>
								<div class="table-responsive">
									
								<table id="subscription" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Title</th>
											<th>Recording</th>
											<th>Campaign</th>
											<th>Date</th>
											<th>Time (24 Hour Format)</th>
											<th>Type</th>
											<th>Action</th>
										</tr>
									</thead>									
									<tbody>
									<?php 
										$user_id = $_SESSION['user_id'];
										global $wpdb;
										$table_name = $wpdb->prefix.'svb_recent_voice';
										if(isset($_POST['drop_campaign'])){
											$campagin_id= $_POST['drop_campaign'];	
											$results = $wpdb->get_results("SELECT * FROM $table_name WHERE select_camp = $campagin_id AND registereduser_id = $user_id",ARRAY_A); 
										}else{
												$user_id = $_SESSION['user_id'];
												$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id",ARRAY_A); 
										}
										$i = 0;
										foreach($results as $result){ ?>
											<tr>		
												<td><?php echo $i;?></td>
												<td><?php echo ucwords($result['voice_title']); ?></td>
												<td><?php if($result['call_type'] == 0) { ?>
													<a href="javascript:void(0);" ><i class="fa fa-volume-up audio_file" audio_file="<?php echo get_template_directory_uri();?>-child/admin/sms_voice_broadcast/audio_files/<?php  echo $result['media_loc']?>" data-toggle="tooltip" data-placement="top" title="Play Audio" ></i></a> <?php  echo $result['media_loc']?></a>
													<?php }elseif($result['call_type'] == 1){ echo '<span class="label label-success">Voice Text</span>'; } ?></td>
												<td><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal<?php echo $i;?>">View</a> <span class="label label-danger">1</span></td>
												<td><?php echo $result['sch_date']; ?></td>
												<td><?php echo $result['sch_time']; ?></td>
												 <td><?php if($result['type'] == 0){ ?>  <span class="label label-danger">Schedule</span> <?php }else{  ?> <span class="label label-success">Imediate</span>  <?php } ?></td>		
												<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=edit&row_id=<?php echo $result['recent_voice_id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
													<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=delete&row_id=<?php echo $result['recent_voice_id'];?>" onclick="return confirm('Are you sure ?');"><i class="fa fa-trash fa-1x camp-action"></i></a>
												</td>
											</tr>	
											<!-- Modal -->
												<div id="myModal<?php echo $i;?>" class="modal fade" role="dialog">
												<div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Campaign Details</h4>
													</div>
													<div class="modal-body">
														<ul id="areoption">			
														<li style="list-style:none;font-weight:bold;"><span class="label label-danger">1</span><?php echo ucwords(getCampaignName($result['select_camp'])->title);?></li>
														</ul>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
													</div>
												</div>
												</div>
										<?php $i++; } ?>										
									</tbody>
								</table>
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
}
?>