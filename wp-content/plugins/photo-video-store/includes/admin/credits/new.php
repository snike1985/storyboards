<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_credits" );

?>




<div class="back"><a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>&" class="btn btn-default"><i class="icon-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "Add" )?> <?php echo pvs_word_lang( "Credits" )?>:</h1>


<?php
if ( isset( $_GET["d"] ) ) {
	echo ( "<p><b>" . pvs_word_lang( "error" ) . "</b></p>" );
}
?>
<div class="box box_padding">
<form method="post" action="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>">
<input type="hidden" name="action" value="add">
<div class='admin_field'>
<span><?php echo pvs_word_lang( "title" )?>:</span>
<input type='text' name='title' style='width:400px' class='ibox form-control' value='Credits bonus'>
</div>
<div class='admin_field'>
<span><?php echo pvs_word_lang( "user" )?>:</span>
<input type='text' name='user' style='width:400px' class='ibox form-control' value=''>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "quantity" )?>:</span>
<input type='text' name='quantity' style='width:100px' class='ibox form-control' value='1'>
</div>



<div class='admin_field'>
<span><?php echo pvs_word_lang( "days till expiration" )?>:</span>
<input type='text' name='days' style='width:100px' class='ibox form-control' value='0'>
</div>

<input type='submit' value='<?php echo pvs_word_lang( "add" )?>' class="btn btn-primary" style="margin-left:6px"></form>
<br>
<p>* You should set <b>"<?php echo pvs_word_lang( "days till expiration" )?>"=0</b> if you don't want to have the expiration date.</p>
</div>

