<?php
   global $wpdb;
   $table_name = $wpdb->prefix.'ringless_compaign_list';
   include( get_template_directory() . '-child/admin/header.php' );
   $user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier2_status == 0) { 
   	echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">		
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
							<div class="row">
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 col-md-2 col-lg-2 control-label">Type</label>
								  <div class="col-sm-8 col-lg-8 col-md-8 col-xs-12">
									 <ul class="list-inline">
										<li>
										   <label class="radio-inline">
										   <input type="radio" name="type" id="schedule1"  value="0" checked /> Scheduler
										   </label>
										</li>
										<li>
										   <label class="radio-inline">
										   <input type="radio" name="type" id="schedule2"  value="1"  /> Send Now
										   </label>
										</li>
									 </ul>
								  </div>
							   </div>
							</div>
                            <div class="dateShow"  >
								<div class="row">
									<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
										<div class="form-group">
											<div class="">
											<label for="inputEmail3" class="control-label">Start Date Time:</label>
												<input type="text" class="form-control remove_requ" name="date" id="datepicker"  readonly required placeholder="DD/MM/YY" />
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
										<div class="form-group">
                                        <label for="inputEmail3" class="control-label">End Date Time:</label>
												<input type="text" class="form-control remove_requ" name="time" id="datepicker2" readonly  placeholder="DD/MM/YY" />
										<!-- <label for="inputPassword3" class="control-label">Schedule Time:</label>
										<select class="form-control remove_requ" name="time" required>
												<option value="">- Select Time -</option>
												<option value="00:00">12:00 AM</option>
												<option value="01:00">01:00 AM</option>
												<option value="02:00">02:00 AM</option>
												<option value="03:00">03:00 AM</option>
												<option value="04:00">04:00 AM</option>
												<option value="05:00">05:00 AM</option>
												<option value="06:00">06:00 AM</option>
												<option value="07:00">07:00 AM</option>
												<option value="08:00">08:00 AM</option>
												<option value="09:00">09:00 AM</option>
												<option value="10:00">10:00 AM</option>
												<option value="11:00">11:00 AM</option>
												<option value="12:00">12:00 PM</option>
												<option value="13:00">01:00 PM</option>
												<option value="14:00">02:00 PM</option>
												<option value="15:00">03:00 PM</option>
												<option value="16:00">04:00 PM</option>
												<option value="17:00">05:00 PM</option>
												<option value="18:00">06:00 PM</option>
												<option value="19:00">07:00 PM</option>
												<option value="20:00">08:00 PM</option>
												<option value="21:00">09:00 PM</option>
												<option value="22:00">10:00 PM</option>
												<option value="23:00">11:00 PM</option>
												</select> -->
										</div>
									</div>
								</div>
                                
                                
                            </div>
                           <div class="form-group">
                              <label for="title">Campaign Title:</label>
                              <input type="text" class="form-control" name="title" required>
                           </div>
                           <div class="form-group">
                              <label for="caller_id">Caller Id:</label>
                              <input type="text" class="form-control" name="caller_id" required>
                           </div>
                           <div class="form-group">
                              <label for="phone_list">Select Phone List:</label>
                              <select class="form-control" name="phone_list">
                                 <option value="" selected>Select Phone List</option>
                                 <?php
                                    $table_phone = $wpdb->prefix.'ringless_voice_mail';
                                    $phone_list_option = $wpdb->get_results("SELECT * FROM $table_phone WHERE registereduser_id = $user_id",ARRAY_A);
                                    foreach($phone_list_option as $option){
                                    
                                    ?>
                                 <option value="<?php echo $option['id'];?>"><?php echo $option['list_name'];?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <?php				
                              $table_name = $wpdb->prefix.'twilio_detail';				
                              $user_id = $_SESSION['user_id'];
                              $campaign_value = $wpdb->get_row("SELECT * FROM $table_name WHERE registereduser_id = $user_id",ARRAY_A);	
                                          
                              if(count($campaign_value) > 0){ ?>
                           <div class="form-group">
                              <label for="phone_list">Select Campaign:</label>
                              <select class="form-control" name="camp_list">
                                 <option value="" selected>Subscribers</option>
                                 <?php 
                                    $camp_table_name = $wpdb->prefix.'svb_campaings';
                                    $camp_list = $wpdb->get_results("SELECT * FROM $camp_table_name WHERE registereduser_id = $user_id ");
                                    foreach($camp_list as $list){
                                    ?>
                                 <option value="<?php echo $list->id;?>"><?php echo $list->title;?></option>
                                 <?php } ?>                          
                              </select>
                           </div>
                           <?php } ?>
                           <div class="form-group">
                              <label class="control-label">Enter Phone Numbers:</label>                    
                              <textarea class="form-control" name="enter_phone" rows="5" ></textarea>
                              <span class="label label-danger" style="margin-top:5px;" >Enter Phone Number, One per line.</span>
                              <!-- <small class="pull-right labeel label-danger " style="margin-top:5px"> </small> -->                    
                           </div>
                           <div class="form-group">
                              <label for="email">Select Audio List:</label>
                              <select class="form-control" name="audio_list" required>
                                 <option value="" selected>Select Audio List</option>
                                 <?php
                                    $table = $wpdb->prefix.'ringless_audio_list';
                                    $audio_list_option = $wpdb->get_results("SELECT * FROM $table WHERE registereduser_id = $user_id",ARRAY_A);
                                    
                                    foreach($audio_list_option as $option){
                                    ?>
                                 <option value="<?php echo $option['audio_file'];?>"><?php echo $option['list_name'];?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="form-group" style="text-align:right;">
                              <button type="submit" class="btn btn-danger"> <i class="fa fa-save" style="margin-right: 10px;"></i> Submit</button>
                              <a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=campaigns" class="btn btn-danger"> <i class="fa fa-times"></i>  Cancel</a>
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
      $caller_id        = $_POST['caller_id'];
      $str              = $_POST['enter_phone'];
      $camp_list        = $_POST['camp_list'];
      $tpe              = $_POST['type'];
      $date             = $_POST['date'];
      $time             = $_POST['time'];             
   // 	var_dump($phone_number['contacts']);
      
      //create_campaign($audio_list,$caller_id,$title,$phone_list,$str,$camp_list,$type,$date,$time);
      create_campaign($_POST);      
   }      
   ?>   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"></script>
   <script>   	

    jQuery('#datepicker').datetimepicker({                        
            minDate:0,            
            disabled:"true",
            stepHour: 2,
            stepMinute: 10,
            stepSecond: 10
        });
        jQuery('#datepicker2').datetimepicker({                        
            minDate:0,            
            disabled:"true",
            stepHour: 2,
            stepMinute: 10,
            stepSecond: 10
        });
		var select = jQuery(".remove_requ");
        jQuery("#schedule2").click(function () {            
					  jQuery(".btnSend").text("Send");
            jQuery(".dateShow").hide();
						select.prop('required', false);
        });
        jQuery("#schedule1").click(function () {
					jQuery(".btnSend").text("Save");
            jQuery(".dateShow").show();
						select.prop('required', true);
        });
        jQuery("#choose_no1").click(function () {
            jQuery(".noShow").show();
            jQuery(".noshow1").hide();
        });
        jQuery("#choose_no2").click(function () {
            jQuery(".noShow").hide();
            jQuery(".noshow1").show();
        });
	</script>