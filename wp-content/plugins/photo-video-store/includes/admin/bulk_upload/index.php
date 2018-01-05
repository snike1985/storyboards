<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );

if ( isset( $_GET["d"] ) ) {
	$d = ( int )$_GET["d"];
} else
{
	$d = 1;
}

if ( @$_REQUEST["action"] == 'image' )
{
	include("image.php");
}

if ( @$_REQUEST["action"] == 'photo_upload' )
{
	include("photo_upload.php");
}

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>

<script>
function change_group(value)
{
	$(".group_settings").css("display","none");
	$(".group_"+value).css("display","block");
	$(".menu_settings").removeClass('nav-tab-active');
	$(".menu_settings_"+value).addClass('nav-tab-active');
}

$(document).ready(function() {
	change_group('files');
});
</script>



<?php
if ( $pvs_global_settings["allow_vector"] ) {
?>
	<a class="btn btn-<?php
	if ( $d == 4 ) {
		echo ( "danger" );
	} else {
		echo ( "success" );
	}
?> toright" href="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));
?>&d=4"><i class="icon-picture icon-white fa fa-leaf"></i>&nbsp; <?php echo pvs_word_lang( "ftp vector uploader" )?></a>
<?php
}

if ( $pvs_global_settings["allow_audio"] ) {
?>
	<a class="btn btn-<?php
	if ( $d == 3 ) {
		echo ( "danger" );
	} else {
		echo ( "success" );
	}
?> toright" href="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));
?>&d=3"><i class="icon-music icon-white fa fa-music"></i>&nbsp; <?php echo pvs_word_lang( "ftp audio uploader" )?></a>
<?php
}

if ( $pvs_global_settings["allow_video"] ) {
?>
	<a class="btn btn-<?php
	if ( $d == 2 ) {
		echo ( "danger" );
	} else {
		echo ( "success" );
	}
?> toright" href="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));
?>&d=2"><i class="icon-film icon-white fa fa-film"></i>&nbsp; <?php echo pvs_word_lang( "ftp video uploader" )?></a>
<?php
}

if ( $pvs_global_settings["allow_photo"] ) {

	if ( PVS_LICENSE != 'Free'  ) {
	?>
		<a class="btn btn-<?php
		if ( $d == 5 ) {
			echo ( "danger" );
		} else {
			echo ( "success" );
		}
	?> toright" href="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));
	?>&d=5"><i class="icon-camera icon-white fa fa-photo"></i>&nbsp; <?php echo pvs_word_lang( "java photo uploader" )?></a> 
	<?php
		}
	?>

	<a class="btn btn-<?php
	if ( $d == 1 ) {
		echo ( "danger" );
	} else {
		echo ( "success" );
	}
?> toright" href="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));
?>&d=1"><i class="icon-camera icon-white fa fa-photo"></i>&nbsp; <?php echo pvs_word_lang( "ftp photo uploader" )?></a>
<?php
}
?>


<h1><?php echo pvs_word_lang( "bulk upload" )?>:</h1>

<link rel="stylesheet" href="<?php echo ( pvs_plugins_url() );
?>/assets/js/treeview/jquery.treeview.css" />
<script src="<?php echo ( pvs_plugins_url() );
?>/assets/js/treeview/jquery.cookie.js"></script>
<script src="<?php echo ( pvs_plugins_url() );
?>/assets/js/treeview/jquery.treeview.js"></script>

<script>
$(document).ready(function(){
	$("#categories_tree_menu").treeview({
		collapsed: false,
		persist: "cookie",
		cookieId: "treeview-black"
	});
});
</script>


<?php
if ( isset( $_GET["quantity"] ) ) {
	$_SESSION["bulk_page"] = ( int )$_GET["quantity"];
}

if ( ! isset( $_SESSION["bulk_page"] ) ) {
	$_SESSION["bulk_page"] = 10;
}

if ( isset( $_GET["str"] ) ) {
	$str = ( int )$_GET["str"];
} else
{
	$str = 1;
}

if ( $d == 1 ) {
	include ( "photo.php" );
}

if ( $d == 5 ) {
	include ( "photo_java.php" );
}

if ( $d == 2 ) {
	include ( "video.php" );
}

if ( $d == 3 ) {
	include ( "audio.php" );
}

if ( $d == 4 ) {
	include ( "vector.php" );
}

include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>