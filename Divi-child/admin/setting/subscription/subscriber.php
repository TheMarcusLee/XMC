<?php

if(isset($_GET['new_action'])){
	if($_GET['page'] == 'add_subscriber'){
		include( get_template_directory() . '-child/admin/subscription/add_subscriber.php' );
	}
	if($_GET['page'] == 'edit_subscriber'){
		include( get_template_directory() . '-child/admin/subscription/edit_subscriber.php' );
	}		
}
if(isset($_GET['id'])){
    $id = $_GET['id'];		
		
}
if(isset($_GET['subscriber_action'])){
	if($_GET['subscriber_action'] == 'exportcsv'){
		include( get_template_directory() . '-child/admin/subscription/export_csv.php' );
	}
}

	else{
include( get_template_directory() . '-child/admin/header.php' );


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
					<a href="<?php echo home_url();?>/dashboard/?option=subscription" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					<!-- <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> -->
						</h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading subsciber-heading">
									<h5>Subscriber 									
									<small class="pull-right heading-earnings add-earning subsciber-link">
									<font color="#007803">
										<a	href="<?php echo home_url().'/wp-content/themes/Divi-child/admin/subscription/csv_sample.csv';?>" type="button" download><i class="fa fa-share-square-o"></i> CSV Sample</a>
										<a href="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&page=add_subscriber&id=<?php echo $id;?>"><i class="fa fa-plus"></i> Add Subsciber</a>
									</font>
									</small>
									</h5>
									<hr />
								</div>
								<?php if(isset($_GET['imsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Subscriber added Successfully!
											</code>
										</div>
								<?php } ?>	
								<?php if(isset($_GET['umsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Subscriber updated Successfully!
											</code>
										</div>
								<?php } ?>				
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
								<form action="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&subscriber_action=exportcsv&id=<?php echo $id;?>" method="post" onsubmit="return ischeckbox();">
								<table id="subscription" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><input type="checkbox" id="chkall" /></th>
											<th>Name</th>
											<th>Phone Number</th>
											<!-- <th>Campaigns Title</th> -->
											<!-- <th>Status</th> -->
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									$user_id= $_SESSION['user_id'];
									$results = $wpdb->get_results("SELECT * FROM $table_name WHERE sub_group_id = $id AND registereduser_id = $user_id",ARRAY_A); 
									$i = 0;
									foreach($results as $result){
									?>
										<tr>
											<td><input type="checkbox" name="check_list_ho_ja[]" id="check_list_ho_ja<?php echo $i;?>"  value="<?php echo $result['id'];?>" /></td>
											<td><?php echo $result['name'];?></td>
											<td><?php echo $result['phone_number'];?></td>
											<!-- <td><?php echo $result['campaign'];?></td> -->
											<!-- <td><font color="#228B22"><?php echo $result['status'];?></font></td> -->
											<td>
												<a href="#"><i class="fa fa-envelope fa-1x camp-action"></i></a>
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&page=edit_subscriber&id=<?php echo $id;?>&row_id=<?php echo $result['id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<!-- <a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a> -->
											</td>
										</tr>			
										<input type="hidden" name="ad" id="unique" value="<?php echo $i;?>">									
									<?php $i++; } ?>
									</tbody>
								</table>	
								<h5>
								<small class="pull-right heading-earnings add-earning subsciber-link">
										<!-- <select class="">
											<option value="">Select Campaigns</option>
											<?php 
											$camp_table_name = $wpdb->prefix.'svb_campaings';
											$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name");
											foreach($camp_list as $list){
											?>
											<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
											
											<?php } ?>
										</select> -->
										<font color="#007803">
										<button type="button"><i class="fa fa-telegram"></i> Send SMS</button>
										<button type="submit" name="exp_sub_mit"><i class="fa fa-share-square-o"></i> Export</button>
										<!-- <a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=subscriber&subscriber_action=exportcsv"><i class="fa fa-share-square-o"></i> Export</a> -->
										
										
										<button type="button" data-toggle="modal" data-target="#upload_csv"><i class="fa fa-cloud-upload"></i> Import</button>
										<button type="submit" name="delete_sub"><i class="fa fa-trash"></i> Delete</button>									
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
			if($data[0] != ""){
				$idata = array('sub_group_id'=>$id,'registereduser_id'=>$_SESSION['user_id'],'name' =>$data[0],'phone_number'=>$data[1]);
				$wpdb->insert($table_name,$idata);
			}
			
		}		
		$row++;		
		 //echo "</pre>";
		//$idata = array('name' =>$data[0],'phone_number'=>$data[1] );
		//$wpdb->insert($table_name,$idata);
		 
		}
		fclose($handle);
		echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription&new_action=subscriber&import=1&id='.$id.'"</script>';		 		 
	}
?>
