<?php 
/*Template Name: Remove unlicense user
 
*/
include(get_template_directory().'-child/PHPMailer/class.phpmailer.php');
include(get_template_directory().'-child/PHPMailer/class.smtp.php');
global $wpdb;
date_default_timezone_set('America/Chicago'); // CDT
$table_name = $wpdb->prefix.'register_user';
$query = $wpdb->get_results("SELECT * FROM `$table_name` WHERE r_licence = 0 AND `join_date` + interval 7 day > CURDATE() = 0", ARRAY_A);
$admin = $wpdb->get_row("SELECT * FROM $table_name WHERE role ='admin'");   
foreach($query as $row)
{  
    //print_r($row);
    //if(($row['r_licence'] == 0 ) && (date("Y-m-d H:i:s",strtotime($row['time'].'+ 7 days'))))
    if($row['r_licence'] == 0)
    {
        $subject = 'Account Deleted';               
        $message = 'Hello'. $row['fname'].' '.$row['fname'];
        '<p>Due to the not purchasing any Tier/software, we have to permanently remove your account</p>
         <p>Having Username : '.$row['username'].' and Email : '.$row['email'].' from our system</p>';
        $to     = $row['email']; 
        $mail   = new PHPMailer();
        $mail->SMTPAuth   = true;                 
        $mail->Host       = "mail.xtrememarketingcode.com"; 
        $mail->Port       = 587;                    
        $mail->Username   = "info@xtrememarketingcode.com"; 
        $mail->Password   = "4Dm!n@9870";                    
        $mail->SetFrom($admin->email, ucwords($admin->fname.' '.$admin->lname));  
        $mail->Subject = $subject;
        $mail->MsgHTML($message); //$mail->Body    = $content;
        $mail->addAddress($to, ucwords($row->fname.' '.$row->lname));  
        if( $mail->Send()){
            $delete = $wpdb->delete('wp_register_user',array('id'=>$row['id']));
        }
        else{
            $delete = $wpdb->delete('wp_register_user',array('id'=>$row['id']));
        } 
    }
}
?>