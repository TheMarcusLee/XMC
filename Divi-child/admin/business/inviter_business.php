<?php

global $wpdb;
$table_name = $wpdb->prefix.'ringless_compaign_list';

$user_id= $_SESSION['user_id'];
$table = $wpdb->prefix.'register_user';
$refrer_name = $wpdb->get_row("SELECT * FROM $table WHERE id = $user_id");
$get_bus = $wpdb->get_row("SELECT * FROM $table WHERE username='".$refrer_name->refrencename."'");
include( get_template_directory() . '-child/admin/header.php' );
?>
	
	<style>
		.iframe-video iframe{width:100%;height: 300px;}
		
        .small-video {
            background: transparent;
            padding: 33px 0px 30px;
            margin-top: 65px;
        }
		.small-video h3 {
			font-size: 26px;
			color: #333;
			line-height: 30px;
			margin-bottom: 17px;
			margin-top: 25px;
		}
		.small-video p {
			font-size: 15px;
			color: #333;
		}
		.get-access {
            color: rgb(255, 255, 255);
            background-color: rgb(226, 5, 28);
            border-color: rgb(227, 6, 29);
            border-radius: 5px;
            text-shadow: 1px 1px 0px rgb(74, 74, 74);
            background-image: none;
            font-size: 30px;
            font-weight: bold;
            min-width: 338px;
            min-height: 57px;
            width: auto;
            height: auto;
            display: inline-block;
            text-align: center;
            line-height: 57px;
            margin-top: 10px;
        }
        .get-access:hover{color:#fff;opacity:0.7}
	</style>
<section class="dashboard">
		<div class="container-fluid">
			<div class="dashboard-box no-padding-left no-padding-top no-padding-bottom no-margin-top">
				
				<div class="row">
                
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 no-padding-left">
                        <?php include( get_template_directory() . '-child/admin/sidebar.php' ); ?>
                </div>                
                <div class="col-md-9 col-sm-9 col-lg-9 col-xs-12">
				<?php if($refrer_name->username != 'easy') { 
                    if( $get_bus->custom_video == '' || $get_bus->my_button_text == "" || $get_bus->my_custom_link == "") { ?>
                <section class="small-video">
                    <div class="">
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                                <div class="iframe-video">
									<h3 class="text-info">You don't have a inviter business</h3>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
                               
                            </div>
                        </div>
                    </div>
                </section>
                <?php } else{ ?>
                <section class="small-video">
                    <div class="">
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                                <div class="iframe-video">
                                <?php //echo $get_bus->custom_video; ?>
                                    <iframe src="<?php echo $get_bus->custom_video; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            </div>
                            
                            <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
                                <h3><?php echo ucwords($get_bus->custom_video_text); ?></h3>
                                <p><?php echo ucwords($get_bus->custom_description); ?></p>
                                
                                <a href="<?php echo $get_bus->my_custom_link; ?>" target="_blank" class="get-access"><?php echo $get_bus->my_button_text; ?></a>
                            </div>
                        </div>
                    </div>
                </section>
                <?php } 
            }elseif($refrer_name->username == 'easy'){  ?>
				<section class="small-video">
                    <div class="">
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                                <div class="iframe-video">
									<h3 class="text-info">You don't have a inviter business</h3>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
                               
                            </div>
                        </div>
                    </div>
                </section>
				<?php } ?>
                </div>
				
				
             </div>
    </div>
    </div>
    </div>
    </section>
    <?php
    include( get_template_directory() . '-child/admin/footer.php' );
    ?>