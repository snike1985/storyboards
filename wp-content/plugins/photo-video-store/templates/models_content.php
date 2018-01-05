<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	
	exit();
}


include ( "profile_top.php" );?>


<h1><?php echo pvs_word_lang( "models" )?></h1>






<?php
$sql = "select * from " . PVS_DB_PREFIX . "models where user='" . pvs_result( pvs_get_user_login () ) .
	"' and id_parent=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
?>

<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/models-edit/?id=<?php echo $rs->row["id_parent"] ?>" name="uploadform">


<div class="form_field">
	<span><b><?php echo pvs_word_lang( "title" )?>:</b></span>
	<input class='ibox form-control' name="title" value="<?php echo $rs->row["name"] ?>" type="text" style="width:300px">
</div>


<div class="form_field">
	<span><b><?php echo pvs_word_lang( "description" )?>:</b></span>
	<textarea name="description"  class='ibox form-control' style="width:400px;height:200px"><?php echo $rs->row["description"] ?>
	</textarea>
</div>


<div class="form_field">
	<span><b><?php echo pvs_word_lang( "photo" )?>:</b></span>
	<input name="modelphoto" type="file" style="width:300px" class='ibox form-control'> 

	<?php
	if ( $rs->row["modelphoto"] != "" and file_exists( pvs_upload_dir() . $rs->
		row["modelphoto"] ) ) {
?>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $rs->row["modelphoto"] ?>"><?php echo pvs_word_lang( "preview" )?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo (site_url( ) );?>/models-file-delete/?id=<?php echo $rs->row["id_parent"] ?>&type=modelphoto"><?php echo pvs_word_lang( "delete" )?></a>
	<?php
	}
?>
	<span class="smalltext">(*.jpg. <?php echo pvs_word_lang( "size" )?> < 1Mb.)</span>
</div>


<div class="form_field">
	<span><b><?php echo pvs_word_lang( "model property release" )?>:</b></span>
	<input name="model" type="file" style="width:300px" class='ibox form-control'>
	<?php
	if ( $rs->row["model"] != "" and file_exists( pvs_upload_dir() . $rs->
		row["model"] ) ) {
?>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $rs->row["model"] ?>"><?php echo pvs_word_lang( "preview" )?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo (site_url( ) );?>/models-file-delete/?id=<?php echo $rs->row["id_parent"] ?>&type=model"><?php echo pvs_word_lang( "delete" )?></a>
	<?php
	}
?>
	<span class="smalltext">(*.zip or *.pdf or *.jpg.  <?php echo pvs_word_lang( "size" )?> < 5Mb.)</span>
</div>


<div class="form_field">
	<input class='isubmit' value="<?php echo pvs_word_lang( "save" )?>" name="subm" type="submit">
</div>

</form>

<?php
}
?>





<?php
include ( "profile_bottom.php" );
?>