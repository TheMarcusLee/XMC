<?php
require_once get_template_directory().'-child/admin/sms_voice_broadcast/vendor/autoload.php'; // Loads the library
use Twilio\Rest\Client;
if(isset($_GET['no']))
{    
    $page =  (int)$_GET['no']; 
} 
global $wpdb;
if(isset($_GET['page'])){
	if($_GET['page'] == 'add_subscriber'){
		include( get_template_directory() . '-child/admin/subscription/add_subscriber.php' );
		exit;
	}
	if($_GET['page'] == 'edit_subscriber'){
		include( get_template_directory() . '-child/admin/subscription/edit_subscriber.php' );
		exit;
	}		
}
if(isset($_GET['id'])){
    $id = $_GET['id'];		
		
}

if(isset($_GET['subscriber_action'])){
	if($_GET['subscriber_action'] == 'exportcsv'){
		include( get_template_directory() . '-child/admin/subscription/export_csv.php' );
		exit;
	}
}

	else{
include( get_template_directory() . '-child/admin/header.php' );


global $wpdb;
global $wp;

$user_id = $_SESSION['user_id'];
$table_name = $wpdb->prefix.'svb_subscriber';

$table = $wpdb->prefix.'twilio_detail';
$get_twilio = $wpdb->get_row("SELECT * FROM $table WHERE registereduser_id = $user_id");	
$sid = $get_twilio->twilio_sid; // Your Account SID from www.twilio.com/console
$token = $get_twilio->twilio_token; // Your Auth Token from www.twilio.com/console
//pagination
if(isset($_GET['no']))
{    
    $page =  $_GET['no']; 
}else{
	$page = 1;
}
$num_per_page = 10;
if(isset($_POST['drop_campaign'])){
	$campagin_id= $_POST['drop_campaign'];	
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id ORDER BY date DESC  LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A); 
	$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id");
	$first = ((($page-1)*$num_per_page)+1);		
	$total = $count[0]->count;
	$last  = ((($page-1)*$num_per_page)+count($results));
}elseif(isset($_POST['short'])){
	$user_id = $_SESSION['user_id'];
	$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id GROUP BY phone_number ORDER BY date DESC LIMIT ".$_POST['short'],ARRAY_A);
	$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE registereduser_id = $user_id");
	$first = ((($page-1)*$num_per_page)+1);		
	$total = $count[0]->count;
	$last  = ((($page-1)*$num_per_page)+count($results));
}elseif(isset($_GET['camp'])){
	$user_id = $_SESSION['user_id'];
	$campagin_id = $_GET['camp'];
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id ORDER BY date DESC LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A);
	
	$first = ((($page-1)*$num_per_page)+1);
	$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id");
	$total = $count[0]->count;
	$last  = ((($page-1)*$num_per_page)+count($results));
}else{
	$user_id = $_SESSION['user_id'];
	$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id GROUP BY phone_number ORDER BY date DESC LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A);
	$first = ((($page-1)*$num_per_page)+1);
	$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE registereduser_id = $user_id");
	$total = $count[0]->count;
	$last  = ((($page-1)*$num_per_page)+count($results));
}
$first = ((($page-1)*$num_per_page)+1);

$total = $count[0]->count;
$last  = ((($page-1)*$num_per_page)+count($results));
if(isset($_POST['sms_submit'])){		
	$twilio_number = $_POST['sms_twilio_no']; 
	$client = new Twilio\Rest\Client($sid, $token);
	$sms_camp_sms = $_POST['sms_camp_sms'].'
Reply STOP to cancel msgs';
	$subPhones = $_POST['subPhones'];
	$details = explode(',',$subPhones);	

	foreach ($details as $phone) {	
		if(strstr($phone,'+') ==  true){
			$send_no  = $phone;
		}else{
			$send_no  = '+1'.$phone;
		}			
		$messages = $client->messages->create(
			// the number you'd like to send the message to
				''.$send_no.'',
			array(
				// A Twilio phone number you purchased at twilio.com/console
				//'from' => '+13143100397 ',
				'from' => $twilio_number,
				// the body of the text message you'd like to send
				'body' => $sms_camp_sms
			)
		);
		if($messages){
			global $wpdb;
			//insert stop in db   
			$sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table              
			$inbox = array('phone_number' => $phone,
				'reply'        => $sms_camp_sms,
				'user_id'      => $user_id,
				'sent_date'    => date('Y-m-d'),
			);
			$wpdb->insert($sms_inbox,$inbox);
		}
	}
	wp_redirect(home_url().'/dashboard/?option=subscription&tmsg=1');
}
// get single message form twilio 
if(isset($_POST['single_sms_submit'])){			
	$twilio_number = $_POST['sms_twilio_no']; 
	$client = new Twilio\Rest\Client($sid, $token);
	$sms_camp_sms = $_POST['sms_camp_sms'].'
Reply STOP to cancel msgs';
	$phone = $_POST['single_phn'];						
		if(strstr($phone,'+') ==  true){
			$send_no  = $phone;
		}else{
			$send_no  = '+1'.$phone;
		}		
	$messages = $client->messages->create(
		// the number you'd like to send the message to
			''.$send_no.'',
		array(
			// A Twilio phone number you purchased at twilio.com/console
			//'from' => '+13143100397 ',
			'from' => $twilio_number,
			// the body of the text message you'd like to send
			'body' => $sms_camp_sms
		)
	);
	if($messages){
		global $wpdb;
		//insert stop in db   
		$sms_inbox = $wpdb->prefix.'sms_inbox';  //sms inbox table              
		$inbox = array('phone_number' => $phone,
			'reply'        => $sms_camp_sms,
			'user_id'      => $user_id,
			'sent_date'    => date('Y-m-d'),
		);
		$wpdb->insert($sms_inbox,$inbox);
	}
	wp_redirect(home_url().'/dashboard/?option=subscription&tmsg=1');
}

?>
<style>
.subsciber-heading h5 {
    padding-bottom: 10px;
}


.subsciber-heading select {
    background: #d9534f;
    color: #fff;
    border: 1px solid #d987b5;
    padding: 3px 5px;
    border-radius: 2px;
}

.subsciber-heading select option {
    margin: 40px;
    background: #fff;
    color: #000;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
}
.my-pageination7 {
    text-align: center;
    margin-bottom: 15px;
    position: absolute;
    top: 105px;
    right: 25px;
}
.table-box{position: relative;}
.my-pageination {
    text-align: center;
    margin-bottom: 15px;
    position: absolute;
    bottom: 40px;
    right: 15px;
}
.table-box {
    position: relative;
}
.left-shifter {
    position: relative;
    top: 4px;
    left: -6px;
}
.right-shifter {
    position: relative;
    top: 4px;
    right: -6px;
}
.subs-table {
    margin-top: 20px;
}
.table-div{position:relative;}
</style>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
						<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
					<a href="<?php echo home_url();?>/dashboard/" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					<!-- <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a> -->
						</h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading subsciber-heading">
									<h5>Subscribers 									
									<small class="pull-right heading-earnings add-earning subsciber-link">
									<font color="#007803">
									<form style="display:inline;" action="<?php echo home_url();?>/dashboard/?option=subscription" method="post">
										<select class="" name="drop_campaign" onchange="form.submit();">
											<option value="">Select Campaigns</option>
											<?php 
											$camp_table_name = $wpdb->prefix.'svb_campaings';
											$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $user_id");
											foreach($camp_list as $list){
											?>
											<option value="<?php echo $list->id;?>" <?php if($list->id == $_POST['drop_campaign']){ echo "selected"; } ?>><?php echo $list->title;?></option>
											
											<?php } ?>
										</select>
										</form>
										<a href="#" data-toggle="modal" data-target="#send_sms" id="send_sms_twilio"><i class="fa fa-telegram"></i> Send SMS</a>
										<a	href="<?php echo home_url().'/wp-content/themes/Divi-child/admin/subscription/csv_sample.csv';?>" download><i class="fa fa-share-square-o"></i> CSV Sample</a>
										<a href="<?php echo home_url();?>/dashboard/?option=subscription&page=add_subscriber"><i class="fa fa-plus"></i> Add Subsciber</a>
									</font>
									</small>
									</h5>
									<hr />
								</div>								
								<?php if(isset($_GET['umsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Subscriber updated Successfully!
											</code>
										</div>
								<?php } ?>		
								<?php if(isset($_GET['tmsg'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Messages sent Successfully!
											</code>
										</div>
								<?php } ?>				
								<?php if(isset($_GET['delete'])) {?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Deleted Succcesfully!
											</code>
										</div>
								<?php }if(isset($_GET['import'])) { ?>
								<div class="alert alert-success border-success">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button> Data Imported Succcesfully!
											</code>
										</div>
								<?php } ?>
								
								<ul class='list-inline'>
									<li>
										<label for="label">Sort By:</label>
										<form action="" method="post">
											<select name="short" id="" onchange="form.submit();">
												<option value="10" <?php if($_POST['short'] == 10){ echo "selected";} ?> >10</option>
												<option value="25" <?php if($_POST['short'] == 25){ echo "selected";} ?> >25</option>
												<option value="50" <?php if($_POST['short'] == 50){ echo "selected";} ?> >50</option>
												<option value="75" <?php if($_POST['short'] == 75){ echo "selected";} ?> >75</option>
												<option value="100" <?php if($_POST['short'] == 100){ echo "selected";} ?> >100</option>
												<option value="150" <?php if($_POST['short'] == 150){ echo "selected";} ?> >150</option>
											</select>
										</form>
									</li>
									<li>
										<input type="text" name="" id="search" class="subscriber-search" placeholder="Search by phone number" />
									</li>
								</ul>

								<div class="my-pageination7">
									<?php 
										if($first > $last)
										{
											$first=$last;
										}if($page > 1)
										{ if(isset($_POST['drop_campaign']) || $_GET['camp']){ 
											if(isset($_GET['camp'])){
												$camp_id = $_GET['camp'];
											}else{
												$camp_id = $_POST['drop_campaign'];
											}
											?>										
										<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page-1; ?>&camp=<?php echo $camp_id;?>" class="left-shifter"><i class="fa fa-angle-left fa-2x"></i></a>
										<?php }else{ ?>
											<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page-1; ?>" class="left-shifter"><i class="fa fa-angle-left fa-2x"></i></a>
										<?php }
										}
										   if($total == 0)
										   {
											  // echo "<td colspan='6'><h4 class='text-danger text-center'>There are no results that meet your criteria.</h4></td>";
										   }
										   else	// else there are clips
										   {
											   echo "<span class='peg-desi'>$first - $last of $total</span>";
										   }
										if($last < $total){ 
											if(isset($_POST['drop_campaign']) || $_GET['camp']){ 
												if(isset($_GET['camp'])){
													$camp_id = $_GET['camp'];
												}else{
													$camp_id = $_POST['drop_campaign'];
												}
												?>										
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>&camp=<?php echo $camp_id;?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>
											<?php }else{ ?>
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>
											<?php }
											?> 											
												<!-- <a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>											 -->
										<?php }
									?>
								</div>
								<form action="<?php echo home_url();?>/dashboard/?option=subscription&subscriber_action=exportcsv" method="post" onsubmit="return ischeckbox();">				
								<div class="table-responsive">									
								<table id="" class="table table-striped table-bordered nowrap subs-table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><input type="checkbox" id="chkall" /></th>
											<th>Name</th>
											<th>Phone Number</th>
											<th>Campaigns Title</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody id="table">
									<?php
									//$user_id= $_SESSION['user_id'];
									//$results = $wpdb->get_results("SELECT * FROM $table_name WHERE registereduser_id = $user_id",ARRAY_A); 
									if(isset($_POST['drop_campaign'])){
										$campagin_id= $_POST['drop_campaign'];	
										$results = $wpdb->get_results("SELECT * FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id ORDER BY date DESC LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A); 
									}elseif(isset($_POST['short']) ){
										if(isset($_GET['camp']) || isset($_POST['drop_campaign'])){
											if(isset($_GET['camp'])){
												$campagin_id = $_GET['camp'];
											}else{
												$campagin_id = $_POST['drop_campaign'];
											}
											$user_id = $_SESSION['user_id'];											
											$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id GROUP BY phone_number ORDER BY date DESC LIMIT ".$_POST['short'],ARRAY_A);																						
											$first = ((($page-1)*$num_per_page)+1);
											$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id");
											$total = $count[0]->count;
											$last  = ((($page-1)*$num_per_page)+count($results));
										}else{
											$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id GROUP BY phone_number ORDER BY date DESC LIMIT ".$_POST['short'],ARRAY_A);
										}										
									}elseif(isset($_GET['camp'])){
											$user_id = $_SESSION['user_id'];
											$campagin_id = $_GET['camp'];
											$results = $wpdb->get_results("SELECT * FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id ORDER BY date DESC LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A);

											$first = ((($page-1)*$num_per_page)+1);
											$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE campaign = $campagin_id AND registereduser_id = $user_id");
											$total = $count[0]->count;
											$last  = ((($page-1)*$num_per_page)+count($results));
									}else{
										$user_id = $_SESSION['user_id'];
										$results = $wpdb->get_results("SELECT * FROM `$table_name` where registereduser_id = $user_id GROUP BY phone_number ORDER BY date DESC LIMIT ".$num_per_page." offset ".(($page-1)*$num_per_page),ARRAY_A);
										$first = ((($page-1)*$num_per_page)+1);
										$count =  $wpdb->get_results("SELECT COUNT(*) as count FROM $table_name WHERE registereduser_id = $user_id");
										$total = $count[0]->count;
										$last  = ((($page-1)*$num_per_page)+count($results));
									}
									$i = 0;
									foreach($results as $result){
									?>
										<tr>
											<td>
												<?php if($result['status'] == 0) { ?>
													<input type="checkbox" name="check_list_ho_ja[]" id="check_list_ho_ja<?php echo $i;?>"  class="check_list_ho_ja" value="<?php echo $result['id'];?>|<?php echo $result['phone_number'];?>" />
												<?php } ?>
											</td>
											<td><?php echo $result['name'];?></td>
											<td><?php echo $result['phone_number'];?></td>
											<td><a href="javascript:void(0);" onclick="campaign_group('<?php echo $result['phone_number'];?>');">View</a> <span class="label label-danger"><?php echo svbCampaignCount($result['phone_number']);?></span></td>
											<td><?php if($result['status'] == 0 ) { echo "<span class='label label-success'>Active</span>"; }else{ echo "<span class='label label-danger'>Block</span>";}?></td>
											<td><?php if($result['status'] == 0) { ?>
												<a href="javascript:void(0);" onclick="single_sms('<?php echo $result['phone_number'];?>')" ><i class="fa fa-envelope fa-1x camp-action"></i></a>
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&page=edit_subscriber&row_id=<?php echo $result['id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<!-- <a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a> -->
												<?php }else{ } ?>
											</td>
										</tr>			
										<input type="hidden" name="ad" id="unique" value="<?php echo $i;?>">									
									<?php $i++; } ?>
								   </tbody>									
									<div class="my-pageination">
									<?php 
										if($first > $last)
										{
											$first=$last;
										}if($page > 1)
										{ if(isset($_POST['drop_campaign']) || $_GET['camp']){ 
											if(isset($_GET['camp'])){
												$camp_id = $_GET['camp'];
											}else{
												$camp_id = $_POST['drop_campaign'];
											}
											?>										
											<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page-1; ?>&camp=<?php echo $camp_id;?>" class="left-shifter"><i class="fa fa-angle-left fa-2x"></i></a>
										<?php }else{ ?>
											<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page-1; ?>" class="left-shifter"><i class="fa fa-angle-left fa-2x"></i></a>
										<?php }
										}
										   if($total == 0)
										   {
											   echo "<td colspan='6'><h4 class='text-danger text-center'>There are no results that meet your criteria.</h4></td>";
										   }
										   else	// else there are clips
										   {
											   echo "<span class='peg-desi'>$first - $last of $total</span>";
										   }
										if($last < $total){ 
											if(isset($_POST['drop_campaign']) || $_GET['camp']){ 
												if(isset($_GET['camp'])){
													$camp_id = $_GET['camp'];
												}else{
													$camp_id = $_POST['drop_campaign'];
												}
												?>										
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>&camp=<?php echo $camp_id;?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>
											<?php }else{ ?>
												<a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>
											<?php }
											?> 											
												<!-- <a href="<?php echo home_url();?>/dashboard/?option=subscription&no=<?php echo $page+1; ?>" class="right-shifter"><i class="fa fa-angle-right fa-2x"></i></a>											 -->
										<?php }
									?>
									</div>
								</table>	
									</div>
								<h5 style="margin-top: 30px;">
								<small class="pull-right heading-earnings add-earning subsciber-link">
										<!-- <select class="">
											<option value="">Select Campaigns</option>
											<?php 
											$camp_table_name = $wpdb->prefix.'svb_campaings';
											$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name");
											foreach($camp_list as $list){
											?>
											<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
											
											<?php } ?>
										</select> -->
										<font color="#007803">										
										<button type="submit" name="exp_sub_mit"><i class="fa fa-share-square-o"></i> Export</button>
										<!-- <a href="<?php echo home_url();?>/dashboard/?page=sms_voice_broadcast&sms_page=subscriber&subscriber_action=exportcsv"><i class="fa fa-share-square-o"></i> Export</a> -->
										
										
										<button type="button" data-toggle="modal" data-target="#upload_csv"><i class="fa fa-cloud-upload"></i> Import</button>
										<button type="submit" name="delete_sub" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i> Delete</button>									
										</font></small>
								</h5>
								
								</form>													
							</div>							
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Modal Box For Upload Csv-->

	<div id="upload_csv" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Upload CSV</h4>
			</div>
			<div class="modal-body">
			<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
			<label class="control-label">Select Campaign:</label>			
				<select class="form-control" name="svb_campaign" required>
					<option value="">Select Campaign</option>
					<?php 
						$camp_table_name = $wpdb->prefix.'svb_campaings';
						$camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $user_id");
						foreach($camp_list as $list){
						?>
							<option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>																	
						<?php } ?>
				</select>			
			</div> 			
				<div class="form-group">
					<label for="csv_file">Choose CSV:</label>
					<input type="file" class="form-control" name="svb_csv_file" required>
				</div>
				
				<button type="submit" class="btn btn-info" name="svb_csv">Submit</button>
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			</div>

		</div>
		</div>


<!-- End Modal Box For Upload Csv-->
<?php
include( get_template_directory() . '-child/admin/footer.php' );
	}
	if(isset($_POST['svb_csv'])){
		$row = 0;
		$table_name = $wpdb->prefix.'svb_subscriber';
		$handle = fopen($_FILES['svb_csv_file']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
		if($row !=0 ){
			$svb_campaign = $_POST['svb_campaign'];
			//if($data[0] != ""){
				//$idata = array('registereduser_id'=>$_SESSION['user_id'],'name' =>$data[0],'phone_number'=>$data[1]);
				$idata = array('registereduser_id'=>$_SESSION['user_id'],'name' =>$data[0],'phone_number'=>$data[1],'campaign'=>$_POST['svb_campaign'],'campaign_title'=>ucwords(getCampaignName($svb_campaign)->title));
				$wpdb->insert($table_name,$idata);
			//}
			
		}		
		$row++;		
		 //echo "</pre>";
		//$idata = array('name' =>$data[0],'phone_number'=>$data[1] );
		//$wpdb->insert($table_name,$idata);
		 
		}
		fclose($handle);
		echo '<script>window.location.href="'.home_url().'/dashboard/?option=subscription&new_action=subscriber&import=1"</script>';		 		 
	}
?>
  <!-- Campaign Modal -->
  <div class="modal fade" id="camp_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Campaigns</h4>
        </div>
        <div class="modal-body">
		<ul id="areoption">
			
		</ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- end campaign modal -->
  <!-- send sms  Modal -->
  <div class="modal fade" id="send_sms" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-size: 20px;font-weight: bold;">Message to Subscribers</h4>
        </div>
        <div class="modal-body">
		<form action="" method="post">
		<!-- check condition  -->
			<div class="alert-danger sdiv" style="display:none;">
				<strong> Please select subscriber</strong>
			</div>
		<!-- end check condition  -->
		<strong class="subcountdiv mdiv" style="text-align:left">Total Subscribers: &nbsp;<strong class="subCountShow"></strong></strong>
             <div class="form-group mdiv" style="">
                <label for="sel1">App Phone Number:</label>
                  <select id="camp_phone_sel" class="form-control" name="sms_twilio_no" required>
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
              <div class="form-group mdiv">
                <label class="mkdiv">Message</label>
					<textarea class="form-control sms_campaign_sms_popup2" name="sms_camp_sms" maxlength="135" required rows=8 id="sms_campaign_sms_popup2"></textarea>
					<small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em id="sms_length_count_popup2">135</em></small>
              </div>                          
              	<input type="hidden" name="camp_number" value="">
            	<input type="hidden" name="subPhones" class="subphones" value="">
        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button> -->
          <button type="submit" class="btn btn-danger" name="sms_submit">Send</button>
		  </form>
        </div>
      </div>
      
    </div>
  </div>
  <!-- end send multiple sms modal -->
    <!-- send single sms  Modal -->
	<div class="modal fade" id="send_sms_single" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-size: 20px;font-weight: bold;">Message</h4>
        </div>
        <div class="modal-body">
		<form action="" method="post">		
			<div class="form-group" >
				<label class="mkdiv">Phone Number</label>	
				<input type="text" name="single_phn" value="" readonly id="single_phn" class="form-control">	
			</div>		
             <div class="form-group" style="">
                <label for="sel1">App Phone Number:</label>
                  <select id="camp_phone_sel" class="form-control" name="sms_twilio_no" required>
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
              <div class="form-group mdiv">
                <label class="mkdiv">Message</label>
				<textarea class="form-control sms_campaign_sms_popup" name="sms_camp_sms" maxlength="135" required rows=8 id="sms_campaign_sms_popup"></textarea>
				<small class="pull-right" style="margin-top:5px"><b>characters</b>:  <em class="sms_length_count_popup">135</em></small>
              </div>                          
              	<input type="hidden" name="camp_number" value="">            	
        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-default" data-dismiss="modal">Close</button> -->
          <button type="submit" class="btn btn-danger" name="single_sms_submit">Send</button>
		  </form>
        </div>
      </div>
      
    </div>
  </div>
  <!-- end send multiple sms modal -->
<script>
   function single_sms(mob_no){	   
		$("#send_sms_single").modal("show");
		$("#single_phn").val(mob_no);
	}
	$("#send_sms_twilio").click(function (){
		$(".mdiv").hide();
		var countCheckedCheckboxes = $("input[class='check_list_ho_ja']:checked").length;	
		
			$('.subCountShow').text(countCheckedCheckboxes);
			if(countCheckedCheckboxes > 0){		 
				var val = [];
				$.each($("input[class='check_list_ho_ja']:checked"),function(){
					//val.push($(this).val());
					var str = $(this).val();
					//var rest = str.substring(0, str.lastIndexOf("|") + 0);
					var last = str.substring(str.lastIndexOf("|") + 1, str.length);
					val.push(last);															
				});	
				$(".subphones").val(val);
				$(".mdiv").show();
				$(".sdiv").remove();
			}else{
				
				$(".mdiv").hide();
				$(".sdiv").show();
			}
	});
	function campaign_group(param){
		ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';	
		$("#camp_modal").modal("show");
		data = {
				   'action' : 'campaignDetails',
				   'val' : param,
				};
				jQuery.post(ajax_url,data,function(response) {					
					// console.log(response.length);
					if(response.length >  0){
						var option =1;
						var list ="";
						jQuery.each(response,function (index,obj){
							//list += '<li style="list-style:none;font-weight:bold;"><span class="label label-danger">'+option+'</span> '+obj.campaign_title+'</li>';
							str = obj.campaign_title.toLowerCase().replace(/\b[a-z]/g, function(letter) {
								return letter.toUpperCase();
							});
							list += '<li style="list-style:none;font-weight:bold;"><span class="label label-danger">'+option+'</span> '+str+'</li>';
							option++;						
						});
						$("#areoption").html(list);
					}else{
						var list = '<li style="list-style:none;font-weight:bold;" class="text-danger">No Campaign is assigned</li>';
						$("#areoption").html(list);
					}
				});		
	}
	$("#sms_campaign_sms_popup").keyup(function() { 		
        var textvalue = $(this).val();
        val_array = textvalue.split("");		
        var total_charcter = 135;
        var remain_charcter = total_charcter - val_array.length;
        $(".sms_length_count_popup").html(remain_charcter);
	});
	$(".sms_campaign_sms_popup2").keyup(function() { 			
        var textvalue = $(this).val();
        val_array = textvalue.split("");		
        var total_charcter = 135;
		var remain_charcter = total_charcter - val_array.length;
		
        $("#sms_length_count_popup2").text(remain_charcter);
    });
	$("#search").keyup(function (){
		var val = $("#search").val();
		if(val == ""){
			location.reload();
		}
		ajax_url = '<?php echo admin_url( 'admin-ajax.php' );?>';				
		data = {
		'action' : 'searchsub',
		'val' : val,
		};
		jQuery.post(ajax_url,data,function(response) {
			console.log(response);
			jQuery(".my-pageination7").remove();
			jQuery(".my-pageination").remove();
			if(response != 0 ){
			jQuery('#table').html(response);
			}
			else if(response == 0){
			var td = "<tr><td colspan='6'><h4 class='text-danger text-center'>There are no results that meet your criteria.</h4></td></tr>";
			jQuery('#table').html(td);
			}
		});	
	});
</script>