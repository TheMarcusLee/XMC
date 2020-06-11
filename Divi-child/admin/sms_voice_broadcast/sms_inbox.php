<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
$table_name = $wpdb->prefix.'sms_inbox';
if(isset($_GET['del_num'])){

	$sid = $_GET['del_num'];
    $where = array('sms_id'=> $sid);
	$wpdb->delete($table_name,$where);
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=sms_inbox";</script>';
}

$user_id = $_SESSION['user_id'];
$all_num = $wpdb->get_results("SELECT * FROM `$table_name` WHERE user_id = $user_id",ARRAY_A);

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
									<h5>SMS Inbox
										
									</h5>
									<hr />
								</div>
								<div class="table-responsive">
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>                                            
											<th>Phone Number</th>
                                            <th>Reply</th>
                                            <th>Date</th>
											<th>Action</th>											
										</tr>
									</thead>									
									<tbody>                                   
                                        <?php
										$serial = 1;
                                        foreach($all_num as $num){
                                             
                                       ?>
                                       <tr>
                                        <td><?php echo $serial;?></td>
                                        <td><?php echo $num['phone_number'];?></td>
                                        <td><?php echo $num['reply'];?></td>
                                        <td><?php echo $num['sent_date'];?></td>
                                        <td>
                                            <!-- <a href="#"><i class="fa fa-ban fa-1x camp-action"></i></a> -->
                                            <a href="<?php echo $_SERVER['REQUEST_URI'].'&del_num='.$num['sms_id'];?>" onclick="return confirm('Are you sure ?');"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
                                        </td>
                                            </tr>
                                    	
										<?php
									$serial++;
									} ?>
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
?>