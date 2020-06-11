<?php
global $wpdb;
// get slybroad cast detail from db

$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'register_user';
$get_sly = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id");	

$table_name = $wpdb->prefix.'ringless_compaign_list';
$campaign = $wpdb->get_results("SELECT * FROM $table_name WHERE registereduser_id =$user_id",ARRAY_A);

if(isset($_GET['sub_more_page']) || isset($_GET['action']) ){

    if($_GET['action'] == 'add_campaign'){
        include( get_template_directory() . '-child/admin/ringless-voicemail/add_campaign.php' );
    }
    if($_GET['action'] == 'campaign_status'){
        include( get_template_directory() . '-child/admin/ringless-voicemail/campaign_status.php' );
    }

    if($_GET['action'] == 'pause_session'){

   
    
        $post = array(
            'c_uid' => $get_sly->slybroadcast_username,
            'c_password' => $get_sly->slybroadcast_password,
            'session_id'   => $_GET['session_val'],
            'c_option'     => 'pause',
            
        );
    
       
    
        $ch = curl_init(); // Intilise Curl
         
        $url = 'https://www.mobile-sphere.com/gateway/vmb.php'; // Url
    
        curl_setopt($ch,CURLOPT_URL,$url);      // Set Option for Curl
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Date for Sending
    
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
        curl_setopt($ch,CURLOPT_HEADER, false); 
        $response = curl_exec($ch);
    
        $data = array(
            'session_status' => $response,
        );
        $where = array(
            'id' => $_GET['id'],
        );
       
        $wpdb->update($table_name,$data,$where);
        echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=compaigns"</script>';
    }

    if($_GET['action'] == 'resume_session'){

   
    
        $post = array(
            'c_uid' => $get_sly->slybroadcast_username,
            'c_password' => $get_sly->slybroadcast_password,
            'session_id'   => $_GET['session_val'],
            'c_option'     => 'run',
            
        );
    
       
    
        $ch = curl_init(); // Intilise Curl
         
        $url = 'https://www.mobile-sphere.com/gateway/vmb.php'; // Url
    
        curl_setopt($ch,CURLOPT_URL,$url);      // Set Option for Curl
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Date for Sending
    
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
        curl_setopt($ch,CURLOPT_HEADER, false); 
        $response = curl_exec($ch);
    
        $data = array(
            'session_status' => $response,
        );
        $where = array(
            'id' => $_GET['id'],
        );
       
        $wpdb->update($table_name,$data,$where);
        echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=compaigns"</script>';
    }
    
		if($_GET['action'] == 'cancel_campaign'){


			if($_GET['session_val'] != ''){
			$post = array(
				'c_uid' => $get_sly->slybroadcast_username,
                'c_password' => $get_sly->slybroadcast_password,
				'session_id' => $_GET['session_val'],
				'c_option' => 'stop',

			);

			$ch = curl_init(); // Intilise Curl

			$url = 'https://www.mobile-sphere.com/gateway/vmb.php'; // Url

			curl_setopt($ch,CURLOPT_URL,$url);      // Set Option for Curl

			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Date for Sending

			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			curl_setopt($ch,CURLOPT_HEADER, false); 

			$response = curl_exec($ch);

			if(strpos($response,'stopped') == true){
				$where = array(
						'id' => $_GET['id'],
						);
				$wpdb->delete( $table_name, $where);

			echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=compaigns"</script>';
			}
			}
			else{
				
				echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=compaigns&sess=0"</script>';
			}

	}

    

}
else{

include( get_template_directory() . '-child/admin/header.php' );

    
  
   
?>
<!-- Create List Model popup-->



<!-- End Create List Model popup-->


<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                    <h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<div class="table-div">
							

							<div class="table-box">
								<div class="table-heading">
									<h5>Campaign List 
										<small class="pull-right heading-earnings add-earning">
                                        <font color="#007803"><a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=add_campaign" id="create_list" class="btn btn-primary pull-right" > <i class="fa fa-plus"></i> Add Compaign</a></font></small>
                                        <small class="pull-right heading-earnings add-earning">
										<font color="#007803"><a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=campaign_status" id="create_list" class="btn btn-warning pull-right" style="margin-right:30px;">Running Compaign Status</a></font></small>
									</h5>
									<hr />
								</div>
								 <?php if(isset($_GET['sess'])) {?>
								<div class="alert alert-warning border-warning">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<i class="icofont icofont-close-line-circled"></i>
											</button>It cannot be deleted, due to session is not set.
											</code>
										</div>
								<?php } ?>	
								<table id="compaign_list_table" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
<!-- 											<th>S. No.</th> -->
                                            <th>Title</th>
											<th>Caller Id</th>
											<th>Group Name</th>
                                            <th>Audio</th>
											<th>Date</th>
											<th>Subscribers</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
                                   
                                        <?php
                                        $serial = 1;
                                        foreach($campaign as $camp){
                                            
                                             
                                       ?>
                                       <tr>
<!--                                         <td><?php echo $serial;?></td> -->
                                        <td><?php echo $camp['title'];?></td>
                                        <td><?php echo $camp['caller_id'];?></td>
                                        <td><?php echo ucwords(getSubscriberGroupDetails($camp['phone_list'])->group_name);?></td>
                                        <td>
										   <a href="javascript:void(0);" >
										<i class="fa fa-volume-up audio_file" audio_file="<?php echo get_template_directory_uri();?>-child/admin/ringless-voicemail/audio_files/<?php  echo $camp['audio_list'];?>" data-toggle="tooltip" data-placement="top" title="Play Audio" ></i></a> <?php echo $camp['audio_list'];?>
										   </td>
                                        <td><?php echo $camp['date'];?></td>                                    
                                        <td> <a href="<?php echo home_url();?>/dashboard/?option=subscription&new_action=subscriber&id=<?php echo $camp['phone_list'];?>"><?php  echo subscriberCount($camp['phone_list'])->total; //if($camp['subscribers'] == '') { echo '0';}else{ echo "0";} ?> </a></td>
											<td>
                                            <?php 
                                            $ses =  $camp['session_id'];
                                            $ses_ar = explode("session_id",$camp['session_id']);
                                            $first_pause = strpos($ses_ar[1] ,"=");
                                            $second_pause = strpos($ses_ar[1] ,"number");
                                            $ar = substr($ses_ar[1],1,11);

                                            if($camp['session_status'] == ''){
												?>
												 <a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=pause_session&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-pause fa-1x camp-action"></i></a>
                                                <a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=cancel_campaign&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
												<?php
											}
											else{
												if(strpos($camp['session_status'],'paused') == true){
													?>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=resume_session&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-play fa-1x camp-action"></i></a>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=cancel_campaign&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
												<?php
												}
												if(strpos($camp['session_status'],'resumed') == true){
													?>
												 <a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=pause_session&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-pause fa-1x camp-action"></i></a>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&action=cancel_campaign&session_val=<?php echo $ar;?>&id=<?php echo $camp['id']; ?>"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
												<?php
												}
												if(strpos($camp['session_status'],'finished') == true){
													?>
												<a href="#" data-toggle="tooltip" title="Campaign Completed"><i class="fa fa-check-circle" style="color:green; font-size:20px;"></i></a>
												<?php													
												}
												
											}
                                                ?>                                                                                                            
												<a href="javascript:void(0);" onclick="clone_campaign('<?php echo $camp['title']; ?>','<?php echo $camp['caller_id']; ?>',<?php echo $camp['phone_list']; ?>,'<?php echo $camp['audio_list'];?>');" data-toggle="tooltip" title="Copy Campaign"><i class="fa fa-clone" style="color:green; font-size:20px;"></i></a>
                                                    
											</td>
                                            </tr>
                                        <?php 
                                        $serial++;
                                        } ?>
											
                                        
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<script>
	function clone_campaign(title,caller_id,phone_list,audio_list){
			
			var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			var data = {
			'action'	: 'clone_campaign_fcn',
			'title'		: title,
			'caller_id' : caller_id,
			'phone_list': phone_list,
			'audio_list': audio_list,
			
			};

			
			jQuery.post(ajax_url, data, function(response) {
				jQuery("#clone_create_msg").fadeIn();
				window.location.href='<?php echo $_SERVER['REQUEST_URI'];?>';
			});

	}
	</script>
    
<?php
include( get_template_directory() . '-child/admin/footer.php' );

}

?>