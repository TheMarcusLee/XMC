<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
//use Twilio\Rest\Client;
	if(isset($_GET['edit_cam'])){
        $id = $_GET['edit_cam'];
        $table_name = $wpdb->prefix.'svb_campaings';
        $rows= $wpdb->get_row("SELECT * FROM $table_name WHERE id= $id");
        
		}
	if(isset($_GET['more_del'])){
			$more_id = $_GET['more_del'];
			$id= $_GET['edit_cam'];
			$crone_table = $wpdb->prefix.'sms_crone';
			$wpdb->delete($crone_table,array('sms_crone_id'=>$more_id));
			echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&sms_action=edit_campaign&edit_cam='.$id.'"</script>';
			exit;
			
	}
if(isset($_POST['sms_camp_title'])){
	
	$sms_camp_title = $_POST['sms_camp_title'];
	$sms_keyword = $_POST['sms_keyword'];
	$sms_phone_number = $_POST['sms_phone_number'];
	
	if(strpos($_POST['sms_camp_sms'],'Reply STOP to cancel this msgs')){

	}
	if (strpos($_POST['sms_camp_sms'], 'Reply STOP') !== false) {
		$sms_camp_sms = $_POST['sms_camp_sms'];
	}else{
		$sms_camp_sms = $_POST['sms_camp_sms'].'
Reply STOP to cancel this msgs';	
	}
	$sms_your_camp_mobile_number = $_POST['sms_your_camp_mobile_number'];
	$sms_camp_lead_nitification = $_POST['sms_camp_lead_nitification'];
//	$sms_followup_day_after = $_POST['sms_followup_day_after'];
	//$time_sms = $_POST['time_sms'];
//	$sms_followup_sms_text = $_POST['sms_followup_sms_text'];
	$sub_group_id = $_POST['group_list'];
	$receive_notification = $_POST['receive_notifications'];	
	$follow_up = $_POST['follow_up'];

	// Submit Data
	sms_data_submit($sms_camp_title,$sms_keyword,$sms_phone_number,$sms_camp_sms,$sms_your_camp_mobile_number,$sms_camp_lead_nitification,$sub_group_id,$receive_notification,$follow_up);

}

function sms_data_submit( $sms_camp_title = null, $sms_keyword = null, $sms_phone_number = null, $sms_camp_sms = null, $sms_your_camp_mobile_number = null, $sms_camp_lead_nitification = null,$sub_group_id = null,$receive_notification,$follow_up ){

	global $wpdb;

	$table_name = $wpdb->prefix.'svb_campaings';
	$data = array(
						'title' => $sms_camp_title,
						'keyword' => $sms_keyword,
						'phone_number' => $sms_phone_number,
						'camp_sms' => $sms_camp_sms,
						'sub_group_id' => $sub_group_id,
						'your_mobile_number' => $sms_your_camp_mobile_number,
						'receive_notification'=>$receive_notification,
						'sms_lead_notification_text' => $sms_camp_lead_nitification,								
						'follow_up'=> $follow_up,
                    );
	
    $where = array('id'=>$_GET['edit_cam']);        
		$update = $wpdb->update($table_name,$data,$where);
		@$sms_followup_day_after = $_POST['sms_followup_day_after'];
		@$time_sms = $_POST['time_sms'];
		@$sms_followup_sms_text = $_POST['sms_followup_sms_text'];
		$last_id = $_GET['edit_cam'];

		if($update == true){			
			session_start();
			$user_id_12 = $_SESSION['user_id']; 
		$msg = 'Submit Successfully';
		for($i=0;$i<count($sms_followup_day_after);$i++)
			{				
				$data = array('crone_date'=> $sms_followup_day_after[$i],
											'crone_time' => $time_sms[$i],
											'crone_sms_text' => $sms_followup_sms_text[$i],
											'user_id'    => $user_id_12,
											'twilio_no'  => $sms_phone_number,
											'sms_camp_id'  => $last_id
									);
									$crone_table = $wpdb->prefix.'sms_crone';
									$wpdb->insert($crone_table,$data);							
			}
				echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&umsg=1";</script>';
			}
			else{
				$msg = 'Could Not Submit';
				echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&umsg=1";</script>';
			}
		return $msg;
}
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
													<h3>Edit Campaign</h3>
													<form method="post" action="" class="form-horizontal profile-form">
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Campaign Title:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text" name="sms_camp_title" required class="form-control" value="<?php echo $rows->title;?>" />
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Keyword:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="text"  name="sms_keyword" class="form-control" readonly value="<?php echo $rows->keyword;?>" />
                              <!-- <span class="label label-danger">No space or special characters permitted in  keyword</span> -->
                              <span class="label label-danger">You can not changed keyword</span>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Phone Number:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														<select name="sms_phone_number" class="form-control" id="sel1">
														<option value="">Select a number</option>
														<?php
															$tbl_name = $wpdb->prefix.'twilio_numbers_detail';
															$p_num = $wpdb->get_results("SELECT * FROM $tbl_name",ARRAY_A);
															foreach($p_num as $p){
															?>
																	<option value="<?php echo $p['twilio_phone_number'];?>" <?php if($rows->phone_number == $p['twilio_phone_number']){ echo "selected";} ?> ><?php echo $p['twilio_phone_number'];?></option>
																<?php } ?>
														</select>
														</div>
													  </div>
														<!-- <div class="form-group">
															<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Subscribers :</label>														
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														<select class="form-control" name="group_list">
														<option value="" selected>Select Subscribers</option>
														<?php
														$table_phone = $wpdb->prefix.'subscriber_group';
														$phone_list_option = $wpdb->get_results("SELECT * FROM $table_phone",ARRAY_A);
														foreach($phone_list_option as $option){
															
														?>
																<option value="<?php echo $option['group_id'];?>" <?php if($rows->sub_group_id == $option['group_id']){ echo "selected";} ?> ><?php echo ucwords($option['group_name']);?></option>
																
														<?php } ?>
														</select>
														</div>
														</div>  -->
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Campaign SMS:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <textarea class="form-control" name="sms_camp_sms" maxlength="135" id="sms_campaign_sms" rows=5 ><?php echo $rows->camp_sms;?></textarea>
														  <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_length_count">135</em></small>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12  control-label">Receive New Lead Notificaions Via SMS</label>
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="receive_notifications" id="notificationRadio1" value="1" onclick="notishowable()" <?php if($rows->receive_notification ==1){ echo "checked"; } ?> /> Yes
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="receive_notifications" id="notificationRadio2" value="0" onclick="notishowable()" <?php if($rows->receive_notification == 0){ echo "checked"; } ?> /> No
																</label>
															</li>
														  </ul>
														  <div  <?php if($rows->receive_notification ==0){ echo "class='mobilehidden-div' id='mobilehidden-div'"; } ?> >
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Your Mobile Number:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <input type="phone" class="form-control" name="sms_your_camp_mobile_number" value="<?php echo $rows->your_mobile_number;?>"  />
																</div>
															  </div>
															  <div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">SMS Lead Notificaion Text (For Your Records Only):</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <textarea type="phone" class="form-control" name="sms_camp_lead_nitification" id="sms_lead_text" maxlength=135 rows=5><?php echo $rows->sms_lead_notification_text;?></textarea>
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
																  <input type="radio" name="follow_up" id="dayRadio1" value="1" onclick="followshowable()" <?php if($rows->follow_up == 1){ echo "checked"; } ?> /> Yes
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="follow_up" id="dayRadio2" value="0" onclick="followunshowable()" <?php if($rows->follow_up == 0){ echo "checked"; } ?> /> No
																</label>
															</li>
														  </ul>
														  <div <?php if($rows->follow_up == 0){ ?> class='dayhidden-div' id='dayhidden-div' <?php } ?> >
															<?php $more = $wpdb->get_results("SELECT * FROM `wp_sms_crone` WHERE sms_camp_id = $rows->id");																																															
																		$i=0;
																		foreach($more as $mo){			?>
																		
															<div class="row">
																<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
																	<div class="form-group">
																		<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Day of sent :</label>
																		<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																		  <ul class="list-inline day-ul">
																			<li>
																				<input type="text" readonly class="form-control" value="<?php echo $mo->crone_date;?>" <?php if($i != 0) { ?> style="margin-top: 24px;" <?php } ?> >
																				<!-- <select class="form-control" name="sms_followup_day_after[]" required>
																					<?php 
																					for($day = 0; $day<=99; $day++){                                                                                    
																					?>
																					<option value="<?php echo date('Y-m-d', strtotime("+$day days"));?>"><?php echo $day;?> Day(s)</option>
																					<?php }	?>
																				</select> -->
																			</li>
																		  </ul>
																		</div>
																	</div>
																</div>
																<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
																	<div class="form-group">
																		<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Time</label>
																		<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																		  <input type="text" name="" readonly value="<?php echo $mo->crone_time;?>" class="time_smss" >
																		</div>
																	</div>
																</div>
															</div>
															  <div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">SMS Text:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <textarea type="phone" class="form-control" readonly required name="" id="sms_below_text" maxlength="135"><?php echo $mo->crone_sms_text;?></textarea>
																   <small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_character_text">135</em></small>
																</div>
															  </div>
																<div class="pull-right">
																				<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign&sms_action=edit_campaign&edit_cam=<?php echo $id;?>&more_del=<?php echo $mo->sms_crone_id;?>" class="btn btn-danger btn-sm"> <i class="fa fa-times-circle"></i> Delete </a>
																</div>															  
																<?php $i++; }  ?>	
																<div class="input_fields_wrap ">
																	<button type="button" class="add_field_button btn btn-danger btn-sm"> <i class="fa fa-plus"></i> Add More Fields</button>	
																	<div></div>															
																</div>
														  </div>															
														</div>
																											
													  </div>
														

													  <div class="form-group">
														
														<div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-floppy-o"></i> Update</button>
															
														</div>
														<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=allcampaign" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
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
</script>