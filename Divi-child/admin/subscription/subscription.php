<?php
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
					<h4 style="text-align:right; margin-top:3%;">
						<a href="<?php echo home_url();?>/dashboard/" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
						</h4>
						<div class="table-div">
							<div class="table-box">
								<div class="table-heading subsciber-heading">
									<h5>Subscription 
										<small class="pull-right heading-earnings add-earning subsciber-link">
										<select class="">
											<option value="">Select Campaigns</option>
											<option value="">All Campaigns</option>
											<option value="1398">ECC</option>
											<option value="1416">Websites</option>
											<option value="1433">IWIN Optins</option>
											<option value="1434">Iwin List 2</option>
											<option value="1435">FaceBook</option>
											<option value="1712">Welcome to ECC</option>
											<option value="2139">Real View</option>
										</select>
										<font color="#007803">
										<a href="#"><i class="fa fa-telegram"></i> Send SMS</a>
										<a href="#"><i class="fa fa-share-square-o"></i> Export</a>
										<a href="#"><i class="fa fa-share-square-o"></i> CSV Sample</a>
										<a href="#"><i class="fa fa-cloud-upload"></i> Import</a>
										<a href="#"><i class="fa fa-trash"></i> Delete</a>
										</font></small>
									</h5>
									<hr />
								</div>
								<div class="table-responsive">
									
								<table id="subscription" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><input type="checkbox" /></th>
											<th>Name</th>
											<th>Phone Number</th>
											<th>Campaigns Title</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th><input type="checkbox" /></th>
											<th>Name</th>
											<th>Phone Number</th>
											<th>Campaigns Title</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#228B22">Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>	
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#228B22">Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#228B22">Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#D00013">Un-Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#228B22">Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#D00013">Block</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" /></td>
											<td>len Richmond</td>
											<td>+18454941599</td>
											<td><a href="#">View <code>4</code></a></td>
											<td><font color="#228B22">Active</font></td>
											<td>
												<a href="#"><i class="fa fa-cloud-download fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-edit fa-1x camp-action"></i></a>
												<a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a>
											</td>
										</tr>
									</tbody>
								</table>
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
?>