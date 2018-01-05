<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_collections" );



//If it is new
$id = 0;
if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];
}

//Fields list
$admin_fields = array(
	"title",
	"description",
	"active",
	"types",
	"price",
	"photo"
	);

$admin_names = array(
	pvs_word_lang( "title" ),
	pvs_word_lang( "description" ),
	pvs_word_lang( "Active" ),
	pvs_word_lang( "type" ),
	pvs_word_lang( "price" ),
	pvs_word_lang( "preview" )
	);

//Fields meanings
$admin_meanings = array(
	"",
	"",
	1,
	0,
	1,
	""
	);

//Fields types
$admin_types = array(
	"text",
	"textarea",
	"checkbox",
	"collection_type",
	"float",
	"file"
	);

//If it isn't a new category
if ( $id != 0 ) {
	//Get field's meanings
	$sql = "select title,description,active,types,price from " . PVS_DB_PREFIX .
		"collections where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		for ( $i = 0; $i < count( $admin_fields ); $i++ ) {
			$admin_meanings[$i] = @$rs->row[$admin_fields[$i]];
		}
	}
	
	if(file_exists(pvs_upload_dir() . "/content/categories/collection_" . ( int )@$_GET["id"] . ".jpg")) {
		$admin_meanings[5] = "/content/categories/collection_" . ( int )@$_GET["id"] . ".jpg";
	}
}
?>

<link rel="stylesheet" href="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.treeview.css" />
<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.cookie.js"></script>
<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.treeview.js"></script>

<script>





function collection_change(value)
{
	if (value == 0)
	{
		$('#category_list_collection').css("display","block");
	}
	else
	{
		$('#category_list_collection').css("display","none");
	}
}
</script>
<?php
//Category's list
$category_ids = array();

if ( $id != 0 ) {
	$sql = "select category_id from " . PVS_DB_PREFIX .
		"collections_items where collection_id=" . $id;
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$category_ids[$rs->row["category_id"]] = 1;
		$rs->movenext();
	}
}

$itg = "";
$nlimit = 0;
pvs_build_menu_admin_tree( 0, "admin" );
$category_list_collection = $itg;
?>

<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'collections/index.php' ) );
?>"><b>&#171; <?php echo pvs_word_lang( "back" )?></b></a></div>


<h1><?php
if ( $id == 0 ) {
	echo ( pvs_word_lang( "add" ) . " &mdash; " . pvs_word_lang( "Collections" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "Collections" ) );
}
?>:</h1>




<?php echo pvs_build_admin_form( pvs_plugins_admin_url( 'collections/index.php' ) . "&action=add&id=" . $id, "category" )?>
<script>

function treemenu_init()
{
	$("#categories_tree_menu").treeview({
		collapsed: false,
		persist: "cookie",
		cookieId: "treeview-black"
	});
}
treemenu_init();
</script>