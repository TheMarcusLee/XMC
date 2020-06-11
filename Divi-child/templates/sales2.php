<?php
/*
 * Template Name: sales 2
 */
global $wp;
if(!isset($_GET['keyword'])){
	wp_redirect(home_url().'/dashboard/?page=capture_and_sales');
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
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url();?>/wp-content/themes/Divi-child/img/favicon.ico">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sales 2</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/sales.css" rel="stylesheet" />
	  <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	.sales-right i{width: 25px;}
		.sales-right p {
			padding-left: 0px;
		}
	</style>
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
		if($sal == 2){ ?>	
	<section class="sales-inner-page">
		<div class="top-sale">
			<div class="container text-center">
			<h1><?php echo $sales->post_title; ?><h1>
			</div>
		</div>
		<div class="inner-start">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8 col-lg-8 col-xs-12">						
						<div class="inner-sales-video">
							<video width="640" height="360" controls>
								<source src="<?php echo get_post_meta($sales->ID,'video_url',true);?>"  />
							</video>
						</div>
						<div class="sale-big-image">
						<?php echo get_post_meta($sales->ID,'middle_content',true);?>
						</div>
					</div>
					<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
						<div class="sales-right">
						<?php echo get_post_meta($sales->ID,'right_content',true);?>
							<a href="<?php echo home_url();?>/registration/?username=<?php echo $_GET['keyword'];?>" class="earning-today"><?php echo get_post_meta($sales->ID,'button_text',true);?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	<section class="copyright">
		<div class="container text-center">
			<p><?php echo get_post_meta($sales->ID,'footer',true);?></p>			
		</div>
	</section>
<?php } } ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>