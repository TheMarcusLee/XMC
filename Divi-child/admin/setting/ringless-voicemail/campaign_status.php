<?php
include( get_template_directory() . '-child/admin/header.php' );

    $post = array(
        'c_uid' => 'sdarvid@gmail.com',
        'c_password' => 'Jennifer77',
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

<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                    <div class="campaign_status"><?php echo $response;?></div>
                </div>
            </div>
         </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>