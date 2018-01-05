<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );

//If it is new
$id = 0;
if ( isset( $_GET["id"] ) )
{
	$id = ( int )$_GET["id"];
}

//Fields list
$admin_fields = array(
	"name",
	"percentage",
	"percentage_subscription",
	"percentage_prints",
	"priority",
	"category",
	"upload",
	"upload2",
	"upload3",
	"upload4",
	"menu",
	"blog",
	"photolimit",
	"videolimit",
	"previewvideolimit",
	"audiolimit",
	"previewaudiolimit",
	"vectorlimit" );

$admin_names = array(
	pvs_word_lang( "title" ),
	pvs_word_lang( "commission" ) . " &mdash; " . pvs_word_lang( "orders" ) .
		" (to seller)",
	pvs_word_lang( "commission" ) . " &mdash; " . pvs_word_lang( "subscription" ) .
		" (to seller)",
	pvs_word_lang( "commission" ) . " &mdash; " . pvs_word_lang( "prints" ) .
		" (to seller)",
	pvs_word_lang( "priority" ),
	pvs_word_lang( "Allow to create category" ),
	pvs_word_lang( "Allow to upload photo" ),
	pvs_word_lang( "Allow to upload video" ),
	pvs_word_lang( "Allow to upload audio" ),
	pvs_word_lang( "Allow to upload vector" ),
	pvs_word_lang( "Show in menu" ),
	pvs_word_lang( "Blog" ),
	pvs_word_lang( "Upload photo limit (Mb)" ),
	pvs_word_lang( "Upload video limit (Mb)" ),
	pvs_word_lang( "Upload preview video limit" ),
	pvs_word_lang( "Upload audio limit (Mb)" ),
	pvs_word_lang( "Upload preview audio limit" ),
	pvs_word_lang( "Upload vector limit (Mb)" ) );

//Fields meanings
$admin_meanings = array(
	"",
	"50",
	"50",
	"50",
	"1",
	"1",
	"1",
	"1",
	"1",
	"1",
	"0",
	"0",
	"10",
	"10",
	"10",
	"10",
	"10",
	"10" );

//Fields types
$admin_types = array(
	"text",
	"commission",
	"commission",
	"commission",
	"int",
	"checkbox",
	"checkbox",
	"checkbox",
	"checkbox",
	"checkbox",
	"checkbox",
	"checkbox",
	"int",
	"int",
	"int",
	"int",
	"int",
	"int" );

//If it isn't a new category
if ( $id != 0 )
{
	//Get field's meanings
	$sql = "select name,priority,category,upload,upload2,upload3,upload4,menu,blog,percentage,percentage_prints,percentage_subscription,percentage_type,percentage_prints_type,percentage_subscription_type,photolimit,videolimit,previewvideolimit,audiolimit,previewaudiolimit,vectorlimit from " .
		PVS_DB_PREFIX . "user_category where id_parent=" . ( int )$_GET["id"];
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
echo ( pvs_plugins_admin_url( 'seller_categories/index.php' ) );
?>" class="btn btn-mini btn-primary btn-sm"><i class="icon-arrow-left icon-white fa fa-arrow-left"></i>&nbsp; <?php
echo pvs_word_lang( "back" )
?></a></div>


<h1><?php
if ( $id == 0 )
{
	echo ( pvs_word_lang( "add" ) . " &mdash; " . pvs_word_lang( "customer categories" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "customer categories" ) );
}
?></h1>

<?php
echo pvs_build_admin_form( pvs_plugins_admin_url( 'seller_categories/index.php' ) .
	"&action=add&id=" . $id, "catalog" )
?>