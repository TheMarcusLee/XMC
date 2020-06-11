<?php
include( get_template_directory() . '-child/admin/header.php' );

require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
global $wpdb;
$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'twilio_detail';
$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");	
$table_name = $wpdb->prefix.'twilio_numbers_detail';

if(isset($_GET['del_num'])){
	$sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
	$token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
	$client = new Client($sid, $token);
	
	$sid = $_GET['del_num'];

	$number = $client
    ->incomingPhoneNumbers($sid)
	->delete();
	$where = array(
				'twilio_sid' => $sid,		
			);
	//print_r($number);
	$wpdb->delete($table_name,$where);

	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=existing_numbers";</script>';
}

$user_id = $_SESSION['user_id'];
$all_num = $wpdb->get_results("SELECT * FROM `$table_name` WHERE registereduser_id = $user_id",ARRAY_A);

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
									<h5>Existing Numbers
										
									</h5>
									<hr />
								</div>
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
                                            <th>Friendly Name</th>
											<th>Phone Number</th>
                                           <th>Purchase Date</th>
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
                                        <td><?php echo $num['twilio_friendly_name'];?></td>
                                        <td><?php echo $num['twilio_phone_number'];?></td>
                                        <td><?php echo $num['time'];?></td>
                                        <td>
                                            <a href="#"><i class="fa fa-ban fa-1x camp-action"></i></a>
                                            <a href="<?php echo $_SERVER['REQUEST_URI'].'&del_num='.$num['twilio_sid'];?>" onclick="return confirm('Are you sure ?');"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
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
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>