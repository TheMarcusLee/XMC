<?php
/*
Template Name: My Dashboard
*/
session_start();
global $wpdb;
global $wp;
if($_SESSION['role']!= 'admin') { 
    wp_redirect(home_url());
}
$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'register_user';
$get_img = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id"); 
// get plan status  from admin  side 

$plan_name = $wpdb->prefix.'plan';
$plans = $wpdb->get_row("SELECT * FROM $plan_name WHERE plan_id = 1",ARRAY_A);  

//end plan status
if($_SESSION['user_id'] == NULL){
	echo '<script>window.location.href="'.home_url().'/user-login"</script>';
}

if(isset($_GET['payment'])){
	if($_GET['payment'] =="payeezy"){
		include( get_template_directory() . '-child/admin/payeezy_process.php' );
	}
	if($_GET['payment'] =="authorize"){
		include( get_template_directory() . '-child/admin/authorize_process.php' );
	}
	

}
if(isset($_GET['page']) || isset($_GET['option'])){
	
	if($_GET['option'] == 'settings'){

		include( get_template_directory() . '-child/admin/setting/admin_setting.php' );

	}
if($_GET['option'] == 'leads'){

		include( get_template_directory() . '-child/admin/leads.php' );

	}
	if($_GET['option'] == 'earnings'){

		include( get_template_directory() . '-child/admin/earnings.php' );

	}
	if($_GET['option'] == 'admin-affiliates'){

		include( get_template_directory() . '-child/admin/admin-affiliates.php' );

	}

	
	
}
else{

	include( get_template_directory() . '-child/admin/header.php' );
?>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<style>
		.sidebar {
			background: #333;
			color: #fff;
			min-height: 805px;
		}
		
		
		div#paymentMethod .modal-dialog {
			width: 550px;
			margin-top: 7%;
		}
		div#paymentMethod .modal-header {
			padding: 8px 15px;
			background: #333;
			color: #fff;
		}
		div#paymentMethod .modal-header .close {
			margin-top: 3px;
			color: #fff;
			opacity: 1;
		}
		div#paymentMethod .modal-footer {
			padding: 12px 15px 10px;
		}
		div#paymentMethod .modal-content{border-radius: 0px}
		.panel-heading span {
			margin-top: -3px;
		}
		.panel-heading span {
				margin-top: -3px;
			}
			.expiration li {
			width: 50%;
			float: left;
		}
		.expiration:after {
			clear: both;
			content: "";
			display: table;
		}
		.panel-title label {
			font-size: 14px;
			font-weight: normal;
		}
		.panel-title a {
    color: #000;
    width: 96%;
    display: inline-block;
}
	.not-allowed {cursor: not-allowed;}
	.lead-btn {
    text-align: right;
}
.lead-btn i {
    position: relative;
    top: 0px;
    margin-left: 10px !important;
}
.referral-btn{text-align: right;}
.referral-btn i {
    position: relative;
    top: 0px;
    margin-left: 10px !important;
}

.start-here-button a {
    display: inline-block;
    background: #2dc0f0;
    color: #fff;
    min-width: 120px;
    text-align: center;
    line-height: 35px;
    border-radius: 3px;
    margin-top: 20%;
    font-size: 15px;
    text-transform: uppercase;
    box-shadow: 0px 2px 5px 0px #888888;
}
.start-here-button a:hover{color:#fff;background:#333333;}

.start-here-div p {
    font-size: 28px;
    margin-top: 30px;
    text-align: center;
    text-transform: uppercase;
    color: #fff;
}
.start-here-div i {
    margin-top: 25px;
    color: #4ff5b5;
}
.start-here-div {
    background: #4ff5b5 !important;transition: all 300ms ease-in;
}
.start-here-div:hover {
    background: #2dc0f0 !important;transition: all 300ms ease-in;
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
						<div class="row">
							<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
										<?php $user_id = $_SESSION['user_id'];
											$table = $wpdb->prefix.'earnings';
											$total_amount = $wpdb->get_results("SELECT SUM(send_amount) as amount FROM `$table` WHERE rec_id = $user_id");
										?>
										  <h3>$<?php echo $total_amount[0]->amount;?>.00</h3>
										  <p>Earnings</p>
										</div>
										<div class="icon">
										  <i class="fa fa-usd"></i>
										</div>
										<a href="<?php echo home_url();?>/my-dashboard?option=earnings" class="small-box-footer lead-btn">More info <i class="fa fa-arrow-right" style="color:#fff"></i></a>
									  </div>
									
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
								<div class="small-boxes">
									<div class="small-box bg-aqua">
										<div class="inner">
										<?php 
										global $wpdb;
										$table = $wpdb->prefix.'register_user';
										$count = $wpdb->get_results("SELECT COUNT(*) as count FROM $table");
										//print_r($count);
										?>
										  <h3><?php echo $count[0]->count;?></h3>
										  <p>Affiliates</p>
										</div>
										<div class="icon">
										  <i class="fa fa-users"></i>
										</div>
										<a href="<?php echo home_url();?>/my-dashboard?option=admin-affiliates" class="small-box-footer referral-btn">More info  <i class="fa fa-arrow-right" style="color:#fff"></i></a>
										
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
	$( "#all_auth_form" ).validate({
    rules: {
        card_no_auth: {
			required: true,
			number: true
        },    
		month_auth: {
			required: true,
			number: true
        },
		year_auth: {
			required: true,
			number: true
        },
		cvv_auth: {
			required: true,
			number: true
        },    
    }   
    });
	$( "#payeezy_all" ).validate({
    rules: {
        card_no: {
			required: true,
			number: true
        },    
		card_month: {
			required: true,
			number: true
        },
		card_year: {
			required: true,
			number: true
        },
		cvv: {
			required: true,
			number: true
        },  
    }   
    });
	
           
	</script>