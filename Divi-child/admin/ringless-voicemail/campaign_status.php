<?php
global $wpdb;
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
$table = $wpdb->prefix.'register_user';
$user_id = $_SESSION['user_id'];
$get_sly = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id");	
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->paid_status == 'unpaid') { 
	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
    $post = array(
		'c_uid' => $get_sly->slybroadcast_username,
		'c_password' => $get_sly->slybroadcast_password,
        'c_ctype' => 'running',
        'c_option' => 'campaign_reports',
        
    );

    $ch = curl_init(); // Intilise Curl

    $url = 'https://www.mobile-sphere.com/gateway/vmb.php'; // Url

    curl_setopt($ch,CURLOPT_URL,$url);      // Set Option for Curl

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Date for Sending

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch,CURLOPT_HEADER, false); 

    $response = curl_exec($ch);
    
    

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>-child/css/table-responsive.css" />
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
					<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=campaigns" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
                    <div class="campaign_status"><?php 
						
						?>
						<div id="no-more-tables">
						<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<th class="numeric">Caller Id</th>
								<th class="numeric">Campaign Id</th>
								<th class="numeric">Number of destinations</th>
								<th class="numeric">Delivery time</th>
								<th class="numeric">Status</th>
							</tr>
							<?php 
							if($response == 'No record found.'){ 														
							?>
								<tr class="numeric">
									<td colspan="5"><h4 class="text-danger text-center">There is no running campaign.</h4></td>
								</tr> 
							<?php								
							}else{ 
								$a = $response;
								$b = preg_replace("[\n]","*", $a);
								$c = explode("*",$b);
								$count_val = count($c);  
								$new_ar = array();
								for($i = 1; $i<$count_val-1; $i++){
									$d = explode("|",$c[$i]);
									array_push($new_ar,$d[0]);
								}
								global $wpdb;
								$tbnm = $wpdb->prefix.'ringless_compaign_list';
								foreach($new_ar as $ar){
								$session_id = trim($ar);	
								$dt = $wpdb->get_row("SELECT * FROM $tbnm WHERE session_id LIKE '%$session_id%'",ARRAY_A);							
							?>
							<tr>
								<td class="numeric"><?php echo $dt['caller_id']; ?></td>
								<td class="numeric"><?php echo trim($ar);?></td>
								<td class="numeric"><?php echo $dt['subscribers'];?></td>
								<?php if($dt['schd_date'] != ""){  ?>
								<td class="numeric"><?php echo $dt['schd_date'];?></td>
								<?php }else{ ?>
								<td class="numeric"><?php echo $dt['date'];?></td>
								<?php } ?>
								<?php if($dt['schd_date'] != ""){  ?>
								<td class="numeric"><?php echo '<span class="label label-info">Scheduled</span>'?></td>
								<?php }else{ ?>
								<td class="numeric"><?php echo '<span class="label label-info">Running</span>';?></td>
								<?php } ?>
								
							</tr>
							<?php
								} 
							} ?>
							
						</table>
						</div>
					</div>
                </div>
            </div>
         </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>