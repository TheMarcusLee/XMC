<?php
/*
 * Template Name: sales 1
 */
global $wp;
global $wpdb;
if(!isset($_GET['keyword'])){
	wp_redirect(home_url().'/dashboard/?page=capture_and_sales');
}

if(isset($_GET['provider'])){
	if($_GET['provider'] == 'email'){
		global $spdb;
		$resp_id = $_GET['responder'];		
		$single = $wpdb->get_row("SELECT * FROM wp_auto_responder WHERE responder_id = $resp_id");		
		$click = $single->no_clicks+1;
		$wpdb->update('wp_auto_responder', array( 'no_clicks' => $click),array('responder_id' => $resp_id) );
	}
}
if(isset($_POST['submit'])){
	
	global $wpdb;
	global $wp;
	$table = $wpdb->prefix.'leads';
			$data = array('leads_fname' => $_POST['fname'],
						'leads_lname' => $_POST['lname'],
						'leads_email' => $_POST['email'],
						'leads_email' => $_POST['email'],
						'leads_phonenumber' => $_POST['phonenumber'],
						'keyword' => $_GET['keyword'],
						);			
			$wp = $wpdb->insert($table,$data);
			//wp_redirect(home_url());
			
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url();?>/wp-content/themes/Divi-child/img/favicon.ico">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sales 1</title>

    <!-- Bootstrap -->
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/sales.css" rel="stylesheet" />
	  <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php
     $sales_1 = get_posts(array(
		'post_type'   => 'sales_page',
		'post_per_page' => -1,
		
	));
   
   foreach($sales_1 as $sales) {
		//print_r($sales);
		$sal = get_post_meta($sales->ID,'sales_page',true);
		if($sal == 1){ ?>		
	<section class="sales-page" style="background:url(<?php echo  get_template_directory_uri().'-child'; ?>/img/beach-fishing.jpg);background-size:cover;">
		<div class="sales-content">
			<div class="container">
				<div class="sales-logo">
					<a href="<?php echo home_url();?>"><img src="<?php echo  get_template_directory_uri().'-child'; ?>/img/logo-2.png" alt="..." /></a>
				</div>
				<div class="sale-icon">
					<h1 style="color:red;font-size:44px;font-weight: bold;font-style: italic;margin-top:13px; font-family: andale mono, times;"><?php echo $sales->post_title;?></h1>

					<!-- <img src="<?php echo  get_template_directory_uri().'-child'; ?>/img/signs.png" alt="..." /> -->
				</div>
				<div class="sales-video">
					<video controls width="640" height="360" autoplay>
						<source  src="<?php echo get_post_meta($sales->ID,'video_url',true);?>" type="video/mp4">
					</video>
				</div>
			</div>
		</div>
	</section>
	<section class="sales-button-one">
		<div class="conatiner text-center">
			<a href="<?php echo home_url();?>/registration/?username=<?php echo $_GET['keyword'];?>" class="sales-link-one"><?php echo get_post_meta($sales->ID,'button_text',true);?></a>
		</div>
	</section>
	<section class="sales-features">
		<div class="container">
			<div class="text-center"><h3><?php echo get_post_meta($sales->ID,'second_title',true);?></h3></div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
					<?php echo get_post_meta($sales->ID,'left_content',true);?>
				</div>
				<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
					<?php echo get_post_meta($sales->ID,'middle_content',true);?>
				</div>
				<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
					<?php echo get_post_meta($sales->ID,'right_content',true);?>
				</div>
			</div>
		</div>
	</section>
	<section class="sales-button-two">
		<div class="conatiner text-center">
			<a href="<?php echo home_url();?>/registration/?username=<?php echo $_GET['keyword'];?>" class="sales-link-two"><?php echo get_post_meta($sales->ID,'button_text',true);?></a>
		</div>
	</section>	
	<section class="copyright">
		<div class="container text-center">
			<p><?php echo get_post_meta($sales->ID,'footer',true);?></p>			
		</div>
	</section>
<?php }   }
	?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>