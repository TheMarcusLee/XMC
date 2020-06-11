<?php
/*
Template Name: Dashboard
*/
session_start();
	  global $wpdb;
$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'register_user';
$get_img = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id"); 

if($_SESSION['user_id'] == NULL){
	echo '<script>window.location.href="'.home_url().'/user-login"</script>';
}


if(isset($_GET['page']) || isset($_GET['option'])){
	
	if($_GET['option'] == 'settings'){

		include( get_template_directory() . '-child/admin/setting/main_setting.php' );

	}
if($_GET['option'] == 'leads'){

		include( get_template_directory() . '-child/admin/leads.php' );

	}

if($_GET['option'] == 'referrals'){

		include( get_template_directory() . '-child/admin/referrals.php' );

	}
	if($_GET['option'] == 'tutorials'){

		include( get_template_directory() . '-child/admin/video_tutorials/video_tutorials.php' );

	}
	if($_GET['page'] == 'auto_responder'){

		include( get_template_directory() . '-child/admin/autoresponder/auto_responder.php' );

	}
	if($_GET['option'] == 'media_library'){

		include( get_template_directory() . '-child/admin/media-library/media_library.php' );

	}
	if($_GET['option'] == 'subscription'){

		include( get_template_directory() . '-child/admin/subscription/subscriber_group.php' );

	}
	if($_GET['option'] == 'inviter_business'){

		include( get_template_directory() . '-child/admin/business/inviter_business.php' );

	}
	
	 
	if($_GET['page'] == 'ringless_voice_mail'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/ringless_voice_mail.php' );

	}
	if($_GET['page'] == 'sms_voice_broadcast'){

		include( get_template_directory() . '-child/admin/sms_voice_broadcast/sms_voice_broadcast.php' );

	}
	if($_GET['page'] == 'view_phone_list'){

		include( get_template_directory() . '-child/admin/ringless-voicemail/view_phone_list.php' );

	}
	if($_GET['page'] == 'capture_and_sales'){

		include( get_template_directory() . '-child/admin/capture_and_sales/capture_and_sales.php' );

	}
	if($_GET['page'] == 'capture_page_builder'){

		include( get_template_directory() . '-child/admin/capture_page_builder/capture_page_builder.php' );

	}
	if($_GET['page'] == 'reseller-licence'){

		include( get_template_directory() . '-child/admin/reseller-licence/reseller-licence.php' );

	}
	if($_GET['page'] == 'software'){

		include( get_template_directory() . '-child/admin/software/software.php' );

	}
	if($_GET['page'] == 'subscription'){

		include( get_template_directory() . '-child/admin/subscription/subscription.php' );
	}
	if($_GET['page'] == 'marketting-banner'){

		include( get_template_directory() . '-child/admin/marketting-banner/marketting-banner.php' );
	}
}
else{

	include( get_template_directory() . '-child/admin/header.php' );
?>  
<style>
		.sidebar {
			background: #333;
			color: #fff;
			min-height: 600px;
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
					<div class="dashboard-main">
						<div class="custom-dropdown">
							<div class="dropdown-button">
								ACCOUNT OVERVIEW
								
							</div>
							
						</div>
						<div class="row">
							
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
										  <h3>48</h3>

										  <p>LEADS</p>
										</div>
										<div class="icon">
										  <i class="fa fa-users"></i>
										</div>
										<a href="<?php echo home_url();?>/dashboard/?option=leads" class="small-box-footer lead-btn">More info</a> <i class="fa fa-arrow-right"></i>
										
									  </div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
										  <h3>34</h3>

										  <p>REFERRALS</p>
										</div>
										<div class="icon">
										  <i class="fa fa-users"></i>
										</div>
										<a href="<?php echo home_url();?>/dashboard/?option=referrals" class="small-box-footer referral-btn">More info </a>
										
									  </div>
								</div>
							</div>
						</div>
						<div class="">
							
						<div class="dashboard-short">
							<div class="row">
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-envelope"></i>
											</div>
											<div class="dashboard-content">
												<h4>SMS and Voice Broadcast</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-phone-square"></i>
											</div>
											<div class="dashboard-content">
												<h4>Ringless Voicemail</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=capture_and_sales">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-line-chart"></i>
											</div>
											<div class="dashboard-content">
												<h4>Capture and Sales</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=auto_responder">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-share"></i>
											</div>
											<div class="dashboard-content">
												<h4>Auto Responder</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=capture_page_builder">
									<div class="dashboard-inner">
										<div class="icon-shadow">
											<i class="fa fa-camera"></i>
										</div>
										<div class="dashboard-content">
											<h4>Capture Page Builder</h4>
										</div>
									</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=reseller-licence">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-handshake-o"></i>
											</div>
											<div class="dashboard-content">
												<h4>Reseller Licence</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=software">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-wrench"></i>
											</div>
											<div class="dashboard-content">
												<h4>Software</h4>
											</div>
										</div>
									</a>
								</div>
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=subscription">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-rss"></i>
											</div>
											<div class="dashboard-content">
												<h4>Subscription</h4>
											</div>
										</div>
									</a>
								</div>
								<!-- <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
									<a href="#">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-cog"></i>
											</div>
											<div class="dashboard-content">
												<h4>Setting</h4>
											</div>
										</div>
									</a>
								</div> -->
								<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
									<a href="<?php echo home_url();?>/dashboard/?page=marketting-banner">
										<div class="dashboard-inner">
											<div class="icon-shadow">
												<i class="fa fa-play"></i>
											</div>
											<div class="dashboard-content">
												<h4>Marketting Banners</h4>
											</div>
										</div>
									</a>
								</div>
							</div>
							
								<?php
				
				$refrer_table = $wpdb->prefix.'register_user';
				$refrer_name = $wpdb->get_row("SELECT refrencename FROM $refrer_table WHERE id=".$_SESSION['user_id']);
	
				$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
				 
					//print_r("SELECT * FROM $refrer_table WHERE username=".$refrer_name->refrencename);exit;		
							?>
								
							<form action="" method="post" enctype="multipart/form-data">
							<div class="user-info">
								<div class="row">
									<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
										<div class="user-pic">
											<img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'.$get_img->user_image;?> " alt="Man" id ="input_image"/>
											<img id ="output_image"  class= "img-thumbnail hidden-man"/>
										</div>
										<ul class="list-inline" style="width:180px;">
											<li><label class="btn btn-primary update-man" name="uplode_image_profile" for="user_pic">Upload</label></li>

											<li><button type="submit" name="submit_profile" href="#" class="btn btn-danger">Submit</button></li>
											</ul>
									</div>
									 
									<div class="col-md-8 col-sm-8 col-lg-8 col-xs-12">
										<div class="user-information">
									<p><b>Refrerral Informations</b></p>
									<p><b>Name</b>: <?php echo ucwords($refrer_name->refrencename);?></p>
									<p><b>Phone</b>: <?php echo $refrer_detail->mobile;?></p>
									<p><b>Email</b>: <?php echo $refrer_detail->email;?></p>
									<p><b>Keyword</b>: <?php echo $refrer_detail->username;?></p>
											<input type="file" id="user_pic" name="image_profile" accept="image/*" onchange="preview_image(event)" style="opacity:0;">
											
											
										</div>
									</div>
								</div>
							</div>
							</form>
										
								
							
							<?php 
								  if(isset($_POST['submit_profile']))
								  {
								
							      $img_name=$_FILES['image_profile']['name'];
									$img_tmp=$_FILES['image_profile']['tmp_name'];
									$img_error=$_FILES['image_profile']['error'];
									  $dir = get_template_directory().'-child/admin/profile_image/';
$move = move_uploaded_file($_FILES['image_profile']['tmp_name'],$dir.$_FILES['image_profile']['name']);
									
									if($img_error==0)
									{
										$wpdb->update($table,array('user_image' => $img_name),array('id' => $user_id));
									}
								  }
							?>
						</div>
							
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php

	include( get_template_directory() . '-child/admin/footer.php' );
	

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