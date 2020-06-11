<?php
session_start();
global $wpdb;
$user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
$user_id =  $_SESSION['user_id'];
$table = $wpdb->prefix.'auto_responder';
if(isset($_GET['option'])){
	if($_GET['option'] == 'edit_msg'){
		include( get_template_directory() . '-child/admin/autoresponder/edit_message.php' );
	}
	if($_GET['option'] == 'delete'){
		$wpdb->delete($table,array('responder_id' => $_GET['id']));
		flash('dmsg','<div class="alert alert-success alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Success!</strong> Message deleted successfully.
	</div>');
	echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=auto_responder&action=msg_list" }, 2000);</script>';
	}

}else{
	include( get_template_directory() . '-child/admin/header.php' );
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">		
<style>
	.profile-box h3 {
		margin-top: 0px;
		font-size: 18px;
		border-bottom: 1px solid #ccc;
		padding-bottom: 18px;
		position: relative;
		margin-bottom: 20px;
	}
	.profile-box h3 span {
		position: relative;
		top: 4px;
	}
	
	.btnEdit {
		background: #46b8da;
		color: #fff;
		border: 1px solid #46b8da;
		border-radius: 4px;
		text-align: center;
	}
	.btnTrash {
		background: red;
		border: 1px solid red;
		border-radius: 4px;
		margin-left: 4px;
		color: #fff;
	}
	div#no-more-tables {
		overflow-x: hidden;
	}
</style>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/table-responsive.css" />
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard/?page=auto_responder" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
                        <div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box">
													<h3>
														<span>Current Messages</span>
														
														<small class="heading-earnings add-earning subsciber-link pull-right">
															<font color="#007803">															    
																<a href="<?php echo home_url();?>/dashboard?page=auto_responder&action=create_msg"><i class="fa fa-plus"></i> New Messages</a>
															</font>
														</small>
													</h3>
													<?php flash('dmsg');?>
													<div id="no-more-tables">
														<table class="table table-bordered table-striped table-condensed nowrapnowrap cf" id="compaign_list_table"  >
															<thead class="cf">
																<tr class="info">
																	<th>S.No</th>
																	<th style="padding-left: 15px;">Message Subject</th>
																	<th>Schedule Date</th>
																	<th style="text-align: center;">Status</th>
																	<th class="numeric" style="text-align: center;">Options</th>
																</tr>
															</thead>
															<tbody>
															<?php $i = 1;
																  $messages = $wpdb->get_results("SELECT * FROM $table WHERE registered_userid = $user_id",ARRAY_A); 
																  foreach($messages as $msg) { ?>
																<tr>
																	<td><?php echo $i; ?></td>
																	<td data-title="Message Subject" style="padding-left: 15px;"><?php echo $msg['subject']; ?></td>
																	<td><a href="javascript:void(0);" onclick="datepopup(<?php echo $i;?>);"><?php echo $msg['date'];?></a></td>
																	<td data-title="Status" style="text-align: center;    font-size: 16px;"><?php if($msg['status'] == 0) { ?>
																		<span class="label label-danger">Pending</span>
																	<?php }else { ?>
																		<span class="label label-success">Success</span>
																	<?php } ?>
																	</td>
																	<td data-title="Options" class="numeric" style="text-align: center;"><a href="<?php echo $_SERVER['REQUEST_URI']; ?>&option=edit_msg&id=<?php echo $msg['responder_id'];?>"  class="btnEdit"><i class="fa fa-edit"></i></a> <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&option=delete&id=<?php echo $msg['responder_id'];?>" onclick ="return confirm('Are you sure ?');" class="btnTrash"><i class="fa fa-trash"></i></a></td>
																</tr>	
																<!-- Modal -->
																<div id="myModal<?php echo $i;?>" class="modal fade" role="dialog">
																<div class="modal-dialog">

																	<!-- Modal content-->
																	<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Change Date</h4>
																	</div>
																	<div class="modal-body">
																		<div class="merror"></div>
																		<input type="text" class="form-control datepicker" name="date" id="datepicker<?php echo $i;?>"  required placeholder="DD/MM/YY" value="<?php echo $msg['date'];?>"/>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-primary" onclick="changeDate(<?php echo $msg['responder_id'];?>,<?php echo $i;?>);" >Submit</button>
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
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>	
	$( function() {
		$( ".datepicker" ).datepicker({
				minDate: 0
		});
  });

	function datepopup(val){		
		jQuery("#myModal"+val).modal("show");
	}
	function changeDate(id,val){		
		ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';	
		var date = jQuery("#datepicker"+val).val();		
		data = {
				'action' : 'msdDateUpdate',
				'val' : date,
				'id' : id,
				};
				jQuery.post(ajax_url,data,function(response) {
					console.log(response);
					if(response == 'succsess'){
							var error = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
									error += 'This date changed successfully. </div>';  
							$(".merror").html(error);
							//jQuery("#myModal"+val).modal("hide");
							setTimeout(function(){ location.reload(); }, 200);
					}else if(response == "no"){
						
					}
				});				
	}
</script>
<?php }
?>