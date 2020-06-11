<?php 

if(isset($_GET['sms_action'])){

    if($_GET['sms_action'] == 'add_scheduler'){

        include( get_template_directory() . '-child/admin/sms_voice_broadcast/add_scheduler.php' );
    }
	if($_GET['sms_action'] == 'edit_scheduler'){

        include( get_template_directory() . '-child/admin/sms_voice_broadcast/edit_scheduler.php' );
    }
}
else{
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
$tab_name = $wpdb->prefix.'svb_recent_broad';

if(isset($_GET['del_cam'])){
	$id = $_GET['del_cam'];
	$wpdb->delete($tab_name,array('recent_id'=>$id));
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_broad&dmsg=1";</script>';
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
						<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					</h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading">
									<h5>
										<div class="sub_headpart_left">
										Recent Broadcasts
										</div>
										<div class="sub_headpart_right" style="width: 100%;">
										<small class="heading-earnings add-earning">
											<font color="#007803"><a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_action=add_scheduler" id="create_list" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Create SMS Broadcast</a></font></small>
										</div>
									</h5>
									<hr />
								</div>
								<?php if(isset($_GET['imsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>SMS Scheduler has been created successfully.
											</code>
										</div>
								<?php } ?>	
								<?php if(isset($_GET['umsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>SMS Scheduler has been updated successfully.
											</code>
										</div>
								<?php } ?>
                                <?php if(isset($_GET['dmsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>SMS Scheduler has been deleeted successfully
											</code>
										</div>
								<?php } ?>
						<div class="table-responsive">
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
                                            <th>Subject</th>											
											<!-- <th>Subscriber Group</th> -->
											<th>Phone Number</th>                                           
											<th>Date</th>
											<th>Time (24 Hour Format)</th>
											<th>Type</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
                                   
                                        <?php
										
										global $wpdb;
										$tab_name = $wpdb->prefix.'svb_recent_broad';
										$user_id = $_SESSION['user_id'];
										$all_campaign = $wpdb->get_results("SELECT * FROM $tab_name WHERE registereduser_id = $user_id",ARRAY_A);
										$se_number = 1;
                                             foreach($all_campaign as $campaign){
                                       ?>
                                       <tr>
                                        <td><?php echo $se_number;?></td>
										<td><?php echo $campaign['subject'];?></td>
										<td><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal<?php echo $se_number;?>">View</a></td>
                                        <td><?php echo $campaign['schedule_date'];?></td>
										    <td class="text-center"><?php echo $campaign['scheedule_time'];?></td>
                                             <td><?php if($campaign['type'] == 0){ ?>  <span class="label label-danger">Schedule</span> <?php }else{  ?> <span class="label label-success">Imediate</span>  <?php } ?></td>									                                                                                                                                                                
                                        <td>
											<a href="<?php echo home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_broad&sms_action=edit_scheduler&edit_cam='.$campaign['recent_id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
											<a href="<?php echo home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_broad&del_cam='.$campaign['recent_id'];?>" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
										</td>
                                            </tr>                                            
                                                <!-- Modal -->
                                                <div id="myModal<?php echo $se_number;?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Phone Numbers</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php $ph = explode(',',$campaign['phone_no']);
                                                            $s = 1; foreach($ph as $po) { ?>                                                        
                                                        <p><?php echo $s;?>. <?php echo $po;?></p>
                                                            <?php  $s++; } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </div>

                                                </div>
										<?php 
										$se_number++;
											 }
                                     ?>											                                        
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
