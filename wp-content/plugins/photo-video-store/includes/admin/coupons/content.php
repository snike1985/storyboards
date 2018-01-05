<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_coupons" );
?>




<div class="back"><a href="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&" class="btn btn-default"><i class="icon-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "Edit" )?> &mdash; <?php echo pvs_word_lang( "Coupon" )?>:</h1>

<div class="box box_padding">

<form method="post">
<input type="hidden" name="action" value="change">
<input type="hidden" name="id" value="<?php echo ( int )$_GET["id"] ?>">

<?php
$sql = "select * from " . PVS_DB_PREFIX . "coupons where id_parent=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
?>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "code" )?>:</span>
<input type='text' name='code' style='width:300px' class='ibox form-control' value='<?php echo $rs->row["coupon_code"] ?>'>
<br><small>if the code is not unique or empty the script will generate a random one.</small>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "title" )?>:</span>
<input type='text' name='title' style='width:200px' class='ibox form-control' value='<?php echo $rs->row["title"] ?>'>
</div>


<div class='admin_field'>
<span><?php echo pvs_word_lang( "user" )?>:</span>
<input type='text' name='user' style='width:200px' class='ibox form-control' value='<?php echo $rs->row["user"] ?>'>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "limit of usage" )?>:</span>
<input type='text' name='limit_of_usage' style='width:100px' class='ibox form-control' value='<?php echo $rs->row["ulimit"] ?>'>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "total discount" )?>:</span>
<input type='text' name='total' style='width:100px' class='ibox form-control' value='<?php echo $rs->row["total"] ?>'>
</div>


<div class='admin_field'>
<span><?php echo pvs_word_lang( "percentage discount" )?>:</span>
<input type='text' name='percentage' style='width:100px' class='ibox form-control' value='<?php echo $rs->row["percentage"] ?>'>
</div>



<input type='hidden' name='url' style='width:300px' class='ibox form-control' value='<?php echo $rs->row["url"] ?>'>




<div class='admin_field'>
<span><?php echo pvs_word_lang( "days till expiration" )?>:</span>
<input type='text' name='days' style='width:100px' class='ibox form-control' value='<?php echo round( ( $rs->row["data"] - $rs->row["data2"] ) / 86400 )?>'>
</div>

<input type='submit' class="btn btn-primary" style="margin-left:6px" value='<?php echo pvs_word_lang( "save" )?>'>

<?php
}
?>


</form>

</div>

