<?php
include( get_template_directory() . '-child/admin/header.php' );
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}

if(isset($_GET['edit_cam'])){
    $id = $_GET['edit_cam'];
}
global $wpdb;

$table_name = $wpdb->prefix.'svb_subscriber';
$recent_tab = $wpdb->prefix.'svb_recent_broad';
$single = $wpdb->get_row("SELECT * FROM $recent_tab WHERE recent_id = $id",ARRAY_A);
if(isset($_POST['submit'])){


    $recent_table = $wpdb->prefix.'svb_recent_broad';
    $phone_no = implode(',',$_POST['phone_no']);
    $select_camp = implode(',',$_POST['campaign']);
    //$select_camp = $_POST['campaign'];
    
    $subject = $_POST['subject'];
    $type = $_POST['type'];
    $schedule_date = $_POST['date'];
    $scheedule_time = $_POST['time'];
    $choose_no = $_POST['choose_no'];
    $pool = $_POST['pool'];
//		$sms_text = $_POST['sms_text'].'Reply STOP to cancel msgs';
		if (strpos($_POST['sms_text'], 'Reply STOP') !== false) {
			$sms_text = $_POST['sms_text'];
		}else{
			$sms_text = $_POST['sms_text'].'
Reply STOP to cancel this msgs';	
		}
	 $data = array(
                'subject' => $subject,
                'registereduser_id' => $_SESSION['user_id'],
                'type' => $type,
                'schedule_date' => $schedule_date,
                'scheedule_time' => $scheedule_time,
                'phone_no' => $phone_no,
                'select_camp' => $select_camp,
                'sms_text' => $sms_text,                
						);
		if($type == 1){
			$table = $wpdb->prefix.'twilio_detail';
			$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");	
			$sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
			$token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
			$twilio_number = $sms_phone_number; 
			$client = new Twilio\Rest\Client($sid, $token);
			$fin_arr = array();
			foreach($_POST['campaign'] as $camp_id){
				$details = $wpdb->get_results("SELECT phone_number FROM $table_name WHERE campaign = $camp_id AND registereduser_id = $user_id",ARRAY_A);			
				$all_arr = array_filter($details);
				foreach($all_arr as $sub_ph){						
					$fin_arr[] = $sub_ph;
					// print_r($sub_ph);
				}				
			}					
			$new_no = array();
			foreach ($fin_arr as $phone) {						
				$new_no[] = $phone['phone_number'];
			
			}			
				
			foreach($_POST['phone_no'] as $twili_no){ 
			//	print_r($twili_no); 
			
				// $final_ph = array_filter(array_merge($new_no,$arr));
				$final_ph = $new_no;
			
				foreach($final_ph as $final){
					
					//print_r($final); exit;
					$messages = $client->messages->create(
						// the number you'd like to send the message to
							''.$final.'',
						array(
							// A Twilio phone number you purchased at twilio.com/console
							//'from' => '+13143100397 ',
							'from' => $twili_no,
							// the body of the text message you'd like to send
							'body' => $sms_text
						)
					);
				}
			} 
		} 
	$wpdb->update($recent_table,$data,array('recent_id'=>$id));
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_broad&umsg=1";</script>';  
}

 

?>
<style>
		.sidebar {
			min-height: 1016px;
		}
		
		.multiselect-native-select {
			width: 100%;    display: block;
		}
		ul.multiselect-container {
			top: 34px;
			width: 100%;
		}
		.multiselect-native-select .btn-group {
			width: 100%;
		}
		.multiselect {
			width: 100%;
			text-align: left;
		}
		.multiselect b {
			float: right;
			margin-top: 10px;
		}
	</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/bootstrap-multiselect.css">

	<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
                        <?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=recent_broad" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<!-- <div class="setting-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile Setting</a></li>
								<li role="presentation"><a href="#sly-broadcast" aria-controls="sly-broadcast" role="tab" data-toggle="tab">Sly-Broadcast</a></li>
								<li role="presentation"><a href="#twilio" aria-controls="twilio" role="tab" data-toggle="tab">Twilio</a></li>
							  </ul>
						</div> -->
						<div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-7 col-sm-12 col-lg-7 col-xs-12">
												<div class="profile-box">
													<h3>Update SMS Broadcast</h3>
													<form class="form-horizontal profile-form" method="post">
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Campaign Message Title (For Your Records Only)</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<input type="text" class="form-control" name="subject" required value="<?php echo $single['subject'];?>"/>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Type</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="type" id="schedule1" value="0" <?php if($single['type'] == 0 ){ echo "checked"; } ?> /> Scheduler
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="type" id="schedule2" value="1" <?php if($single['type'] == 1 ){ echo "checked"; } ?> /> Send Now
																</label>
															</li>
														  </ul>
														  <div class="mobilehidden-divs dateShow" id="dateShow" <?php if($single['type'] == 1 ){ echo "style='display:none;'"; } ?> >
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Select Date and Time:</label>
																<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																	<input type="text" class="form-control" id="datepicker" name="date" required value="<?php echo $single['schedule_date'];?>"/>
																</div>
																<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																  <select class="form-control" name="time" required>
																	<option value="<?php echo $single['scheedule_time'];?>"><?php echo $single['scheedule_time'];?></option>
																	<option value="00:00">12:00 AM</option>
																	<option value="01:00">01:00 AM</option>
																	<option value="02:00">02:00 AM</option>
																	<option value="03:00">03:00 AM</option>
																	<option value="04:00">04:00 AM</option>
																	<option value="05:00">05:00 AM</option>
																	<option value="06:00">06:00 AM</option>
																	<option value="07:00">07:00 AM</option>
																	<option value="08:00">08:00 AM</option>
																	<option value="09:00">09:00 AM</option>
																	<option value="10:00">10:00 AM</option>
																	<option value="11:00">11:00 AM</option>
																	<option value="12:00">12:00 PM</option>
																	<option value="13:00">01:00 PM</option>
																	<option value="14:00">02:00 PM</option>
																	<option value="15:00">03:00 PM</option>
																	<option value="16:00">04:00 PM</option>
																	<option value="17:00">05:00 PM</option>
																	<option value="18:00">06:00 PM</option>
																	<option value="19:00">07:00 PM</option>
																	<option value="20:00">08:00 PM</option>
																	<option value="21:00">09:00 PM</option>
																	<option value="22:00">10:00 PM</option>
																	<option value="23:00">11:00 PM</option>
																  </select>
																</div>
															  </div>
														  </div>
														  
														   <div class="mobilehidden-divs" >
														  </div>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label"></label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <!-- <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="choose_no" id="choose_no1" value="0"  <?php if($single['choose_no'] == 0 ){ echo "checked"; } ?> /> Manual Numbers
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="choose_no" id="choose_no2" value="1" <?php if($single['choose_no'] == 1 ){ echo "checked"; } ?> />  Numbers Pool
																</label>
															</li>
														  </ul> -->
														  <div class="mobilehidden-divss noShow" id="noShow">
															<div class="form-group">
															
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Phone Number:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																 <select class="form-control" id="phoneNumber" name="phone_no[]" multiple="multiple" required>
                                                                 
																	<?php
																			$tbl_name = $wpdb->prefix.'twilio_numbers_detail';
																			$p_num = $wpdb->get_results("SELECT * FROM $tbl_name WHERE registereduser_id = $user_id",ARRAY_A);
																			$ph_arr = explode(',',$single['phone_no']);																			
																			foreach($p_num as $p){
																			?>
																							<option value="<?php echo $p['twilio_phone_number'];?>" <?php if(in_array($p['twilio_phone_number'],$ph_arr) ){ echo "selected";} ?> ><?php echo $p['twilio_phone_number'];?></option>
																					<?php } ?>
														
																	</select>
																</div>
															  </div>
														  </div>
														  
														   <div class="mobilehidden-divss noshow1" style="display:none;" id="noshow1" >
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Number Pools:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																 <select class="form-control" name="pool">
																	<option value="">Choose One</option>
																</select>
																</div>
															  </div>
														  </div>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Select Campaign</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<select class="form-control" id="campaignSelect" name="campaign[]" multiple required>
                                                            
															<?php 
																$camp_table_name = $wpdb->prefix.'svb_campaings';
																$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $user_id");
																$arr = explode(',',$single['select_camp']);
																foreach($camp_list as $list){
																?>
																<option value="<?php echo $list->id;?>" <?php if(in_array($list->id,$arr) ){ echo "selected";} ?> ><?php echo $list->title;?></option>
																
																<?php } ?>
															</select>
														</div>
													  </div>
														
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">SMS Text</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<textarea class="form-control" maxleength=160 name="sms_text" required id="sms_campaign_sms"><?php echo $single['sms_text'];?></textarea>
                               <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_length_count">160</em></small>
														</div>
													  </div>
													  <div class="form-group">
														<div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign" name="submit"><i class="fa fa-floppy-o"></i> Update</button>
														</div>
													  </div>
													</form>
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
        jQuery("#schedule2").click(function () {            
            jQuery(".dateShow").hide();
        });
        jQuery("#schedule1").click(function () {
            jQuery(".dateShow").show();
        });
        jQuery("#choose_no1").click(function () {
            jQuery(".noShow").show();
            jQuery(".noshow1").hide();
        });
        jQuery("#choose_no2").click(function () {
            jQuery(".noShow").hide();
            jQuery(".noshow1").show();
        });
	</script>
	
	
	<script>
		$(document).ready(
			function(){
			$('.dropdown-button').click(function(){
				$('.dropdown-options').toggle();
			});
			$('.btnAdd').click(function(){
				$('#services-select').toggleClass('hidden-select');
				$('#btnAdd').toggleClass('removeBtnAdd');
			});
		});
	</script>
	
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>-child/js/bootstrap-multiselect.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#phoneNumber').multiselect({
                includeSelectAllOption: true,
                selectAllText: ' Select all',
                selectAllValue: '',
                nonSelectedText: 'Select Phone No',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                enableClickableOptGroups: false,
                filterPlaceholder: 'Search',
                // possible options: 'text', 'value', 'both'
                filterBehavior: 'text',
                includeFilterClearBtn: true,
                preventInputChangeEvent: false,
                nonSelectedText: 'None selected',
                nSelectedText: 'selected',
                allSelectedText: 'All selected',
            });
			$('#campaignSelect').multiselect({
                includeSelectAllOption: true,
                selectAllText: ' Select all',
                selectAllValue: '',
                nonSelectedText: 'Select Phone No',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                enableClickableOptGroups: false,
                filterPlaceholder: 'Search',
                // possible options: 'text', 'value', 'both'
                filterBehavior: 'text',
                includeFilterClearBtn: true,
                preventInputChangeEvent: false,
                nonSelectedText: 'None selected',
                nSelectedText: 'selected',
                allSelectedText: 'All selected',
            });
		});
        $( function() {
            $( "#datepicker" ).datepicker({
                minDate: 0
            });
        } );
	</script>