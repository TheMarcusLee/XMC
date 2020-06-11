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
								<?php if($user_detail['tier2_status'] == 1) { ?>
								<li role="presentation"><a href="#sly-broadcast" aria-controls="sly-broadcast" role="tab" data-toggle="tab">Sly-Broadcast</a></li>
								<li role="presentation"><a href="#twilio" aria-controls="twilio" role="tab" data-toggle="tab">Twilio</a></li>
								<?php } ?>
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
												<div class="profile-box">
													
													<div class="form-horizontal profile-form">
													<form action="<?php echo home_url();?>/dashboard/?option=settings&action=business_field" method="post">
													  <div class="form-group">
														<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Activate Primary Business:</label>
														<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
														  <div class="checkbox" style = "display:inline;margin-left:10px;">
															<label style="">
																<input type="checkbox" id="apb" name="activate_primary" value="1" <?php if($user_detail['activate_primary']==1 ){ echo "checked";} ?>/> 
															
															</label>
															<?php if($user_detail['activate_primary']==1 ) {?>
															<span style = "margin-left:125px;">
															<a href ="<?php echo home_url();?>/dashboard/?option=my_business" target = "_blank" class= "btn btn-danger btn-sm" ><i class= "fa fa-eye"></i> Preview </a>
															</span>
															<?php } ?>
														  </div>
															
														</div>

													  </div>														
														<!-- Activate Primary Business  Fields-->
														<div <?php if($user_detail['activate_primary'] == 0 || $user_detail['activate_primary'] == null ){ ?> class="apbf" style="display:none;" <?php } ?> >
																	<div class="form-group">
																	<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Custom Video:</label>
																	<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		<textarea class="form-control" name="custom_video" ><?php echo $user_detail['custom_video'];?></textarea>
																	</div>
																	</div>
																	<div class="form-group">
																	<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Custom Video Title:</label>
																	<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		<input type="text" class="form-control" name="custom_video_text" value="<?php echo $user_detail['custom_video_text'];?>"/>
																	</div>
																	</div>
																	<div class="form-group">
																	<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">My Custom Link:</label>
																	<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		<input type="text" class="form-control" name="my_custom_link" value="<?php echo $user_detail['my_custom_link'];?>"  />
																	</div>
																	</div>
																	<div class="form-group">
																	<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">My Button Text:</label>
																	<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		<input type="text" class="form-control" name="my_button_text" value="<?php echo $user_detail['my_button_text'];?>"  />
																	</div>
																	</div>
																	
																	<div class="form-group">
																	<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Custom Description:</label>
																	<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		<textarea name="custom_description" id="custom_description"  class="form-control" cols="10" rows="5"><?php echo $user_detail['custom_description'];?></textarea>
																		<!-- <input type="text" class="form-control" name="custom_description" value="<?php echo $user_detail['custom_description'];?>"/> -->

																	</div>
																	</div>
																	<div class="form-group">
																	<div class="col-sm-12 text-right">
																		<button type="submit" name="business_field" class="btn btn-primary previewBtn"> <i class="fa fa-floppy-o"></i> Save</button>
																	</div>
																	</div>
														</div>
														</form>
													  <!-- END Activity Primary Business -->
														<form action="<?php echo home_url();?>/dashboard/?option=settings&action=auto_responder" method="post">													
														<!-- Activity 3rd Page Responder -->
														<div <?php if($user_detail['activate_autoresponder'] !=1 ){ ?> class="a3pr" style="display:none;" <?php } ?> >
														<!-- Auto Responder Integration -->

																<div id="get_response" <?php if($user_detail['get_response_api_key'] == null) { ?>  class="auto_respo" style="display:none;" <?php } ?>>

																		<div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Get Response API Key:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																			<input type="text" class="form-control"  name="get_response_api_key" value="<?php echo $user_detail['get_response_api_key'];?>" />
																		</div>
																		</div>
																		<div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Compaign name:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																				<select class="form-control" id="camp_name">
																					<option value="0">Select your compaign name</option>
																				</select>
																		</div>
																		</div>

																</div>

																<!-- end aweber -->
															<div id="now_lifestyle" <?php if($user_detail['life_campaign_name'] == null) { ?>  class="auto_respo" style="display:none;" <?php } ?> >

																		<div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Campaign:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																			<input type="text" class="form-control" name = "life_campaign_name"  value="<?php echo $user_detail['life_campaign_name'];?>" />
																		</div>
																		</div>
																		<div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Affiliate Name:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																			<input type="text" class="form-control" name="affliate_name"  value="<?php echo $user_detail['affliate_name'];?>" />
																		</div>
																		</div>

																	</div>

																	<div id="traffic_wave" <?php if($user_detail['user_name'] == null) { ?>  class="auto_respo" style="display:none;" <?php } ?> >

																			<div class="form-group">
																			<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Username:</label>
																			<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																				<input type="text" class="form-control" name="user_name"  value="<?php echo $user_detail['user_name'];?>" />
																			</div>
																			</div>
																			<div class="form-group">
																			<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Compaign name:</label>
																			<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																				<input type="text" class="form-control" name="traffic_campaign_name"  value="<?php echo $user_detail['traffic_campaign_name'];?>"/>
																			</div>
																			</div>

																	</div>

																

														<!--End Auto Responder Integration-->
														</div>

													</div>
													<!-- </form> -->
												</div>
											</div>
											</form>
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
												<form action="<?php echo home_url();?>/dashboard/?option=settings&action=payment" method="post" id="hmac">
												<div class="profile-box credit-card-box">
													<h3>Payment Settings (Can only select 3 max)</h3>
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
																<li role="presentation" class="active count" data-url="authorise"><a href="#authorise" aria-controls="home" role="tab" data-toggle="tab">Authorize.Net</a></li>
																<li role="presentation" class="count" data-url="payeezy"><a href="#payeezy" aria-controls="profile" role="tab" data-toggle="tab">Payeezy</a></li>
																<li role="presentation" class="count" data-url="stripe"><a href="#stripe" aria-controls="profile" role="tab" data-toggle="tab">Stripe</a></li>
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
																<!-- stripe -->
																<div role="tabpanel" class="tab-pane fade" id="stripe">
																	<!-- <form class="form-horizontal profile-form"> -->
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Stripe Publish Key:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="stripe_primary" value="<?php echo $user_detail['stripe_primary'];?>">
																		</div>
																	  </div>
																	  <div class="form-group">
																		<label class="col-sm-5 col-md-5 col-lg-5 col-xs-12 control-label">Stripe Secret Key:</label>
																		<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
																		  <input type="text" class="form-control" name="stripe_secret" value="<?php echo $user_detail['stripe_secret'];?>">
																		</div>
																	  </div>
																	<!-- </form> -->
																</div>
																<!-- end stripe -->
															</div>
														</div>
													</div>					
														<!-- End Credit Card -->
													</div>
												</div>
												


												<div class="profile-box credit-card-box paypal-form2">
													<div class="credit-card-box-data">
														<h4>
															<label for="credit-card">
																<input type="checkbox" class="count" id="paypal_check" name="paypal_check" value="1"  <?php if($user_detail['paypal_check'] == 1 ) { echo "checked"; }?>/> Paypal
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
												<div class="row">
												    <div class="form-group">
														<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
															<button type="submit" name="payment_field" class="btn btn-primary btn-red btn-block btn-save"><i class="fa fa-floppy-o"></i> Save</button>
														</div>
													</div>
												</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="sly-broadcast">
									<div class="sly-broadcast profile-div">
										<div class="custom-dropdown">
											<div class="dropdown-buttons">
												
											<span style="border-bottom: 1px solid #ca1302;
															padding-bottom: 6px;
															font-size: 15px;
													">SlybroadCast Account</span>
												<?php 
												if($user_detail['slybroadcast_username'] != '' && $user_detail['slybroadcast_password'] != '' ) {
													?>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&message_action=check" class="pull-right btn btn-success btnRegister">Check Message Balance</a>
												<?php
												}
												?>
											</div>
										</div>
										<form method='post' action="" class="form-horizontal profile-form slybroadcast-form">
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label">Email:</label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="email" name="sly_username" class="form-control" value="<?php echo $user_detail['slybroadcast_username'];?>">
											</div>
										  </div>
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label">Password</label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="password" name="sly_password" class="form-control" value="<?php echo $user_detail['slybroadcast_password'];?>">
											</div>
										  </div>
										  
										  <div class="form-group">
											<label class="col-sm-3 col-md-3 col-lg-3 col-xs-12 col-md-offset-1 control-label"></label>
											<div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
											  <input type="submit" class="btn btn-primary btn-red" name="sly_sbumit" value="Save">
											
											</div>
										  </div>
											<div class="form-group">
													<label class="col-sm-1 col-md-1 col-lg-1 col-xs-12 col-md-offset-1 control-label"></label>
													<div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">
														<p>don't have an account? <a href="https://www.slybroadcast.com/index.php" target="_blank">Create account</a></p>
													</div>
										  </div>
										</form>
										<?php 
										if(isset($_POST['sly_sbumit'])){

											
											$username = $_POST['sly_username'];
											$password = $_POST['sly_password'];

											
											
											$data2 = array(
															'slybroadcast_username' => $username,
															'slybroadcast_password' => $password,
																														
														);
											$where = array(
															 'id'	=> $user_detail['id'],
														);
												
											$up_res = $wpdb->update( $table_name, $data2, $where );
										if($up_res == true){
											echo '<script>window.location.href="'.home_url().'/dashboard/?option=settings";</script>';
										
										}

											}
										
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="twilio">
										<div class="sly-broadcast profile-div">
													<?php
													$twilio_table_name = $wpdb->prefix.'twilio_detail';
													$user_id = $_SESSION['user_id'];
													$get_data = $wpdb->get_row("SELECT * FROM $twilio_table_name WHERE 	registereduser_id = $user_id",ARRAY_A);
												
													?>
													<form action="" method="post">


												<!-- Twilio Api Section -->
												<div class="tab-content">
														<div class="tab-pane active" id="twilio">
																<div class="form-group">
																		<label for="title">Twilio SID</label>
																		<input type="text" name="twilio_sid" required class="form-control" value="<?php echo $get_data['twilio_sid'];?>" name="twilio_sid" placeholder="Twilio SID">
																</div>
																<div class="form-group">
																		<label for="keyword">Twilio Token</span> </label>
																		<input type="text" name="twilio_token" value="<?php echo $get_data['twilio_token'];?>" class="form-control" placeholder="Twilio Token">
																</div>
														</div>
												
												<!-- END Twilio API Section -->

														<div class="form-group">
																<button type="submit" class="btn btn-danger"> <i class="fa fa-save"></i> Save</button></br>
																<p style="margin-top: 21px;">Don't have an account? <a href="https://www.twilio.com/try-twilio" target="_blank">Create account</a></p>															
														</div>
												</form>
												<?php
												if(isset($_POST['twilio_sid'])){
													
													$sid = $_POST['twilio_sid'];
													$token = $_POST['twilio_token'];
													$id = $_SESSION['user_id'];

													

													$data = array(
																	'registereduser_id'	=> $id,
																	'twilio_sid' 	=> $sid,
																	'twilio_token' => $token,
																	
																);

												
													
													if($get_data != NULL){
														$where = array(
															'registereduser_id' => $id,
														);
																$wpdb->update( $twilio_table_name, $data, $where);
																echo '<script>window.location.href="'.home_url().'/dashboard/?option=settings";</script>';
													}

													else{
																$wpdb->insert($twilio_table_name,$data);
																echo '<script>window.location.href="'.home_url().'/dashboard/?option=settings";</script>';
													}

												}
												
												?>
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
	var count = 0;

// jQuery('.count').click(function () {
// 	count += 1;	
// 	if (count == 4) {
// 		// come code
// 		jQuery(this).text()
// 		var val = jQuery(this).text();
// 		if(val == ""){
// 			jQuery('.paypal-form').hide();
// 			jQuery('.paypal-form2').hide();
			
// 			alert("You can select only 3 max");
// 		}else{
// 			var id = jQuery(this).attr('data-url');			
// 			jQuery("#"+id).hide();
// 			jQuery(this).hide();
// 			alert("You can select only 3 max");
			
// 		}
// 	}
// });
</script>