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
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
$tab_name = $wpdb->prefix.'svb_campaings';

if(isset($_GET['del_cam'])){
	$id = $_GET['del_cam'];
	$del = $wpdb->delete($tab_name,array('id'=>$id));
	if($del){
		$wpdb->delete('wp_sms_crone',array('sms_camp_id'=>$id));
		echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign";</script>';
	}	
}

?>
<style>
table.custom-table tbody {
    display: block;
    height: 235px;
    overflow: auto;
}
table.custom-table thead, table.custom-table tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
table.custom-table thead {
    width: calc( 100% )
}
table.custom-table  {
    width:100%;
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
								<div class="table-heading">
									<h5>
										<div class="sub_headpart_left">
										Campaign List 
										</div>
										<div class="sub_headpart_right" style="width: 86%;">
										<small class="heading-earnings add-earning">
											<font color="#007803"><a href="<?php echo $_SERVER['REQUEST_URI'];?>&sms_action=add_sms_campaign" id="create_list" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Add Campaign</a></font></small>
										</div>
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
						<div class="table-responsive">
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
                                            <th>Title</th>
											<th>Keyword</th>
											<!-- <th>Subscriber Group</th> -->
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
										<!-- <td><?php echo ucwords(getSubscriberGroupDetails($campaign['sub_group_id'])->group_name);?></td> -->
                                        <td><?php echo $campaign['phone_number'];?></td>
                                        <td><?php echo $campaign['date'];?></td>
                                        
                                        
                                        <td><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal<?php echo $se_number;?>"><?php echo  subscriberCount($campaign['id'])->total; ?> </a></td>
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
		</div>
	</section>
	<?php  $se_number= 1;  foreach($all_campaign as $campaign){
                                       ?>
		<!-- Modal -->
	<div id="myModal<?php echo $se_number;?>" class="modal fade" role="dialog">
	<div class="modal-dialog custom-scroll">

		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Subscribers</h4>
		</div>
		<div class="modal-body">
			<table id="" class="table table-striped table-bordered nowrap custom-table phone_name_lists" cellspacing="0" width="100%">
				<thead>
					<tr class="info">
						<th>Name</th>
						<th>Phone Number</th>
					</tr>
				</thead>
				<tbody>
				<?php 	$subscribers = $wpdb->get_results("SELECT * FROM wp_svb_subscriber WHERE campaign = ".$campaign['id']." AND status = 0 AND registereduser_id =".$_SESSION['user_id'],ARRAY_A); 
						foreach($subscribers as $sub){ 
					?>
					<tr>
						<td><?php echo $sub['name'];?></td>
						<td><?php echo $sub['phone_number'];?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>														
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
	</div>
						<?php $se_number++; } ?>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
}
?>