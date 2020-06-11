<?php
include( get_template_directory() . '-child/admin/header.php' );
$user_id= $_SESSION['user_id'];
if(paidStatus($user_id)->tier2_status == 0) { 
    echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
}
global $wpdb;
$table_name = $wpdb->prefix.'ringless_voice_mail';

$list_id = $_GET['list_id'];
$detail =  $wpdb->get_row("SELECT * FROM $table_name WHERE id = $list_id",ARRAY_A);

$contacts = explode(",",$detail['contacts']);
// print_r($contacts);
$serial = 1;
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
					<div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                    <h4 style="text-align:right; margin-top:3%;">
                        <a href="<?php echo home_url();?>/dashboard/?page=ringless_voice_mail&sub-page=phone_list" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
                    </h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading">
									<h5><?php echo $detail['list_name'];?> Contacts 
										<small class="pull-right heading-earnings add-earning" style="margin-left:25px;">
										<font color="#007803"><a href="javascript:void(0);" data-toggle="modal" data-target="#add_new_number" >Add New Number</a></font></small>

                                        <small class="pull-right heading-earnings add-earning">
										<font color="#007803"><a href="javascript:void(0);" data-toggle="modal" data-target="#upload_csv_file">Upload File</a></font></small>

									</h5>
									<hr />
								</div>
								<table id="view_phone_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S No.</th>
											<th>All Contact</th>
											<th>Update Contact</th>
											<th>Delete Contact</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
                                            <th>S No.</th>
											<th>All Contact</th>
											<th>Update Contact</th>
											<th>Delete Contact</th>
										</tr>
									</tfoot>
									<tbody>
                                    <?php
                                         foreach($contacts as $contact)
                                            {
                                         if($contact != ''){ 
                                             ?>
										<tr>
											
											<td><?php echo $serial;?></td>
											<td><?php echo $contact;?></td>
											<td align="center">
                                            <span class="up_pop" id="<?php echo $contact;?>"><i class="fa fa-edit fa-1x camp-action"></i></span>
                                            </td>
											<td align="center">
												
												
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&del_contact=<?php echo $contact;?>" onclick="return confirm('Are You Sure');"><i class="fa fa-trash-o fa-1x camp-action"></i></span>
											</td>
										</tr>
                                        <?php }
                                        
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

    <!-- Add New Number Modal -->

    <div class="modal fade" id="add_new_number" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Number</h4>
            </div>
            <div class="modal-body">
               
                <form action="" method="post" id="ann_in_list">
                    <div class="form-group">

                        <input type="text" class="form-control" name="contact_number" placeholder="Enter Number">
                        
                    </div>
                    <input type="submit" class="btn btn-primary" name="save_name" value="Submit">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
            </div>
        </div>
    </div>
    <!-- END Add New Number Modal -->

    <!-- Add New Number Modal -->
        <div class="modal fade" id="upload_csv_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload CSV FILE</h4>
                </div>
                <div class="modal-body">
                
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">

                            <input type="file"  name="csv_file">
                            
                        </div>
                        <input type="submit" class="btn btn-primary" name="upload_csv" value="Submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    
                </div>
                </div>
            </div>
        </div>
    <!-- END Add New Number Modal -->

    <!-- Update Modal Box -->

    <div class="update_modalbox" style="display: none;">
        <div class="update_header">
            Update Contact
        </div>
            <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">

                            <input type="text"  name="contact_up" id="upconval" readonly style="width:100%;padding:3px;">
                            
                        </div>
                         <div class="form-group">

                            <input type="text"  name="new_contact_up" placeholder="Enter New Number" style="width:100%;padding:3px;">
                            
                        </div>
                        <input type="submit" class="btn btn-primary" name="update_con" value="Update">
            </form>
            <div class="updatefooter">
                
                    <span class="pull-right btn btn-default" id="clo_it">Close</span>
                
            </div>
        </div>

    <!-- END Update Modal Box -->

<?php
include( get_template_directory() . '-child/admin/footer.php' );

if(isset($_POST['save_name'])){

    $data = array(
        'contacts' => substr($_POST['contact_number'].','.$detail['contacts'],0,-1),
    );
    $where = array(
        'id'    => $list_id,
    );
    $wpdb->update( $table_name, $data, $where );
    echo '<script>window.location.href="'.$_SERVER['REQUEST_URI'].'"</script>';

}

/* Upload Csv Options*/

if(isset($_POST['upload_csv'])){

    
    $check_exe = explode(".", $_FILES['csv_file']['name']);
    
    if($check_exe[1] != 'csv'){
        echo '<script>alert("Please upload only CSV file")</script>';
    }
    else{
    
   $content = file_get_contents($_FILES['csv_file']['tmp_name']);
   $csvData = $content;
    $lines = explode(PHP_EOL, $csvData);
    $array = array();
    foreach ($lines as $line) {
        $array[] = str_getcsv($line);
    }
    echo '<pre>';
   
    $singleArray = array();

    foreach ($array as $key => $value){
        $singleArray[$key] = $value[0];
    }
    
   
  

        $a = count($singleArray);
        $new_array = array();
        $b = 0;
        for($i=1; $i < $a; $i++){
            $new_array[$b] =$singleArray[$i]; 
            $b++;
            
        }
        $new_contact = implode(",",$new_array);
        $loop_count = count($new_array);
        $con_array = explode(",",substr($new_contact,0,-1));
        
        
                
        $data = array(
            'contacts' => substr($new_contact.','.$detail['contacts'],0,-1),
        );
        $where = array(
            'id'    => $list_id,
        );
        $wpdb->update( $table_name, $data, $where );
        echo '<script>window.location.href="'.$_SERVER['REQUEST_URI'].'"</script>';
    

   

    }
}

if(isset($_POST['update_con'])){
    
    $new_contacts = array();
    $new_contacts = $contacts;
    $position = array_search($_POST['contact_up'], $new_contacts);
    $new_contacts[$position] = $_POST['new_contact_up'];

         $data = array(
        'contacts' => implode(",",$new_contacts),
        );
        $where = array(
            'id'    => $list_id,
        );
        $wpdb->update( $table_name, $data, $where );
        echo '<script>window.location.href="'.$_SERVER['REQUEST_URI'].'"</script>';

    
}

if(isset($_GET['del_contact'])){
    
    $new_contacts = array();
    $new_contacts = $contacts;
    $position = array_search($_GET['del_contact'], $new_contacts);
    unset($new_contacts[$position]);
    $data = array(
    'contacts' => implode(",",$new_contacts),
    );
    $where = array(
        'id'    => $list_id,
    );
    $wpdb->update( $table_name, $data, $where );

    echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=phone_list&sub_more_page=view_phone_list&list_id='.$list_id.'"</script>';

}
?>