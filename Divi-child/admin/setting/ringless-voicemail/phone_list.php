<?php
if(isset($_GET['sub_more_page'])){

    if($_GET['sub_more_page'] == 'view_phone_list'){
        include( get_template_directory() . '-child/admin/ringless-voicemail/view_phone_list.php' );
    }

}
else{
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
$table_name = $wpdb->prefix.'ringless_voice_mail';

if(isset($_GET['phone_action'])){
	$id = $_GET['list_id'];

	$where = array(
				'id' => $id,		
			);
	$wpdb->delete($table_name,$where);
	
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=phone_list"</script>';
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
									<h5>Contact Groups 
										<small class="pull-right heading-earnings add-earning">
										<font color="#007803"><a href="#" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i> Create Group</a></font></small>
									</h5>
									<hr />
								</div>
								<table id="phone_name_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>S. No.</th>
											<th>Group Name</th>
											<th>Number of contacts</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
                                    <?php
                                       $user_id = $_SESSION['user_id'];
                                            $query = "SELECT * FROM $table_name WHERE status = 1 AND registereduser_id = $user_id";
                                            $result = $wpdb->get_results( $query,ARRAY_A);
                                            $serial = 1;
                                            foreach($result as $data)
                                            {
                                                $count_contact = explode(',',$data['contacts']);
                                            
                                                
                                        ?>
										<tr>
											
											<td><?php echo $serial;?></td>
											<td><?php echo $data['list_name']?></td>
											<td><?php  if($data['contacts'] == '') { echo '0';} 
											else{ 
												
												echo count($count_contact); 
												
											}
											?></td>
											<td>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&sub_more_page=view_phone_list&list_id=<?php echo $data['id'];?>"><i class="fa fa-eye fa-1x camp-action"></i></a>
												
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&phone_action=del_name&list_id=<?php echo $data['id'];?>"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
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
                <h4 class="modal-title" id="myModalLabel">Create Group</h4>
            </div>
            <div class="modal-body">
               
                <form action="" method="post" id="phone_list_create">
                    <div class="form-group">
                        <label for="text">Enter Group Name:</label>
                        <input type="text" class="form-control" name="list_name">
                        
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
<?php
include( get_template_directory() . '-child/admin/footer.php' );

if(isset($_POST['save_name'])){

    global $post;

    $table = $wpdb->prefix.'ringless_voice_mail';
    $data = array(
				'list_name' => $_POST['list_name'],
				'registereduser_id'=>$_SESSION['user_id']
                  
            );
    $wpdb->insert( $table, $data );
	echo '<script>window.location.href="'.home_url().'/dashboard/?page=ringless_voice_mail&sub-page=phone_list"</script>';
}
}
?>