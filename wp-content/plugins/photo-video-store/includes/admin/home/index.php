<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_home" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "components_add.php" );
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "components_change.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "components_delete.php" );
}
?>

<a class="btn btn-success toright" href="<?php
echo ( pvs_plugins_admin_url( 'home/index.php' ) );
?>&action=content"><i class="icon-plus icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add" )
?></a>

<h1><?php
echo pvs_word_lang( "home page" )
?>:</h1>

<?php
if ( @$_REQUEST["action"] != 'content' )
{
?>

<div class="box box-solid">
<div class="box-body">
<p>
If you want to modify a home page you should edit the file on FTP:<br>
<b><?php echo( get_bloginfo( 'template_url' ) ); ?>/homepage.php</b>
</p><p>
You can place different file's sets by different criterias into the HTML code.
</p><p>
To add a new file set component you should insert the next code: <b>&lt;?php echo(pvs_show_homepage_component(COMPONENT_ID));?&gt;</b>.
</p>
<p>
The preview template is:
<b><?php echo( get_bloginfo( 'template_url' ) ); ?>/templates/item_home.php</b><br>You can create also item_home2.php and item_home3.php templates if elements have different views.</b>
</p>


</div>
</div>



<br>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
<tr>

<th><b><?php
	echo pvs_word_lang( "id" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "title" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "edit" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>

</tr>
</thead>
<?php
	$sql = "select * from " . PVS_DB_PREFIX . "components order by id";
	$rs->open( $sql );
	
	while ( ! $rs->eof )
	{
?>
<tr valign="top">
<td><?php
		echo $rs->row["id"]
?></td>
<td class="big"><?php
		echo $rs->row["title"]
?></td>
<td><div class="link_edit"><a href="<?php
		echo ( pvs_plugins_admin_url( 'home/index.php' ) );
?>&action=content&id=<?php
		echo $rs->row["id"]
?>"><?php
		echo pvs_word_lang( "edit" )
?></div></td>
<td>
<div class="link_delete">
<a href='<?php
		echo ( pvs_plugins_admin_url( 'home/index.php' ) );
?>&action=delete&id=<?php
		echo $rs->row["id"]
?>' onClick="return confirm('<?php
		echo pvs_word_lang( "delete" )
?>?');"><?php
		echo pvs_word_lang( "delete" )
?></a>
</div>
</td>
</tr>
<?php
		
		$rs->movenext();
	}
?>
</table>







<?php
} else
{
?>




<div class="box box_padding">








<?php
	if ( isset( $_GET["id"] ) )
	{
		$sql = "select * from " . PVS_DB_PREFIX . "components where id=" . ( int )$_GET["id"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
			$title = $rs->row["title"];
			$content = $rs->row["content"];
			$types = $rs->row["types"];
			$category = $rs->row["category"];
			$user = $rs->row["user"];
			$quantity = $rs->row["quantity"];
			$ctemplate = $rs->row["template"];
		}
?>
<form method=post Enctype="multipart/form-data" name="componentform">
<input type="hidden" name="action" value="change">
<input type="hidden" name="id" value="<?php
		echo $_GET["id"]
?>">
<?php
	} else
	{
		$title = "";
		$content = "";
		$types = "";
		$category = 0;
		$user = "";
		$quantity = 1;
		$ctemplate = 1;
?>
<form method=post Enctype="multipart/form-data" name="componentform">
<input type="hidden" name="action" value="add">
<?php
	}
?>



<script language="javascript">

function fslideshow()
{
	with(document.componentform)
	{
		if(slideshow.checked==true)
		{
			slideshowtime.disabled=false
		}
		else
		{
			slideshowtime.disabled=true
		}
	}
}

</script>




<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "title" )
?>:</b></span>
<input name="title" type="text" value="<?php
	echo $title
?>" style="width:300px">
</div>



<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "content" )
?>:</b></span>
<select name="content" style="width:300px">
<option value="">...</option>

<?php
	if ( $pvs_global_settings["allow_photo"] and ! $pvs_global_settings["printsonly"] )
	{
?>
	<option value="photo1" <?php
		if ( $content == "photo1" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "photos" )
?> - <?php
		echo pvs_word_lang( "Big preview" )
?></option>
	
	<option value="photo2" <?php
		if ( $content == "photo2" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "photos" )
?> - <?php
		echo pvs_word_lang( "Small preview" )
?></option>

<?php
	}
	if ( $pvs_global_settings["allow_video"] and ! $pvs_global_settings["printsonly"] )
	{
?>

	<option value="video" <?php
		if ( $content == "video" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "videos" )
?> - <?php
		echo pvs_word_lang( "Big preview" )
?></option>
	
	<option value="video2" <?php
		if ( $content == "video2" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "videos" )
?> - <?php
		echo pvs_word_lang( "Small preview" )
?></option>

<?php
	}
	if ( $pvs_global_settings["allow_audio"] and ! $pvs_global_settings["printsonly"] )
	{
?>

	<option value="audio" <?php
		if ( $content == "audio" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "audio" )
?> - <?php
		echo pvs_word_lang( "Big preview" )
?></option>
	
	<option value="audio2" <?php
		if ( $content == "audio2" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "audio" )
?> - <?php
		echo pvs_word_lang( "Small preview" )
?></option>

<?php
	}
	if ( $pvs_global_settings["allow_vector"] and ! $pvs_global_settings["printsonly"] )
	{
?>

	<option value="vector1" <?php
		if ( $content == "vector1" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "vector" )
?> - <?php
		echo pvs_word_lang( "Big preview" )
?></option>
	
	<option value="vector2" <?php
		if ( $content == "vector2" )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "vector" )
?> - <?php
		echo pvs_word_lang( "Small preview" )
?></option>

<?php
	}
?>

<option value="category" <?php
	if ( $content == "category" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "categories" )
?> - <?php
	echo pvs_word_lang( "preview" )
?></option>
	
<?php
	if ( $pvs_global_settings["prints"] )
	{

		$prints_mass = array();

		$sql_prints = "select id from " . PVS_DB_PREFIX .
			"prints_categories where active=1 order by priority";
		$dr->open( $sql_prints );
		while ( ! $dr->eof )
		{
			$prints_mass[] = $dr->row["id"];
			$dr->movenext();
		}
		$prints_mass[] = 0;

		foreach ( $prints_mass as $key => $value )
		{
			$sql_prints = "select id_parent,title from " . PVS_DB_PREFIX .
				"prints where category=" . $value . " order by priority";
			$dd->open( $sql_prints );
			while ( ! $dd->eof )
			{
				$chk = "";
				if ( $content == "print" . $dd->row["id_parent"] )
				{
					$chk = "selected";
				}
?>
			<option value="<?php
				echo 'print' . $dd->row["id_parent"]
?>"  <?php
				echo $chk
?>><?php
				echo pvs_word_lang( $dd->row["title"] )
?> - <?php
				echo pvs_word_lang( "preview" )
?></option>
		<?php
				$dd->movenext();
			}
		}

	}
?>	

</select>
</div>


<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "type" )
?>:</b></span>
<select name="types" style="width:300px">
<option value="">...</option>
<option value="featured" <?php
	if ( $types == "featured" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "featured" )
?></option>
<option value="new" <?php
	if ( $types == "new" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "new" )
?></option>
<option value="popular" <?php
	if ( $types == "popular" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "most popular" )
?></option>
<option value="downloaded" <?php
	if ( $types == "downloaded" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "most downloaded" )
?></option>
<option value="free" <?php
	if ( $types == "free" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "free download" )
?></option>
<option value="random" <?php
	if ( $types == "random" )
	{
		echo ( "selected" );
	}
?>><?php
	echo pvs_word_lang( "random" )
?></option>
</select>
</div>



<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "category" )
?>:</b></span>
<select name="category" style="width:300px">
<option value="0">...</option>
<?php
	$itg = "";
	$nlimit = 0;
	$iid = 0;
	if ( isset( $id ) )
	{
		$iid = $id;
	}
	pvs_build_menu_admin( 5, $category, 2, $iid );
	echo ( $itg );
?>
</select>
</div>






<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "user" )
?>:</b></span>
<select name="user" style="width:300px">
<option value="">...</option>
<?php
	$sql = "select ID, user_login from " . $table_prefix .
		"users order by user_login";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
?>
<option value="<?php
		echo $rs->row["user_login"]
?>" <?php
		if ( $user == $rs->row["user_login"] )
		{
			echo ( "selected" );
		}
?>><?php
		echo $rs->row["user_login"]
?></option>
<?php
		$rs->movenext();
	}
?>
</select>
</div>


<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "template" )
?>:</b></span>
<select name="ctemplate" style="width:300px">
<option value="1" <?php
	if ( $ctemplate == 1 )
	{
		echo ( "selected" );
	}
?>>item_home.php</option>
<option value="2" <?php
	if ( $ctemplate == 2 )
	{
		echo ( "selected" );
	}
?>>item_home2.php</option>
<option value="3" <?php
	if ( $ctemplate == 3 )
	{
		echo ( "selected" );
	}
?>>item_home3.php</option>
</select>
</div>




<div class="admin_field">
<span><b><?php
	echo pvs_word_lang( "quantity" )
?>:</b></span>
<input name="quantity" type="text" value="<?php
	echo $quantity
?>" style="width:80px">
</div>





<div class="admin_field">
<input type=submit value="<?php
	if ( isset( $_GET["id"] ) )
	{
		echo ( pvs_word_lang( "save" ) );
	} else
	{
		echo ( pvs_word_lang( "add" ) );
	}
?>" style="margin-top:7px" class="btn btn-primary">
</div>


</form>








</div>


<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>