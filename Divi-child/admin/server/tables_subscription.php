<?php 
	// $table = 'wp_svb_subscriber';
	// // Table's primary key
	// $primaryKey = 'id';
	// // indexes
	// $columns = array(
	// 	array( 'db' => 'name', 'dt' => 0 ),
	// 	array( 'db' => 'phone_number',  'dt' => 1 ),
	// 	array( 'db' => 'campaign_title',   'dt' => 2 )		
	// 	// array( 'db' => 'date','dt' => 4,
	// 	// 	'formatter' => function( $d, $row ) {
	// 	// 		return date( 'd-m-Y', strtotime($d));
	// 	// 	}
	// 	// ) 
	
	// );
	// // SQL server connection information
	// $sql_details = array(
	// 	'user' => 's1',
	// 	'pass' => 'cVsZ5fZm5qsgimC2VE9DIwFEBpgOf6WAJY2SldPZrB3KYU9EIbAQtWZzJS5hX',
	// 	'db'   => 's1',
	// 	'host' => 'localhost'
	// );
	// // require( 'vendor/datatables/ssp.class.php' );
	// include( get_template_directory() . '-child/admin/ssp.class.php' );
	// echo json_encode(
	// 	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	// );
	/* Database connection start */
	$servername = "localhost";
	$username = "s1";
	$password = "cVsZ5fZm5qsgimC2VE9DIwFEBpgOf6WAJY2SldPZrB3KYU9EIbAQtWZzJS5hX";
	$dbname = "s1";
	$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
	/* Database connection end */
	// storing  request (ie, get/post) global array to a variable  
	$requestData= $_REQUEST;
	$columns = array( 
	// datatable column index  => database column name
		0 =>'employee_name', 
		1 => 'employee_salary',
		2=> 'employee_age'
	);
	// getting total number records without any search
	$sql = "SELECT employee_name, employee_salary, employee_age ";
	$sql.=" FROM employee";
	$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
	$totalData = mysqli_num_rows($query);
	$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
	if( !empty($requestData['search']['value']) ) {
		// if there is a search parameter
		$sql = "SELECT employee_name, employee_salary, employee_age ";
		$sql.=" FROM employee";
		$sql.=" WHERE employee_name LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
		$sql.=" OR employee_salary LIKE '".$requestData['search']['value']."%' ";
		$sql.=" OR employee_age LIKE '".$requestData['search']['value']."%' ";
		$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
		$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
		$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees"); // again run query with limit
		
	} else {	
		$sql = "SELECT employee_name, employee_salary, employee_age ";
		$sql.=" FROM employee";
		$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		
	}
	$data = array();
	while( $row=mysqli_fetch_array($query) ) {  // preparing an array
		$nestedData=array(); 
		$nestedData[] = $row["employee_name"];
		$nestedData[] = $row["employee_salary"];
		$nestedData[] = $row["employee_age"];
		
		$data[] = $nestedData;
	}
	$json_data = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $data   // total data array
				);
	echo json_encode($json_data);  // send data as json format