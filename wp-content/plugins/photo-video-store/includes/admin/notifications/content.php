<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_notifications" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>


<?php
$sql = "select events,title,message,enabled,priority,subject,html,message_html from " .
	PVS_DB_PREFIX . "notifications where events='" . pvs_result( $_GET["events"] ) .
	"'";
$rs->open( $sql );
if ( ! $rs->eof ) {

	$content_text = $rs->row["message"];

	$content_html = $rs->row["message_html"]; 
?>


<div class="back"><a href="<?php echo(pvs_plugins_admin_url('notifications/index.php'));?>" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<script type='text/javascript' src='<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/tiny_mce.js'></script>

<script>

tinyMCE.init({
		// General options
		mode : "exact",
		elements : "message_html",
		theme : 'advanced',
		plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks',
		document_base_url : '<?php echo site_url()?>/',
		convert_urls : false,
		relative_urls : false,

		// Theme options
		theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
		theme_advanced_buttons4 : 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : '<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/css/content.css',

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : '<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/lists/template_list.js',
		external_link_list_url : '<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/lists/link_list.js',
		external_image_list_url : '<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/lists/image_list.js',
		media_external_list_url : '<?php echo(pvs_plugins_url());?>/includes/plugins/tiny_mce/lists/media_list.js',

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'}
		],


	});

function open_content(param) {
	if(param==0) {
		document.getElementById('content_text').style.display='block';
		document.getElementById('content_html').style.display='none';
	}
	else {
		document.getElementById('content_html').style.display='block';
		document.getElementById('content_text').style.display='none';	
	}
}

<?php
	if ( $rs->row["html"] == 1 ) {
?>
	open_content(1);
	<?php
	}
?>
</script>


<h1>
<?php echo ( pvs_word_lang( "edit" ) . " &mdash; " . $rs->row["title"] );
?>:
</h1>
<div class="box box_padding">
<form method="post" action="<?php echo(pvs_plugins_admin_url('notifications/index.php'));?>&action=save&events=<?php echo $rs->row["events"] ?>">

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "subject" )?>:</b></span>
	<input type="text" name="subject" style="width:500px" value="<?php echo $rs->row["subject"] ?>">
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "type" )?>:</b></span>
	<input type="radio" name="html" value="0" <?php
	if ( $rs->row["html"] != 1 ) {
		echo ( "checked" );
	}
?> onClick="open_content(0);">&nbsp;Text&nbsp;&nbsp;&nbsp;
	<input type="radio" name="html" value="1" <?php
	if ( $rs->row["html"] == 1 ) {
		echo ( "checked" );
	}
?> onClick="open_content(1);">&nbsp;HTML
</div>

<div class="form_field">
	<span><b><?php echo pvs_word_lang( "content" )?>:</b></span>
	<div id="content_text" <?php
	if ( $rs->row["html"] == 1 ) {
		echo ( "style='display:none'" );
	}
?>>
		<textarea name="message_text" id="message_text" style="width:700px;height:400px"><?php echo $rs->row["message"] ?></textarea>
	</div>
	<div id="content_html" <?php
	if ( $rs->row["html"] != 1 ) {
		echo ( "style='display:none'" );
	}
?>>
		<textarea name="message_html" id="message_html" style="width:700px;height:400px"><?php echo $content_html
?></textarea>
	</div>
</div>

	<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" value="<?php echo pvs_word_lang( "save" )?>" class="btn btn-primary" style="margin-top:20px">
		</div>
	</div>

</form>
</div>

<?php
}
?>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>