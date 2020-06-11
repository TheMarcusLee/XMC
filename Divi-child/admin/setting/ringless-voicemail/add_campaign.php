<?php

global $wpdb;
$table_name = $wpdb->prefix.'ringless_compaign_list';



include( get_template_directory() . '-child/admin/header.php' );
?>

<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                

                        <div class="setting-divs campaign-page">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div">
										<div class="row">
											<div class="col-md-7 col-sm-12 col-lg-7 col-xs-12">
												<div class="profile-box">
													<h3>Add Campaign</h3>
													<form action="" method="post" id="add_camp" style="padding-top:15px;">
                    <div class="form-group">
                        <label for="title">Campaign Title:</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>

                     <div class="form-group">
                        <label for="caller_id">Caller Id:</label>
                        <input type="text" class="form-control" name="caller_id" required>
                    </div>
                   
                    
                    <!-- <div class="form-group">
                        <label for="phone_list">Select Phone List:</label>

                        <select class="form-control" name="phone_list">
                        <option value="" selected>Select Phone List</option>
                        <?php
                        $table_phone = $wpdb->prefix.'ringless_voice_mail';
                        $phone_list_option = $wpdb->get_results("SELECT * FROM $table_phone",ARRAY_A);
                        foreach($phone_list_option as $option){
                           
                        ?>
                            <option value="<?php echo $option['id'];?>"><?php echo $option['list_name'];?></option>
                            
                        <?php } ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="phone_list">Select Subscriber Group:</label>

                        <select class="form-control" name="phone_list">
                        <option value="" selected>Select Subscriber Group List</option>
                        <?php
                        $table_phone = $wpdb->prefix.'subscriber_group';
                        $phone_list_option = $wpdb->get_results("SELECT * FROM $table_phone",ARRAY_A);
                        foreach($phone_list_option as $option){
                           
                        ?>
                            <option value="<?php echo $option['group_id'];?>"><?php echo ucwords($option['group_name']);?></option>
                            
                        <?php } ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="email">Select Audio List:</label>

                        <select class="form-control" name="audio_list">
                            <option value="" selected>Select Audio List</option>
                        <?php
                        $table = $wpdb->prefix.'ringless_audio_list';
                        $audio_list_option = $wpdb->get_results("SELECT * FROM $table",ARRAY_A);
                  
                        foreach($audio_list_option as $option){
                        ?>
                            <option value="<?php echo $option['audio_file'];?>"><?php echo $option['list_name'];?></option>
                            
                        <?php } ?>
                        </select>
                    </div>
                   
                    <div class="form-group" style="text-align:right;">
                        <button type="submit" class="btn btn-danger"> <i class="fa fa-save" style="margin-right: 10px;"></i> Submit</button>
                        <a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=compaigns" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
                    </div>
                 </form>
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

if(isset($_POST['title'])){
   $title            = $_POST['title'];
   $phone_list       = $_POST['phone_list'];
   $audio_list       = $_POST['audio_list'];
   $caller_id       = $_POST['caller_id'];
   
   
    
// 	var_dump($phone_number['contacts']);
   
   create_campaign($audio_list,$caller_id,$title,$phone_list);
   
}


?>