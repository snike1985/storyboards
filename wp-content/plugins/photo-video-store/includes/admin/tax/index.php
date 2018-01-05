<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_taxes" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>

	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'tax/index.php' ) );
?>&action=content"><i class="icon-book icon-white fa fa-plus"></i>&nbsp; <?php
	echo pvs_word_lang( "add" )
?></a>
	<h1><?php
	echo pvs_word_lang( "taxes" )
?></h1>
	
	<?php
	$sql = "select * from " . PVS_DB_PREFIX . "tax order by title,rate_all";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
?>
		<br>
		<form method="post">
		<input type="hidden" name="action" value="change">
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<th><b><?php
		echo pvs_word_lang( "enabled" )
?>:</b></th>
		<th style="width:20%"><b><?php
		echo pvs_word_lang( "title" )
?>:</b></th>
		<th><b><?php
		echo pvs_word_lang( "items" )
?>:</b></th>
		<th><b><?php
		echo pvs_word_lang( "price includes tax" )
?>:</b></th>
		
		<th style="width:15%"><?php
		echo pvs_word_lang( "cost" )
?>:</th>
		<th><b><?php
		echo pvs_word_lang( "regions" )
?>:</b></th>
		<th></th>
		<th></th>
		</tr>
		</thead>
		<?php
		while ( ! $rs->eof )
		{
?>
			<tr  valign="top">
			<td><input type="checkbox" name="enabled<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["enabled"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td><input type="text" value="<?php
			echo $rs->row["title"]
?>" name="title<?php
			echo $rs->row["id"]
?>" style="width:200px"></td>
			<td nowrap>
				<input type="checkbox" name="files<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["files"] == 1 )
			{
				echo ( "checked" );
			}
?>>&nbsp;<?php
			echo pvs_word_lang( "files" )
?><br>
				<input type="checkbox" name="credits<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["credits"] == 1 )
			{
				echo ( "checked" );
			}
?>>&nbsp;<?php
			echo pvs_word_lang( "credits" )
?><br>
				<input type="checkbox" name="subscription<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["subscription"] == 1 )
			{
				echo ( "checked" );
			}
?>>&nbsp;<?php
			echo pvs_word_lang( "subscription" )
?><br>
				<input type="checkbox" name="prints<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["prints"] == 1 )
			{
				echo ( "checked" );
			}
?>>&nbsp;<?php
			echo pvs_word_lang( "prints" )
?><br>
			</td>
			<td align="center"><input name="price_include<?php
			echo $rs->row["id"]
?>" type="checkbox" <?php
			if ( $rs->row["price_include"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td><input name="rate_all<?php
			echo $rs->row["id"]
?>" type="text" style="width:50px;display:inline" value="<?php
			echo $rs->row["rate_all"]
?>">&nbsp;<select name="rate_all_type<?php
			echo $rs->row["id"]
?>" style="width:60px;display:inline" class="form-control">
			<option value="1" <?php
			if ( $rs->row["rate_all_type"] == 1 )
			{
				echo ( "selected" );
			}
?>>%</option>
			<option value="2" <?php
			if ( $rs->row["rate_all_type"] == 2 )
			{
				echo ( "selected" );
			}
?>>$</option>
			</select></td>
			<td><span class="gray">
			<?php
			if ( $rs->row["regions"] == 0 )
			{
				echo ( pvs_word_lang( "everywhere" ) );
			} else
			{
				$sql = "select country,state from " . PVS_DB_PREFIX .
					"tax_regions where id_parent=" . $rs->row["id"];
				$ds->open( $sql );
				$n = 0;
				while ( ! $ds->eof )
				{
					if ( $n != 0 )
					{
						echo ( ", " );
					}
					echo ( $ds->row["country"] );
					if ( $ds->row["state"] != "" )
					{
						echo ( "(" . $ds->row["state"] . ")" );
					}
					$n++;
					$ds->movenext();
				}
			}
?></span>
			</td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'tax/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td><div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'tax/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div></td>
			</tr>
			<?php
			$rs->movenext();
		}
?>
		</table>
	
		
		
	<br>	
	<p><input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "save" )
?>"></p>
	
	
	
	
	
	</form>
	<?php
	} else
	{
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
}
?>
















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>