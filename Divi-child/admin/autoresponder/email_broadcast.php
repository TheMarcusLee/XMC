<?php
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
$user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
if(isset($_POST['submit'])){
	$implode = implode(',',$_POST['list']);
	$data = array('date' => $_POST['date'],
								'time' => $_POST['time'],
								'list' => $implode,
								'subject' => $_POST['subject'],
								'registered_userid' => $_SESSION['user_id'],
								'body' => $_POST['editor1'],
							);
	$table = $wpdb->prefix.'auto_responder';
	$wpdb->insert($table,$data);
	flash('msg','<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success!</strong> Message created successfully.
</div>');
echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=auto_responder&action=msg_list" }, 3000);</script>';
	//echo '<script>window.location.href="'.home_url().'/dashboard/?page=auto_responder&action=msg_list&imsg=1";</script>';
}
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/bootstrap-multiselect.css">
<style>
	.new-message label {
		text-align: left !important;
	}
	
	.btnSend {
		background: #e4041c;
		color: #fff;
		font-size: 16px;
	}
	
	.btnSend:hover {
		background: #333333;
		color: #fff;
		font-size: 16px;
	}
	.new-message textarea{height: 150px;}
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

<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                        <div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box">
													<h3>
														<span>New Messages</span>
													</h3>
													<?php echo flash('msg');?>
													<div class="new-message">
														<form class="form-horizontal" method ="post">
														  <div class="form-group">
															<label for="inputEmail3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Schedule Date:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															  <input type="text" class="form-control" name="date" id="datepicker" placeholder="DD/MM/YY" />
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Schedule Time:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															<select class="form-control" name="time" required>
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
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Select a List:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															<?php $lead_table = $wpdb->prefix.'leads'; 
																		$keyword  =$_SESSION['keyword'];																																		
															      $leads = $wpdb->get_results("SELECT * FROM $lead_table WHERE keyword = '$keyword' AND status = 0",ARRAY_A); ?>
															  <select class="form-control" name="list" multiple="multiple" id="phoneNumber">															
																		<?php foreach($leads as $get_lead){ ?>
																			<option value="<?php echo $get_lead['leads_phonenumber'];?>"><?php echo ucwords($get_lead['leads_fname'].' '.$get_lead['leads_lname']);?></option>
																		<?php } ?>
															  </select>
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Email Subject:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															  <input type="text" class="form-control" name="subject" required/>
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-md-2 col-lg-2 col-xs-12 control-label">Email Body:</label>
															<div class="col-sm-8 col-md-10 col-lg-10 col-xs-12">
															  <textarea class="form-control" id="buider_media" required  name="editor1" placeholder="Enter Message"></textarea>
															</div>
														  </div>
														  <div class="form-group">
															<div class="col-md-offset-2 col-sm-offset-4 col-sm-10">
															  <button type="submit" name="submit" class="btn btn-default btnSend">Save</button>
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
        </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	CKEDITOR.replace( 'editor1' );
	$( function() {
		$( "#datepicker" ).datepicker({
				minDate: 0
		});
  });
</script>	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>-child/js/bootstrap-multiselect.js"></script>
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
		});
        
	</script>