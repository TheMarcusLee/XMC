<?php
session_start();
global $wpdb;
if(isset($_GET['page'])){
    if($_GET['page'] == 'referral_expot'){    
        include( get_template_directory() . '-child/admin/referral_export.php' );
    }
    if($_GET['page'] == 'st'){
        $table = $wpdb->prefix.'leads';
        $status = $_GET['status'];    
        $id = $_GET['id'];
        if($status == 0){
            global $wpdb;
			global $wp;
            $table = $wpdb->prefix.'leads';
            $data = array('status' => 1);
            $wpdb->update($table,$data,array('leads_id' => $id));  	
			echo "<script>window.location.href='location.reload();';</script>";
            wp_redirect(home_url().'/dashboard/?option=leads');
            flash('msg',' <div class="alert alert-success border-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
            </button> Subscribe Succcesfully!
            </code>
           </div>');
        }elseif($status == 1){
            global $wpdb;        
			global $wp;
			$table = $wpdb->prefix.'leads';
            $data = array('status' => 0);
            $wpdb->update($table,$data,array('leads_id' => $id));   						
            flash('msg',' <div class="alert alert-success border-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
            </button> UnSubscribe Succcesfully!
            </code>
           </div>');
			echo "<script>window.location.href='location.reload();';</script>";
            wp_redirect(home_url().'/dashboard/?option=leads');
        }
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
						<a href="<?php echo home_url();?>/dashboard" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
					</h4>
                <div class="table-div">
                    <div class="table-box">
                        <div class="table-heading">
                            <h5>My Leads : <small class="pull-right heading-earnings add-earning">
                                <font color="#007803"><a href="<?php echo home_url();?>/dashboard/?option=referrals&page=referral_expot&action=lead_export">Export CSV</a></font></small></h5>
                            <hr />
                        </div>
                        <table id="phone_name_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>First Name</th>
									<th>Last Name</th>
                                    <th>EMAIL</th>
                                    <th>PHONE</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            
                            <tbody>
								<?php foreach($rows as $row){ 
									?>
                                <tr>
                                    <td><?php echo ucwords($row['leads_fname']);?></td>
									<td><?php echo ucwords($row['leads_lname']);?></td>
                                    <td><?php echo ucwords($row['leads_email']);?></td>
                                    <td><?php echo ucwords($row['leads_phonenumber']);?></td>
                                <td><?php if($row['status']==0){ ?> <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&page=st&status=<?php echo $row['status'];?>&id=<?php echo $row['leads_id'];?>"><span class="label label-success">Subscribe</span> </a><?php }else{ ?> 
                                    <a href="<?php echo $_SERVER['REQUEST_URI']; ?>&page=st&status=<?php echo $row['status'];?>&id=<?php echo $row['leads_id'];?>"><span class="label label-danger">Unsubscribe</span> <?php } ?> </a> </td>
                                    <td><?php echo ucwords($row['time']);?></td>
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