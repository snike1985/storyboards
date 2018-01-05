<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_currency" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Upload
if ( @$_REQUEST["action"] == 'upload' )
{
	$img_sourse = plugin_dir_path( __FILE__ ) . "../includes/img/test.jpg";
	$img_sourse2 = pvs_upload_dir() . "/content/test.jpg";
	$img_watermark = pvs_upload_dir() . "/content/watermark.png";

	if ( $_FILES['watermark']['size'] > 0 )
	{
		if ( 2048 * 1024 >= $_FILES['watermark']['size'] )
		{
			if ( strtolower( pvs_get_file_info( $_FILES['watermark']['name'], "extention" ) ) ==
				"png" )
			{
				move_uploaded_file( $_FILES['watermark']['tmp_name'], $img_watermark );

				$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $img_watermark .
					"' where setting_key='watermark_photo'";
				$db->execute( $sql );
				
				pvs_update_setting('watermark_photo', $img_watermark);
			}
		}
	}

	$sql = "update " . PVS_DB_PREFIX . "settings set svalue=" . ( int )$_POST["position"] .
		" where setting_key='watermark_position'";
	$db->execute( $sql );

	$pvs_global_settings['watermark_position'] = ( int )$_POST["position"];

	if ( file_exists( $img_sourse ) and file_exists( $img_watermark ) )
	{
		copy( $img_sourse, $img_sourse2 );
		pvs_watermark( $img_sourse2, $img_watermark );
	}
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	$sql = "update " . PVS_DB_PREFIX .
		"settings set svalue='' where setting_key='watermark_photo'";
	$db->execute( $sql );

	@unlink( pvs_upload_dir() . "/content/watermark.png" );
}
?>


<h1><?php
echo pvs_word_lang( "watermark" )
?></h1>

<ul>
<li>You should upload *.png file with a transparent background</li>
<li>The watermarked previews are generated one time when you upload a photo. If you upload a new watermark you can bulk recreate old previews here: PVS -> Catalog -> Select action -> Regenerate thumbs.</li>
</ul>


<form Enctype="multipart/form-data" method="post">
<input type="hidden" name="action" value="upload">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php
echo pvs_word_lang( "position" )
?>:</b></th>
<th><b><?php
echo pvs_word_lang( "image" )
?>:</b></th>
</tr>
</thead>
<tr>
<td>

<script language="javascript">

function wposition(j)
{
	document.getElementById('position').value=j
	for(i=1;i<10;i++)
	{
		if(i==j){document.getElementById('ris'+i).style.backgroundColor="#dd5044"}
		else{document.getElementById('ris'+i).style.backgroundColor="#68b5eb"}
	}
}

</script>


<table>
<tr>
<?php
for ( $i = 1; $i < 10; $i++ )
{
?>
	<td style="padding:0;margin:0">
		<div id="ris<?php
	echo $i
?>" onClick="wposition(<?php
	echo $i
?>)" style="cursor:pointer;width:40px;height:40px;margin:0px 2px 2px 0px;background-color:#<?php
	if ( $pvs_global_settings["watermark_position"] == $i )
	{
		echo ( "dd5044" );
	} else
	{
		echo ( "68b5eb" );
	}
?>"></div>
	</td>
	<?php
	if ( $i % 3 == 0 )
	{
		echo ( "</tr><tr>" );
	}
}
?>
</tr>
</table>
<input type="hidden" name="position" id="position" value="<?php
echo $pvs_global_settings["watermark_position"]
?>">

</td>
<td><input type="file" name="watermark"><?php
if ( $pvs_global_settings["watermark_photo"] != "" )
{
?>
	<div style="margin-top:10px;margin-bottom:5px;"><img src="<?php
	echo ( pvs_upload_dir( 'baseurl' ) . '/content/test.jpg' );
?>"></div><div><a href="<?php
	echo ( pvs_plugins_admin_url( 'watermark/index.php' ) );
?>&action=delete" class="button button-secondary button-large"><?php
	echo pvs_word_lang( "delete" )
?></a></div>
<?php
}
?></td>
</tr>

</table>

<p><input type="submit" class="button button-primary button-large" value="<?php
echo pvs_word_lang( "save" )
?>"></p>
</form>










<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>