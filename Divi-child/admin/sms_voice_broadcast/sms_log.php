<?php

global $wpdb;
$table = $wpdb->prefix.'earnings';
if(isset($_GET['page'])){
    if($_GET['page'] == 'referral_expot'){    
        include( get_template_directory() . '-child/admin/referral_export.php' );
    }
}else{
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
?>
<?php
// $con = mysqli_connect("localhost","s63","qIpNApiJRXlcGwFQb7y6cVmRNONtgq4VFqGdYbvb1jvRuctiXFm","s63");

// // Check connection
// if (mysqli_connect_errno())
//   {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   }
//   $my_key = $_SESSION['keyword'];
// $sql="SELECT * FROM wp_refrerral_detail WHERE refreral_keyword = '$my_key'";

//$result=mysqli_query($con,$sql);
// Associative array
$key_word = $_SESSION['keyword'];
$rows = $wpdb->get_results("SELECT * FROM wp_leads WHERE keyword='$key_word'",ARRAY_A);	

?>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-12">
        <h4 style="text-align:right; margin-top:3%;">
						<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					</h4>
                    <div class="table-box">
								<div class="">
									<div class="table-heading">
									<?php $user_id = $_SESSION['user_id'];
										$total_amount = $wpdb->get_results("SELECT SUM(send_amount) as amount FROM `$table` WHERE rec_id = $user_id");
									?>
										<h5>My Earnings : <small class="pull-right heading-earnings"><font color="#007803"><b>Total Earnings: $<?php echo $total_amount[0]->amount;?>.00</b></font></small></h5>
										<hr />
									</div>
									<table id="phone_name_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>To</th>
												<th>From</th>
												<th>Body</th>												
												<!-- <th>Date</th> -->
												<th>Action</th>
											</tr>
										</thead>										
										<tbody>
										<?php																															
											$user_id = $_SESSION['user_id'];
											
											foreach ($client->messages->read() as $message) {
										 ?>
											<tr>
												<td><?php echo $message->to; ?></td>
												<td><?php echo $message->from; ?></td>
												<td><?php echo $message->body; ?></td>
                                                <!-- <td></td> -->
												<td><?php echo $date; ?></td>
											</tr>
										<?php } ?>
										</tbody>
									</table>
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