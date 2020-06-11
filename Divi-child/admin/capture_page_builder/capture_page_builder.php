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
							
					<script type="text/javascript" src="<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckeditor/ckeditor.js"></script>
    				<script type="text/javascript" src="<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/ckfinder.js"></script>
						
							<div class="table-box">
								<div class="table-heading">
									<h5>Capture and Page Builder</h5>
									<span class="btn btn-info" id="page_preview">Preview Page</span>
									<span class="btn btn-info" id="Capture">Capture</span>
									<span class="btn btn-info" id="Save Page">Save Page</span>
								</div>
								<div class="page_buider_form">
								<div class="page_view">
								
								</div>
								<div class="page_build">
									<form action="" method="post">
									<div class="form-group">
											<textarea name="buider_media" id="buider_media" style="width:100%;"></textarea>
									</div>
								
								</div>	
											
									</form>
								</div>
							</div>

							<script type="text/javascript">
								var editor = CKEDITOR.replace( 'buider_media', {
									filebrowserBrowseUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/ckfinder.html',
									filebrowserImageBrowseUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/ckfinder.html?type=Images',
									filebrowserFlashBrowseUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/ckfinder.html?type=Flash',
									filebrowserUploadUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
									filebrowserImageUploadUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
									filebrowserFlashUploadUrl : '<?php echo get_template_directory_uri();?>-child/admin/capture_page_builder/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
								});
								CKFinder.setupCKEditor( editor,{
									language: 'html',
									uiColor: '#9AB8F3',
								} );
								
								
								</script>
					</div>
                    </div>
                </div>
            </div>
        </div>
		
</section>
<?php
include( get_template_directory() . '-child/admin/footer.php' );
?>

<script>
	
	$("#page_preview").click(function(){

		var description = CKEDITOR.replace( 'buider_media' );
        alert( CKEDITOR.instances.description.getData());
		
	});		
</script>
<?php

if(isset($_POST['buider_data'])){
	$editor_data = htmlentities($_POST[ 'buider_media' ]);

	$b = html_entity_decode($editor_data);
	$x =  stripslashes($b);
	global $wpdb;
	$table = $wpdb->prefix.'cpb_buidlder';
	$data = array(
		'builder_code' => $x,
	);
	$wpdb->insert($table,$data);
}
?>