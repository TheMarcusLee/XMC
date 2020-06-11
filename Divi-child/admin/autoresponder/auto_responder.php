<?php
global $wpdb;
$user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
if(isset($_GET['action'])){
	if($_GET['action'] == 'msg_list'){
		include( get_template_directory() . '-child/admin/autoresponder/msg_list.php' );
		exit;
	}
	if($_GET['action'] == 'create_msg'){
		include( get_template_directory() . '-child/admin/autoresponder/create_msg.php' );
		exit;
	}	
	if($_GET['action'] == 'email_broadcast'){
		include( get_template_directory() . '-child/admin/autoresponder/create_msg.php' );
		exit;
	}	
	
}else{
	include( get_template_directory() . '-child/admin/header.php' );
	$user_id = $_SESSION['user_id'];
	$table = $wpdb->prefix.'auto_responder';
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/new-responsive.css" />
<style>
.video-uploader:after {
	content: "";
	display: table;
	clear: both;
}
.responder-content {
    margin-top: 10px;
    border-radius: 5px;
    overflow: hidden;
}
.subscribers-button b {
    font-size: 12px;
}
.subscribers-button {
    margin-top: 45px;
}
.subscribers-button b {
    font-size: 12px;
    margin-bottom: 5px;
    display: inline-block;
}
.subscribers-button a {
    background: #e4041c;
    color: #fff;
    padding: 7px 10px;
    display: inline-block;
    min-width: 154px;
    text-align: center;
    font-size: 13px;
    margin-bottom: 7px;
}
.subscribers-button a:hover {
    background: #333333;
}
</style>
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
							<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box">
													<h3>Auto Responder-Email Broadcaster</h3>
												</div>
											</div>
										</div>
										<div class="row">
										<?php 
											  $keyword = $_SESSION['keyword'];
											  $cur_date = date('Y-m-d');
											  
											  $count  = $wpdb->get_results("SELECT COUNT(*) as total FROM $table WHERE registered_userid = $user_id",ARRAY_A);
											  $sub_count  = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_leads WHERE keyword = '$keyword' AND status = 0",ARRAY_A);
											  $unsub_count  = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_leads WHERE keyword = '$keyword' AND status = 1",ARRAY_A);
											  $bounces  = $wpdb->get_results("SELECT COUNT(*) as total FROM $table WHERE registered_userid = $user_id AND status = 2",ARRAY_A);
											  $clicks  = $wpdb->get_results("SELECT SUM(no_clicks) as click FROM $table WHERE registered_userid = $user_id",ARRAY_A);
											  $today_sub  = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_leads WHERE keyword = '$keyword' AND join_date = '$cur_date' AND status = 0",ARRAY_A);
											  $today_unsub  = $wpdb->get_results("SELECT COUNT(*) as total FROM wp_leads WHERE keyword = '$keyword' AND unsub_date = '$cur_date' AND status = 1",ARRAY_A);
										 ?>
											<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
												<div class="responder-content">
													<table class="table table-striped table-bordered">	
														<tr>
															<td><b>Total Subscibers</b> : </td>
															<td style="text-align: center;"><?php echo $sub_count[0]['total'];?></td>
														</tr>
														<tr>
															<td><b>Total UnSubscibers</b> : </td>
															<td style="text-align: center;"><?php echo $unsub_count[0]['total']; ?></td>
														</tr> 
														<tr>
															<td><b>Total Messages</b> : </td>
															<td style="text-align: center;"><?php echo $count[0]['total']; ?></td>
														</tr>
														<tr>
															<td><b>Total Clicks</b> : </td>
															<td style="text-align: center;"><?php if($clicks[0]['click'] == '') { echo '0'; }else{ echo $clicks[0]['click'];}?></td>
														</tr>
														<tr>
															<td><b>Today Subscibers</b> : </td>
															<td style="text-align: center;"><?php echo $today_sub[0]['total'];?></td>
														</tr>
														<!-- <tr>
															<td><b>Total Opens</b> : </td>
															<td style="text-align: center;">159402</td>
														</tr> -->
													</table>
												</div>
											</div>
											<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">
												<div class="subscribers-button">
													<ul class="list-inline">
														<li><a href="<?php echo home_url();?>/dashboard?page=auto_responder&action=msg_list">Follow Up Emails: <?php echo $count[0]['total']; ?></a></li>
														<li><a href="#">No. Of Url Clicks: <?php if($clicks[0]['click'] == '') { echo '0'; }else{ echo $clicks[0]['click'];}?></a></li>
														<li><a href="<?php echo home_url();?>/dashboard?page=auto_responder&action=email_broadcast">Send Email Broadcast</a></li>
													</ul>
													<b>Todays activity:</b>
													<ul class="list-inline">
														<li><a href="#">Todays Subscibers: <?php echo $today_sub[0]['total'];?></a></li>
														<li><a href="#">Todays UnSubscibers: <?php echo $today_unsub[0]['total']; ?></a></li>
														<li><a href="#">No. Of Bounces: <?php echo $bounces[0]['total'];?></a></li>
													</ul>
												</div>
											</div>
										</div>
										<!-- <div class="row">
											<div class="col-md-7 ">
												<div class="profile-box">
												   <div class="media-uploader">
													   <h4><i class="fa fa-envelope"></i> Send Mail</h4>
													   <div class="video-uploader">
															<form>
															  <div class="form-group">
																<label for="inputEmail3" class="col-md-2 col-sm-3 col-lg-2 col-xs-12  control-label" style="padding-top: 6px;">Email</label>
																<div class="col-md-7 col-sm-6 col-lg-7 col-xs-8">
																  <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
																</div>
																<div class="col-md-2 col-sm-3 col-md-2 col-xs-4">
																	<button type="submit" class="btn btn-primary previewBtn btncapaign"><i class="fa fa-envelope"></i> Send</button>
																</div>
															  </div>
															</form>
													   </div>
												   </div>
												</div>
											</div>
										</div> -->
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
}
?>