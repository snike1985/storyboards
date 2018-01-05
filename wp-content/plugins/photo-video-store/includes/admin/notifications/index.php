<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_notifications" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Edit
if ( @$_REQUEST["action"] == 'save' )
{
	include ( "save.php" );
}



//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>




<h1><?php echo pvs_word_lang( "notifications" )?></h1>

<ul>

<li>The notification's emails can have 2 formats: <b>text</b> and <b>html</b>.</li> 

</ul>

<script>

function pvs_notification_preview(value) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_notification_preview&events=' + value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			$.colorbox({html:data,width:"700",height:"500"});
		}
	});
}



</script>


<form method="post">
<input type="hidden" name="action" value="change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>

<th><b><?php echo pvs_word_lang( "enabled" )?></b></th>
<th style="width:70%"><b><?php echo pvs_word_lang( "title" )?></b></th>
<th></th>
<th></th>
</tr>
</thead>
<?php

$sql = "select * from " . PVS_DB_PREFIX . "notifications order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
<tr valign="top">
<td><input type="checkbox" name="e<?php echo $rs->row["events"] ?>" <?php
	if ( $rs->row["enabled"] == 1 ) {
		echo ( "checked" );
	}
?>></td>
<td class="big"><?php echo $rs->row["title"] ?></td>
<td><div class="link_preview"><a href="javascript:pvs_notification_preview('<?php echo $rs->row["events"] ?>')" class="preview_link"><?php echo pvs_word_lang( "preview" )?></a></div></td>
<td><div class="link_edit"><a href="<?php echo(pvs_plugins_admin_url('notifications/index.php'));?>&action=content&events=<?php echo $rs->row["events"] ?>"><?php echo pvs_word_lang( "edit" )?></a></div></td>
</tr>
<?php
	
	$rs->movenext();
}
?>
</table>

<br>

	<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class="btn btn-primary">
		</div>
	</div>
</form>









<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>