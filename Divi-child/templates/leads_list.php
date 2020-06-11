<?php
global $wpdb;
$table_name = $wpdb->prefix.'leads';

if(isset($_GET['action'])){
    if($_GET['action'] == 'delete'){
        
        $delete = $wpdb->delete($table_name,array('leads_id'=>$_GET['id']));

        if($delete == true){
        //    flash('msg','<div class="msg" style="background-color:#86f2de;">
        //    Record Delete Successfully
        //    </div>');
           echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=leads_list";</script>';
        }
        else{
            
           // echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
            // flash('no_delete','<div class="msg" style="background-color:#f0c3c1;">
            //             Action Could Not Complete
            //         </div>');
        }
    }
    if($_GET['action'] == 'disable'){
        
        $update = $wpdb->update($table_name,array('status'=>0),array('id'=>$_GET['id']));

        if($update == true){
        //    flash('msg','<div class="msg" style="background-color:#86f2de;">
        //    Record Delete Successfully
        //    </div>');
           echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
        }
        else{
            
           // echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
            // flash('no_delete','<div class="msg" style="background-color:#f0c3c1;">
            //             Action Could Not Complete
            //         </div>');
        }
    }
    if($_GET['action'] == 'active'){
        
        $update = $wpdb->update($table_name,array('status'=>1),array('id'=>$_GET['id']));

        if($update == true){
        //    flash('msg','<div class="msg" style="background-color:#86f2de;">
        //    Record Delete Successfully
        //    </div>');
           echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
        }
        else{
            
           // echo '<script>window.location.href="'.home_url().'/wp-admin/admin.php?page=register_user_list";</script>';
            // flash('no_delete','<div class="msg" style="background-color:#f0c3c1;">
            //             Action Could Not Complete
            //         </div>');
        }
    }
    if($_GET['action'] == 'view'){
        include(get_template_directory().'-child/inc/userprofile_view.php');
        exit;
    }
}
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<div class="wrap">
    <h3 style="text-align: center;margin: 34px 0px;text-transform: uppercase;font-size: 22px;">Leads List</h3>
    
    <?php  ?>

	
    
<table id="tbalud" class="wp-list-table widefat striped" style="width:100%"   >
    <thead>
        <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Id</th>
	    <th>Phone Number</th>
        <th>Date</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $register_user_list = $wpdb->get_results("SELECT * FROM `$table_name`");
		
        foreach($register_user_list as $list){
        ?>
        <tr>
        <td><?php echo $list->leads_fname ?></td>
        <td><?php echo $list->leads_lname; ?></td>
        <td><?php echo $list->leads_email; ?></td>
        <td><?php echo $list->leads_phonenumber; ?></td>
        <td><?php echo $list->time; ?></td>
        <td>
        <a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->leads_id;?>&action=delete" onclick="return confirm('Are You Sure')"><span class="dashicons dashicons-trash"></span></a>
       <!--  <a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->leads_id;?>&action=view" ><span class="dashicons dashicons-visibility"></span></a>
        <?php if($list->status == 1) {?>
            <a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->leads_id;?>&action=disable" title="disable"><span class="dashicons dashicons-thumbs-down"></span></a>
        <?php }
        
        else{
            ?> 
            <a href="<?php echo $_SERVER['REQUEST_URI'];?>&id=<?php echo $list->leads_id;?>&action=active" title="active"><span class="dashicons dashicons-thumbs-up"></span></a> -->
            <?php
        }?>
    </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script>
    jQuery("#tbalud").DataTable();
</script>
<style>
    .msg {
    background-color: #fff;
    text-align: center;
    border: 1px dashed red;
    font-size: 17px;
    padding: 10px;
}
</style>