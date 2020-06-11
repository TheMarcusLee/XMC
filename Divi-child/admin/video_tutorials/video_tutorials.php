<?php
if(isset($_GET['page'])){
	if($_GET['page']=='contact'){
		include( get_template_directory() . '-child/admin/video_tutorials/contact.php' );		
	}
}else{
include( get_template_directory() . '-child/admin/header.php' );
global $wpdb;
?>
<style>
.profile-box h3 {
	margin-top: 0px;
	font-size: 18px;
	border-bottom: 1px solid #ccc;
	padding-bottom: 20px;
	position: relative;
	margin-bottom: 20px;
}
.capture-data b{margin-bottom: 5px;}
.capture-box {
    margin-bottom: 30px;
    min-height: 278px;
    max-height: 278px;
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
                    <div class="setting-divs" style="margin-top: 40px;">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="profile">
                                        <div class="profile-div links-div">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                    <div class="profile-box link-boxes">
                                                        <h3>
															Tutorials
															<small class="pull-right heading-earnings add-earning subsciber-link">
																<font color="#007803">
																	
																</font>
															</small>
														</h3>
                                                        <div class="row">

                                                        <?php
                                                        
                                                     $tutorials = array(
                                                         'post_type'   => 'video_tutorials',      
                                                         'post_per_page' => -1,
                                                         'orderby' => 'menu_order',                                                            
                                                         'order'   => 'ASC',                                                        
                                                     );
                                                   
                                                    //$new_arr = array_push($tutorials, '1');
                                                    //echo "<pre>";  print_r($tutorials);                                                    
                                                    $loop = new WP_Query( $tutorials );
                                                    
                                                    while ( $loop->have_posts() ) { 

                                                        //$id = the_id();
                                                        $loop->the_post();                                                      
                                                    // endwhile;
                                                    // foreach($tutorials as $tutorial){
                                                        
                                                       ?>
                                                            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
                                                                <div class="capture-box">
                                                                    <div class="capture-image">
                                                                        <div class="video-box" class="full-width">
                                                                            <video controls> 
                                                                            <source class="video_source" src="<?php echo get_post_meta($id,'video_url',true);?>" type="video/mp4">
                                                                            </video>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="capture-data">
                                                                        <b><?php echo the_title();?></b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        <?php }  ?>


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
<!-- Video Popup -->
<div class="modal fade" id="videoPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Modal title</h4>
		  </div>
		  <div class="modal-body">
			<div class="video-popup">
				<video controls controlsList="nodownload"> 
				  <source class="popup_video" src="http://localhost/xtrem/wp-content/uploads/2018/03/video-1.mov" type="video/mp4">
				</video>
			</div>
		  </div>
		</div>
	  </div>
	</div>
<!-- Video Popup -->
<?php
include( get_template_directory() . '-child/admin/footer.php' );
}
?>
<script>
var $ = jQuery;
jQuery(".video_pop").click(function(){
    var source = $(this).parent().parent().find(".video_source").attr("src");
    $(".popup_video").attr("src",source);
});
</script>