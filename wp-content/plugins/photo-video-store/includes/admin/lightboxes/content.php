<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_lightboxes" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>




<div class="back"><a href="<?php echo(pvs_plugins_admin_url('lightboxes/index.php'));?>" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "edit" )?> &mdash; <?php echo pvs_word_lang( "lightboxes" )?>:</h1>

<div class="box box_padding">
<?php
$sql = "select * from " . PVS_DB_PREFIX . "lightboxes where id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
?>

<form method="post" enctype='multipart/form-data' action="<?php echo(pvs_plugins_admin_url('lightboxes/index.php'));?>">
<input type="hidden" name="action" value="change">
<input type="hidden" name="id" value="<?php echo ( int )$_GET["id"] ?>">

<div class='admin_field'>
	<span><?php echo pvs_word_lang( "title" )?>:</span>
	<input type='text' name='title' style='width:400px' class='ibox form-control' value='<?php echo $rs->row["title"] ?>'>
</div>

<div class='admin_field'>
	<span><?php echo pvs_word_lang( "show in catalog" )?>:</span>
	<input type='checkbox' value='1' name='catalog' <?php
	if ( $rs->row["catalog"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
	<span><?php echo pvs_word_lang( "preview" )?>:</span>
	<input type='file' name='photo' style='width:400px' class='ibox form-control'><small>(*.jpg)</small>
	<?php
	if(file_exists(pvs_upload_dir() . "/content/categories/lightbox_" . ( int )@$_GET["id"] . ".jpg"))
	{
		echo("<div style='padding-top:3px'><div  style='padding-bottom:3px'><img src='" . pvs_upload_dir('baseurl'). "/content/categories/lightbox_" . ( int )@$_GET["id"] . ".jpg'></div><a href='" . pvs_plugins_admin_url('lightboxes/index.php'). "&action=delete_thumb&id=" . ( int )@$_GET["id"] . "' class='btn btn-xs btn-default'>" .
			pvs_word_lang( "delete" ) . "</a></div>");
	}
	?>
</div>


<input type='submit' value='<?php echo pvs_word_lang( "save" )?>' class="btn btn-primary" style="margin-left:6px"></form>

<?php
}
?>
</div>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>