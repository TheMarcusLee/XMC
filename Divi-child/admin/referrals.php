<?php
if(isset($_GET['page'])){
    if($_GET['page'] == 'referral_expot'){    
        include( get_template_directory() . '-child/admin/referral_export.php' );
    }
}else{
include( get_template_directory() . '-child/admin/header.php' );

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
                            <h5>My Referrals: <small class="pull-right heading-earnings add-earning">
                                <font color="#007803"><a href="<?php echo home_url();?>/dashboard/?option=referrals&page=referral_expot&action=export">Export CSV</a></font></small></h5>
                            <hr />
                        </div>
                        <table id="phone_name_list" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>                                    
                                    <th>Email</th>
                                    <th>Phone</th>                                    
                                    <th>Keyword</th>
                                    <th>Tier 1</th>
                                    <th>Tier 2</th>
                                    <th>Date</th>
                                </tr>
                            </thead>                            
                            <tbody>
                            <?php global $wpdb;
                                  $table_name = $wpdb->prefix.'register_user'; 
                                  $my_key = $_SESSION['keyword'];
                                  $result = $wpdb->get_results("SELECT * FROM $table_name WHERE refrencename= '$my_key'",ARRAY_A);
                                 
                                  foreach($result as $row) { ?>
                                <tr>
                                    <td><?php echo ucwords($row['fname']);?> <?php echo ucwords($row['lname']);?></td>
                                    <!-- <td><?php echo ucwords($row['lname']);?></td> -->
                                    <td><?php echo $row['email'];?></td>
                                    <td><?php echo $row['mobile'];?></td>                                    
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php if($row['tier1_status'] == 0) { ?> <span class="label label-danger">Unpaid</span><?php }else{ ?><span class="label label-success">Paid</span><?php } ?></td>
                                    <td><?php if($row['tier2_status'] == 0) { ?> <span class="label label-danger">Unpaid</span><?php }else{ ?><span class="label label-success">Paid</span><?php } ?></td>
                                    <td><?php echo date("Y/m/d",(strtotime($row['time'])));?></td>
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