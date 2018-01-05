<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );

//If it is new
$id = 0;
if ( isset( $_GET["id"] ) )
{
	$id = ( int )$_GET["id"];
}

//Fields list
$admin_fields = array(
	"name",
	"description",
	"user",
	"model",
	"modelphoto" );

$admin_names = array(
	pvs_word_lang( "title" ),
	pvs_word_lang( "description" ),
	pvs_word_lang( "user" ),
	pvs_word_lang( "file" ),
	pvs_word_lang( "photo" ) );

//Fields meanings
$admin_meanings = array(
	"",
	"",
	"",
	"",
	"" );

//Fields types
$admin_types = array(
	"text",
	"textarea",
	"author",
	"filepdf",
	"file" );

//If it isn't a new category
if ( $id != 0 )
{
	//Get field's meanings
	$sql = "select name,description,user,model,modelphoto from " . PVS_DB_PREFIX .
		"models where id_parent=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		for ( $i = 0; $i < count( $admin_fields ); $i++ )
		{
			$admin_meanings[$i] = $rs->row[$admin_fields[$i]];
		}
	}
}
?>

<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'models/index.php' ) );
?>" class="btn btn-primary btn-sm btn-mini"><b><i class="fa fa-arrow-left"></i>&nbsp;<?php
echo pvs_word_lang( "back" )
?></b></a></div>


<h1><?php
if ( $id == 0 )
{
	echo ( pvs_word_lang( "add" ) . " &mdash; " . pvs_word_lang( "model property release" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "model property release" ) );
}
?></h1>

<?php
echo pvs_build_admin_form( pvs_plugins_admin_url( 'models/index.php' ) .
	"&action=add&id=" . $id, "category" )
?>