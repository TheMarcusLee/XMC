<?php

include( get_template_directory() . '-child/admin/header.php' );
        global $wpdb;
        $table_name = $wpdb->prefix.'ringless_audio_list';
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM $table_name WHERE status = 1 AND registereduser_id =$user_id ";
        $result = $wpdb->get_results( $query,ARRAY_A);
        $serial = 1;

    

    // Add Audio File

    if(isset($_POST['up_audio_list'])){
   

        $audio_name = $_FILES['up_audio']['name'];
    
        $audio_list = explode(".",$audio_name);
    
        
    if($audio_list[1] == 'wav')
    {
        if(in_array($_FILES['up_audio']['name'],$result)){

            echo '<script>alert("Already Exist");</script>';
        }
        else{
            
            $dir = get_template_directory().'-child/admin/ringless-voicemail/audio_files/';

            $move = move_uploaded_file($_FILES['up_audio']['tmp_name'],$dir.$_FILES['up_audio']['name']);

            
            
            
            $data = array(
                'list_name' => $_POST['list_name'],
                'audio_file' => $_FILES['up_audio']['name'],  
                 'registereduser_id' => $_SESSION['user_id'],
                );
    
            $wpdb->insert($table_name,$data);
            echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=audio_list"</script>';
         }

    }
    else{
        echo '<script>alert("Upload wav format audio only");</script>';
    }
}





    // End Audio File





    if(isset($_GET['audio_action'])){


            // Delete Audio Code
        
        if($_GET['audio_action'] == 'delete'){
            $id = $_GET['audio_id'];

            $audio_name = "SELECT audio_file FROM $table_name WHERE id = $id";
            $get_audio_name = $wpdb->get_row($audio_name);
            $audio = $get_audio_name->audio_file;

            $audio_dir = get_template_directory().'-child/admin/ringless-voicemail/audio_files/'.$audio;
            unlink($audio_dir);
            $where = array(
                    'id' => $id,                        
                    );

            $wpdb->delete($table_name,$where);
            echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=audio_list";</script>';
        }   

            // End Delete Audio Code

    }



?>
<!-- Create List Model popup-->



<!-- End Create List Model popup-->

<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
                    <h4 style="text-align:right; margin-top:3%;">
                        <a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    </h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading">
									<h5>Audio List 
										<small class="pull-right heading-earnings add-earning">
										<font color="#007803"><a href="#" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i> Add Audio</a></font></small>
									</h5>
									<hr />
								</div>
								<table id="audio_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
											<th>List Name</th>
											<th>Audio</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
                                    <?php
                                    foreach($result as $data)
                                    {
                                    ?>
										<tr>
											<td><?php echo $serial;?></td>
											<td><?php echo $data['list_name'];?></td>
											
											<td><a href="javascript:void(0);" ><i class="fa fa-volume-up audio_file" audio_file="<?php echo get_template_directory_uri();?>-child/admin/ringless-voicemail/audio_files/<?php  echo $data['audio_file']?>" data-toggle="tooltip" data-placement="top" title="Play Audio" ></i></a> <?php  echo $data['audio_file']?></td>
											
											
											<td>
                                            
                                             <a href="<?php echo get_template_directory().'-child/admin/ringless-voicemail/audio_files/'.$data['audio_file'];?>" download class="btn btn-warning"> <i class="fa fa-cloud-download"></i></a>
                                             <a href="<?php echo $_SERVER['REQUEST_URI'];?>&audio_action=delete&audio_id=<?php echo $data['id'];?>" class="btn btn-danger"> <i class="fa fa-trash-o"></i> </a>
                                            
                                            </td>
											
										</tr>	
										<?php
                                        $serial++;
                                        } ?>
									</tbody>
								</table>
							</div>
						</div>	
						
					</div>
					
				</div>
			</div>
		</div>
	</section>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Audio</h4>
            </div>
            <div class="modal-body">
               
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="text">Enter List Name:</label>
                        <input type="text" class="form-control" name="list_name">
                        
                    </div>
                    <div class="form-group">
                        <label for="text">Upload Audio:</label>
                        <input type="file" class="form-control" name="up_audio">
                        
                    </div>
                    <input type="submit" class="btn btn-primary" name="up_audio_list" value="Submit">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
            </div>
        </div>
    </div>
<?php
include( get_template_directory() . '-child/admin/footer.php' );



    


    


?>