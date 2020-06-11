<?php 

if(isset($_GET['sms_action'])){

    if($_GET['sms_action'] == 'add_sms_campaign'){

        include( get_template_directory() . '-child/admin/sms_voice_broadcast/add_sms_campaign.php' );
    }
	if($_GET['sms_action'] == 'edit_campaign'){

        include( get_template_directory() . '-child/admin/sms_voice_broadcast/edit_sms_campaign.php' );
    }
}
else{
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
$tab_name = $wpdb->prefix.'svb_campaings';

if(isset($_GET['del_cam'])){
	$id = $_GET['del_cam'];
	$wpdb->delete($tab_name,array('id'=>$id));
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign";</script>';
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
									<h5>Campaign List 
										<small class="pull-right heading-earnings add-earning">
											<font color="#007803"><a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_action=add_sms_campaign" id="create_list" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Add Compaign</a></font></small>
                                       
									</h5>
									<hr />
								</div>
								<?php if(isset($_GET['imsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>Campaign created Successfully!
											</code>
										</div>
								<?php } ?>	
								<?php if(isset($_GET['umsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>Campaign updated Successfully!
											</code>
										</div>
								<?php } ?>	
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
                                            <th>Title</th>
											<th>Keyword</th>
											<th>Subscriber Group</th>
											<th>Phone Number</th>                                           
											<th>Date</th>
											<th>Subscribers</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
                                   
                                        <?php
										
										global $wpdb;
										$tab_name = $wpdb->prefix.'svb_campaings';
										$user_id = $_SESSION['user_id'];
										$all_campaign = $wpdb->get_results("SELECT * FROM $tab_name WHERE registereduser_id = $user_id",ARRAY_A);
										$se_number = 1;
                                             foreach($all_campaign as $campaign){
                                       ?>
                                       <tr>
                                        <td><?php echo $se_number;?></td>
										<td><?php echo $campaign['title'];?></td>
                                        <td><?php echo $campaign['keyword'];?></td>
										<td><?php echo ucwords(getSubscriberGroupDetails($campaign['sub_group_id'])->group_name);?></td>
                                        <td><?php echo $campaign['phone_number'];?></td>
                                        <td><?php echo $campaign['date'];?></td>
                                        
                                        
                                        <td><?php echo  subscriberCount($campaign['sub_group_id'])->total; ?></td>
											<td>
											<a href="<?php echo home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&sms_action=edit_campaign&edit_cam='.$campaign['id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="<?php echo home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&del_cam='.$campaign['id'];?>" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
                                            </tr>
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
	</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
}
?>