<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_upload" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Delete gallery
if ( @$_REQUEST["action"] == 'delete_gallery' )
{
	include ( "delete_gallery.php" );
}

//Delete gallery photo
if ( @$_REQUEST["action"] == 'delete_gallery_photo' )
{
	include ( "delete_gallery_photo.php" );
}

//Delete category
if ( @$_REQUEST["action"] == 'delete_category' )
{
	include ( "delete_category.php" );
}

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>






<h1><?php echo pvs_word_lang( "upload manager" )?>:</h1>


<script>


function reason_open(value) {
document.getElementById('reason'+value).style.display="inline";
document.getElementById('reason_edit'+value).style.display="none";
}

function reason_close(value) {
document.getElementById('reason'+value).style.display="none";
document.getElementById('reason_edit'+value).style.display="inline";
}




function pvs_upload_moderation(fid,fdo) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_upload_moderation&fid=' + fid + '&fdo=' + fdo,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+fid).innerHTML = data;
		}
	});
}


function pvs_upload_moderation_category(fid,fdo) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_upload_moderation_category&fid=' + fid + '&fdo=' + fdo,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+fid).innerHTML = data;
		}
	});
}


function pvs_refuse_reason(fid) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_refuse_reason&fid=' + fid + '&fcontent=' + document.getElementById('reason_text'+fid).value,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('reason_content'+fid).innerHTML = data;
			reason_close(fid);
		}
	});
}
</script>



<?php
$d = 1;

if ( isset( $_REQUEST["d"] ) ) {
	$d = ( int )$_REQUEST["d"];
} else
{
	if ( $pvs_global_settings["allow_vector"] ) {
		$d = 5;
	}
	if ( $pvs_global_settings["allow_audio"] ) {
		$d = 4;
	}
	if ( $pvs_global_settings["allow_video"] ) {
		$d = 3;
	}
	if ( $pvs_global_settings["allow_photo"] ) {
		$d = 2;
	}
}
?>



<h2 class="nav-tab-wrapper">
    		<?php
if ( $pvs_global_settings["allow_photo"] ) {
?>
				<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=2" class="nav-tab <?php if ( $d == 2 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "photo" )?></a>
			<?php
}
if ( $pvs_global_settings["allow_video"] ) {
?>
				<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=3"  class="nav-tab <?php if ( $d == 3 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "video" )?></a>
			<?php
}
if ( $pvs_global_settings["allow_audio"] ) {
?>
				<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=4"  class="nav-tab <?php if ( $d == 4 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "audio" )?></a>
			<?php
}
if ( $pvs_global_settings["allow_vector"] ) {
?>
				<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=5"  class="nav-tab <?php if ( $d == 5 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "vector" )?></a>
			<?php
}
?>
			<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=1"  class="nav-tab <?php if ( $d == 1 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "categories" )?></a>
			<?php
if ( $pvs_global_settings["prints_lab"] ) {
?>
				<a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));
?>&d=6"  class="nav-tab <?php if ( $d == 6 or $d == 7 ) { echo ( "nav-tab-active" ); } ?>"><?php echo pvs_word_lang( "prints lab" )?></a>
				<?php
}
?>
</h2>





<?php
//Текущая страница
if ( ! isset( $_REQUEST["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_REQUEST["str"];
}

//Количество новостей на странице
$kolvo = $pvs_global_settings["k_str"];

//Количество страниц на странице
$kolvo2 =  PVS_PAGE_NUMBER;

if ( isset( $_REQUEST["status"] ) ) {
	$pstatus = ( int )$_REQUEST["status"];
} else
{
	$pstatus = -1;
}

if ( isset( $_REQUEST["pid"] ) ) {
	$pid = ( int )$_REQUEST["pid"];
} else
{
	$pid = 0;
}

if ( isset( $_REQUEST["ptitle"] ) ) {
	$ptitle = ( int )$_REQUEST["ptitle"];
} else
{
	$ptitle = 0;
}

if ( isset( $_REQUEST["pviewed"] ) ) {
	$pviewed = ( int )$_REQUEST["pviewed"];
} else
{
	$pviewed = 0;
}

if ( isset( $_REQUEST["pdownloads"] ) ) {
	$pdownloads = ( int )$_REQUEST["pdownloads"];
} else
{
	$pdownloads = 0;
}

if ( isset( $_REQUEST["pdata"] ) ) {
	$pdata = ( int )$_REQUEST["pdata"];
} else
{
	$pdata = 2;
}

if ( isset( $_REQUEST["puser"] ) ) {
	$puser = ( int )$_REQUEST["puser"];
} else
{
	$puser = 0;
}

//Status
$com = "";
if ( $pstatus >= 0 ) {
	if ( $pstatus == 2 ) {
		$com = " and published=-1";
	} else {
		$com = " and published=" . $pstatus;
	}
}

//Sort
$com2 = "";
if ( $pdata == 1 ) {
	$com2 = " order by data";
}
if ( $pdata == 2 ) {
	$com2 = " order by data desc";
}
if ( $pdownloads == 1 ) {
	$com2 = " order by downloaded";
}
if ( $pdownloads == 2 ) {
	$com2 = " order by downloaded desc";
}
if ( $pid == 1 ) {
	$com2 = " order by id";
}
if ( $pid == 2 ) {
	$com2 = " order by id desc";
}
if ( $ptitle == 1 ) {
	$com2 = " order by title";
}
if ( $ptitle == 2 ) {
	$com2 = " order by title desc";
}
if ( $pviewed == 1 ) {
	$com2 = " order by viewed";
}
if ( $pviewed == 2 ) {
	$com2 = " order by viewed desc";
}
if ( $puser == 1 ) {
	$com2 = " order by author";
}
if ( $puser == 2 ) {
	$com2 = " order by author desc";
}

//search
$search = "";
if ( isset( $_POST["search"] ) ) {
	$search = pvs_result( $_POST["search"] );
}
if ( isset( $_REQUEST["search"] ) ) {
	$search = pvs_result( $_REQUEST["search"] );
}
if ( $search != "" ) {
	$com .= " and author='" . $search . "'";
}

$mstatus = array();
$mstatus["all"] = -1;
$mstatus["approved"] = 1;
$mstatus["pending"] = 0;
$mstatus["declined"] = 2;

$varsort = "&pid=" . $pid . "&ptitle=" . $ptitle . "&pviewed=" . $pviewed .
	"&pdownloads=" . $pdownloads . "&pdata=" . $pdata . "&puser=" . $puser .
	"&search=" . $search;

if ( $pid == 1 ) {
	$varsort_id = "&pid=2&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} elseif ( $pid == 2 ) {
	$varsort_id = "&pid=1&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} else
{
	$varsort_id = "&pid=1&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
}

if ( $ptitle == 1 ) {
	$varsort_title = "&pid=0&ptitle=2&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} elseif ( $ptitle == 2 ) {
	$varsort_title = "&pid=0&ptitle=1&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} else
{
	$varsort_title = "&pid=0&ptitle=1&pviewed=0&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
}

if ( $pviewed == 1 ) {
	$varsort_viewed = "&pid=0&ptitle=0&pviewed=2&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} elseif ( $pviewed == 2 ) {
	$varsort_viewed = "&pid=0&ptitle=0&pviewed=1&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
} else
{
	$varsort_viewed = "&pid=0&ptitle=0&pviewed=2&pdownloads=0&pdata=0&puser=0&search=" .
		$search;
}

if ( $pdownloads == 1 ) {
	$varsort_downloads =
		"&pid=0&ptitle=0&pviewed=0&pdownloads=2&pdata=0&puser=0&search=" . $search;
} elseif ( $pdownloads == 2 ) {
	$varsort_downloads =
		"&pid=0&ptitle=0&pviewed=0&pdownloads=1&pdata=0&puser=0&search=" . $search;
} else
{
	$varsort_downloads =
		"&pid=0&ptitle=0&pviewed=0&pdownloads=2&pdata=0&puser=0&search=" . $search;
}

if ( $pdata == 1 ) {
	$varsort_data = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=2&puser=0&search=" .
		$search;
} elseif ( $pdata == 2 ) {
	$varsort_data = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=1&puser=0&search=" .
		$search;
} else
{
	$varsort_data = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=2&puser=0&search=" .
		$search;
}

if ( $puser == 1 ) {
	$varsort_user = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=2&search=" .
		$search;
} elseif ( $puser == 2 ) {
	$varsort_user = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=1&search=" .
		$search;
} else
{
	$varsort_user = "&pid=0&ptitle=0&pviewed=0&pdownloads=0&pdata=0&puser=1&search=" .
		$search;
}

if ( $d == 2 ) {
	$table = "media_id = 1";
}
if ( $d == 3 ) {
	$table = "media_id = 2";
}
if ( $d == 4 ) {
	$table = "media_id = 3";
}
if ( $d == 5 ) {
	$table = "media_id = 4";
}
?>

<?php
if ( $d != 1 and $d != 6 and $d != 7 ) {
?>





<div id="catalog_menu">
<form method="post" action="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>" style="margin:0px">
<div class="toleft">
<span><?php echo pvs_word_lang( "author" )?>:</span>
<input type="hidden" name="d" value="<?php echo $d
?>">
<input type="text" name="search" style="width:200px" class="ft" value="<?php echo $search
?>" onClick="this.value=''">
</div>
<div class="toleft">
<span><?php echo pvs_word_lang( "type" )?>:</span>
<select name="status" style="width:120px" class="ft">
<option value="-1"><?php echo pvs_word_lang( "all" )?></option>
<option value="1" <?php
	if ( $pstatus == 1 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "approved" )?></option>
<option value="0" <?php
	if ( $pstatus == 0 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "pending" )?></option>
<option value="2" <?php
	if ( $pstatus == 2 ) {
		echo ( "selected" );
	}
?>><?php echo pvs_word_lang( "declined" )?></option>
</select>
</div>

<div class="toleft">
<span>&nbsp;</span>
<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "search" )?>">
</div>

<div class="toleft_clear"></div>
</form>
</div>
<?php
}
?>



<?php
if ( $d == 1 ) {
	include ( "publications_category.php" );
}

if ( $d == 2 ) {
	include ( "publications_content.php" );
}

if ( $d == 3 ) {
	include ( "publications_content.php" );
}

if ( $d == 4 ) {
	include ( "publications_content.php" );
}

if ( $d == 5 ) {
	include ( "publications_content.php" );
}

if ( $d == 6 ) {
	include ( "publications_galleries.php" );
}

if ( $d == 7 ) {
	include ( "gallery.php" );
}
?>

















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>