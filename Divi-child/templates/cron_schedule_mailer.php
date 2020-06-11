<?php 
/*Template Name: schedule mailer
 
*/
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
global $wpdb;
$query = $wpdb->get_results("SELECT * FROM  wp_cron_email", ARRAY_A);
date_default_timezone_set('America/Chicago'); // CDT
// echo $wpdb->show_erros();
$mail   = new PHPMailer();
foreach($query as $row)
{ 
    $resp_id = $row['auto_responder_id'];
    $get_date = $wpdb->get_row("SELECT * FROM wp_auto_responder WHERE `responder_id` = $resp_id",ARRAY_A); 

    $user_id = $row['user_id'];  
    $row['schedule_date'];
    $get_date['date'];
    if($get_date['date'] == date('m/d/Y'))
    {
        echo $email = $row['email'];
        $get = $wpdb->get_row("SELECT * FROM wp_register_user WHERE `email` = '$email'",ARRAY_A);
        $sender = $wpdb->get_row("SELECT * FROM wp_register_user WHERE `id` = $user_id",ARRAY_A);
        //print_r($get);
        $name = $get['fname'].' '.$get['lname'];
        $s_first = ['{name}','{first}'];
        $s_second = [ucwords($name),ucwords($get['fname'])];
        $subject = str_replace($s_first,$s_second,$row['subject']);
        $keyword = $row['keyword'];
        
        $link = '<a href="'.home_url().'/sales-1/?keyword='.$keyword.'&provider=email&responder='.$resp_id.'"> Get started</a>';

        //$link  = str_replace('{sales page link}',$link,$row['body']);
        $first_repl = ['{name}','{sales page link}','{first}'];
        $second_repl = [ucwords($name),$link,ucwords($get['fname'])];
        $to     = $row['email']; 
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <title>Xtreme Marketing Code</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        </head><body>';
        //$message .= str_replace('Click Here {sales page link}',$link,$row['body']); 
        //$message .= str_replace('{sales page link}',$link,$row['body']); 
        $message .= str_replace($first_repl,$second_repl,$row['body']); 
        $message .= '</body></html>';  
        $mail->SMTPAuth   = true;                 
        $mail->Host       = "mail.xtrememarketingcode.com"; 
        $mail->Port       = 587;                    
        $mail->Username   = "info@xtrememarketingcode.com"; 
        $mail->Password   = "4Dm!n@9870";                    
        // $mail->SetFrom('info@xtrememarketingcode.com', 'Xtreme Marketing Code');  
        $mail->setFrom($sender['email'],ucwords($sender['fname'].' '.$sender['lname']));
        $mail->AddReplyTo($get['email'],ucwords($get['fname'].' '.$get['lname']));
        $mail->Subject = $subject;
        $mail->MsgHTML($message); //$mail->Body    = $content;
        $mail->addAddress($to, ucwords($name));
        if( $mail->Send()){
            $up = $wpdb->update('wp_cron_email', array( 'status' => '1'),array('cron_id' => $row['cron_id']) );
            if($up){
                $wpdb->update('wp_auto_responder', array( 'status' => '1'),array('responder_id' => $row['auto_responder_id']) );
            }
        }
        else{
            $upd = $wpdb->update('wp_cron_email', array( 'status' => '2'),array('cron_id' => $row['cron_id']) );
            if($upd){
                $wpdb->update('wp_auto_responder', array( 'status' => '2'),array('responder_id' => $row['auto_responder_id']) );
            }
        } 
        $mail->ClearAllRecipients();
    }
}exit;

?>