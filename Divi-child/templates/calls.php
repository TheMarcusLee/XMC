<?php 
/*
*Template Name: Make Call
*/
echo '<?xml version="1.0" encoding="UTF-8"?>';
header('content-type: text/xml');
$id = $_GET['id'];
?>

<?php if($id != NULL){ 
    global $wpdb;      
    $table = $wpdb->prefix.'svb_recent_voice'; 
    $get = $wpdb->get_row("SELECT * FROM $table WHERE recent_voice_id = $id",ARRAY_A); 
    if($get['call_type'] == 0){ 
        $audio = get_template_directory_uri().'-child/admin/sms_voice_broadcast/audio_files/'.$get['media_loc']; ?>
        <Response>
             <Play><?php echo $audio; ?></Play>
        </Response>        
         <?php }elseif($get['call_type'] == 1){ ?> 
        <Response>
             <Say><?php echo $get['voice_text'];?>.</Say>
        </Response>   
        <?php } 
}
?>