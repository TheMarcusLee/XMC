<?php

include( get_template_directory() . '-child/admin/header.php' );
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
global $wpdb;
$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'twilio_detail';
$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");
if(isset($_POST['search_area_code'])){
	$code = $_POST['search_area_code'];
	$show_list = 1;
	$sid = $get_twilio->twilio_sid;
	$token = $get_twilio->twilio_token;
	$client = new Client($sid, $token);

	$numbers = $client->availablePhoneNumbers('US')->local->read(
		array("areaCode" => $code)
	);
}
if(isset($_POST['purchase_num'])){
	$sid = $get_twilio->twilio_sid;
	$token = $get_twilio->twilio_token;
	$client = new Client($sid, $token);

	global $wpdb;
	foreach($_POST['purchase_num'] as $num){
		
		$number = $client->incomingPhoneNumbers
		->create(
			array(
				"phoneNumber" => $num,
			)
		);
		$table = $wpdb->prefix.'twilio_numbers_detail';
		$data = array(
					'twilio_sid' => $number->sid,
					'twilio_phone_number' => $num,
					'twilio_friendly_name'	=> $number->friendlyName,
					'registereduser_id' => $_SESSION['user_id']
				);
		$wpdb->insert($table,$data);

	echo '<script>window.location.href="'.home_url().'/dashboard/?page=sms_voice_broadcast&sms_page=existing_numbers";</script>';
		
	}
	
	
}
if(isset($_POST['select_country_code'])){

	$code = $_POST['select_country_code'];
	$show_list = 1;
	$sid = $get_twilio->twilio_sid;
	$token = $get_twilio->twilio_token;
	$client = new Client($sid, $token);

	$number_code = $client->availablePhoneNumbers('US')->local->read(
		array("areaCode" => $code)
	);
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
									<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
								</h4>
					<div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
										
											<div class="col-md-7 col-sm-12 col-lg-7 col-xs-12">
												<div class="profile-box">
													<h3>Buy Numbers</h3>
													<div class="form-horizontal profile-form">
													  <div class="form-group">
														<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 control-label">Select Country:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <select type="text" class="form-control">
															<option>-- Select Country --</option>
															
															<option value="US">United States</option>
														  </select>
														</div>
													  </div>
													  <div class="form-group">
														<!-- <label class="col-sm-12 col-md-12 col-lg-12 col-xs-12  control-label">Receive New Lead Notificaions Via SMS</label> -->
														<div class="col-sm-8 col-md-8 col-lg-8 col-xs-12">
														  <ul class="list-inline">
															<li>
																<label class="radio-inline">
																  <input type="radio" name="notificationRadio" id="state_radio" <?php if(isset($number_code) > 0){ echo 'checked'; } ?> value="option1" /> State
																</label>
															</li>
															<li>
																<label class="radio-inline">
																  <input type="radio" name="notificationRadio" id="area_code_radio" <?php if(isset($numbers) > 0){ echo 'checked'; } ?> value="option2" /> Area Code
																</label>
															</li>
														  </ul>
														  <div class="mobilehidden-div" id="mobilehidden-div">
															<form action="" method="post">

															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Select State:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																  <select class="form-control" name="city" onchange="getAreaCode(this.value);">
																	<?php 	global $wpdb;
																	$rows = $wpdb->get_results("SELECT * FROM `wp_area_code`  GROUP BY city ORDER BY `state` ASC"); ?>
																		<option value="">- Select One -</option>
																	<?php foreach($rows as $row){ ?>
																		<option value="<?php echo $row->city;?>"><?php echo $row->city;?></option>
																	<?php } ?>
																  </select>
																</div>
															  </div>
															  <div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Select Area Code</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																<select class="form-control" required name="select_country_code" id="areoption">
																	<option value="">- Select One -</option>																	
																  </select>
																</div>
															  </div>
															  
															  <div class="form-group">
															  	<button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-search"></i> Search</button>
															  </div>
															  </form>
															 
															  <form action="" method="post">
															  <div id="no-more-tables">
																	<table class="table table-bordered table-striped table-condensed cf">
																		<thead class="cf">
																			<tr>
																				<th><input type="checkbox" /></th>
																				<th>Number</th>
																				<th class="numeric">SMS</th>
																				<th class="numeric">Voice</th>
																				<th class="numeric">MMS</th>
																			</tr>
																		</thead>
																		<tbody>
																		<?php if(isset($number_code)){
																					foreach($number_code as $num){
																					?>
																			<tr>
																				<td data-title="Code" align="center">
																					<input type="checkbox" name="purchase_num[]" value="<?php echo $num->phoneNumber; ?>"/>
																				</td>
																				<td data-title="Company"><?php echo $num->phoneNumber; ?></td>
																				<td data-title="Price" class="numeric" align="center">
																					<i class="fa fa-check-circle-o"></i>
																				</td>
																				<td data-title="Price" class="numeric" align="center">
																					<i class="fa fa-check-circle-o"></i>
																				</td>
																				<td data-title="Price" class="numeric" align="center">
																					<i class="fa fa-check-circle-o"></i>
																				</td>
																			</tr>
																			<?php
																					}
																		}
																			?>
																		
																		</tbody>
																	</table>
																</div>
															
														  </div>
														  <?php if(isset($number_code)){?>
													  <div class="form-group">
														<div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-floppy-o"></i> Buy</button>
														</div>
													  </div>
														  <?php } ?>
													  </form>
															 
														  
														   <div class="mobilehidden-div" id="mhidden-div">
															<div class="form-group">
																<label class="col-sm-12 col-md-12 col-lg-12 col-xs-12 control-label">Enter Code:</label>
																<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
																	<div class="row">
																	<form action="" method="post">
																		<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">
																			<input type="text" name="search_area_code" required class="form-control" />
																		</div>
																		<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
																			<button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-search"></i> Search</button>
																		</div>
																		</form>
																	</div>
																</div>
																<form action="" method="post">
																
																<div class="row no-margin">
																	<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
																		<div id="no-more-tables">
																			<table class="table table-bordered table-striped table-condensed cf">
																				<thead class="cf">
																					<tr>
																						<th><input type="checkbox" /></th>
																						<th>Number</th>
																						<th class="numeric">SMS</th>
																						<th class="numeric">Voice</th>
																						<th class="numeric">MMS</th>
																					</tr>
																				</thead>
																				<tbody>
																				
																				<?php 
																				if(isset($numbers)){
																					foreach($numbers as $num){
																					?>
																					<tr>
																						<td data-title="Code" align="center">
																							<input type="checkbox" name="purchase_num[]" value="<?php echo $num->phoneNumber; ?>"/>
																						</td>
																						<td data-title="Company"><?php echo $num->phoneNumber; ?></td>
																						<td data-title="Price" class="numeric" align="center">
																							<i class="fa fa-check-circle-o"></i>
																						</td>
																						<td data-title="Price" class="numeric" align="center">
																							<i class="fa fa-check-circle-o"></i>
																						</td>
																						<td data-title="Price" class="numeric" align="center">
																							<i class="fa fa-check-circle-o"></i>
																						</td>
																					</tr>
																				<?php }
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
													  <?php if(isset($numbers)){?>
													  <div class="form-group">
														<div class="col-md-4 col-sm-4 col-lg-4 col-md-offset-2 text-right">
														  <button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-plus"></i>Add</button>
														</div>
													  </div>
													  <?php } ?>
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
<script>
function getAreaCode(params){
	ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';  
  data = {
   'action' : 'usAreaCode',
   'val' : params,
  };
  jQuery.post(ajax_url,data,function(response) {
	  if(response.length >  0){
			var option ="";
			 $.each(response,function (index,obj){
				 		option += '<option value"'+obj.area_code+'">'+obj.area_code+'</option>';
			 });
			 $("#areoption").html(option);
		}else{

		}
	 
  });
}
</script>