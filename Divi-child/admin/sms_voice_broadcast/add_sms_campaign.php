<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;

if(isset($_POST['sms_camp_title'])){
	
	$sms_camp_title = $_POST['sms_camp_title'];
	$sms_keyword = $_POST['sms_keyword'];
	$sms_phone_number = $_POST['sms_phone_number'];
	$sms_camp_sms = $_POST['sms_camp_sms'].'
Reply STOP to cancel this msgs';	
	$sms_your_camp_mobile_number = $_POST['sms_your_camp_mobile_number'];
	$sms_camp_lead_nitification = $_POST['sms_camp_lead_nitification'];

	// $sms_followup_day_after = $_POST['sms_followup_day_after'];
	// $time_sms = $_POST['time_sms'];
	// $sms_followup_sms_text = $_POST['sms_followup_sms_text'];

	// echo "<pre>";
	// print_r($final); exit;
	$sub_group_id = $_POST['group_list'];
	$receive_notification = $_POST['receive_notifications'];	
	$follow_up = $_POST['follow_up'];
	$str= $_POST['enter_phone'];	// get new line no

	// Submit Data
	sms_data_submit($sms_camp_title,$sms_keyword,$sms_phone_number,$sms_camp_sms,$sms_your_camp_mobile_number,$sms_camp_lead_nitification,$sub_group_id,$receive_notification,$follow_up,$str);

}

function sms_data_submit( $sms_camp_title = null, $sms_keyword = null, $sms_phone_number = null, $sms_camp_sms = null, $sms_your_camp_mobile_number = null, $sms_camp_lead_nitification = null,$sub_group_id = null,$receive_notification,$follow_up,$str){

	global $wpdb;

	$table_name = $wpdb->prefix.'svb_campaings';
	$svb_table = $wpdb->prefix.'svb_subscriber';
	$user_id= $_SESSION['user_id'];
	/*if($str != NULL){
		$str_1 = preg_replace('/\s+/',',',str_replace(array("\r\n","\r","\n"),' ',trim($str))); //replace into aray
		$str_2 = preg_replace('#\s+#',',',trim($str_1));  //cleaner
		$arr = explode(',',$str_2); //get array
		foreach($arr as $ph_no){
			$data = array('phone_number'=>$ph_no,
										'sub_group_id'=>$sub_group_id,
									'registereduser_id'=>$user_id);
			$wpdb->insert($svb_table,$data);
		}
	}*/
	$data = array(
						'title' => $sms_camp_title,
						'keyword' => $sms_keyword,
						'phone_number' => $sms_phone_number,
						'camp_sms' => $sms_camp_sms,
					//	'sub_group_id' => $sub_group_id,
						'your_mobile_number' => $sms_your_camp_mobile_number,
						'receive_notification'=>$receive_notification,
						'sms_lead_notification_text' => $sms_camp_lead_nitification,
						//'follow_up_day_after' => $sms_followup_day_after,
					//	'follow_up_time' => $time_sms,
						//'follow_up_sms_text' => $sms_followup_sms_text,						
						'follow_up'=> $follow_up,
						'registereduser_id' => $_SESSION['user_id']
					);
					
		$insert = $wpdb->insert($table_name,$data);
		$sms_followup_day_after = $_POST['sms_followup_day_after'];
		$time_sms = $_POST['time_sms'];
		$sms_followup_sms_text = $_POST['sms_followup_sms_text'];
		$last_id = $wpdb->insert_id;
		/*
		$table = $wpdb->prefix.'twilio_detail';
		$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");	
		$sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
		$token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
		$twilio_number = $sms_phone_number; 
		$client = new Twilio\Rest\Client($sid, $token);
		$details = $wpdb->get_results("SELECT * FROM $svb_table WHERE sub_group_id = $sub_group_id",ARRAY_A);	
		foreach ($details as $phone) {			
			$messages = $client->messages->create(
				// the number you'd like to send the message to
					''.$phone['phone_number'].'',
				array(
					// A Twilio phone number you purchased at twilio.com/console
					//'from' => '+13143100397 ',
					'from' => $twilio_number,
					// the body of the text message you'd like to send
					'body' => $sms_camp_sms
				)
			);
		}*/
		if($insert == true){
			for($i=0;$i<count($sms_followup_day_after);$i++)
			{
				
				$data = array('crone_date'=> $sms_followup_day_after[$i],
											'crone_time' => $time_sms[$i],
											'crone_sms_text' => $sms_followup_sms_text[$i],
											'user_id'    => $user_id,
											'twilio_no'  => $sms_phone_number,
											'sms_camp_id'  => $last_id
									);
									$crone_table = $wpdb->prefix.'sms_crone';
									$wpdb->insert($crone_table,$data);							
			}			
		$msg = 'Submit Successfully';

				echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&imsg=1";</script>';
			}
			else{
				$msg = 'Could Not Submit';
			}
		return $msg;
}
?>
<?php 

 
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
						<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					</h4>

                       <div class="setting-divs campaign-page">
						 	 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-7 col-sm-12 col-lg-7 col-xs-12">
												<div class="profile-box">
													<h3>Add Campaign</h3>
													<form method="post" action="" class="form-horizontal profile-form">
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Campaign Title:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="sms_camp_title" required class="form-control"  />
														</div>
													  </div>
													  <div class="form-group">
													
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Keyword:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														<div id="error"></div>
														  <input type="text"  name="sms_keyword" class="form-control" id="sms_keyword" onkeyup=checkkeyword(this.value); />
                              <span class="label label-danger" style="display:block; margin: 4px 0;">No space or special characters permitted in  keyword</span>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Phone Number:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														<select name="sms_phone_number" class="form-control" id="sel1" required>
														<option value="">Select a number</option>
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
														<!-- <div class="form-group">
															<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Subscribers :</label>														
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														<select class="form-control" name="group_list" required>
														<option value="" selected>Select Subscribers</option>
														<?php $user_id = $_SESSION['user_id'];;
																	$table_phone = $wpdb->prefix.'subscriber_group';
																	$phone_list_option = $wpdb->get_results("SELECT * FROM $table_phone WHERE registereduser_id = $user_id",ARRAY_A);
														foreach($phone_list_option as $option){
															
														?>
																<option value="<?php echo $option['group_id'];?>"><?php echo ucwords($option['group_name']);?></option>
																
														<?php } ?>
														</select>
														</div>
														</div> 
														<div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Enter Phone Numbers:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <textarea class="form-control" name="enter_phone" rows="5" ></textarea>
															<span class="label label-danger" style="margin-top:5px;" >Enter Phone Number, One per line.</span>
														  <small class="pull-right labeel label-danger " style="margin-top:5px"> </small> 
														</div>
													  </div> -->
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Campaign SMS:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <textarea class="form-control" name="sms_camp_sms" maxlength="135" id="sms_campaign_sms"></textarea>
														  <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_length_count">135</em></small>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12  control-label">Receive New Lead Notificaions Via SMS</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="receive_notifications" id="notificationRadio1" value="1" onclick="notishowable()" /> Yes
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="receive_notifications" id="notificationRadio2" value="0" onclick="notishowable()" checked /> No
																</label>
															</li>
														  </ul>
														  <div class="mobilehidden-div" id="mobilehidden-div">
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Your Mobile Number:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <input type="phone" class="form-control" name="sms_your_camp_mobile_number"  />
																</div>
															  </div>
															  <div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">SMS Lead Notificaion Text (For Your Records Only):</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <textarea type="phone" class="form-control" name="sms_camp_lead_nitification" id="sms_lead_text"maxlength=135></textarea>
																   <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_count">135</em></small>
																</div>
															  </div>
														  </div>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12  control-label">Follow Up Messages!</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="follow_up" id="dayRadio1" value="1" onclick="followshowable()" /> Yes
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="follow_up" id="dayRadio2" value="0" onclick="followunshowable()" checked /> No
																</label>
															</li>
														  </ul>
														  <div class="dayhidden-div" id="dayhidden-div">
															<div class="row">
																<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
																	<div class="form-group">
																		<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Day After :</label>
																		<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																		  <ul class="list-inline day-ul">
																			<li>
																				<select class="form-control" name="sms_followup_day_after[]" required>
																					<?php 
																					for($day = 0; $day<=99; $day++){                                                                                    
																					?>
																					<option value="<?php echo date('Y-m-d', strtotime("+$day days"));?>"><?php echo $day;?> Day(s)</option>
																					<?php }	?>
																				</select>
																			</li>
																		  </ul>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
																	<div class="form-group">
																		<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Time</label>
																		<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																		  <input type="text" name="time_sms[]" class="time_sms" >
																		</div>
																	</div>
																</div>
															</div>
															  <div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">SMS Text:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <textarea type="phone" class="form-control" name="sms_followup_sms_text[]" id="sms_below_text" maxlength="135"></textarea>
																   <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_character_text">135</em></small>
																</div>
															  </div>
															  <div class="input_fields_wrap">
																	<button type="button" class="add_field_button btn btn-danger btn-sm"> <i class="fa fa-plus"></i> Add More Fields</button>	
																	<div></div>															
																</div>															
														  </div>															
														</div>														
													  </div>

													  <div class="form-group">
														
														<div class="col-md-7 col-sm-7 col-lg-7 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign" id="btncapaign"><i class="fa fa-floppy-o"></i> Save</button>
														<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
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
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>
<script>
$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
				e.preventDefault();
        if(x < max_fields){ //max input box allowed
						x++; //text box increment
						var apd = '<div><div class="row"><div class="col-md-6 col-sm-6 col-lg-6 col-xs-12"><div class="form-group">';
							apd += '<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Day After :</label>';
							apd += '<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12"><ul class="list-inline day-ul"><li>';
							apd += '<select class="form-control" name="sms_followup_day_after[]" required><?php for($day = 0; $day<=99;$day++){ ?>';
							apd += '<option value="<?php echo date("Y-m-d", strtotime("+$day days"));?>"><?php echo $day;?> Day(s)</option><?php } ?></select></li></ul></div></div></div>';
							apd += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12"><div class="form-group"><label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Time</label>';
							apd += '<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12"><input type="text" name="time_sms[]"  class="time_sms"></div></div></div></div>';
							apd += '<div class="form-group"><label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">SMS Text:</label>';
							apd += '<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12"><textarea type="phone" required class="form-control" name="sms_followup_sms_text[]" id="sms_below_text" maxlength="135"></textarea>';
							apd += '<small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_character_text">135</em></small></div></div>';
							apd += '<a href="#" class="remove_field btn btn-danger btn-sm"> <i class="fa fa-times-circle"></i> Remove</a></div>';
						$(wrapper).append(apd); //add input box
						$(".time_sms").timepicker({
								timeFormat: 'h:mm p',
								interval: 15,
								minTime: '12:00am',
								maxTime: '11:45pm',
								defaultTime: '12',
								startTime: '12:00am',
								dynamic: false,
								dropdown: true,
								scrollbar: true
							});
							$("#sms_below_text").keyup(function(){
							var textvalue = $(this).val();
							val_array = textvalue.split("");

							var total_charcter = 135;
							var remain_charcter = total_charcter-val_array.length;
							$("#sms_character_text").html(remain_charcter);
						});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
function checkkeyword(text){
	ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';				
					data = {
					'action' : 'checkkeyword',
					'val' : text,
					};
					jQuery.post(ajax_url,data,function(response) {
						console.log(response);
						if(response == 'succsess'){							
								var error = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
										error += 'This keyword is already exist. </div>';  
								$("#error").html(error);
								$("#error").show();
								$("#btncapaign").prop('disabled','true');
						}else if(response == "no"){
							$("#error").hide();
							$("#btncapaign").removeAttr('disabled');
						}
					});		
}
</script>