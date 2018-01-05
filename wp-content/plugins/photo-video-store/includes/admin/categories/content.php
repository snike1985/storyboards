<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_categories" );

//If the category is new
$id = 0;
if ( isset( $_GET["id"] ) )
{
	$id = ( int )$_GET["id"];
}

//Fields list
$admin_fields = array(
	"id_parent",
	"title",
	"priority",
	"password",
	"description",
	"keywords",
	"creation_date",
	"activation_date",
	"expiration_date",
	"photo",
	"location",
	"upload",
	"published",
	"featured" );

$admin_names = array(
	pvs_word_lang( "category" ),
	pvs_word_lang( "title" ),
	pvs_word_lang( "priority" ),
	pvs_word_lang( "password" ),
	pvs_word_lang( "description" ),
	pvs_word_lang( "keywords" ),
	pvs_word_lang( "Creation date" ),
	pvs_word_lang( "Activation date" ),
	pvs_word_lang( "expiration date" ),
	pvs_word_lang( "preview" ),
	pvs_word_lang( "Location" ),
	pvs_word_lang( "upload" ),
	pvs_word_lang( "published" ),
	pvs_word_lang( "featured" ) );

//Fields meanings
$admin_meanings = array(
	"0",
	"",
	"0",
	"",
	"",
	"",
	pvs_get_time(),
	pvs_get_time(),
	0,
	"",
	"",
	"1",
	"1",
	"0" );

//Fields types
if ( $pvs_global_settings["multilingual_categories"] )
{
	$admin_types = array(
		"category",
		"text_translation",
		"int",
		"text",
		"textarea_translation",
		"textarea_translation",
		"data",
		"data",
		"data_expire",
		"file",
		"text",
		"checkbox",
		"checkbox",
		"checkbox" );
} else
{
	$admin_types = array(
		"category",
		"text",
		"int",
		"text",
		"textarea",
		"textarea",
		"data",
		"data",
		"data_expire",
		"file",
		"text",
		"checkbox",
		"checkbox",
		"checkbox" );
}

if ( $pvs_global_settings["google_coordinates"] )
{
	$admin_fields[] = "google_x";
	$admin_names[] = pvs_word_lang( "Google coordinate X" );
	$admin_meanings[] = 0;
	$admin_types[] = "float";

	$admin_fields[] = "google_y";
	$admin_names[] = pvs_word_lang( "Google coordinate Y" );
	$admin_meanings[] = 0;
	$admin_types[] = "float";
}

//If it isn't a new category
if ( $id != 0 )
{
	//Get field's meanings
	$sql = "select id_parent,title, priority, password, description, keywords, photo, upload, published, featured,creation_date, activation_date, expiration_date, location, google_x, google_y from " .
		PVS_DB_PREFIX . "category where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		for ( $i = 0; $i < count( $admin_fields ); $i++ )
		{
			$admin_meanings[$i] = $rs->row[$admin_fields[$i]];
		}
	}
}

//Category's list
$itg = "";
$nlimit = 0;
pvs_build_menu_admin( 0, $admin_meanings[0], 2, $id );
$admin_meanings[0] = $itg;
?>

<div class="back"><a href="<?php
echo ( pvs_plugins_admin_url( 'categories/index.php' ) );
?>" class="btn btn-mini btn-primary"><i class="icon-arrow-left"></i> <?php
echo pvs_word_lang( "back" )
?></a></div>

<script>

function translation_add(param_field,param_lang,param_lang2,param_lang3,param_type)
{
	if(param_type=="text_translation")
	{
		input_code="<input type='text' name='translate_"+param_field+"_"+param_lang3+"' style='width:400px' class='ibox form-control' value=''>";
	}
	else
	{
		input_code="<textarea name='translate_"+param_field+"_"+param_lang3+"' style='width:400px;height:120px' class='ibox form-control'></textarea>";
	}
	
	$('#trans_'+param_field).append("<div class='clear' id='div_"+param_field+"_"+param_lang3+"' style='padding-top:20px'><div class='input-append' style='float:left;margin-right:4px'>"+input_code+"<span class='add-on' style='width:120px;text-align:left'><img src='<?php
echo ( pvs_plugins_url() . '/includes/admin/includes/img/languages/' );
?>"+param_lang2+".gif'>&nbsp;<font class='langtext'>"+param_lang+"</font></span></div><button class='btn btn-danger' type='button' onClick=\"translation_delete('"+param_field+"','"+param_lang3+"');\"><?php
echo pvs_word_lang( "delete" )
?></button></div>");
	
	document.getElementById('li_'+param_field+'_'+param_lang3).style.display='none';
}

function translation_delete(param_field,param_lang3)
{
	$('#div_'+param_field+'_'+param_lang3).remove()
	document.getElementById('li_'+param_field+'_'+param_lang3).style.display='block';
}


function set_expire_date(data_field, value)
{
	if(value == 0)
	{
		$('#ed_' + data_field).slideUp();
	}
	else
	{
		$('#ed_' + data_field).slideDown();
	}
}
</script>


<h1><?php
if ( $id == 0 )
{
	echo ( pvs_word_lang( "add category" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) );
}
?>:</h1>

<?php
echo pvs_build_admin_form( pvs_plugins_admin_url( 'categories/index.php' ) .
	"&action=add&id=" . $id, "category" )
?>