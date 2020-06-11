<?php

 // Constants 
define( 'NT_THEME_URI', get_stylesheet_directory_uri().'/' );
define( 'NT_THEME_DIR', get_stylesheet_directory().'/' );
define( 'NT', 'neurothemes' );

// Redux Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( NT_THEME_DIR.'framework/ReduxCore/framework.php' ) ) {
	require_once( NT_THEME_DIR.'framework/ReduxCore/framework.php' );
}

// Redux Options
if ( class_exists( 'ReduxFramework' ) && file_exists( NT_THEME_DIR.'inc/options.php' ) ) {
	require_once( NT_THEME_DIR.'inc/options.php' );
}

include(get_template_directory().'-child/inc/list_directory.php');


function custom_app_css_js(){

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '-child/css/bootstrap.min.css', array(), '1.1', 'all');
	wp_enqueue_style( 'fontawosome', get_template_directory_uri() . '-child/css/font-awesome.min.css', array(), '1.1', 'all');
	wp_enqueue_style( 'pricing', get_template_directory_uri() . '-child/css/pricing.css', array(), '1.1', 'all');
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '-child/css/responsive.css', array(), '1.1', 'all');
	
	
}
add_action( 'wp_enqueue_scripts', 'custom_app_css_js' );


// Post For Tutorials

if (current_user_can('administrator') ) {
function create_post_type() {
	register_post_type( 'video_tutorials',
	  array(
		'labels' => array(
		  'name' => __( 'Tutorials' ),
		  'singular_name' => __( 'Tutorials' )
		),
		'public' => true,
		'has_archive' => true,
		'menu_icon'	=> 'dashicons-playlist-video',
		'supports'	=> array('title','page-attributes'),
		'hierarchical' => false
	  )
	);
  }
  add_action( 'init', 'create_post_type' );


function tutorial_css_js(){
	wp_enqueue_media();
	wp_enqueue_script( 'jsadmin', get_template_directory_uri() . '-child/js/adminscript.js', array ( 'jquery' ), 1.1, true);
	
	
}
add_action( 'admin_enqueue_scripts', 'tutorial_css_js' );

function create_start_here() {
	register_post_type( 'start_here',
	  array(
		'labels' => array(
		  'name' => __( 'Getting Start' ),
		  'singular_name' => __( 'Getting Start' )
		),
		'public' => true,
		'has_archive' => true,
		'menu_icon'	=> 'dashicons-playlist-video',
		'supports'	=> array('title','editor'),
	  )
	);
	}
  add_action( 'init', 'create_start_here' );

  function create_special_offer() {
	register_post_type( 'special_offer',
	  array(
		'labels' => array(
		  'name' => __( 'Special Offer' ),
		  'singular_name' => __( 'Special Offer' )
		),
		'public' => true,
		'has_archive' => true,
		'menu_icon'	=> 'dashicons-playlist-video',
		'supports'	=> array('title','editor'),
	  )
	);
	}
  add_action( 'init', 'create_special_offer' );

add_action( 'admin_enqueue_scripts', 'tutorial_css_js' );
/**
 * Video tutorials Post Table: Display a custom column of orders functionality will do here
 */
add_action( 'manage_video_tutorials_posts_custom_column', function ( $column_name, $post_id ) 
{	
	//print_r(get_post($post_id)->menu_order);
	if ( $column_name == 'post_order'){
		// printf( '<input type="button" value="%s" />', esc_attr( __( 'Send Email' ) ) );
		echo get_post($post_id)->menu_order;
	}

}, 10, 2 );

/**
 * Video tutorials Post Table: Display a custom column of orders
 */
add_filter('manage_video_tutorials_posts_columns', function ( $columns ) 
{
	if( is_array( $columns ) && ! isset( $columns['post_order'] ) )
		$columns['post_order'] = __( 'Orders' );     
	return $columns;
} );

function video_meta_box(){
	$arr = array('video_tutorials','start_here','special_offer');
	add_meta_box( 'video_meta_box', 'Videos', 'video_meta_box_fcn', $arr, 'advanced', 'default');
}
add_action('add_meta_boxes','video_meta_box',10,2);

function video_meta_box_fcn(){

	?>
	<div class="wrap">
		<?php

		global $post;
		$video_url = get_post_meta($post->ID, 'video_url', true);
		//$order = get_post_meta($post->ID, 'order', true);				
		?>
		<input type="text" id="video_url" name="video_url" value="<?php echo $video_url;?>" style="width:70%;"><span class="button button-primary upload_video">Upload Video</span>
		<p></p>
		
		</div>
	<?php
}

function save_video_url(){
	global $post;
	update_post_meta( $post->ID, 'video_url', $_POST['video_url'] );
	//update_post_meta( $post->ID, 'order', $_POST['order'] );
}
add_action( 'save_post', 'save_video_url' );
/** 
 * custom post types for sales page with meta box 
 * 
*/
function create_post_type_sales() {
	register_post_type( 'sales_page',
	  array(
	 'labels' => array(
	   'name' => __( 'Sales Page' ),
	   'singular_name' => __( 'Sales Page' )
	 ),
	 'public' => true,
	 'has_archive' => true,
	 'menu_icon' => 'dashicons-chart-line',
	 'supports' => array('title',),
	  )
	);
}
	 add_action( 'init', 'create_post_type_sales' );

function my_meta_box_add() {
    add_meta_box( 'my-meta-box-id', 'Sales Attributes', 'my_meta_box', 'sales_page', 'normal', 'high' );
} 
add_action( 'add_meta_boxes', 'my_meta_box_add' );


function my_meta_box( $post ) {
	$sales_page = get_post_meta($post->ID, 'sales_page', true);
	$button_text = get_post_meta($post->ID, 'button_text', true);
	$second_title = get_post_meta($post->ID, 'second_title', true);
	$video_url = get_post_meta($post->ID, 'video_url', true);
	$footer = get_post_meta($post->ID, 'footer', true);

	// $right_img = get_post_meta($post->ID, 'right_img', true);
	// $middle = get_post_meta($post->ID, 'middle', true);
	// $left = get_post_meta($post->ID, 'left', true);
 	?>
   <p>
        <label for="my_meta_box_post_type">Select Sales Page: </label>&nbsp;
        <select name='sales_page' id='my_meta_box_post_type'>            
            <option value="1" <?php if($sales_page == 1){  echo "selected";} ?> >Sales page 1</option>            
            <option value="2" <?php if($sales_page == 2){  echo "selected";} ?> >Sales page 2</option>            
        </select>
    </p>
	<?php 
		$left_content = get_post_meta( $post->ID, 'left_content', false );
		echo '<h3>Left Content</h3></br>';
		wp_editor( $left_content[0], 'left_content' );
		//midddle
		$middle_content = get_post_meta( $post->ID, 'middle_content', false );
		echo '<h3>Middle Content</h3></br>';
		wp_editor( $middle_content[0], 'middle_content' );
		//right
		$right_content = get_post_meta( $post->ID, 'right_content', false );
		echo '<h3>Right Content</h3></br>';
		wp_editor( $right_content[0], 'right_content' );	
    ?>
		<div class="wrap">	
		
		<input type="text" id="video_url" name="video_url" value="<?php echo $video_url;?>" style="width:70%;"><span class="button button-primary upload_video">Upload Video</span>
		</div>
		<!-- <div class="wrap">			
			<input type="text" id="right_img" name="right_img" value="<?php echo $right_img;?>" style="width:70%;"><span class="button button-primary upload_video">Upload Right Image</span>
		</div>
		<div class="wrap">	
		
		<input type="text" id="middle" name="middle" value="<?php echo $middle;?>" style="width:70%;"><span class="button button-primary upload_video">Upload Midddle Image</span>
		</div>
		<div class="wrap">	
		<label for="">Left Image</label>	
		<input type="text" id="left" name="left" value="<?php echo $left;?>" style="width:70%;"><span class="button button-primary upload_video">Upload Left Image</span>
		</div> -->
  
	<p>
		<label for="my_meta_box_post_type">Button text: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="button_text" value="<?php echo $button_text;?>" >
	</p>
	<p>
		<label for="my_meta_box_post_type">Second Title: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="second_title" value="<?php echo $second_title;?>" >
	</p>
	<p>
		<label for="my_meta_box_post_type">Footer Text: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="footer" value="<?php echo $footer;?>" >
	</p>
	
    <?php   
}
function save_meta_sales(){
	global $post;	
	update_post_meta( $post->ID, 'button_text',$_POST['button_text'] );
	update_post_meta( $post->ID, 'video_url',$_POST['video_url'] );
	update_post_meta( $post->ID, 'sales_page',$_POST['sales_page'] );
	update_post_meta( $post->ID, 'second_title',$_POST['second_title'] );
	update_post_meta( $post->ID, 'footer',$_POST['footer'] );
	//images
	// update_post_meta( $post->ID, 'right_img',$_POST['right_img'] );
	// update_post_meta( $post->ID, 'middle',$_POST['middle'] );
	// update_post_meta( $post->ID, 'left',$_POST['left'] );
	//content
	update_post_meta( $post->ID, 'left_content',$_POST['left_content'] );
	update_post_meta( $post->ID, 'middle_content',$_POST['middle_content'] );
	update_post_meta( $post->ID, 'right_content',$_POST['right_content'] );
}
	add_action( 'save_post', 'save_meta_sales' );

}


/**  
 * check unique username get from registration 
 * @method uniqueUsername
 * @param null
*/

add_action( 'wp_ajax_uniqueUsername', 'uniqueUsername' );
add_action( 'wp_ajax_nopriv_uniqueUsername', 'uniqueUsername' );


function uniqueUsername(){
	global $post;	
	global $wpdb;	
	 $username = $_POST['val'];
	$table_name = $wpdb->prefix.'register_user';
	$result = $wpdb->get_results("SELECT * FROM `$table_name` WHERE username = '$username'");		
	if(count($result) > 0){
		echo "succsess"; 
	}else{
		echo "no";
	}
	wp_die();
}
add_action( 'wp_ajax_uniqueEmail', 'uniqueEmail' );
add_action( 'wp_ajax_nopriv_uniqueEmail', 'uniqueEmail' );


function uniqueEmail(){
	global $post;	
	global $wpdb;	
	$email = $_POST['val'];
	$table_name = $wpdb->prefix.'register_user';
	$result = $wpdb->get_results("SELECT * FROM `$table_name` WHERE email = '$email'");		
	if(count($result) > 0){
		echo "succsess"; 
	}else{
		echo "no";
	}
	wp_die();
}
add_action( 'wp_ajax_msdDateUpdate', 'msdDateUpdate' );
add_action( 'wp_ajax_nopriv_msdDateUpdate', 'msdDateUpdate' );


function msdDateUpdate(){
	global $post;	
	global $wpdb;		
	$date = $_POST['val'];
	$id = $_POST['id'];	
	$table_name = $wpdb->prefix.'auto_responder';
	$result = $wpdb->update($table_name,array('date'=>$date),array('responder_id'=>$id));		
	if(count($result) > 0){
		echo "succsess"; 
	}else{
		echo "no";
	}
	wp_die();
}

add_action( 'wp_ajax_checkkeyword', 'checkkeyword' );
add_action( 'wp_ajax_nopriv_checkkeyword', 'checkkeyword' );


function checkkeyword(){
	global $post;	
	global $wpdb;	
	$keyword = $_POST['val'];
	$table_name = $wpdb->prefix.'svb_campaings';
	$result = $wpdb->get_results("SELECT * FROM `$table_name` WHERE keyword = '$keyword'");		
	if(count($result) > 0){
		echo "succsess"; 
	}else{
		echo "no";
	}
	wp_die();
}

add_action( 'wp_ajax_clone_campaign_fcn', 'clone_campaign_fcn' );
add_action( 'wp_ajax_nopriv_clone_campaign_fcn', 'clone_campaign_fcn' );

function clone_campaign_fcn(){

	$post = array('title'=>$_POST['title'],
				  'audio_list' => $_POST['audio_list'],
				  'phone_list' => $_POST['phone_list'], 
				  'type' => 1, 
				  'camp_list' => $_POST['camp_list'], 
				  'caller_id'  => $_POST['caller_id']);
	$title = $_POST['title'];
	$audio_list = $_POST['audio_list'];
	$phone_list = $_POST['phone_list'];
	$caller_id = $_POST['caller_id'];
	
	//create_campaign($audio_list,$caller_id,$title,$phone_list);
	create_campaign($post);
	wp_die();
}
function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

/** 
* ajax for city
*/
add_action( 'wp_ajax_usAreaCode', 'usAreaCode' );
add_action( 'wp_ajax_nopriv_usAreaCode', 'usAreaCode' );


function usAreaCode(){
	global $post;	
	global $wpdb;	
	 $city = $_POST['val'];
	$table_name = $wpdb->prefix.'area_code';
	$result = $wpdb->get_results("SELECT area_code FROM `$table_name` WHERE city = '$city' GROUP BY area_code");		
	if(count($result) > 0){
		header('Content-Type: application/json');
		echo json_encode($result);
	}else{
		echo "no";
	}
	wp_die();
}
/**
 * Register user list Admin menu
 *  @method register_user_list
 */

function register_user_list(){
    add_menu_page('Registered User', 'Registered User', 'manage_options', 'register_user_list', 'register_user_list_fcn', '
    dashicons-editor-ol',25 );
}
add_action('admin_menu','register_user_list');

function register_user_list_fcn(){
    include(get_template_directory().'-child/inc/register_user_list.php');
}





// Custom CP Builder 
/**
 * rishan custom role 
 */
function psp_add_project_management_role() {
	
	add_role('psp_project_manager',__(
			   'CP Builder'),
			   array(
				'read'              => true, // Allows a user to read
				'create_posts'      => true, // Allows user to create new posts
				'edit_posts'        => true, // Allows user to edit their own posts
				'delete_posts'     => true, // Allows user to edit their own posts				  
				'edit_others_posts' => true, // Allows user to edit others posts too
				'publish_posts'     => true, // Allows the user to publish posts
				'manage_categories' => true, // Allows user to manage post categories
			   )
		   );
	  }
	  register_activation_hook( __FILE__, 'psp_add_project_management_role' );
// 	  add_action( 'init', 'psp_register_cpt_projects');
// function psp_register_cpt_projects() {
//      		$args = array(
// 			'label'               => __( 'psp_projects', 'psp_projects' ),
// 			'label'               => __( 'psp_projects', 'psp_projects' ),
// 			'description'         => __( 'Projects', 'psp_projects' ),
// 			'labels'              => $labels,
// 			'supports'            => array('*'),
// 			'hierarchical'        => false,
// 			'public'              => true,
// 			'show_ui'             => true,
// 			'rewrite'             => $rewrite,
// 			'capability_type'     => array('psp_project','psp_projects'),
// 			'map_meta_cap'        => true,
// 		);
// 		register_post_type( 'psp_projects', $args );
// }
/*function psp_create_builder() {
	
	register_post_type( 'page_builder',
	  array(
		'labels' => array(
		  'name' => __( 'Page Builder' ),
		  'singular_name' => __( 'Page Builder' )
		),
		'public' => true,		 
		'has_archive' => true,		
		'capability_type'     => array('psp_create_builder','psp_create_builder'),
		// 'menu_icon'	=> 'dashicons-playlist-video',
		'supports'	=> array('title'),
	  )
	);
  }
  add_action( 'init', 'psp_create_builder' );
add_action('admin_init','psp_add_role_caps',999);
function psp_add_role_caps() {

	// Add the roles you'd like to administer the custom post types
	$roles = array('psp_project_manager','editor','administrator');
	
	// Loop through each role and assign capabilities
	foreach($roles as $the_role) { 

		 $role = get_role($the_role);
		
			 $role->add_cap( 'read' );
			 $role->add_cap( 'read_psp_create_builder');
			 $role->add_cap( 'read_private_psp_create_builder' );
			 $role->add_cap( 'edit_psp_create_builder' );
			 $role->add_cap( 'edit_psp_create_builder' );
			 $role->add_cap( 'edit_others_psp_create_builder' );
			 $role->add_cap( 'edit_published_psp_create_builder' );
			 $role->add_cap( 'publish_psp_create_builder' );
			 $role->add_cap( 'delete_others_psp_create_builder' );
			 $role->add_cap( 'delete_private_psp_create_builder' );
			 $role->add_cap( 'delete_published_psp_create_builder' );
			$role->add_cap( 'delete_posts_psp_create_builder' );
	}
}*/
/** 
 * set builder for uniquer user
 * custom code
 */
/*
global $wp;
$user_id = get_current_user_id();
$current_uri = home_url().$_SERVER['REQUEST_URI'];
if(!isset($_GET['all_posts'])){
	if($current_uri == admin_url('edit.php?post_type=page') && @$_GET['author'] != 1 ){

		wp_redirect( admin_url('edit.php?post_type=page&author='.$user_id) );    
	} 
}
*/
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

// code for delete custom post type

// $mycustomposts = get_posts( array( 'post_type' => 'page_builder', 'numberposts' => 19)); 
//    foreach( $mycustomposts as $mypost ) {
//      // Delete's each post.
//     wp_delete_post( $mypost->ID, true);
//     // Set to False if you want to send them to Trash.
//    }   
/** 
 * update the input link of capture and sales page using ajax
 * @method updateCaptureSales
 * @param null 
*/
add_action( 'wp_ajax_updateCaptureSales', 'updateCaptureSales' );
add_action( 'wp_ajax_nopriv_updateCaptureSales', 'updateCaptureSales' );


function updateCaptureSales(){
	global $post;	
	global $wpdb;		
	 $link = $_POST['val'];
	 $capture_id = $_POST['capture_id'];
	$table_name = $wpdb->prefix.'capture_sales';
	$data = array('link'=>$link);
	$where = array('capture_sales_id'=>$capture_id);
	$result = $wpdb->update($table_name,$data,$where);		
	if($result){
		echo "succsess";
	}else{
		echo "no";
	}
	wp_die();
}
// dashicons dashicons-money
function leads_list(){
    add_menu_page('Leads List', 'Leads List', 'manage_options', 'leads_list', 'leads_list_fcn', '
    dashicons-editor-ol',25 );
}
add_action('admin_menu','leads_list');

function leads_list_fcn(){
    include(get_template_directory().'-child/templates/leads_list.php');
}
/** 
 * function for pay action on amdin side 
 * @method pay_list
 * @param null 
*/
function pay_list(){
    add_menu_page('Plan Action', 'Plan Action', 'manage_options', 'pay_list', 'pay_list_fcn', '
    dashicons-money',25 );
}
add_action('admin_menu','pay_list');

function pay_list_fcn(){
    include(get_template_directory().'-child/templates/pay_list.php');
}
function create_post_type_faq() {
	register_post_type( 'faq_list',
	  array(
	 'labels' => array(
	   'name' => __( 'FAQ' ),
	   'singular_name' => __( 'FAQ' )
	 ),
	 'public' => true,
	 'has_archive' => true,
	 'menu_icon' => 'dashicons-editor-help',
	 'supports' => array('title','editor'),
	  )
	);
}
	 add_action( 'init', 'create_post_type_faq' );

/** 
 * cheeck user is editor and show list and menu on behalf of role 
 * @method custom 
 * @param null
*/
// this hook, remove the menu page for particular role like editor 
add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {
 
	global $user_ID;
	 
	if ( current_user_can( 'editor' ) ) {
		remove_menu_page( 'edit.php?post_type=project' );
		remove_menu_page( 'edit.php?post_type=faq_list' );		
		remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('tools.php'); // tools
		remove_menu_page('admin.php?page=wpcf7');		
	}
}
// this hook, view post, page on behalf of author 
add_action( 'load-edit.php', 'posts_for_current_editor' );
function posts_for_current_editor() {
	global $user_ID;
	if ( current_user_can( 'editor' ) ) {
		if ( ! isset( $_GET['author'] ) ) {
			wp_redirect( add_query_arg( 'author', $user_ID ) );
			exit;
		}
	}
}
/* hook for custom script */
if($user_id != 1 && !current_user_can('administrator')){	
	function my_enqueue($hook) {
		if ('edit.php' !== $hook) {
			return;
		}	
		wp_enqueue_script('my_custom_script', get_template_directory_uri() . '-child/my-script.js',array ( 'jquery' ), 1.1, true);
	}	
	add_action('admin_enqueue_scripts', 'my_enqueue');
	
}
/** 
 * get camping details of no 
 * @method campaignDetails
 * @param null 
*/
add_action( 'wp_ajax_campaignDetails', 'campaignDetails' );
add_action( 'wp_ajax_nopriv_campaignDetails', 'campaignDetails' );

function campaignDetails(){
	session_start();
	global $post;	
	global $wpdb;		
	$phone_no = $_POST['val'];		
	$user_id = $_SESSION['user_id'];
	global $wpdb;    	
	$table_name = $wpdb->prefix.'svb_subscriber';	
	$single = $wpdb->get_row("SELECT * FROM $table_name WHERE phone_number = '$phone_no' AND registereduser_id = $user_id");
    
    if($single->campaign != ''){
		$result = $wpdb->get_results("SELECT campaign_title,campaign FROM $table_name WHERE phone_number = '$phone_no' AND registereduser_id = $user_id");
		if($result > 0){
			header('Content-Type: application/json');
			echo json_encode($result);
		}else{
			echo "no";
		}
    }else{
		$count = 0; 
		header('Content-Type: application/json');
		echo json_encode($count);
    }    
	
	wp_die();
}
add_action( 'wp_ajax_data_subcription', 'data_subcription' );
add_action( 'wp_ajax_nopriv_data_subcription', 'data_subcription' );
function data_subcription() {
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
}
/**
 * ajax for search sub 
 */
add_action( 'wp_ajax_searchsub', 'searchsub' );
add_action( 'wp_ajax_nopriv_searchsub', 'searchsub' );
function  searchsub(){
	global $post;
	global $wpdb;
	$table_name = $wpdb->prefix.'svb_subscriber';
	$val = $_POST['val'];
	$page = 1;
	$num_per_page =  10;
	$search = $wpdb->get_results("SELECT * FROM $table_name WHERE phone_number LIKE '%$val%' ORDER BY date DESC LIMIT 0,10",ARRAY_A);		
	if($search > 0 ){
		$i = 0;
	foreach ($search as $result) { ?>
		<tr>
			<td>
				<?php if($result['status'] == 0) { ?>
					<input type="checkbox" name="check_list_ho_ja[]" id="check_list_ho_ja<?php echo $i;?>"  class="check_list_ho_ja" value="<?php echo $result['id'];?>|<?php echo $result['phone_number'];?>" />
				<?php } ?>
			</td>
			<td><?php echo $result['name'];?></td>
			<td><?php echo $result['phone_number'];?></td>
			<td><a href="javascript:void(0);" onclick="campaign_group('<?php echo $result['phone_number'];?>');">View</a> <span class="label label-danger"><?php echo svbCampaignCount($result['phone_number']);?></span></td>
			<td><?php if($result['status'] == 0 ) { echo "<span class='label label-success'>Active</span>"; }else{ echo "<span class='label label-danger'>Block</span>";}?></td>
			<td><?php if($result['status'] == 0) { ?>
				<a href="javascript:void(0);" onclick="single_sms('<?php echo $result['phone_number'];?>')" ><i class="fa fa-envelope fa-1x camp-action"></i></a>
				<a href="<?php echo home_url();?>/dashboard/?option=subscription&page=edit_subscriber&row_id=<?php echo $result['id'];?>"><i class="fa fa-edit fa-1x camp-action"></i></a>
				<!-- <a href="#"><i class="fa fa-trash-o fa-1x camp-action"></i></a> -->
				<?php }else{ } ?>
			</td>
		</tr>	
	<?php $i++; } }else{
		 echo "<td colspan='6'><h4 class='text-danger text-center'>There are no results that meet your criteria.</h4></td>";
	}
	
}
/** 
 * temporary comin soon page 
*/

// global $wp;
// $user_id = get_current_user_id();
// $current_uri = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// if($current_uri == home_url().'/'){	
// 	include(get_template_directory().'-child/coming/index.php');
// 	exit;
// }
?>