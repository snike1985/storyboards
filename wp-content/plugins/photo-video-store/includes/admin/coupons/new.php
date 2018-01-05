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

<h1><?php echo pvs_word_lang( "Add" )?> <?php echo pvs_word_lang( "Coupon" )?>:</h1>


<div class="box box_padding">

<p>Also you can set automatic coupons <a href="<?php echo(pvs_plugins_admin_url('coupons_types/index.php'));?>">here</a></p>

<p>Not to fill in "User" field if the coupon is for everyone.</p>

<form method="post">
<input type="hidden" name="action" value="add">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "code" )?>:</span>
<input type='text' name='code' style='width:200px' class='ibox form-control' value=''>
<br><small>if the code is not unique or empty the script will generate a random one.</small>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "title" )?>:</span>
<input type='text' name='title' style='width:200px' class='ibox form-control' value='New coupon'>
</div>


<div class='admin_field'>
<span><?php echo pvs_word_lang( "user" )?>:</span>
<input type='text' name='user' style='width:200px' class='ibox form-control' value=''>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "limit of usage" )?>:</span>
<input type='text' name='limit_of_usage' style='width:100px' class='ibox form-control' value='1'>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "total discount" )?>:</span>
<input type='text' name='total' style='width:100px' class='ibox form-control' value='0'>
</div>


<div class='admin_field'>
<span><?php echo pvs_word_lang( "percentage discount" )?>:</span>
<input type='text' name='percentage' style='width:100px' class='ibox form-control' value='0'>
</div>


<input type='hidden' name='url' style='width:300px' class='ibox form-control' value=''>




<div class='admin_field'>
<span><?php echo pvs_word_lang( "days till expiration" )?>:</span>
<input type='text' name='days' style='width:100px' class='ibox form-control' value='30'>
</div>

<input type='submit' class="btn btn-primary" style="margin-left:6px" value='<?php echo pvs_word_lang( "add" )?>'></form>

</div>
