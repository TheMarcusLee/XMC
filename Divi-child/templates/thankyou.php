<?php 
/*Template Name: thank you
*
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Unsubscribtion</title>
  <style>
    .thankyou-box {
        width: 40%;
        background: rgba(250,250,250,1);
        padding: 19px 21px 1px;
        box-sizing: border-box;
        margin: 16% auto 0px;
        border-top: 4px solid red;
        font-family: 'arial';
        line-height: 22px;
        border-radius: 0px 0px 5px 5px; 
    }
    .thankyou-box h4 {
        margin-top: 14px;
        font-family: 'Trebuchet','Trebuchet MS',Helvetica,Arial,Lucida,sans-serif;
        font-size: 16px;
        line-height: 22px;
        margin-bottom: 28px;
    }
    body {
      background: url(https://www.xtrememarketingcode.com/wp-content/uploads/2018/02/sky.jpeg);
    }
    .thankyou-box i {
      font-size: 48px;
      color: green;
    } 
</style>
<link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<?php 
global $wpdb;
if(isset($_GET['subemail'])){
$email = $_GET['subemail'];
$table = $wpdb->prefix.'leads';

$get = $wpdb->get_row("SELECT * FROM wp_leads WHERE `leads_email` = '$email'",ARRAY_A);

if($get > 0 ){
    if($get['leads_email'] == $email)
    {
        global $wp;
        $wpdb->update($table, array( 'status' => '0','join_date' => date('Y-m-d')),array('leads_email' => $email) );
        wp_redirect(home_url().'/thank-you?email=$email');
    } 
}
?>
<div class="thankyou-box">    
<center><i class="fa fa-check-circle-o"></i></center>
    <h4 align="center">Welcome back, You have been successfully subscribe again from xtrememarketing  <br>
        <!-- Miss u already? The felling’s mutual.  <a href="#">click here</a> to subscribe again. -->
    </h4>
</div>
<?php 
}else { 
?>
<div class="thankyou-box">    
<center><i class="fa fa-check-circle-o"></i></center>
    <h4 align="center"> You have been successfully unsubscribe from xtrememarketing  <br>
        Miss u already? The felling mutual.  <a href="<?php echo home_url();?>/thank-you/?subemail=<?php echo @$_GET['email'];?>">click here</a> to subscribe again.
    </h4>
</div>
<?php 
} ?>
</body>
</html>
