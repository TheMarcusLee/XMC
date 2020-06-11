<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
$user_id = $_SESSION['user_id'];
global $wpdb;
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
$table_name = $wpdb->prefix.'svb_subscriber';


if(isset($_POST['submit'])){

    $recent_table = $wpdb->prefix.'svb_recent_voice';
    $phone_no = implode(',',$_POST['phone_no']);
    $select_camp = implode(',',$_POST['campaign']);
    //$select_camp = $_POST['campaign'];
				
    $subject = $_POST['subject'];
    $type = $_POST['type'];
    $schedule_date = $_POST['date'];
    $scheedule_time = $_POST['time'];    
    $call_type = $_POST['call_type'];
		$voice_text = $_POST['sms_text'];
		
		$audio_name = $_FILES['up_audio']['name'];		    
		//$audio_list = explode(".",$audio_name);		
		$audio_list = pathinfo($audio_name);
		$newfilename = round(microtime(true)) . '.' . end($audio_list[extension]);
		
		if($audio_name != null){			
				if($audio_list[extension] == 'mp3')
				{
						// if(in_array($_FILES['up_audio']['name'],$result)){

						// 		echo '<script>alert("Already Exist");</script>';
						// }
						// else{
							global $wpdb;
							$recent_table = $wpdb->prefix.'svb_recent_voice';
								$dir = get_template_directory().'-child/admin/sms_voice_broadcast/audio_files/';

								$move = move_uploaded_file($_FILES['up_audio']['tmp_name'],$dir.$newfilename);
								$data = array(
											'voice_title' => $subject,
											'registereduser_id' => $_SESSION['user_id'],
											'type' => $type,
											'sch_date' => $schedule_date,
											'sch_time' => $scheedule_time,
											'phone_number' => $phone_no,
											'select_camp' => $select_camp,
											'call_type ' => $call_type ,
											'voice_text' => $voice_text,
											'media_loc'  => $newfilename
							);
							$inc = $wpdb->insert($recent_table,$data);
							$lastid = $wpdb->insert_id;
							$_SESSION['call_id'] = $lastid;
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
								$final_ph = array();
								foreach ($fin_arr as $phone) {							
									$final_ph[] = $phone['phone_number'];				
								}	
								
								 // send voice by sing this code
								foreach($_POST['phone_no'] as $twili_no){ 
								//	print_r($twili_no); 							
									// $final_ph = array_filter(array_merge($new_no,$arr));								
									foreach($final_ph as $final){										
										//print_r($final); exit;
										$messages = $client->calls->create(
											// the number you'd like to call
												''.$final.'',						
												// A Twilio phone number you purchased at twilio.com/console
												//'from' => '+13143100397 ',
												$twili_no,
												// the body of the text message you'd like to send
												array(
													'url' => 'https://www.xtrememarketingcode.com/call/?id='.$lastid,
											)
										);
									}
								} 
							} 	
							if($ins > 0){
								flash('msgc','<div class="alert alert-success alert-dismissible">
												<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
												<strong>Alert!</strong>Voice Broadcast has been Added successfully.
											</div>');
								echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast"; }, 2000);</script>';
							}
							//echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast&imsg=1";</script>';

						//}

				}
				else{
						echo '<script>alert("Upload .MP3 Files Only. Files Must Be Less Than 10MB. format audio only");</script>';
				}
		}else{ 
			global $wpdb;			
			$table = $wpdb->prefix.'svb_recent_voice';
			$data1 = array(
							'voice_title' => $subject,
							'registereduser_id' => $_SESSION['user_id'],
							'type' => $type,
							'sch_date' => $schedule_date,
							'sch_time' => $scheedule_time,
							'phone_number' => $phone_no,
							'select_camp' => $select_camp,
							'call_type' => $call_type ,
							'voice_text' => $voice_text,             
							);															
			$ins = $wpdb->insert($table,$data1);	
			$lastid = $wpdb->insert_id;
			$_SESSION['call_id'] = $lastid;
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
				$final_ph = array();
				foreach ($fin_arr as $phone) {							
					$final_ph[] = $phone['phone_number'];				
				}				
				 
				foreach($_POST['phone_no'] as $twili_no){ 
					//print_r($twili_no); 
				
					// $final_ph = array_filter(array_merge($new_no,$arr));
				
					foreach($final_ph as $final){
						
						//print_r($final); exit;
						$messages = $client->calls->create(
							// the number you'd like to call
								''.$final.'',						
								// A Twilio phone number you purchased at twilio.com/console
								//'from' => '+13143100397 ',
								$twili_no,
								// the body of the text message you'd like to send
								array(
								'url' => 'https://www.xtrememarketingcode.com/call/?id='.$lastid
							)
						);
					}
				} 
			} 							
			if($ins > 0){
				flash('msgc','<div class="alert alert-success alert-dismissible">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Alert!</strong>Voice Broadcast has been Added successfully.
							</div>');
				echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast"; }, 2000);</script>';
			}
			//echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=recent_voice_brodcast&imsg=1";</script>';
		}
		
	//	print_r($arr);
	
    
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
							<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
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
													<h3>Create Voice Broadcast</h3>
													<?php echo 	flash('msgc');?>
													<form class="form-horizontal profile-form" method="post" enctype="multipart/form-data">
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Voice Broadcast Campaign Title</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<input type="text" class="form-control" required name="subject"/>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Type</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="type" id="schedule1"  value="0" checked /> Scheduler
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="type" id="schedule2"  value="1"  /> Send Now
																</label>
															</li>
														  </ul>
														  <div class="mobilehidden-divs dateShow" id="dateShow" >
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Select Date and Time:</label>
																<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																	<input type="text" class="form-control" id="datepicker" autocomplete=offf readonly name="date"  placeholder="MM/DD/YYYY"/>
																</div>
																<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																  <select class="form-control" name="time" >
																	<option value="">- Select Time -</option>
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
														  <div class="mobilehidden-divss noShow" id="noShow">
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Phone Number:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																 <select class="form-control" id="phoneNumber" multiple="multiple" required name="phone_no[]">                                                                 
																	<?php
																			$tbl_name = $wpdb->prefix.'twilio_numbers_detail';
																			$p_num = $wpdb->get_results("SELECT * FROM $tbl_name WHERE registereduser_id = $user_id",ARRAY_A);
																			foreach($p_num as $p){
																			?>
																			<option value="<?php echo $p['twilio_phone_number'];?>"><?php echo $p['twilio_phone_number'];?></option>
																	<?php } ?>														
																	</select>
																</div>
															  </div>
														  </div>														  														  
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Select Campaign</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<select class="form-control" id="campaignSelect" required name="campaign[]" multiple>                                                            
															<?php 
																$camp_table_name = $wpdb->prefix.'svb_campaings';
																$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id =  $user_id");
																foreach($camp_list as $list){
																?>
																<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
																
																<?php } ?>
															</select>
														</div>
													  </div>
														<label class="control-label">Call Type</label>
														<ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="call_type" id="call_type1"  value="0" checked /> MP3
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="call_type" id="call_type2"  value="1"  /> Voice/Text
																</label>
															</li>
														  </ul>
														<div class="form-group" id="mp_3">														
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<input type="file" name="up_audio" >
														</div>
													  </div>
													  <div class="form-group" style="display:none;" id="voice">
														<label class="col-sm-8 col-md-8 col-lg-8 col-xs-12 control-label">Call Voice/Text</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
															<textarea class="form-control" maxleength=160 name="sms_text"  id="sms_campaign_sms" rows=5></textarea>
                                							<small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_length_count">160</em></small>
														</div>
													  </div>													  
														<div class="form-group">														
														<div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign" name="submit"><i class="fa fa-floppy-o"></i> Save</button>
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
        jQuery("#call_type1").click(function () {
            jQuery("#voice").hide();
            jQuery("#mp_3").show();
        });
        jQuery("#call_type2").click(function () {
            jQuery("#voice").show();
            jQuery("#mp_3").hide();
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