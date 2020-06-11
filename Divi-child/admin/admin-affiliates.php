<?php
session_start();
global $wpdb;
global $wp;
if($_SESSION['role']!= 'admin') { 
    wp_redirect(home_url());
}
$table = $wpdb->prefix.'register_user';
if(isset($_GET['page'])){
    if($_GET['page'] == 'referral_expot'){    
        include( get_template_directory() . '-child/admin/referral_export.php' );
    }
}else{
include( get_template_directory() . '-child/admin/header.php' );

?>
<?php
// $con = mysqli_connect("localhost","s63","qIpNApiJRXlcGwFQb7y6cVmRNONtgq4VFqGdYbvb1jvRuctiXFm","s63");

// // Check connection
// if (mysqli_connect_errno())
//   {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   }
//   $my_key = $_SESSION['keyword'];
// $sql="SELECT * FROM wp_refrerral_detail WHERE refreral_keyword = '$my_key'";

//$result=mysqli_query($con,$sql);
// Associative array
$key_word = $_SESSION['keyword'];
$rows = $wpdb->get_results("SELECT * FROM wp_leads WHERE keyword='$key_word'",ARRAY_A);	

if($_GET['action'] == 'delete'){
        
	$delete = $wpdb->delete($table,array('id'=>$_GET['id']));

	if($delete == true){
	   flash('msg',' <div class="alert alert-success border-success">
	   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	   <i class="icofont icofont-close-line-circled"></i>
	   </button> Deleted Succcesfully!
	   </code>
	  </div>');
	  
	}
	else{
		
	   // echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
		// flash('no_delete','<div class="msg" style="background-color:#f0c3c1;">
		//             Action Could Not Complete
		//         </div>');
	}
}
?>

<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
							<?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
					</div>
					<div class="col-md-9 col-lg-9 col-sm-9 col-xs-12">
					
					<h4 style="text-align:right; margin-top:3%;">
						<?php if($_SESSION['role'] == 'admin') { ?>
						<a href="<?php echo home_url();?>/my-dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						<?php }else{ ?>
							<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						<?php } ?>
					</h4>
					<?php flash( 'msg' ); ?>
                    <div class="table-box">
								<div class="">
									<div class="table-heading">
									</div>
									<table id="phone_name_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>Name</th>
										<th>Email Id</th>
										<th>Affilate Url</th>
										<th>Date</th>
										<th>Action</th>
										</tr>
									</thead>									
									<tbody>
											<?php
											$register_user_list = $wpdb->get_results("SELECT * FROM $table");
											foreach($register_user_list as $list){
											?>
											<tr>
											<td width="5"><?php echo $list->fname.' '.$list->lname; ?></td>
											<td ><?php echo $list->email; ?></td>
											<td ><a href="<?php echo home_url().'/registration/?username='.$list->refrencename; ?>"><?php echo home_url().'/registration/?username='.$list->refrencename; ?></a></td>
											<td><?php echo date('m-d-Y',strtotime($list->time)); ?></td>
											<td>
											<a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->id;?>&action=delete" onclick="return confirm('Are You Sure')"><i class="fa fa-trash"></i></a>
											<a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->id;?>&action=view" ><span class="dashicons dashicons-visibility"></span></a>
											<?php if($list->status == 1) {?>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->id;?>&action=disable" title="disable"><span class="dashicons dashicons-thumbs-down"></span></a>
											<?php }
											
											else{
												?>
												<a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->id;?>&action=active" title="active"><span class="dashicons dashicons-thumbs-up"></span></a>
												<?php
											}?>
										</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>	
            </div>
            </div>
        </div>
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
}
?>