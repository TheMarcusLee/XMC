<?php 
/*
 * Template Name: hello data
 * */
	$table = 'wp_svb_subscriber';
	// Table's primary key
	$primaryKey = 'id';
	// indexes
	$columns = array(
		array( 'db' => 'name', 'dt' => 0 ),
		array( 'db' => 'phone_number',  'dt' => 1 ),
		array( 'db' => 'campaign_title',   'dt' => 2 )		
		// array( 'db' => 'date','dt' => 4,
		// 	'formatter' => function( $d, $row ) {
		// 		return date( 'd-m-Y', strtotime($d));
		// 	}
		// ) 
	
	);
	// SQL server connection information
	$sql_details = array(
		'user' => 's1',
		'pass' => 'cVsZ5fZm5qsgimC2VE9DIwFEBpgOf6WAJY2SldPZrB3KYU9EIbAQtWZzJS5hX',
		'db'   => 's1',
		'host' => 'localhost'
	);
	// require( 'vendor/datatables/ssp.class.php' );
	include( get_template_directory() . '-child/admin/ssp.class.php' );
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
	/* Database connection start */
	     
    ?>