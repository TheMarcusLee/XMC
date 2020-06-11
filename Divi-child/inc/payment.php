<?php 
/*
Template Name: Payment
*/
// PayPal settings

if(isset($_POST['submit'])){
$paypal_email = 'user@domain.com';
$return_url = home_url().'/user-login';
$cancel_url = 'http://localhost/paypal/paypal-cancel.php';
$notify_url = 'http://localhost/paypal/paypal-success.php';
$item_name = 'Monthly Plan';
$item_amount = 30;

    $querystring = '';
   
	
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";
	
	// Append amount& currency (£) to quersytring so it cannot be edited in html
	
	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
	$querystring .= "item_name=".urlencode($item_name)."&";
	$querystring .= "amount=".urlencode($item_amount)."&";
	
	
	$querystring .= "cmd=_xclick&";
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Append querystring with custom field
	//$querystring .= "&custom=".USERID;
	
	// Redirect to paypal IPN
	header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	exit();
}

?>
