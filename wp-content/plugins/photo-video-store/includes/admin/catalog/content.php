<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_catalog" );
?>
<script>	


function model_add(model_id,type,model_name) {	
	if(type==0) {
		type_name="<?php echo pvs_word_lang( "Model release" )?>";
	}
	else {
		type_name="<?php echo pvs_word_lang( "Property release" )?>";
	}
	
	$('#models_list').append("<div class='clear' id='div_"+model_id+"' style='margin-bottom:5px'><div class='input-append' style='float:left;margin-right:4px'><a href='<?php echo(pvs_plugins_admin_url('models/index.php'));?>&action=content&d="+model_id+"' class='btn btn-small btn-default'><b><i class='fa fa-check' aria-hidden='true'></i> "+type_name+":</b> "+model_name+"</a></div><button class='btn btn-danger btn-small' type='button' onClick=\"pvs_model_delete('"+model_id+"');\"><?php echo pvs_word_lang( "delete" )?></button><input type='hidden' name='model"+model_id+"' value='"+type+"'></div>");
	
	document.getElementById('model0_'+model_id.toString()).style.display='none';
	document.getElementById('model1_'+model_id.toString()).style.display='none';
}

function pvs_model_delete(model_id) {
	$('#div_'+model_id.toString()).remove()
	document.getElementById('model0_'+model_id.toString()).style.display='block';
	document.getElementById('model1_'+model_id.toString()).style.display='block';
}



function translation_add(param_field,param_lang,param_lang2,param_lang3,param_type) {
	if(param_type=="text_translation") {
		input_code="<input type='text' name='translate_"+param_field+"_"+param_lang3+"' style='width:400px' class='ibox form-control' value=''>";
	}
	else {
		input_code="<textarea id='translate_"+param_field+"_"+param_lang3+"' name='translate_"+param_field+"_"+param_lang3+"' style='width:400px;height:120px' class='ibox form-control'></textarea>";
	}
	
	$('#trans_'+param_field).append("<div class='clear' id='div_"+param_field+"_"+param_lang3+"' style='padding-top:20px'><div class='input-append' style='float:left;margin-right:4px'>"+input_code+"<span class='add-on' style='width:120px;text-align:left'><img src='<?php echo(pvs_plugins_url());
?>/includes/admin/includes/img/languages/"+param_lang2+".gif'>&nbsp;<font class='langtext'>"+param_lang+"</font></span></div><button class='btn btn-danger' type='button' onClick=\"translation_delete('"+param_field+"','"+param_lang3+"');\"><?php echo pvs_word_lang( "delete" )?></button></div>");
	
	document.getElementById('li_'+param_field+'_'+param_lang3).style.display='none';
}

function translation_delete(param_field,param_lang3) {
	$('#div_'+param_field+'_'+param_lang3).remove()
	document.getElementById('li_'+param_field+'_'+param_lang3).style.display='block';
}

function change_group(value) {
	$(".group_settings").css("display","none");
	$(".group_"+value).css("display","block");
	$(".menu_settings").removeClass('nav-tab-active');
	$(".menu_settings_"+value).addClass('nav-tab-active');
	
	if(value == 'google' && $(".gllpLatlonPicker")) 
	{
		$(document).gMapsLatLonPicker().init( $(".gllpLatlonPicker") );
	}
}

$(document).ready(function() {
	change_group('files');
});
</script>


<?php
//If the item is new
$id = 0;
if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];
}

//Get type
$type = "photo";
if ( isset( $_GET["type"] ) ) {
	$type = pvs_result( $_GET["type"] );
}

if ( isset( $_GET["id"] ) ) {
	$sql = "select media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
		$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$type = pvs_media_type($rs->row["media_id"]);
	}
}

$user_info  = get_userdata(get_current_user_id());

//Fields list
$admin_fields = array(
	"category",
	"title",
	"description",
	"keywords",
	"author",
	"file",
	"data",
	"published",
	"featured",
	"viewed",
	"downloaded",
	"free",
	"exclusive",
	"contacts",
	"content_type",
	"model",
	"adult",
	"vote_like",
	"vote_dislike",
	"collections"
	);

$admin_names = array(
	pvs_word_lang( "category" ),
	pvs_word_lang( "title" ),
	pvs_word_lang( "description" ),
	pvs_word_lang( "keywords" ),
	pvs_word_lang( "author" ),
	pvs_word_lang( "file for sale" ),
	pvs_word_lang( "date" ),
	pvs_word_lang( "published" ),
	pvs_word_lang( "featured" ),
	pvs_word_lang( "viewed" ),
	pvs_word_lang( "downloads" ),
	pvs_word_lang( "free" ),
	pvs_word_lang( "exclusive price" ),
	pvs_word_lang( "contact us to get the price" ),
	pvs_word_lang( "content type" ),
	pvs_word_lang( "models" ),
	pvs_word_lang( "adult content" ),
	pvs_word_lang( "like" ),
	pvs_word_lang( "dislike" ),
	pvs_word_lang( "Collections based on the items" )
	);

//Fields meanings
$admin_meanings = array(
	"0",
	"",
	"",
	"",
	$user_info -> user_login,
	"",
	pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) ),
	"1",
	"0",
	"0",
	"0",
	"0",
	"0",
	"0",
	$pvs_global_settings["content_type"],
	"",
	0,
	0,
	0,
	""
	);

//Fields types
$admin_types = array(
	"category_tree",
	"text_translation",
	"textarea_translation",
	"textarea_translation",
	"author",
	"file",
	"data",
	"checkbox",
	"checkbox",
	"int",
	"int",
	"checkbox",
	"checkbox",
	"checkbox",
	"content_type",
	"model",
	"checkbox",
	"int",
	"int",
	"collections"
	);

if ( $type == "photo" ) {

	$admin_fields[] = "editorial";
	$admin_names[] = pvs_word_lang( "editorial" );
	$admin_meanings[] = "";
	$admin_types[] = "checkbox";
}

if ( $type == "video" ) {
	$admin_fields[] = "duration";
	$admin_names[] = pvs_word_lang( "duration" );
	$admin_meanings[] = 0;
	$admin_types[] = "duration";

	$admin_fields[] = "format";
	$admin_names[] = pvs_word_lang( "clip format" );
	$admin_meanings[] = "";
	$admin_types[] = "format";

	$admin_fields[] = "ratio";
	$admin_names[] = pvs_word_lang( "Aspect Ratio" );
	$admin_meanings[] = "";
	$admin_types[] = "ratio";

	$admin_fields[] = "rendering";
	$admin_names[] = pvs_word_lang( "Field Rendering" );
	$admin_meanings[] = "";
	$admin_types[] = "rendering";

	$admin_fields[] = "frames";
	$admin_names[] = pvs_word_lang( "Frames per Second" );
	$admin_meanings[] = "";
	$admin_types[] = "frames";

	$admin_fields[] = "holder";
	$admin_names[] = pvs_word_lang( "Copyright Holder" );
	$admin_meanings[] = "";
	$admin_types[] = "text";

	$admin_fields[] = "usa";
	$admin_names[] = pvs_word_lang( "U.S. 2257 Information" );
	$admin_meanings[] = "";
	$admin_types[] = "text";
}

if ( $type == "audio" ) {
	$admin_fields[] = "duration";
	$admin_names[] = pvs_word_lang( "duration" );
	$admin_meanings[] = 0;
	$admin_types[] = "duration";

	$admin_fields[] = "source";
	$admin_names[] = pvs_word_lang( "Track Source" );
	$admin_meanings[] = "";
	$admin_types[] = "source";

	$admin_fields[] = "format";
	$admin_names[] = pvs_word_lang( "Track Format" );
	$admin_meanings[] = "";
	$admin_types[] = "track_format";

	$admin_fields[] = "holder";
	$admin_names[] = pvs_word_lang( "Copyright Holder" );
	$admin_meanings[] = "";
	$admin_types[] = "text";

}


if ( $pvs_global_settings["google_coordinates"] ) {
	$admin_fields[] = "google_x";
	$admin_names[] = pvs_word_lang( "Google coordinate X" );
	$admin_meanings[] = 0;
	$admin_types[] = "float";

	$admin_fields[] = "google_y";
	$admin_names[] = pvs_word_lang( "Google coordinate Y" );
	$admin_meanings[] = 0;
	$admin_types[] = "float";
}

//If it isn't a new item
if ( $id != 0 ) {

	//Get field's meanings
	$sql = "select id,title,description,keywords,author,data,published,featured,viewed,downloaded,free,content_type,google_x,google_y,editorial,adult,exclusive,contacts,vote_like,vote_dislike,duration,format,ratio,rendering,frames,holder,usa,source from " .
			PVS_DB_PREFIX . "media where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		for ( $i = 1; $i < count( $admin_fields ); $i++ ) {
			if ( $admin_fields[$i] != "file" )
			{
				$admin_meanings[$i] = @ $rs->row[$admin_fields[$i]];
			}
		}
	}
}

//Category's list
$category_ids = array();

if ( $id != 0 ) {
	$sql = "select category_id from " . PVS_DB_PREFIX .
		"category_items where publication_id=" . $id;
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$category_ids[$rs->row["category_id"]] = 1;
		$rs->movenext();
	}
}

$itg = "";
$nlimit = 0;
pvs_build_menu_admin_tree( 0, "admin" );
$admin_meanings[0] = $itg;
?>
<link rel="stylesheet" href="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.treeview.css" />
<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.cookie.js"></script>
<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/treeview/jquery.treeview.js"></script>



<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php
if ( $id == 0 ) {
	echo ( pvs_word_lang( "add" ) . " " );
} else
{
	echo ( pvs_word_lang( "edit" ) . " " );
}

if ( $type == "photo" ) {
	echo ( pvs_word_lang( "photo" ) );
}
if ( $type == "video" ) {
	echo ( pvs_word_lang( "video" ) );
}
if ( $type == "audio" ) {
	echo ( pvs_word_lang( "audio" ) );
}
if ( $type == "vector" ) {
	echo ( pvs_word_lang( "vector" ) );
}

//upload limits:
$lvideo = "UNLIMITED ";
$lpreviewvideo = "UNLIMITED ";
$laudio = "UNLIMITED ";
$lpreviewaudio = "UNLIMITED ";
$lvector = "UNLIMITED ";

//File form for photos
$file_form = true;

//Remove temp files
$tmp_folder = "user_" . get_current_user_id();
pvs_remove_files_from_folder( $tmp_folder );
?>:</h1>

<?php echo pvs_build_admin_form( pvs_plugins_admin_url( 'catalog/index.php' ) . "&action=add&id=" . $id, $type )?>

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
