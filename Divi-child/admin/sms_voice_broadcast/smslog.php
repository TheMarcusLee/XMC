<?php
session_start();
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
global $wpdb;
$user_id = $_SESSION['user_id'];
$table = $wpdb->prefix.'twilio_detail';
$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");	
$account_sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
$auth_token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
$twilio_number = $sms_phone_number; 

if(isset($_GET['del_cam'])){
	$sms_id = $_GET['del_cam']; 
	$client = new Twilio\Rest\Client($account_sid, $auth_token);
	
	$messages = $client->accounts("ACc8ce1993c63561a4551636b200e4af25")->messages("SM50b617c42de366b4bd7bfd6b68123217")->delete();
	print_r($messages); exit;
	echo "<script>location.reload();</script>";
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
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
									<h5>Sms Log : </h5>									
										<hr />
									</div>
									<table id="example" class="display responsive nowrap" style="width:100%" cellspacing="0" width="100%">
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
											
											$client = new Twilio\Rest\Client($account_sid, $auth_token);
											foreach ($client->messages->read() as $message) {
										 ?>
											<tr>
												<td><?php echo $message->to; ?></td>
												<td><?php echo $message->from; ?></td>
												<td><?php echo $message->body; ?></td>
                                                <!-- <td></td> -->
												<!-- <td><a href="<?php echo home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=sms_log&del_cam='.$message->sid;?>" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-o fa-1x camp-action"></i></a></td> -->
												<td><a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a></td>
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>