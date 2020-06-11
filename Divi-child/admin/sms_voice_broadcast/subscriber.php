<?php

if(isset($_GET['new_action'])){
	if($_GET['new_action'] == 'add_subscriber'){
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/add_subscriber.php' );
	}

	
}
if(isset($_GET['subscriber_action'])){
	if($_GET['subscriber_action'] == 'exportcsv'){
		include( get_template_directory() . '-child/admin/sms_voice_broadcast/export_csv.php' );
	}
}

	else{
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}

global $wpdb;

$table_name = $wpdb->prefix.'svb_subscriber';


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
								<div class="table-heading subsciber-heading">
									<h5>Subscriber 
										
									</h5>
									<hr />
								</div>
								<?php if(isset($_GET['delete'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Deleted Succcesfully!
											</code>
										</div>
								<?php }if(isset($_GET['import'])) { ?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Data Imported Succcesfully!
											</code>
										</div>
								<?php } ?>
								<form action="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=subscriber&subscriber_action=exportcsv" method="post">															
								<table id="subscription" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><input type="checkbox" id="chkall" /></th>
											<th>Name</th>
											<th>Phone Number</th>
											<th>Campaigns Title</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									$results = $wpdb->get_results("SELECT * FROM $table_name",ARRAY_A); 
									$i = 0;
									foreach($results as $result){
									?>
										<tr>
											<td><input type="checkbox" name="check_list_ho_ja[]" value="<?php echo $result['id'];?>" /></td>
											<td><?php echo $result['name'];?></td>
											<td><?php echo $result['phone_number'];?></td>
											<td><?php echo $result['campaign'];?></td>
											<td><font color="#228B22"><?php echo $result['status'];?></font></td>
											<td>
												<a href="#"><i class="fa fa-envelope fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<!-- <a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a> -->
											</td>
										</tr>												
									<?php $i++; } ?>
									</tbody>
								</table>	
								<h5>
								<small class="pull-right heading-earnings add-earning subsciber-link">
										<select class="">
											<option value="">Select Campaigns</option>
											<?php 
											$camp_table_name = $wpdb->prefix.'svb_campaings';
											$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name");
											foreach($camp_list as $list){
											?>
											<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
											
											<?php } ?>
										</select>
										<font color="#007803">
										<button type="button"><i class="fa fa-telegram"></i> Send SMS</button>
										<button type="submit" name="exp_sub_mit"><i class="fa fa-share-square-o"></i> Export</button>
										<!-- <a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=subscriber&subscriber_action=exportcsv"><i class="fa fa-share-square-o"></i> Export</a> -->
										
										<button	type="button"><i class="fa fa-share-square-o"></i> CSV Sample</button>
										<button type="button" data-toggle="modal" data-target="#upload_csv"><i class="fa fa-cloud-upload"></i> Import</button>
										<button type="submit" name="delete_sub"><i class="fa fa-trash"></i> Delete</button>
										<a href="<?php echo $_SERVER['REQUEST_URI'];?>&new_action=add_subscriber"><i class="fa fa-plus"></i> Add Subsciber</a>
										</font></small>
								</h5>
								
								</form>													
							</div>							
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Modal Box For Upload Csv-->

	<div id="upload_csv" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload CSV</h4>
			</div>
			<div class="modal-body">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="csv_file">Choose CSV:</label>
					<input type="file" class="form-control" name="svb_csv_file" >
				</div>
				
				<button type="submit" class="btn btn-info" name="svb_csv">Submit</button>
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
		</div>


<!-- End Modal Box For Upload Csv-->
<?php
include( get_template_directory() . '-child/admin/footer.php' );
	}
	if(isset($_POST['svb_csv'])){
		$row = 0;
		$table_name = $wpdb->prefix.'svb_subscriber';
		$handle = fopen($_FILES['svb_csv_file']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
		if($row !=0 ){
			$idata = array('name' =>$data[0],'phone_number'=>$data[1] );
			$wpdb->insert($table_name,$idata);
		}		
		$row++;		
		 //echo "</pre>";
		//$idata = array('name' =>$data[0],'phone_number'=>$data[1] );
		//$wpdb->insert($table_name,$idata);
		 
		}
		fclose($handle);
		echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=subscriber&import=1"</script>';		 		 
	}
?>