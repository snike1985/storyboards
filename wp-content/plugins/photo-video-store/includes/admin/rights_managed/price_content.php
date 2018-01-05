<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );

$user_fields = array();
$user_fields["title"] = "";
$user_fields["price"] = 1;
$user_fields["formats"] = "jpg,jpeg";
$user_fields["photo"] = 1;
$user_fields["video"] = 0;
$user_fields["audio"] = 0;
$user_fields["vector"] = 0;

if ( isset( $_GET["id"] ) )
{
	$sql = "select * from " . PVS_DB_PREFIX . "rights_managed where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$user_fields["title"] = $rs->row["title"];
		$user_fields["price"] = $rs->row["price"];
		$user_fields["formats"] = $rs->row["formats"];
		$user_fields["photo"] = $rs->row["photo"];
		$user_fields["video"] = $rs->row["video"];
		$user_fields["audio"] = $rs->row["audio"];
		$user_fields["vector"] = $rs->row["vector"];
	}
}
?>



<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=1" class="btn btn-primary btn-sm btn-mini"><b><i class="fa fa-arrow-left"></i>&nbsp; <?php
echo pvs_word_lang( "back" )
?></b></a></div>



<h1><?php
echo pvs_word_lang( "price" )
?> &mdash; <?php
if ( ! isset( $_GET["id"] ) )
{
	echo ( pvs_word_lang( "add" ) . " " );
} else
{
	echo ( pvs_word_lang( "edit" ) . " " );
}
?></h1>



<div class="box box_padding">








<form method="post"  Enctype="multipart/form-data">
<input type="hidden" name="action" value="price_add">
<?php
if ( isset( $_GET["id"] ) )
{
?>
	<input type="hidden" name="id" value="<?php
	echo ( @$_GET["id"] );
?>">
	<?php
}
?>

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "title" )
?>:</span>
	<input type="text" name="title" value="<?php
echo $user_fields["title"]
?>" style="width:350px">
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "type" )
?>:</span>
	<input type="text" name="formats" value="<?php
echo $user_fields["formats"]
?>" style="width:350px">
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "price" )
?>:</span>
	<input type="text" name="price" value="<?php
echo pvs_price_format( $user_fields["price"], 2 )
?>" style="width:70px">
	</div>
	
	<?php
if ( $pvs_global_settings["allow_photo"] )
{
?>
		<div class='admin_field'>
		<span><?php
	echo pvs_word_lang( "photo" )
?>:</span>
		<input type="checkbox" name="photo" value="1" <?php
	if ( $user_fields["photo"] == 1 )
	{
		echo ( "checked" );
	}
?>>
		</div>
	<?php
}
?>

	<?php
if ( $pvs_global_settings["allow_video"] )
{
?>
		<div class='admin_field'>
		<span><?php
	echo pvs_word_lang( "video" )
?>:</span>
		<input type="checkbox" name="video" value="1" <?php
	if ( $user_fields["video"] == 1 )
	{
		echo ( "checked" );
	}
?>>
		</div>
	<?php
}
?>	

	<?php
if ( $pvs_global_settings["allow_audio"] )
{
?>
		<div class='admin_field'>
		<span><?php
	echo pvs_word_lang( "audio" )
?>:</span>
		<input type="checkbox" name="audio" value="1" <?php
	if ( $user_fields["audio"] == 1 )
	{
		echo ( "checked" );
	}
?>>
		</div>
	<?php
}
?>

	<?php
if ( $pvs_global_settings["allow_vector"] )
{
?>
		<div class='admin_field'>
		<span><?php
	echo pvs_word_lang( "vector" )
?>:</span>
		<input type="checkbox" name="vector" value="1" <?php
	if ( $user_fields["vector"] == 1 )
	{
		echo ( "checked" );
	}
?>>
		</div>
	<?php
}
?>
	
	
	

<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>">
		</div>
	</div>




</form>

</div>