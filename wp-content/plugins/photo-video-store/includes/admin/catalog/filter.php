<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_catalog" );
?>

<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>" class="btn btn-primary btn-sm"><i class="icon-arrow-left fa fa-arrow-left"></i>  <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "filter" )?>:</h1>

<p>You can write a list of bad/undesirable words here. The script will search the publication which contains the words.<br> You should use comma "," as separator. </p>

<form method="post">
<input type="hidden" name="action" value="filter_change">
<?php
$sql = "select words from " . PVS_DB_PREFIX . "content_filter";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<div class="form_field">
<textarea name="filter" style="width:400px;height:200px" class="ft"><?php echo $rs->row["words"] ?></textarea></div>
<?php
}
?>
<div class="form_field">
<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class='btn btn-primary'>
</div>
</form>
