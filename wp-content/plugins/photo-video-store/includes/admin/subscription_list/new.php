<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_subscription" );
?>



<div class="back"><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>" class="btn btn-default"><i class="icon-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "new" )?>:</h1>

<div class="box box_padding">
	<form method="post" action="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>">
	<input type="hidden" name="action" value="add">
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "subscription" )?>:</span>
	<select name="subscription" style="width:300px" class="ibox form-control">
		<?php
$sql = "select id_parent,title from " . PVS_DB_PREFIX .
	"subscription order by priority";
$ds->open( $sql );
while ( ! $ds->eof ) {
?>
			<option value="<?php echo $ds->row["id_parent"] ?>"><?php echo $ds->row["title"] ?></option>
			<?php
	$ds->movenext();
}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "user" )?>:</span>
	<input type="text" name="user" value="<?php echo $rs->row["user"] ?>" style="width:150px" class="ibox form-control">
	</div>
	
	<div class='admin_field'>
	<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "add" )?>">
	</div>
	</form>

</div>
