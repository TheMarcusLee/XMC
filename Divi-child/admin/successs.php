<?php 

session_start();
global $wpdb;
$user_id= $_SESSION['user_id'];

include( get_template_directory() . '-child/admin/header.php' );
?>
	<style>
		.sidebar {
			background: #333;
			color: #fff;
			min-height: 600px;
		}
		.payment-icon {
			font-size: 45px;
		}
		.payment-status h3 {
			margin-top: 0px;
		}
		.payment-status {
			background: #fff;
			width: 35%;
			margin: auto;
			text-align: center;
			padding: 15px 35px 14px;
			margin-top: 10%;
			border-radius: 5px;
			border: 1px solid #ccc;
		}
		
		.paymentBtn {
			padding: 6px 15px;
			display: inline-block;
			border-radius: 20px;
			border: 1px solid;
			margin-top: 10px;
			margin-bottom: 15px;
		}
		.success-payment .payment-icon i {
			color: green;
		}
		.successBtn {
			border-color: green;
			color: green;
		}
		.successBtn:hover , .successBtn:focus{
			border-color: green;
			color: #fff;
			background: green;
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 767px) and (orientation: landscape) {
		.payment-status {
				width: 100% !important;
				margin-bottom: 40px !important;
			}
		}
		@media only screen and (min-device-width : 320px) and (max-device-width : 767px) and (orientation: portrait) {
			.payment-status {
				width: 100% !important;
				margin-bottom: 40px !important;
			}
		}
	</style>
<?php 
global $wpdb;
$refrer_table = $wpdb->prefix.'register_user';
$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);					
?>
<section class="dashboard">
    <div class="container-fluid">
        <div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
            <div class="row">
            <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
                    <?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                    <div class="payment-status success-payment">
                        <!-- Modal -->
                        <div class="payment-icon">
                            <i class="fa fa-check-circle-o"></i>
                        </div>
                        <h3>Payment Success</h3>
                        <p>Thank you, for payment </p>
						<?php if($refrer_name->r_licence == 1 && $refrer_name->all_puchased == 1) { ?>
                        	<a href="<?php echo home_url();?>/dashboard" class="paymentBtn successBtn">Dashboard</a>
						<?php }elseif($refrer_name->tier2_status == 0){ 
							header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
							header("Pragma: no-cache"); // HTTP 1.0.
							header("Expires: 0");  ?>
							<a href="<?php echo home_url();?>/dashboard/?page=tier2" class="paymentBtn successBtn">Next Payement</a>
						<?php }else{ ?>
							<a href="<?php echo home_url();?>/dashboard" class="paymentBtn successBtn">Dashboard</a>
						<?php } ?>
                    </div>
                </div>               
				</div>
			</div>
		</div>
	</section>                
<?php
  include( get_template_directory() . '-child/admin/footer.php' );
?>