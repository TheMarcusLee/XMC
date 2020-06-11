<?php
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
$user_id = $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
$table = $wpdb->prefix.'auto_responder';
$id = $_GET['id'];
$single = $wpdb->get_row("SELECT * FROM $table WHERE registered_userid = $user_id AND responder_id = $id");
if(isset($_POST['submit'])){
	$implode = implode(',',$_POST['list']);
	// $body = $_POST['editor1'].'<small>Click <a href="'.home_url().'/unsubscribe/?email='.$email.'">here</a> to unscriber</small>';
	if(strpos($_POST['editor1'],'unsubscribe') == TRUE){
					$body = $_POST['editor1'];
	}else{
		$body = $_POST['editor1'].'<small>Click <a href="">here</a> to unsubscribe</small>';
	}
	$data = array('date' => $_POST['date'],
								'time' => $_POST['time'],
								'type' => $_POST['type'],
								'list' => $implode,
								'subject' => $_POST['subject'],
								'registered_userid' => $_SESSION['user_id'],
								'body' => $body
							);
	//$table = $wpdb->prefix.'auto_responder';
	
	$wp_table = $wpdb->prefix.'cron_email';
	// $last_id = $wpdb->insert_id;
	if($_POST['type'] == 0){
		foreach($_POST['list'] as $email){
			$c_data = array('auto_responder_id'=> $id, 
										'user_id'    => $_SESSION['user_id'],
										'keyword'    => $_SESSION['keyword'],
										'schedule_date' => $_POST['date'],
										'subject' => $_POST['subject'],
										'body' => $body,
										'email' => $email,
										);
			$wpdb->insert($wp_table,$c_data);
		}
	}else{
		foreach($_POST['list'] as $email){		
			if(strpos($_POST['editor1'],'unsubscribe') == TRUE){
							$body = $_POST['editor1'];
			}else{
				$body = $_POST['editor1'].'</br><small><a href="'.home_url().'/unsubscribe/?email='.$email.'">Click here</a> to unsubscribe</small>';
			}			
			$get = $wpdb->get_row("SELECT * FROM wp_register_user WHERE `email` = '$email'",ARRAY_A);
			$sender = $wpdb->get_row("SELECT * FROM wp_register_user WHERE `id` = $user_id",ARRAY_A);
			
			$name = $get['fname'].' '.$get['lname'];
			$s_first = ['{name}','{first}'];
					$s_second = [ucwords($name),ucwords($get['fname'])];
					$subject = str_replace($s_first,$s_second,$_POST['subject']);
			$keyword = $_SESSION['keyword'];
			
			$link = '<a href="'.home_url().'/sales-1/?keyword='.$keyword.'&provider=email&responder='.$id.'"> Get started</a>';
	
			//$link  = str_replace('{sales page link}',$link,$row['body']);
			$first_repl = ['{name}','{geet started}','{first}'];
			$second_repl = [ucwords($name).' ',$link,ucwords($get['fname']).' '];
			$to     = $email; 
			$message = '<!DOCTYPE html>
			<html lang="en">
			<head>
			<title>Xtreme Marketing Code</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Language" content="en-us" />
			</head><body>';
			//$message .= str_replace('Click Here {sales page link}',$link,$row['body']); 
			//$message .= str_replace('{sales page link}',$link,$row['body']); 
			$message .= str_replace($first_repl,$second_repl,$body); 
			$message .= '</body></html>';  	
			$mail->SMTPAuth   = true;                 
			$mail->Host       = "mail.xtrememarketingcode.com"; 
			$mail->Port       = 587;                    
			$mail->Username   = "info@xtrememarketingcode.com"; 
			$mail->Password   = "4Dm!n@9870";                    
			// $mail->SetFrom('info@xtrememarketingcode.com', 'Xtreme Marketing Code');  
			
			$mail->setFrom($sender['email'],$sender['fname'].' '.$sender['lname']); 
			$mail->AddReplyTo($sender['email'],$sender['fname'].' '.$sender['lname']); 		
			$mail->Subject = $subject;
			$mail->MsgHTML($message); //$mail->Body    = $content;
			$mail->addAddress($email, ucwords($name));
			
			if( $mail->Send()){
					$wpdb->update('wp_auto_responder', array( 'status' => '1'),array('responder_id' => $id) );				
					flash('msg','<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> Message created successfully.
				</div>');
				echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=auto_responder&action=msg_list" }, 3000);</script>';				
			}
			else{				
						$wpdb->update('wp_auto_responder', array( 'status' => '2'),array('responder_id' => $id) );				
						flash('msg','<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong> Message created successfully.
					</div>');
					echo '<script>setTimeout(function(){ window.location.href="'.home_url().'/dashboard/?page=auto_responder&action=msg_list" }, 3000);</script>';					
			} 		
			$mail->ClearAllRecipients();
	}
}
	$table = $wpdb->prefix.'auto_responder';
	$wpdb->update($table,$data,array('responder_id' => $id));
	
	flash('msg','<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Success!</strong> Message updated successfully.
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
	.btnShortcode {
    background: #da524e;
    color: #fff;
    padding: 6px 9px;
    display: inline-block;
    font-size: 15px;
    border-radius: 4px;
}
.btnShortcode:hover {
    background: #da524e;
    color: #fff;
    opacity: 0.8;
}
	.profile-box h3 {
		padding-bottom: 19px;
	}	
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">		

<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
<!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard/?page=auto_responder&action=msg_list" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
                        <div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box">
													<h3>
														<span>Update Messages</span>
														<a href="javascript: void(0);" data-toggle="modal" data-target="#uniqueOpen" class="pull-right btnShortcode"><i class="fa fa-info"></i>  Short Codes</a>
													</h3>
													<?php echo flash('msg');?>
													<div class="new-message">
														<form class="form-horizontal" method ="post">
														  <div class="form-group">
															<label for="inputEmail3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Schedule Date:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															  <input type="text" class="form-control" name="date" id="datepicker" placeholder="DD/MM/YY" value="<?php echo $single->date;?>"  />
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Schedule Time:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															<select class="form-control" name="time" required>
																	<option value="<?php echo $single->time;?>"><?php echo $single->time;?></option>
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
															      $leads = $wpdb->get_results("SELECT * FROM $lead_table WHERE keyword = '$keyword'",ARRAY_A); ?>
															  <select class="form-control" name="list[]" multiple="multiple" id="phoneNumber">
																<option value="">-- Select list --</option>
																		<?php $lists = explode(',',$single->list);
																			foreach($leads as $get_lead){ ?>
																			<option value="<?php echo $get_lead['leads_email'];?>" <?php if(in_array($get_lead['leads_email'],$lists)){ echo "selected";}?>><?php echo ucwords($get_lead['leads_fname'].' '.$get_lead['leads_lname']);?></option>
																		<?php } ?>
															  </select>
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-lg-2 col-md-2 col-xs-12 control-label">Email Subject:</label>
															<div class="col-sm-8 col-lg-6 col-md-6 col-xs-12">
															  <input type="text" class="form-control" name="subject" value= "<?php echo $single->subject;?>" required/>
															</div>
														  </div>
														  <div class="form-group">
															<label for="inputPassword3" class="col-sm-4 col-md-2 col-lg-2 col-xs-12 control-label">Email Body:</label>
															<div class="col-sm-8 col-md-10 col-lg-10 col-xs-12">
															  <textarea class="textarea" id="buider_media" required  name="editor1" placeholder="Enter Message"	><?php echo $single->body;?></textarea>
															</div>
														  </div>
														  <div class="form-group">
															<div class="col-md-offset-2 col-sm-offset-4 col-sm-10">
															  <button type="submit" name="submit" class="btn btn-default btnSend">Update</button>
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
<!-- Modal -->
<div class="modal fade" id="uniqueOpen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Short Codes</h4>
      </div>
      <div class="modal-body">
	  	{first} -> John </br>
	  	{name} -> John Smith </br>
		 {get started} -> your sales page link
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo get_template_directory_uri();?>-child/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
	CKEDITOR.replace( 'editor1' );
  //  $('.textarea').wysihtml5({
  //     toolbar: { fa: true }
  //   })
  

	$( function() {
		$( "#datepicker" ).datepicker({
				minDate: 0
		});
  });
</script>
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