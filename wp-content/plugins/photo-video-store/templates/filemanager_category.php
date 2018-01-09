<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( ! isset( $_GET["id"] ) ) {
	$site = "upload_category";
} else
{
	$site = "publications";
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	exit();
}


include ( "profile_top.php" );
?>


<h1>
<?php
if ( ! isset( $_GET["id"] ) ) {
	echo ( pvs_word_lang( "create category" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "category" ) .
		" #" . $_GET["id"] );
}
?>
</h1>


<script>
	form_fields=new Array('folder','title','description');
	fields_emails=new Array(0,0,0);
	error_message="<?php echo pvs_word_lang( "Incorrect field" )?>";
</script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<?php
$title = "";
$description = "";
$keywords = "";
$password = "";
$creation_date = pvs_get_time();
$activation_date = pvs_get_time();
$expiration_date = 0;
$location = "";
$google_x = 0;
$google_y = 0;
$id_parent = 0;
if ( isset( $_GET["id"] ) ) {
	$sql = "select id,id_parent,title,description,keywords,userid,password,creation_date, activation_date, expiration_date, location, google_x, google_y from " .
		PVS_DB_PREFIX . "category where id=" . ( int )$_GET["id"] .
		" and userid=" . get_current_user_id();
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$title = $rs->row["title"];
		$description = $rs->row["description"];
		$keywords = $rs->row["keywords"];
		$password = $rs->row["password"];
		$creation_date = $rs->row["creation_date"];
		$activation_date = $rs->row["activation_date"];
		$expiration_date = $rs->row["expiration_date"];
		$location = $rs->row["location"];
		$google_x = $rs->row["google_x"];
		$google_y = $rs->row["google_y"];

		$id_parent = $rs->row["id_parent"];
	}
}
?>



<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/upload-category/?d=1<?php
if ( isset( $_GET["id"] ) ) {
	echo ( "&id=" . $_GET["id"] );
}
?>" name="uploadform"  onSubmit="return my_form_validate();">




<div name="sparent" id="sparent" class="form_field">
	<span><b><?php echo pvs_word_lang( "category" )?>:</b></span>
	<select name="id_parent" id="folder" style="width:300px" class='ibox form-control'>
	<option value=""></option>
	<?php
$itg = "";
$nlimit = 0;
pvs_build_menu_seller_upload(0, ( int )$id_parent, 2, 0 );
echo ( $itg );?>
	</select>
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "title" )?>:</b></span>
	<input class='ibox form-control' name="title" id="title" value="<?php echo $title
?>" type="text" style="width:300px">
</div>

<div  class="form_field">
	<span><b><?php echo pvs_word_lang( "description" )?>:</b></span>
	<textarea class='ibox form-control' name="description" id="description" style="width:300px;height:70px"><?php echo $description
?></textarea>
</div>

<div  class="form_field">
	<span><b><?php echo pvs_word_lang( "keywords" )?>:</b></span>
	<textarea class='ibox form-control' name="keywords" id="keywords" style="width:300px;height:70px"><?php echo $keywords
?></textarea>
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "password" )?>:</b></span>
	<input class='ibox form-control' name="password" id="password" value="<?php echo $password
?>" type="text" style="width:300px">
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "Location" )?>:</b></span>
	<input class='ibox form-control' name="location" id="location" value="<?php echo $location
?>" type="text" style="width:300px">
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "preview" )?>:</b></span>
	<input name="photo" type="file" style="width:300px" class="ibox form-control">
	<span class="smalltext">(*.jpg)</span>
</div>

<?php
if ( $pvs_global_settings["google_coordinates"] ) {
?>
<div  class="gllpLatlonPicker">
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "Google coordinate X" )?>:</b></span>
		<input class='ibox form-control gllpLatitude' name="google_x" value="<?php echo $google_x
?>" type="text" style="width:200px">
	</div>

	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "Google coordinate Y" )?>:</b></span>
		<input class='ibox form-control gllpLongitude' name="google_y" value="<?php echo $google_y
?>" type="text" style="width:200px">
	</div>
	
	<div class="form_field">
	<input type="hidden" class="gllpZoom" value="3"/>
	<input type="hidden" class="gllpUpdateButton" value="update map">
	<div class="gllpMap" id='map' style="width: 500px; height: 250px;margin-bottom:10px"></div>
	<input type="text" class="gllpSearchField ibox form-control" style="width:200px;display:inline">
	<input type="button" class="gllpSearchButton btn btn-default" value="<?php echo pvs_word_lang( "search" )?>">
	<script src='https://maps.googleapis.com/maps/api/js?sensor=false&key=<?php echo $pvs_global_settings["google_api"] ?>'></script>
	<script src='<?php echo pvs_plugins_url()?>/assets/js/gmap_picker/jquery-gmaps-latlon-picker.js'></script>
	</div>
</div>	
<?php
}
?>

<div class="form_field">
	<input class='isubmit' value="<?php echo pvs_word_lang( "save" )?>" type="submit">
</div>

</form>

<?php
include ( "profile_bottom.php" );
?>