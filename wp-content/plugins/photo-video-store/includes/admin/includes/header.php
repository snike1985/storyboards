<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div id='lightbox' style='top:0px;left:0px;position:absolute;z-index:1000;display:none'></div>

<script>      
site_lang = '<?php
echo ( $lang_symbol[$lng_original] );
?>';
site_lang_name = {};
site_lang_name2 = {};
site_lang_symbol= {};
<?php
$sql = "select name,activ from " . PVS_DB_PREFIX .
	"languages where display=1 order by name";
$dd->open( $sql );
while ( ! $dd->eof )
{
?>
	site_lang_name["<?php
	echo ( $lang_symbol[$dd->row["name"]] );
?>"] = "<?php
	echo ( $dd->row["name"] );
?>";
	<?php
	$lng3 = strtolower( $dd->row["name"] );
	if ( $lng3 == "chinese traditional" or $lng3 == "chinese simplified" )
	{
		$lng3 = "chinese";
	}
	if ( $lng3 == "afrikaans formal" or $lng3 == "afrikaans informal" )
	{
		$lng3 = "afrikaans";
	}
?>
	site_lang_name2["<?php
	echo ( $lang_symbol[$dd->row["name"]] );
?>"] = "<?php
	echo ( $lng3 );
?>";
	site_lang_symbol["<?php
	echo ( $dd->row["name"] );
?>"] = "<?php
	echo ( $lang_symbol[$dd->row["name"]] );
?>";
	<?php
	$dd->movenext();
}
?>

function pvs_deselect_row(value) 
{
	$("."+value).css("display","none");
	
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_deselect_row&id=' + value,
		success:function(data){
			
		}
	});
}

</script>
<div class="wrap">
