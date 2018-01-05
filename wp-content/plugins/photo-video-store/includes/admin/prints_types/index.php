<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Delete photo
if ( @$_REQUEST["action"] == 'delete_photo' )
{
	include ( "delete_photo.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>
	
	
<script>
function change_quantity(print,value)
{
	if(value == -1)
	{
		$("#quantity"+print).css("display","none");
	}
	else
	{
		$("#quantity"+print).css("display","block");
	}
}
</script>	
	
	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=content"><i class="icon-print icon-white fa fa-plus"></i>&nbsp; <?php
	echo pvs_word_lang( "add" )
?></a>
	
	
	<h1><?php
	echo pvs_word_lang( "Prints and products" )
?>:</h1>
	
	
	
	
	
	<br>
	<form method="post">
		<input type="hidden" name="action" value="change">
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<th><b><?php
	echo pvs_word_lang( "priority" )
?>:</b></th>
		<th style="width:15%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b><small><sup>(2)</sup></small></th>
		<th><b><?php
	echo pvs_word_lang( "price" )
?>:</b></th>
		<th><b><?php
	echo pvs_word_lang( "weight" )
?> (<?php
	echo $pvs_global_settings["weight"]
?>):</b></th>
		<th><b><?php
	echo pvs_word_lang( "photo" )
?>:</b><small><sup>(1)</sup></small></th>
		<th><b><?php
	echo pvs_word_lang( "prints lab" )
?>:</b><small><sup>(1)</sup></small></th>
		<th style="width:15%"><b><?php
	echo pvs_word_lang( "preview" )
?>:</b></th>
		<th style="width:15%"><b><?php
	echo pvs_word_lang( "quantity" )
?>:</b><small><sup>(3)</sup></small></th>
		<th></th>
		<th></th>
		</tr>
		</thead>
	
	<?php
	$sql = "select id,title from " . PVS_DB_PREFIX .
		"prints_categories order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof )
	{
?>
		<tr>
			<td colspan="10">
				<b><?php
		echo $ds->row["title"]
?></b>
			</td>
		</tr>
		<?php
		$sql = "select id_parent,title,description,price,weight,priority,photo,printslab,preview,in_stock from " .
			PVS_DB_PREFIX . "prints where category=" . $ds->row["id"] . " order by priority";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
?>
			<tr>
			<td><input name="priority<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
			echo $rs->row["priority"]
?>"></td>
			<td><input name="title<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:150px" value="<?php
			echo $rs->row["title"]
?>"></td>
			<td><input name="price<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:70px" value="<?php
			echo pvs_price_format( $rs->row["price"], 2 )
?>"></td>
			<td><input name="weight<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:70px" value="<?php
			echo $rs->row["weight"]
?>"></td>
			<td><input type="checkbox" name="photo<?php
			echo $rs->row["id_parent"]
?>" value="1" <?php
			if ( $rs->row["photo"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td><input type="checkbox" name="printslab<?php
			echo $rs->row["id_parent"]
?>"  value="1" <?php
			if ( $rs->row["printslab"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td>
				<select name="preview<?php
			echo $rs->row["id_parent"]
?>" style="width:150px">
				<option value="0"></option>
				<?php
			$sql = "select title,id from " . PVS_DB_PREFIX .
				"prints_previews order by title";
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
				$sel = "";
				if ( $rs->row["preview"] == $dr->row["id"] )
				{
					$sel = "selected";
				}
?>
					<option value="<?php
				echo $dr->row["id"]
?>" <?php
				echo $sel
?>><?php
				echo $dr->row["title"]
?></option>
					<?php
				$dr->movenext();
			}
?>
			</select>
			</td>
			<td>
				<select id='quantity_type<?php
			echo $rs->row["id_parent"]
?>' name='quantity_type<?php
			echo $rs->row["id_parent"]
?>' class='form-control' onChange="change_quantity('<?php
			echo $rs->row["id_parent"]
?>',this.value)">
					<option value="-1" <?php
			if ( $rs->row["in_stock"] == -1 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_word_lang( "Unlimited" )
?></option>
					<option value="0" <?php
			if ( $rs->row["in_stock"] >= 0 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_word_lang( "Value" )
?></option>
				</select>
				<input type="text"  id='quantity<?php
			echo $rs->row["id_parent"]
?>' name='quantity<?php
			echo $rs->row["id_parent"]
?>' value="<?php
			if ( $rs->row["in_stock"] >= 0 )
			{
				echo ( $rs->row["in_stock"] );
			} else
			{
				echo ( 0 );
			}
?>"  style="margin-top:3px;<?php
			if ( $rs->row["in_stock"] == -1 )
			{
				echo ( "display:none" );
			}
?>">
			</td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td><div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div></td>
			</tr>
			<?php
			$rs->movenext();
		}
?>
	
	<?php
		$ds->movenext();
	}

	$sql = "select id_parent,title,description,price,weight,priority,photo,printslab,preview,in_stock from " .
		PVS_DB_PREFIX . "prints where category=0 order by priority";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
?>
		<tr>
		<td colspan="10">
			<b><?php
		echo pvs_word_lang( "uncategorized" )
?></b>
		</td>
		</tr>
		<?php
		while ( ! $rs->eof )
		{
?>
			<tr>
			<td><input name="priority<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
			echo $rs->row["priority"]
?>"></td>
			<td><input name="title<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:150px" value="<?php
			echo $rs->row["title"]
?>"></td>
			<td><input name="price<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:70px" value="<?php
			echo pvs_price_format( $rs->row["price"], 2 )
?>"></td>
			<td><input name="weight<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:70px" value="<?php
			echo $rs->row["weight"]
?>"></td>
			<td><input type="checkbox" name="photo<?php
			echo $rs->row["id_parent"]
?>" value="1" <?php
			if ( $rs->row["photo"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td><input type="checkbox" name="printslab<?php
			echo $rs->row["id_parent"]
?>"  value="1" <?php
			if ( $rs->row["printslab"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td>
				<select name="preview<?php
			echo $rs->row["id_parent"]
?>" style="width:150px">
				<option value="0"></option>
				<?php
			$sql = "select title,id from " . PVS_DB_PREFIX .
				"prints_previews order by title";
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
				$sel = "";
				if ( $rs->row["preview"] == $dr->row["id"] )
				{
					$sel = "selected";
				}
?>
					<option value="<?php
				echo $dr->row["id"]
?>" <?php
				echo $sel
?>><?php
				echo $dr->row["title"]
?></option>
					<?php
				$dr->movenext();
			}
?>
				</select>
			</td>
			<td>
				<select id='quantity_type<?php
			echo $rs->row["id_parent"]
?>' name='quantity_type<?php
			echo $rs->row["id_parent"]
?>' class='form-control' onChange="change_quantity('<?php
			echo $rs->row["id_parent"]
?>',this.value)">
					<option value="-1" <?php
			if ( $rs->row["in_stock"] == -1 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_word_lang( "Unlimited" )
?></option>
					<option value="0" <?php
			if ( $rs->row["in_stock"] >= 0 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_word_lang( "Value" )
?></option>
				</select>
				<input type="text"  id='quantity<?php
			echo $rs->row["id_parent"]
?>' name='quantity<?php
			echo $rs->row["id_parent"]
?>' value="<?php
			if ( $rs->row["in_stock"] >= 0 )
			{
				echo ( $rs->row["in_stock"] );
			} else
			{
				echo ( 0 );
			}
?>"  style="margin-top:3px;<?php
			if ( $rs->row["in_stock"] == -1 )
			{
				echo ( "display:none" );
			}
?>">
			</td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td><div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'prints_types/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div></td>
			</tr>
			<?php
			$rs->movenext();
		}
	}
?>
	
	
		<tr class='snd'>
			<td colspan="10">
				<select name="addto" style="width:300px">
					<option value="0">Not to change OLD prints prices</option>
					<option value="1">Change ALL prints prices</option>
					<option value="2">Synchronize prints</option>
				</select>
			</td>
		</tr>
		</table>
	<br>
	<p>1) - The stock photos and prints lab can have different prints types. Usually the price of the stock photo's prints is more than prints lab's price because there is seller's commission.</p>
	<p>2) - To translate the print's names you should add them in /admin/languages/your_language.php file.</p>
	<p>3) - For Printslab and Stock site's Prints the quantity is always "Unlimited".</p>
	
			<div id="button_bottom_static">
			<div id="button_bottom_layout"></div>
			<div id="button_bottom">
				<input type="submit" value="<?php
	echo pvs_word_lang( "save" )
?>" class="btn btn-primary" style="margin-top:20px">
			</div>
		</div>
		
			</form>
	

<?php
}

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>