<?php
global $wpdb;
$table = $wpdb->prefix.'register_user';
$id = $_GET['id'];
$data = $wpdb->get_row("SELECT fname,lname,email,mobile,password,address,zipcode,username,refrencename FROM $table WHERE id = $id",ARRAY_A);
// echo '<pre>';
// print_r($data);
?>

<div class="wrap">
    <div class="profile_view">
    <h3 style=" text-align: right;"><a href="<?php echo home_url();?>/wp-admin/admin.php?page=register_user_list" class="button button-primary" style="font-size: 15px;">Back</a></h3>
        <table>
           <?php foreach($data as $usercol => $userval){?>
            <tr>
                <td>
                <b><?php echo str_replace('Username','Keyword',ucwords($usercol));?></b>
                </td>
                <td>
                <?php echo $userval;?>   
                </td>
            </tr>
           <?php } ?>
        </table>
    </div>

</div>
<style>
    .profile_view {
    background-color: #fff;
    width: 80%;
    margin: 5% auto;
    box-shadow: 0 0 2px 2px #ccc;
    padding: 19px 33px;
}
.profile_view td {
    width: 24%;
    font-size: 18px;
    padding: 13px;
}
.profile_view tr {
    width: 81%;
}
.profile_view table {
    width: 100%;
}
</style>