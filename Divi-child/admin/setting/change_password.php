<?php
global $wpdb;
global $wp;
if(isset($_POST['update_password'])){

	$old_password = $_POST['old_pass'];
	$new_password = $_POST['new_pass'];
	$confirm_password = $_POST['confirm_pass'];
    $id = $_POST['change_id'];
	if($old_password != '' && $new_password != '' && $confirm_password != '' && $new_password == $confirm_password){

		if($old_password != $user_detail['password']){
            // echo '<script>$("#old_pass").show();</script>';
            wp_redirect(home_url().'/dashboard/?option=settings&msg=0');
		}
		else{
			$data = array(
						'password' => $confirm_password,
			);
			$where = array(
				'id'	=> $id,
			);
			$res = $wpdb->update($table_name,$data,$where);
			if($res == true){
				// echo '<script>$("#update_password").show();</script>';
				if($_SESSION['role'] == 'admin'){
					wp_redirect(home_url().'/my-dashboard/?option=settings&umsg=1');					
				}else{ 
					wp_redirect(home_url().'/dashboard/?option=settings&umsg=1');
				}
                
			}
		}
	}
}
?>