<?php
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;

$table_name = $wpdb->prefix.'register_user';

$user_detail = $wpdb->get_row("SELECT * FROM $table_name WHERE id =".$_SESSION['user_id'],ARRAY_A);
if(isset($_GET['action'])){
		if($_GET['action'] == 'profile_update'){
			include( get_template_directory() . '-child/admin/setting/profile_update.php' );
		}
		if($_GET['action'] == 'business_field'){
			include( get_template_directory() . '-child/admin/setting/business_field.php' );
		}
		if($_GET['action'] == 'billing_info'){
			include( get_template_directory() . '-child/admin/setting/billing_info.php' );
		}
		if($_GET['action'] == 'auto_responder'){
			include( get_template_directory() . '-child/admin/setting/auto_responder.php' );
		}
		if($_GET['action'] == 'change_password'){
			include( get_template_directory() . '-child/admin/setting/change_password.php' );
		}
		if($_GET['action'] == 'payment'){
			include( get_template_directory() . '-child/admin/setting/payment.php' );
		}
		
}
if(isset($_POST['submit_profile']))
{
	$user_id = $_SESSION['user_id'];
	
	$img_name=$_FILES['image_profile']['name'];
	$img_tmp=$_FILES['image_profile']['tmp_name'];
	$img_error=$_FILES['image_profile']['error'];
		$dir = get_template_directory().'-child/admin/profile_image/';
		$move = move_uploaded_file($_FILES['image_profile']['tmp_name'],$dir.$_FILES['image_profile']['name']);

	if($img_error==0)
	{
		$wpdb->update($table_name,array('user_image' => $img_name),array('id' => $user_id));
		echo '<script>window.location.href="'.home_url().'/dashboard??option=settings"</script>';
	}
}

?>
<style>
.sidebar {
    background: #333;
    color: #fff;
    min-height: 1235px;
}
.card-form:after {
    content: "";
    display: table;
    clear: both;
}
#hmac .form-group:after {
    clear: both;
    content: "";
    display: table;
}
.profile-box:after {
    content: "";
    display: table;
    clear: both;
    margin-bottom: 25px;
}

</style>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
						<div class="setting-tabs">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile Setting</a></li>
							  </ul>
						</div>
						<div class="setting-divs">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
											<div class="profile-main">
													<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="headingOne">
																<h4 class="panel-title">
																	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																		<i class="more-less glyphicon glyphicon-minus"></i>
																		Accounting Information
																	</a>
																</h4>
															</div>
															<form action="<?php echo home_url();?>/dashboard/?option=settings&action=profile_update" method="post">
															<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
																<div class="panel-body">
																  <div class="form-horizontal profile-form">
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">First Name:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="fname" value="<?php echo $user_detail['fname'];?>"  />
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Last Name:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="lname" value="<?php echo $user_detail['lname'];?>"  />
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Email:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="email" name= "email" class="form-control" value="<?php echo $user_detail['email'];?>" />																		  
																		</div>																		
																	  </div>
																		<div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Username:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" value="<?php echo $user_detail['username'];?>" readonly disabled  />
																		  <small style="font-size:12px">Note: Keyword cannot be changed</small>
																		</div>																	
																	  </div>																		
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Mobile:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="tel" class="form-control" name="pro_mobile" value="<?php echo $user_detail['mobile'];?>"  />
																		</div>
																	  </div>
																			<div class="form-group">
																			<div class="col-sm-12 text-right">
																				<button type="submit" name="profile" class="btn btn-primary previewBtn">Save</button>
																			</div>
																			</form>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="panel panel-default">
															<div class="panel-heading" role="tab" id="headingTwo">
																<h4 class="panel-title">
																	<a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																		<i class="more-less glyphicon glyphicon-plus"></i>
																		Billing Information
																	</a>
																</h4>
															</div>
															<form action="<?php echo home_url();?>/dashboard/?option=settings&action=billing_info" method="post">
															<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
																<div class="panel-body">
																	<div class="form-horizontal profile-form">
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Address:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <textarea class="form-control" name="address"><?php echo $user_detail['address'];?></textarea>
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Country:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																			
																		  <select class="form-control" name="country"  >
																				<?php
																						foreach($countries as $code => $value){ ?>
																							<option value="<?php echo $code;?>" <?php if($user_detail['country'] == $code){ echo "selected";} ?> ><?php echo $value; ?></option>
																				<?php }
																				?>		
																		  </select>
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">City:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="city" value="<?php echo $user_detail['city'];?>"  />
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">State:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="tel" class="form-control" name="state" value="<?php echo $user_detail['state'];?>" />
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Zip:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="tel" class="form-control" name="zip" value="<?php echo $user_detail['zipcode'];?>" />
																		</div>
																	  </div>
																		<div class="form-group">
																		<div class="col-sm-12 text-right">
																			<button type="submit" name="billing_field" class="btn btn-primary previewBtn"> <i class="fa fa-floppy-o"></i> Save</button>
																		</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												</form>
											</div>
											<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
												<div class="profile-box">
													<h3>Photo Upload</h3>
													<form method="post"  class="form-horizontal profile-form" enctype="multipart/form-data">
													<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12 padding-right-zero" style="padding-left:0px;">
													<div class="user-pic" >
															<img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'.$user_detail['user_image'];?> " alt="Man" id ="input_image"/>
																<img id ="output_image"  class= "img-thumbnail hidden-man"/>
															</div>
														</div>
														<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">
															<div class="user-information">
															
																<ul class="list-inline" style="margin-top: 45px !important;">
																	<li><label class="btn btn-primary update-man" for="user_pic">Upload</label></li>
																	<li><button type="submit" name="submit_profile" href="#" class="btn btn-danger">Submit</button></li>
																</ul>
																<input type="file" id="user_pic" accept="image/*" onchange="preview_image(event)" name="image_profile" style="opacity:0;height: 13px;">
															</div>
														</div>													 
													</form>
												</div>
												<div class="profile-box">
													<h3>Change Password</h3>
													<form method="post" action="<?php echo home_url();?>/dashboard/?option=settings&action=change_password" class="form-horizontal profile-form">
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Old password:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="password" name="old_pass" class="form-control"  />
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">New password:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <input type="password" name="new_pass" id="new_pass" class="form-control"/>
														</div>
													  </div>
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Confirm password:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
															<input type="password" name="confirm_pass" id="conf_pass" class="form-control"  />
															<input type="hidden" name="change_id" value="<?php echo $user_detail['id']; ?>">
														</div>
														</div>
														<div class="form-group" style="text-align:center">
														<span class="label label-danger" style="display:none;" id="conf_password">New Password and Confirm Password does not match</span>
														<?php if(isset($_GET['umsg'])){ ?>
														<span class="label label-success"  id="update_password">Password Updated Successfully</span>														
														<?php }if(isset($_GET['msg'])){ ?>
															<span class="label label-warning"  id="old_pass">Old password is incorect</span>
														<?php } ?>
														</div>
													  <div class="form-group">
														<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
																
														    <input type="submit" name="update_password" class="btn btn-primary btn-red btn-block btn-save" value="Update">
																
														</div>
													  </div>
													</form>
												</div>
											</div>
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<form action="<?php echo home_url();?>/dashboard/?option=settings&action=payment" method="post" id="hmac">
												<div class="profile-box credit-card-box">
													<h3>Payment Settings (Can only select 3 max)</h3>
													<div class="row">
														<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
															<div class="credit-card-box-data">
														<h4>
															<label for="credit-card">
																<input type="checkbox" id="credit-card" name="credit_card" value="1" <?php if($user_detail['credit_card'] == 1 ) { echo "checked"; }?>/> Credit Card
															</label>
														</h4>

														<!-- Credit Card -->
														<div <?php if($user_detail['credit_card'] == 0 ) { ?> class="creditcard" style="display:none;" <?php } ?> >
														<div class="card-tabs">
															<ul class="nav nav-tabs" role="tablist">
																<li role="presentation" class="active"><a href="#authorise" aria-controls="home" role="tab" data-toggle="tab">Authorize.Net</a></li>
																<li role="presentation"><a href="#payeezy" aria-controls="profile" role="tab" data-toggle="tab">Payeezy</a></li>
															  </ul>
														</div>
														<div class="card-form">
															<div class="tab-content">
																<div role="tabpanel" class="tab-pane fade in active" id="authorise">
																	<!-- <form class="form-horizontal profile-form"> -->
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">ARB Login Id:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="arb_login_key" value="<?php echo $user_detail['arb_login_key'];?>">
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">ARB Transaction Key:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="arb_transaction_key" value="<?php echo $user_detail['arb_transaction_key'];?>">
																		</div>
																	  </div>
																	<!-- </form> -->
																</div>
																<div role="tabpanel" class="tab-pane fade" id="payeezy">
																	<div class="form-horizontal profile-form">
																	  <div class="form-group">
																		<label class="col-sm-6 col-md-6 col-lg-6 col-xs-12 control-label">Api Key:</label>
																		<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																		  <input type="text" class="form-control"  name="hmac_key" value="<?php echo $user_detail['hmac_key'];?>">
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-6 col-md-6 col-lg-6 col-xs-12 control-label">Api Secret</label>
																		<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																		  <input type="text" class="form-control" name="payeezy_key_id" value="<?php echo $user_detail['payeezy_key_id'];?>">
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-6 col-md-6 col-lg-6 col-xs-12 control-label">Token</label>
																		<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																		  <input type="text" class="form-control" name="payeezy_gateway_id" value="<?php echo $user_detail['payeezy_gateway_id'];?>">
																		</div>
																	  </div>
																	  <div class="form-group">
																		<!-- <label class="col-sm-6 col-md-6 col-lg-6 col-xs-12 control-label">Payeezy Gateway Password</label> -->
																		<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
																		  <input type="hidden" class="form-control" name="Payeezy_gateway_password" value="<?php echo $user_detail['Payeezy_gateway_password'];?>">
																		</div>
																	  </div>
																		</div>
																</div>
															</div>
														</div>
													</div>					
														<!-- End Credit Card -->
													</div>
														</div>
														<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
															<div class="profile-box credit-card-box" style="margin-top: 0px;">
													<div class="credit-card-box-data">
														<h4>
															<label for="credit-card">
																<input type="checkbox" id="paypal_check" name="paypal_check" value="1"  <?php if($user_detail['paypal_check'] == 1 ) { echo "checked"; }?>/> Paypal
															</label>
														</h4>
														<!-- Paypal Form -->
														<div <?php if($user_detail['paypal_check'] == 0 ) { ?> class="paypalform" style="display:none;" <?php } ?> >
														<div class="card-form paypal-form">
															<div class="tab-content">
																<div role="tabpanel" class="tab-pane fade in active" id="authorise">
																	<div class="form-horizontal profile-form">
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Email:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="paypal_email_id"  value="<?php echo $user_detail['paypal_email_id'];?>">
																		</div>
																	  </div>
																	  
																		</div>
																</div>
																
															</div>
														</div>
													</div>					
														<!-- End paypal -->
													</div>
												</div>
														</div>
														<div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
															<div class="row">
																<div class="form-group">
																	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
																		<button type="submit" name="payment_field" class="btn btn-primary btn-red btn-block btn-save"><i class="fa fa-floppy-o"></i> Save</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
													
												</div>
												
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
<?php

include( get_template_directory() . '-child/admin/footer.php' );

if($_GET['message_action'] == 'check'){

			$post = array(
				'c_uid' => $user_detail['slybroadcast_username'],
				'c_password' => $user_detail['slybroadcast_password'],
				'remain_message' => '1',
				
				
			);

			$ch = curl_init(); // Intilise Curl

			$url = 'https://www.mobile-sphere.com/gateway/vmb.php'; // Url

			curl_setopt($ch,CURLOPT_URL,$url);      // Set Option for Curl

			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Date for Sending

			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			curl_setopt($ch,CURLOPT_HEADER, false); 

			$response = curl_exec($ch);
		  $msg  = explode(" ",$response);
			$remain_check = explode("=",$msg[1]);
			$pending_check = explode("=",$msg[2]);

		
			if(isset($remain_check[1])){
			
				?>
				<button  id="md" style="display:none;" data-toggle="modal" data-target="#message_check">Open Modal</button>
				<div id="message_check" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close" onclick="refresh();">&times;</button>
									<h4 class="modal-title">Message Balance</h4>
								</div>
								<div class="modal-body">
													<h5 ><span style="color:#e42212">Remaining Messages</span> = <span> <?php echo $remain_check[1];?> </span></h5>
													<h5 ><span style="color:#e42212">Pending Messages</span> = <span> <?php echo $pending_check[1];?> </span></h5>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="refresh();" >Close</button>
								</div>
							</div>

						</div>
					</div>

				<?php
					echo '<script>
					$("#md").trigger("click");
					
					function refresh(){
						window.location.href ="'.home_url().'/dashboard/?option=settings";
					}
					</script>';
					
			}
				else{
			
				?>
				<button  id="md" style="display:none;" data-toggle="modal" data-target="#message_check">Open Modal</button>
				<div id="message_check" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close" onclick="refresh();">&times;</button>
									<h4 class="modal-title">Message Balance</h4>
								</div>
								<div class="modal-body">
													<h5 style="color:#e42212; text-align:center;"> Invalid Login Credential</h5>
													
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="refresh();" >Close</button>
								</div>
							</div>

						</div>
					</div>

				<?php
					echo '<script>
					$("#md").trigger("click");
				
					function refresh(){
						window.location.href ="'.home_url().'/dashboard/?option=settings";
					}
					</script>';
					echo '<script>window.location.href="'.home_url().'/dashboard/?option=settings";</script>';
			}


}

?>
<script>
	function preview_image(event) 
	{
	//alert('Hello');
	 var reader = new FileReader();//FileReader is used to read the contents of a Blob or File.
	 reader.onload = function()// it will fire after load the file.
	 {
	  var output = document.getElementById('output_image');// display output
	  output.src = reader.result;
	 }
	 reader.readAsDataURL(event.target.files[0]);//The readAsDataURL method is used to read the contents of the specified Blob or File.
												 // When the read operation is finished, the readyState becomes DONE, 
				 //and the loadend is triggered. At that time,
		 $("#input_image").hide();	
		 $("#output_image").removeClass('hidden-man');
	}
</script>