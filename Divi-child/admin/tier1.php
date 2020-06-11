<?php
if(isset($_GET['payment'])){
	if($_GET['payment'] =="payeezy"){
		include( get_template_directory() . '-child/admin/payeezy_process.php' );
	}
	if($_GET['payment'] =="authorize"){
		include( get_template_directory() . '-child/admin/authorize_process.php' );
	}	
	if($_GET['payment'] =="stripe"){
		include( get_template_directory() . '-child/admin/stripe.php' );
	}	
}
if(isset($_GET['option'])){
	if($_GET['option'] == 'paypal_success'){
		include( get_template_directory() . '-child/admin/paypal_success.php' );
    }
}else{
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
?>
<link rel='stylesheet' href='<?php echo get_template_directory_uri();?>-child/css/ryxren.css'>
<style>
	.sidebar {
		background: #333;
		color: #fff;
		min-height: 1550px;
	}
	.normal-head {
		width: 90%;
		margin-bottom: 20px;
	}
	.payment-box ul {
		list-style: none;
		padding-left: 0px;
		border: 1px dashed #000;
	}
	.payment-box {
		background: #efefef;
		padding: 20px 20px 10px;
		border-radius: 5px;
		text-align: left;
	}
	.payment-box ul li b {
		float: left;
		width: 45%;
	}
	.payment-box ul li span {
		float: left;
		width: 55%;
		padding-left: 10px;
	}
	.payment-box ul li:after {
		content: "";
		display: table;
		clear: both;
	}
	.payment-box ul li {
		border-bottom: 1px dashed #000;
		padding: 10px 8px 10px;
	}
	.payment-box ul li:last-child {
		border-bottom: 0px;
	}
	.payment-box ul li b i {
		font-style: normal;
		float: right;
		margin-right: -4px;
	}
	.pay-know a {
		background: #da524e;
		color: #fff;
		display: inline-block;
		padding: 5px 10px;
		margin-top: 10px;
		border-radius: 4px;
		margin-bottom: 14px;
	}
	.payment-heading h4 {
		position: relative;
		display:inline-block;
	}
	.payment-heading h4:after {
		content: "";
		display: table;
		width: 35px;
		height: 2px;
		background: #da524e;
		margin: 7px auto 5px;
	}
	
.margin-remover {
    margin: 0px 15px;
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
						<h4 style="text-align:right; margin-top:3%;">
							<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
                        <div class="setting-divs" style="margin-top: 40px;">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div links-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box link-boxes marketing-banners">
													<h3>Payment For Tier 1 Software</h3>
													<div class="normal-head">
													<?php 
														$refrer_table = $wpdb->prefix.'register_user';
														$refrer_name = $wpdb->get_row("SELECT * FROM $refrer_table WHERE id=".$_SESSION['user_id']);					
														$refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_name->refrencename."'");
														$his_refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".$refrer_detail->refrencename."'");
														$admin_details = $wpdb->get_row("SELECT * FROM $refrer_table WHERE role='admin'");
														if($refrer_name->r_licence == 1){
													?>
													Tier 1 Software
														<p>Please make your payment(s) below.</p>
														<p>Once Payment is made you will have immediate access to this Software Suite and able to resell and promote this Software Product</p>
														<!-- <p>Please setup a new subscription, by making the payment(s), using the options below.</p>
														<p>Please note that e-checks in some cases will NOT be accepted as they may need time to clear. E-checks paid with Safepay ARE acceptable, as they clear instantly.</p> -->
													<?php } ?>
													</div>
													<div class="row">
                                                    <?php                                                       
														if($refrer_name->r_licence == 1){ ?>
															<?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == "" && $refrer_detail->paypal_email_id == "" ) { ?>
															 <!-- for his/her first sales get 100% commision-->
															 <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
                                                                <div class="payment-heading text-center"><h4>Payment</h4></div>
                                                                <div class="payment-box">
																	<ul class="">
																		<li><b>Name</b><span><?php echo $admin_details->fname.' '.$admin_details->lname; ?></span></li>
																		<li><b>Keyword<i>:</i></b><span><?php echo $admin_details->username; ?></span></li>
																		<li><b>Amount<i>:</i></b><span>$40.00</span></li>
																		<li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
																		<!-- <li><b>Last paid with<i>:</i></b><span>Paypal</span></li>
																		<li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
																	</ul>
																	<?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == "" && $refrer_detail->paypal_email_id == "" ) { ?>
																		<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_full_admin">Pay Now</a></div>
																	<?php }else{ ?>
                                                                    	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_full">Pay Now</a></div>
																	<?php } ?>
                                                                </div>
                                                            </div>
                                                            <!-- end first sales -->																																
															<?php }
                                                        elseif($refrer_detail->sales_count == 0) { ?>
                                                            <!-- for his/her first sales get 100% commision-->
                                                            <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
                                                                <div class="payment-heading text-center"><h4>Payment</h4></div>
                                                                <div class="payment-box">
                                                                    <ul class="">
																		<li><b>Name</b><span><?php echo $refrer_detail->fname.' '.$refrer_detail->lname; ?></span></li>
                                                                        <li><b>Keyword<i>:</i></b><span><?php echo $refrer_name->refrencename; ?></span></li>
                                                                        <li><b>Amount<i>:</i></b><span>$40.00</span></li>
                                                                        <li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
                                                                        <!-- <li><b>Last paid with<i>:</i></b><span>Paypal</span></li>
                                                                        <li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
                                                                    </ul>
																	<?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == "" && $refrer_detail->paypal_email_id == "" ) { ?>
																		<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_admin">Pay Now</a></div>
																	<?php }else{ ?>
                                                                    	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_full">Pay Now</a></div>
																	<?php } ?>
                                                                </div>
                                                            </div>
                                                            <!-- end first sales -->
                                                    <?php }elseif($refrer_detail->sales_count == 1){ 
														if($refrer_name->paid_tier1_referer == 0 ){ ?>
                                                    <!-- for his/her second sales get 50% commision -->
                                                        <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
                                                            <div class="payment-heading text-center"><h4>Payment</h4></div>
                                                            <div class="payment-box">
                                                                <ul class="">
  															        <li><b>Name</b><span><?php echo $refrer_detail->fname.' '.$refrer_detail->lname; ?></span></li>
                                                                    <li><b>Keyword<i>:</i></b><span><?php echo $refrer_name->refrencename; ?></span></li>
                                                                    <li><b>Amount<i>:</i></b><span>$20.00</span></li>
                                                                    <li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
                                                                    <!-- <li><b>Last paid with<i>:</i></b><span>Paypal</span></li>
                                                                    <li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
                                                                </ul>
																<?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == "" && $refrer_detail->paypal_email_id == "" ) { ?>
																		<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_admin">Pay Now</a></div>
																	<?php }else{ ?>
                                                                    	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_my">Pay Now</a></div>
																	<?php } ?>
																<!-- <?php if($refrer_name->paid_tier1_referer == 0) {  ?>
                                                                	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_my">Pay Now</a></div>
																<?php }else{ ?>
                                                                	<div class="pay-know text-center">Paid to <?php echo $refrer_detail->fname.' '.$refrer_detail->lname; ?></a></div>
																<?php } ?> -->
                                                            </div>
                                                        </div>
														<?php }else{ ?>
                                                        <!-- for his/her second sales admin get 50% commision -->
														<div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
															<div class="payment-heading text-center"><h4>Payment</h4></div>
															<div class="payment-box">
																<ul class="">
																    <li><b>Name</b><span><?php echo $admin_details->fname.' '.$admin_details->lname; ?></span></li>
																	<li><b>Keyword<i>:</i></b><span><?php echo $admin_details->username;?></span></li>
																	<li><b>Amount<i>:</i></b><span>$20.00</span></li>
                                                                    <li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
																	<!-- <li><b>Last paid with<i>:</i></b> <span>Payzey</span></li>
																	<li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
																</ul>
																<?php if($refrer_name->paid_tier1_admin == 0) {  ?>
																	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_admin">Pay Now</a></div>																
																<?php }else{ ?>
                                                                	<div class="pay-know text-center">Paid to <?php echo $admin_details->fname.' '.$admin_details->lname; ?></a></div>
																<?php } ?>
															</div>
														</div>
													<?php } ?>
                                                    <?php }elseif($refrer_detail->sales_count >= 2){
														if($refrer_name->paid_tier1_referer == 0 ){ ?>
                                                    <!-- for his/her third sales get 50% commision -->
                                                        <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
                                                            <div class="payment-heading text-center"><h4>Payment</h4></div>
                                                            <div class="payment-box">
                                                                <ul class="">
																    <li><b>Name</b><span><?php echo $refrer_detail->fname.' '.$refrer_detail->lname; ?></span></li>
                                                                    <li><b>Keyword<i>:</i></b><span><?php echo $refrer_name->refrencename; ?></span></li>
                                                                    <li><b>Amount<i>:</i></b><span>$20.00</span></li>
                                                                    <li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
                                                                    <!-- <li><b>Last paid with<i>:</i></b><span>Paypal</span></li>
                                                                    <li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
                                                                </ul>
																<?php if($refrer_name->paid_tier1_referer == 0) {  ?>
                                                                	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_my">Pay Now</a></div>
																<?php }else{ ?>
                                                                	<div class="pay-know text-center">Paid to <?php echo $refrer_detail->fname.' '.$refrer_detail->lname; ?></a></div>
																<?php } ?>                                                                
                                                            </div>
                                                        </div>
														<?php }else{ ?>
                                                        <!-- for his/her third sales his referer get 50% commision -->
                                                        <div class="col-md-4 col-sm-6 col-lg-4 col-xs-12 text-center">
                                                            <div class="payment-heading text-center"><h4>Payment</h4></div>
                                                            <div class="payment-box">
                                                                <ul class="">
																    <li><b>Name</b><span><?php echo $his_refrer_detail->fname.' '.$his_refrer_detail->lname; ?></span></li>
                                                                    <li><b>Keyword<i>:</i></b><span><?php echo $refrer_detail->refrencename; ?></span></li>
                                                                    <li><b>Amount<i>:</i></b><span>$20.00</span></li>
                                                                    <li><b>Payment type<i>:</i></b><span>Tier 1 - One Time Payment</span></li>
                                                                    <!-- <li><b>Last paid with<i>:</i></b><span>Paypal</span></li>
                                                                    <li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li> -->
                                                                </ul>
																<?php if($refrer_name->paid_tier1_his == 0) {  ?>
                                                                	<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_his">Pay Now</a></div>
																<?php }else{ ?>
                                                                	<div class="pay-know text-center">Paid to <?php echo $his_refrer_detail->fname.' '.$his_refrer_detail->lname; ?></a></div>
																<?php } ?>                                                                
                                                            </div>
                                                        </div>
														<?php } ?>
														<!-- <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 text-center">
															<div class="payment-heading text-center"><h4>Authorize.net</h4></div>
															<div class="payment-box">
																<ul class="">
																	<li><b>Username<i>:</i></b><span>tom</span></li>
																	<li><b>Amount<i>:</i></b><span>$225.00</span></li>
																	<li><b>Payment type<i>:</i></b> <span>Powerline - One Time Payment</span></li>
																	<li><b>Last paid with<i>:</i></b> <span>Authorised.net</span></li>
																	<li><b>Last paid on<i>:</i></b><span>3-Mar-2018</span></li>
																</ul>
																<div class="pay-know text-center"><a href="#" data-toggle="modal" data-target="#paymentMethod_tier1_full">Pay Now</a></div>
															</div>
														</div> -->
                                                    <?php } }else{ ?>
															<div class="margin-remover"><h4 class="">Purchased the <b>Reseller License - Hosting</b> first. </h4></div>
													<?php } ?>
													</div>
												</div>
											</div>
										</div>
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

<script src='<?php echo get_template_directory_uri();?>-child/js/ryxren.js'></script>
<!-- if my refereer did not set payment -->
<div class="modal fade" id="paymentMethod_tier1_full_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($admin_details->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnetier1fulladmin" aria-expanded="true" aria-controls="collapseOnetier1">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier1fulladmin" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=authorize&role=admin" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" required minlength=3 maxlength=3 name="cvv_auth">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$40" />
							</div>
						</div>
						<input type="hidden" name="software" value="tier1">
						<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
						</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($admin_details->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1fulladmin" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwo1fulladmin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier1&role=admin&referer=<?php echo $admin_details->username;?>&amount=20" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $admin_details->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
                                <div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="40.00" type="text" readonly class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($admin_details->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1fulladmin" aria-expanded="false" aria-controls="collapseThree">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThree1fulladmin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=payeezy&role=admin" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx" required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier1">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$40">								
								<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php } if($admin_details->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThreefull2admin" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThreefull2admin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=stripe&role=admin" method="post">
										<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $admin_details->stripe_primary; ?>"
												data-description="Access for a Tier 1"
												data-amount="4000"
												data-locale="auto"></script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="40">
												<input type="hidden" name="software" value="tier1">
												<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
									</form>					
								</div>					
							</div>
					</div>
					</div>
				<?php } if($admin_details->arb_login_key == null && $admin_details->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($admin_details->username)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>
<!-- end full addmin payment gateway  -->
<!-- this is for my referer and he got 100% -->
<div class="modal fade" id="paymentMethod_tier1_full" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($refrer_detail->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnetier1" aria-expanded="true" aria-controls="collapseOnetier1">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier1" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=authorize" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" required minlength=3 maxlength=3 name="cvv_auth">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$40" />
								<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">
							</div>
						</div>
						<input type="hidden" name="software" value="tier1">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
						</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($refrer_detail->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($refrer_name->arb_login_key == "" && $refrer_name->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwo1" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier1&referer=<?php echo $refrer_detail->username;?>&amount=40" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $refrer_detail->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
								<label for="exampleInputEmail1">Amount to be paid:</label></br>
                                <div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="40.00" type="text" readonly class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($refrer_detail->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThree1" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=payeezy" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx" required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier1">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$40">																
								<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php } if($refrer_detail->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThree2" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=stripe" method="post">
										<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $refrer_detail->stripe_primary; ?>"
												data-description="Access for a Tier 1"
												data-amount="4000"
												data-locale="auto"></script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="40">
												<input type="hidden" name="software" value="tier1">
												<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">
									</form>					
								</div>					
							</div>
					</div>
					</div>
				<?php } 
				if($refrer_detail->arb_login_key == null && $refrer_detail->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($refrer_name->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>
<!-- this is for 50% from his referer and admin  -->
<div class="modal fade" id="paymentMethod_tier1_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($admin_details->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnetier1admin" aria-expanded="true" aria-controls="collapseOnetier1">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier1admin" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=authorize&role=admin" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" required minlength=3 maxlength=3 name="cvv_auth">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$20" />
							</div>
						</div>
						<input type="hidden" name="software" value="tier1">
						<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
						</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($admin_details->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1admin" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwo1admin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier1&role=admin&referer=<?php echo $admin_details->username;?>&amount=20" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $admin_details->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
                                <div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="20.00" type="text" readonly class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($admin_details->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1admin" aria-expanded="false" aria-controls="collapseThree">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThree1admin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=payeezy&role=admin" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx" required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier1">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$20">																
								<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php } if($admin_details->stripe_secret != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2admin" aria-expanded="false" aria-controls="collapseThree">
						Stripe
					</a>
					</h4>
				</div>
				<div id="collapseThree2admin" class="panel-collapse collapse <?php if($admin_details->arb_login_key == "" && $admin_details->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">					
					<div class="row">	
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=stripe&role=admin" method="post">
						<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="<?php echo $admin_details->stripe_primary; ?>"
								data-description="Access for a Tier 1"
								data-amount="2000"
								data-locale="auto"></script>
								<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="20">
								<input type="hidden" name="software" value="tier1">
								<input type="hidden" name="referer" value="<?php echo $admin_details->username;?>">
					</form>					
					</div>					
					</div>
				</div>
				</div>
				<?php } if($admin_details->arb_login_key == null && $admin_details->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($admin_details->username)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>
<!-- this is for my referer 50 % -->
<div class="modal fade" id="paymentMethod_tier1_my" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($refrer_detail->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnetier1my" aria-expanded="true" aria-controls="collapseOnetier1">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier1my" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=authorize" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" required minlength=3 maxlength=3 name="cvv_auth">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$20" />
							</div>
						</div>
						<input type="hidden" name="software" value="tier1">
						<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
						</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($refrer_detail->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($refrer_name->arb_login_key == "" && $refrer_name->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1my" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwo1my" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier1&referer=<?php echo $refrer_detail->username;?>&amount=20" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $refrer_detail->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
                                <div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" value="20.00" readonly type="text" class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($refrer_detail->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1my" aria-expanded="false" aria-controls="collapseThree">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThree1my" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=payeezy" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx" required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier1">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$20">
								<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">															
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="submit">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>				
				</div>				
				<?php } 
				if($refrer_detail->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2my" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThree2my" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=stripe" method="post">
										<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $refrer_detail->stripe_primary; ?>"
												data-description="Access for a Tier 1"
												data-amount="2000"
												data-locale="auto"></script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="20">
												<input type="hidden" name="software" value="tier1">
												<input type="hidden" name="referer" value="<?php echo $refrer_detail->username;?>">
									</form>					
								</div>					
							</div>
					</div>
					</div>
				<?php } 
				 if($refrer_detail->arb_login_key == null && $refrer_detail->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($refrer_name->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>
<!-- this is for my referer to his referer  -->
<div class="modal fade" id="paymentMethod_tier1_his" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Select a Payment Method</h4>
		</div>
		<div class="modal-body">
		<div class="payment-popup">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<?php if($his_refrer_detail->arb_login_key != "" ) {  ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
					<label for='r11' style='width: 100%;margin-bottom:0px;'>
					<!--  <input type='radio' id='r11' name='occupation' value='Working' checked required /> -->
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnetier1his" aria-expanded="true" aria-controls="collapseOnetier1">
						Authorize.net <span class="payment-image pull-right"><img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>visa.png" alt="Visa" /> <img src="<?php echo home_url().'/wp-content/themes/Divi-child/admin/profile_image/'?>mastercard.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseOnetier1his" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=authorize" method="post" id="all_auth_form">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx" name="card_no_auth"  required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" placeholder="MM" name="month_auth" required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" placeholder="YYYY" name="year_auth" required minlength=4 maxlength=4>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" placeholder="CVV" required minlength=3 maxlength=3 name="cvv_auth">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount_auth" placeholder="Amount" readonly value="$20" />
							</div>
						</div>
						<input type="hidden" name="software" value="tier1">
						<input type="hidden" name="referer" value="<?php echo $his_refrer_detail->username;?>">
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary pull-right" name="submit_auth" style="margin-top: 25px;" />
						</div>
						</div>
					</div>
					</div>
					</form>
				</div>
				</div>
				<?php }if($his_refrer_detail->paypal_email_id != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
					<label for='r12' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r12' name='occupation' value='Not-Working' required <?php if($his_refrer_detail->arb_login_key == "" && $his_refrer_detail->hmac_key == ""){ echo "checked"; }?>/> -->
					<a for="optionsRadios1" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1his" aria-expanded="false" aria-controls="collapseTwo">
						Paypal <span class="payment-image pull-right"><img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/profile_image/paypal.png" alt="Visa" /></span>
					</a>
					</h4>
				</div>
				<div id="collapseTwo1his" class="panel-collapse collapse <?php if($refrer_detail->arb_login_key == "" && $refrer_detail->hmac_key == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingTwo">
					<div class="panel-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">
							<div class="form-group">
								<!-- <label for="exampleInputEmail1">Email:</label> -->
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="uc-paypal-wps-form" accept-charset="UTF-8">
								<div>
								<input name="cmd" value="_cart" type="hidden">
								<input name="charset" value="utf-8" type="hidden">
								<input name="notify_url" value="<?php echo home_url();?>/dashboard" type="hidden">
								<input name="cancel_return" value="<?php echo home_url();?>/dashboard/?page=cancel" type="hidden">
								<input name="no_note" value="1" type="hidden">ypalap
								<input name="no_shipping" value="1" type="hidden">
								<!-- sucecess url -->
								
								<input name="return" value="<?php echo home_url();?>/dashboard?page=paypal_success&software=tier1&referer=<?php echo $his_refrer_detail->username;?>&amount=20" type="hidden">
								<input name="rm" value="1" type="hidden">
								<input name="currency_code" value="USD" type="hidden">
								<input name="handling_cart" value="0.00" type="hidden">
								<input name="invoice" value="2-2c7a76c0680992ab08c3be1118685463" type="hidden">
								<input name="tax_cart" value="0.00" type="hidden">
								<!-- receiver email  -->
									<input name="business" value="<?php echo $his_refrer_detail->paypal_email_id;?>" type="hidden">
								<!-- /. receiver emaill  -->
								<input name="upload" value="1" type="hidden">
								<input name="lc" value="US" type="hidden">
								<input name="address1" value="<?php echo $refrer_name->address;?>" type="hidden">
								<input name="city" value="<?php echo $refrer_name->city;?>" type="hidden">
								<input name="country" value="<?php echo $refrer_name->country;?>" type="hidden">
								<!-- sender email -->
								<input name="email" value="<?php echo $refrer_name->email;?>" type="hidden">
								<!-- /. sender email  -->
								<input name="first_name" value="<?php echo $refrer_name->fname;?>" type="hidden">
								<input name="last_name" value="<?php echo $refrer_name->lname;?>" type="hidden">
								<input name="state" value="<?php echo $refrer_name->state;?>" type="hidden">
								<input name="zip" value="<?php echo $refrer_name->zipcode;?>" type="hidden">
								<input name="address_override" value="1" type="hidden">
								<!-- amount to be paid -->
                                <div class="form-inline">
                                <div class="form-group">
                                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                    <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input name="amount_1" readonly value="20.00" type="text" class="form-control" placeholder="Amount" />
                                    </div>
                                </div>
                                </div>
									</br>
								<input name="item_name_1" value="Order 2 at XMC" type="hidden">
								<input name="on0_1" value="Product count" type="hidden">
								<input name="os0_1" value="1" type="hidden">
								<input name="form_build_id" value="form-V8sfuPuYET1twLANBYDOZWjbr8oGLDT1XNG_lWWJjhg" type="hidden">
								<input name="form_id" value="uc_paypal_wps_form" type="hidden"> 								 														
								<input id="edit-submit" name="op" value="Pay" class="btn btn-primary" type="submit">
								</div>
								</form>
							</div>
						</div>						
					</div>
					</div>
				</div>
				</div>
				<?php } if($his_refrer_detail->hmac_key != "" ) { ?>
				<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingThree">
					<h4 class="panel-title">
					<label for='r13' style='width: 100%;margin-bottom:0px;'>
					<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($his_refrer_detail->arb_login_key == "" && $his_refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1his" aria-expanded="false" aria-controls="collapseThree">
						Payezy
					</a>
					</h4>
				</div>
				<div id="collapseThree1his" class="panel-collapse collapse <?php if($his_refrer_detail->arb_login_key == "" && $his_refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
					<div class="panel-body">
					<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=payeezy" method="post" id="payeezy_all">
					<div class="row">
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Holder Name</label>
								<input type="text" class="form-control" id="cardnamer" name="card_name" placeholder="John Smith" required>
								</div>
						</div>
						<div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
							<div class="form-group">
								<label for="cardNumber">Card Number</label>
								<input type="text" class="form-control" id="cardNumber" name="card_no" placeholder="xxxx xxxx xxxx" required minlength=16 maxlength=16>
								</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Expiration</label>
								<ul class="list-inline expiration">
									<li>
										<input type="text" class="form-control" name="card_month" placeholder="MM"  required minlength=2 maxlength=2>
									</li>
									<li>
										<input type="text" class="form-control" name="card_year" placeholder="YY"  required minlength=2 maxlength=2>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Security Code</label>
								<input type="text" class="form-control" name="cvv" placeholder="CVV"  required minlength=3 maxlength=3>
							</div>
						</div>
						<div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
							<div class="form-group">
								<label for="exampleInputEmail1">Card Type</label>								
								<input type="text" class="form-control" name="card_type" placeholder="visa" value="visa">
								<input type="hidden" name="code" value="USD">
								<input type="hidden" name="software" value="tier1">
								<input type="hidden" name="referer" value="<?php echo $his_refrer_detail->username;?>">
							</div>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
							<div class="form-group">
							<label for="exampleInputEmail1">Amount to be paid</label>
								<input type="text" class="form-control" name="amount" placeholder="40" readonly value="$20">								
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 text-center">
							<div class="form-group">
							<label for="exampleInputEmail1"></label>
								<input type="submit" value="Pay" class="btn btn-primary" name="Pay">
							</div>
						</div>
						
					</div>
					</form>
					</div>
				</div>
				</div>
				<?php } if($his_refrer_detail->stripe_secret != '') { ?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<label for='r13' style='width: 100%;margin-bottom:0px;'>
							<!-- <input type='radio' id='r13' name='occupation' value='Not-Working' required <?php if($his_refrer_detail->arb_login_key == "" && $his_refrer_detail->paypal_email_id == ""){ echo "checked"; }?>/> -->
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree2his" aria-expanded="false" aria-controls="collapseThree">
								Stripe
							</a>
							</h4>
						</div>
						<div id="collapseThree2his" class="panel-collapse collapse <?php if($his_refrer_detail->arb_login_key == "" && $his_refrer_detail->paypal_email_id == ""){ echo "in"; }?>" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">					
							  	<div class="row">	
									<form action="<?php echo home_url();?>/dashboard/?page=tier1&payment=stripe" method="post">
											<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
												data-key="<?php echo $his_refrer_detail->stripe_primary; ?>"
												data-description="Access for a Tier 1"
												data-amount="2000"
												data-locale="auto">
											</script>
												<input type="hidden" class="form-control" name="amount" placeholder="40" readonly value="20">
												<input type="hidden" name="software" value="tier1">
												<input type="hidden" name="referer" value="<?php echo $his_refrer_detail->username;?>">
									</form>					
								</div>					
							</div>
					</div>
					</div>
				<?php } 
				if($his_refrer_detail->arb_login_key == null && $his_refrer_detail->paypal_email_id == null ){ echo "<h4 class='text-center' style='color:red;'>No Payment is selected from ".ucwords($his_refrer_detail->refrencename)."</h4>"; ?>
    
    <?php } ?>
				</div>
			</div>
		</div>
		</div>
		<div class="modal-footer">
		<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		
		</div>
	</div>
	</div>
</div>
 