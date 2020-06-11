<?php
global $wpdb;
$user_id= $_SESSION['user_id'];
   if(paidStatus($user_id)->tier1_status == 0) { 
   		echo '<script>window.location.href="'.home_url().'/dashboard/";</script>';	
   }
include( get_template_directory() . '-child/admin/header.php' );
?>
<style>

div#capture1_sales .modal-header {
    padding: 8px 15px !important;
    background: #333 !important;
    color: #fff !important;
}
div#capture2_sales .modal-header {
    padding: 8px 15px !important;
    background: #333 !important;
    color: #fff !important;
}
div#capture3_sales .modal-header {
    padding: 8px 15px !important;
    background: #333 !important;
    color: #fff !important;
}
.modal-header .close {
    margin-top: 0px;
    opacity: 1;
    color: #fff;
}
.sidebar {
    background: #333;
    color: #fff;
    min-height: 921px;
}
</style>
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
                    <div class="setting-divs" style="margin-top: 40px;">
							 <!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="profile">
									<div class="profile-div links-div">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
												<div class="profile-box link-boxes">
													<h3>Capture Pages</h3>
													<div class="row">
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/capture_and_sales/screenshots/capture-1.png" alt="Capture Image" class="full-width" />																	
																</div>
																<div class="capture-data">
																	<input type="url" class="form-control" id="capture1" value="https://www.xtrememarketingcode.com/capture-1/?keyword=<?php echo $_SESSION['keyword']; ?>&sales=1" />
																	<div class="text-center"><button class="copylink" onclick="capturecopy(1);">COPY LINK</button>
																	<button class="btn btn-danger"  data-toggle="modal" data-target="#capture1_sales" style = "margin-top:10px;margin-left:9px;">SELECT</button></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/capture_and_sales/screenshots/capture-2.png" alt="Capture Image" class="full-width" />
																	
																</div>
																<div class="capture-data">
																	<input type="url" class="form-control" id="capture2" value="https://www.xtrememarketingcode.com/capture-2/?keyword=<?php echo $_SESSION['keyword']; ?>&sales=1" />
																	<div class="text-center"><button class="copylink" onclick="capturecopy(2);">COPY LINK</button>
																	<button class="btn btn-danger" style = "margin-top:10px;margin-left:9px;"  data-toggle="modal" data-target="#capture2_sales">SELECT</button></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/capture_and_sales/screenshots/capture-3.png" alt="Capture Image" class="full-width" />
																	
																</div>
																<div class="capture-data">
																	<input type="url" class="form-control" id="capture3" value="https://www.xtrememarketingcode.com/capture-3/?keyword=<?php echo $_SESSION['keyword']; ?>&sales=1" />
																	<div class="text-center"><button class="copylink" onclick="capturecopy(3);">COPY LINK</button>
																	<button class="btn btn-danger"  data-toggle="modal" data-target="#capture3_sales" style = "margin-top:10px;margin-left:9px;">SELECT</button></div>
																</div>
															</div>
														</div>																												
													</div>
													
													<h3>Sales Pages</h3>
													<div class="row">
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/capture_and_sales/screenshots/sales-1.png" alt="Capture Image" class="full-width" />
																	
																</div>
																<div class="capture-data">
																	<input type="url" class="form-control" value="https://www.xtrememarketingcode.com/sales-1/?keyword=<?php echo $_SESSION['keyword'];?>" id="sales1" />
																	<div class="text-center"><button class="copylink" onclick="salescopy(1);">COPY LINK</button></div>
																</div>
															</div>
														</div>
														<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
															<div class="capture-box">
																<div class="capture-image">
																	<img src="<?php echo home_url();?>/wp-content/themes/Divi-child/admin/capture_and_sales/screenshots/sales-2.png" alt="Capture Image" class="full-width" />
																	
																</div>
																<div class="capture-data">
																	<input type="url" class="form-control" value="https://www.xtrememarketingcode.com/sales2/?keyword=<?php echo $_SESSION['keyword'];?>" id="sales2" />
																	<div class="text-center"><button class="copylink" onclick="salescopy(2);">COPY LINK</button></div>
																</div>
															</div>
														</div>														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							  </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- sales modal box -->
 <!-- capture 1 Modal -->
 <div class="modal fade" id="capture1_sales" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Sales page</h4>
        </div>
        <div class="modal-body">
          <input type="radio" name="sales" id="sales1" value="sales1" onclick="capture1sales(this.value);"> https://www.xtrememarketingcode.com/sales-1/?keyword=<?php echo $_SESSION['keyword'];?> </br>
          <input type="radio" name="sales" id="sales2" value="sales2" onclick="capture1sales(this.value);"> https://www.xtrememarketingcode.com/sales2/?keyword=<?php echo $_SESSION['keyword'];?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
   <!-- capture 2 Modal -->
 <div class="modal fade" id="capture2_sales" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Sales page</h4>
        </div>
        <div class="modal-body">
          <input type="radio" name="sales" id="sales1" value="sales1" onclick="capture2sales(this.value);"> https://www.xtrememarketingcode.com/sales-1/?keyword=<?php echo $_SESSION['keyword'];?> </br>
          <input type="radio" name="sales" id="sales2" value="sales2" onclick="capture2sales(this.value);"> https://www.xtrememarketingcode.com/sales2/?keyword=<?php echo $_SESSION['keyword'];?> 
        </div>
				<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
   <!-- capture 3 Modal -->
 <div class="modal fade" id="capture3_sales" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Sales page</h4>
        </div>
        <div class="modal-body">
          <input type="radio" name="sales" id="sales1" value="sales1" onclick="capture3sales(this.value);"> https://www.xtrememarketingcode.com/sales-1/?keyword=<?php echo $_SESSION['keyword'];?>  </br>
          <input type="radio" name="sales" id="sales2" value="sales2" onclick="capture3sales(this.value);"> https://www.xtrememarketingcode.com/sales2/?keyword=<?php echo $_SESSION['keyword'];?> 
        </div>
				<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- end sales box -->
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>
<script>
var $ = jQuery;
function capturecopy(value) {
  /* Get the text field */
  var copyText = document.getElementById("capture"+value);	
  /* Select the text field */
  copyText.select();
  /* Copy the text inside the text field */
  document.execCommand("Copy");
  /* Alert the copied text */
//   alert("Copied the text: " + copyText.value);
}
function salescopy(value) {
  /* Get the text field */
  var copyText = document.getElementById("sales"+value);	
  /* Select the text field */
  copyText.select();
  /* Copy the text inside the text field */
  document.execCommand("Copy");
  /* Alert the copied text */
//   alert("Copied the text: " + copyText.value);
}
// capture 1 sales 
function capture1sales(value){
	if(value== 'sales1'){			
		var c1 = $('#capture1').val();		
		var  text = c1.substring(0, c1.lastIndexOf('&'));		
		$('#capture1').val(text + '&sales=1');		
	}
	if(value== 'sales2'){
		var c1 = $('#capture1').val();		
		var  text = c1.substring(0, c1.lastIndexOf('&'));		
		$('#capture1').val(text + '&sales=2');		
	}
}
// capture 2 sales 
function capture2sales(value){
	if(value== 'sales1'){					
		var c2 = $('#capture2').val();		
		var  text = c2.substring(0, c2.lastIndexOf('&'));		
		$('#capture2').val(text + '&sales=1');		
	}
	if(value== 'sales2'){
		var c2 = $('#capture2').val();		
		var  text = c2.substring(0, c2.lastIndexOf('&'));		
		$('#capture2').val(text + '&sales=2');	
	}
}
// capture 3 sales 
function capture3sales(value){
	if(value== 'sales1'){					
		var c3 = $('#capture3').val();		
		var  text = c3.substring(0, c3.lastIndexOf('&'));		
		$('#capture3').val(text + '&sales=1');	
	}
	if(value== 'sales2'){
		var c3 = $('#capture3').val();		
		var  text = c3.substring(0, c3.lastIndexOf('&'));		
		$('#capture3').val(text + '&sales=2');		
	}
}
</script>