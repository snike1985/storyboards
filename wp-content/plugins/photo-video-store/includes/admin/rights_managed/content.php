<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );
?>


<script>
function open_preview(id,value,id_element)
{
	//$.colorbox({width:"500",height:"", href:"<?php
echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&action=preview&id="+id+"&events="+value+"&id_element="+id_element});

	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_rights_managed_preview&id='+id+'&events='+value+'&id_element='+id_element,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			$.colorbox({width:"500",height:"", html:data});
		}
	});
}
</script>

<?php
$sql = "select title from " . PVS_DB_PREFIX . "rights_managed where id=" . ( int )
	$_REQUEST["id"];
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<div class="back"><a href="<?php
	echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>" class="btn btn-mini btn-primary btn-sm"><i class="icon-arrow-left icon-white fa fa-arrow-left"></i> <?php
	echo pvs_word_lang( "back" )
?></a></div>
	<a class="btn btn-success toright" href="javascript:open_preview('<?php
	echo $_REQUEST["id"]
?>','step_add',0)" style="margin-left:20px"><i class="icon-folder-open icon-white fa fa-plus"></i>&nbsp; <?php
	echo pvs_word_lang( "add step" )
?></a>

	<h1>
		<?php
	echo ( $rs->row["title"] );
?>:
	</h1>
	
	
	<div class="box box_padding">
	<?php
	$itg = "";
	$nlimit = 0;
	pvs_build_rights_managed_admin( 0 );
	echo ( $itg );
}
?>
</div>