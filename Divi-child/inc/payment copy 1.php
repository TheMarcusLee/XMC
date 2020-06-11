<?php 
/*
Template Name: Payment
*/

global $wpdb;

$table = $wpdb->prefix.'register_user';
$result = $wpdb->get_col("SELECT email FROM $table");

if(in_array($_POST['email'],$result)){
    get_header();
    ?>
    <div class="text-xs-center" style="padding:52px 0; background-color:#eee;">
        <h1 style="text-align:center;">OOPS !</h1>
        <p style="text-align:center;"><strong>You have already used this email id</strong> <a href="<?php echo home_url();?>/user-login/">Please Login</p>
        <hr>
        <p style="text-align:center;">Having trouble? <a href="<?php echo home_url();?>/feedback/">Contact us</a></p>
        <p style="text-align:center;">
            <a class="btn btn-primary btn-sm" href="<?php echo home_url();?>" role="button">Continue to homepage</a>
        </p>
        </div>
    <?php
    get_footer();
}
else{
    $data = array(
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'email' => $_POST['email'],        
            'mobile' => $_POST['mobile'],        
            'password' => $_POST['password'],        
            'address' => $_POST['address'],        
            'country' => $_POST['country'],        
            'city' => $_POST['city'], 
            'state' => $_POST['state'],        
            'zipcode' => $_POST['zipcode'],  
                     
        );
    $run = $wpdb->insert( $table, $data );
    if($run == true){
       
        $to_mail = $_POST['email'];
        $message = 'Here is your username and password detail
                    Username : '.$_POST['email'].',
                    Password : '.$_POST['password'];
        wp_mail( $to_mail, 'Username and Password', $message );
        get_header();
        ?>
        <div class="text-xs-center" style="padding:52px 0; background-color:#eee;">
            <h1 style="text-align:center;">Thank You!</h1>
            <p style="text-align:center;"><strong>Please check your email</strong> <a href="<?php echo home_url();?>/user-login/">Please Login</p>
            <hr>
            <p style="text-align:center;">Having trouble? <a href="<?php echo home_url();?>/feedback/">Contact us</a></p>
            <p style="text-align:center;">
                <a class="btn btn-primary btn-sm" href="<?php echo home_url();?>" role="button">Continue to homepage</a>
            </p>
            </div>
        <?php
        get_footer();
    }
    else{
        echo 'Not Inserted';
    }
}
    

?>
