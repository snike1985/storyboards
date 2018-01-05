<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );
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

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>
	
	
	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'seller_categories/index.php' ) );
?>&action=content"><i class="icon-user icon-white fa fa-plus"></i> <?php
	echo pvs_word_lang( "add" )
?></a>
	
	
	
	<h1><?php
	echo pvs_word_lang( "customer categories" )
?></h1>
	
	
	
	
	<?php
	$sql = "select id_parent,priority,name,percentage,percentage_prints,percentage_subscription,percentage_type,percentage_prints_type,percentage_subscription_type from " .
		PVS_DB_PREFIX . "user_category order by priority";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
?>
		<form method="post">
		<input type="hidden" name="action" value="change">
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<th><b><?php
		echo pvs_word_lang( "priority" )
?>:</b></th>
		<th><b><?php
		echo pvs_word_lang( "title" )
?>:</b></th>
		<th style="width:20%"><b><?php
		echo pvs_word_lang( "Commission" )
?> &mdash; <?php
		echo pvs_word_lang( "order" )
?> (<?php
		echo pvs_word_lang( "to seller" )
?>):</b></th>
		<th style="width:20%"><b><?php
		echo pvs_word_lang( "Commission" )
?> &mdash; <?php
		echo pvs_word_lang( "subscription" )
?> (<?php
		echo pvs_word_lang( "to seller" )
?>):</b></th>
		<th style="width:20%"><b><?php
		echo pvs_word_lang( "Commission" )
?> &mdash; <?php
		echo pvs_word_lang( "prints" )
?> (to <?php
		echo pvs_word_lang( "to seller" )
?>):</b></th>
		<th></th>
		<th></th>
		</tr>
		</thead>
		<?php
		while ( ! $rs->eof )
		{
?>
			<tr valign="top">
			<td align="center"><input name="priority<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
			echo $rs->row["priority"]
?>"></td>
			<td><input name="title<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:100px" value="<?php
			echo $rs->row["name"]
?>"></td>
			<td>
				<input name="percentage<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:50px;display:inline" value="<?php
			if ( $rs->row["percentage_type"] == 0 )
			{
				echo ( round( $rs->row["percentage"] ) );
			} else
			{
				echo ( pvs_price_format( $rs->row["percentage"], 2 ) );
			}
?>">
				<select name="percentage_type<?php
			echo $rs->row["id_parent"]
?>" style="width:70px;display:inline">
					<option value="0" <?php
			if ( $rs->row["percentage_type"] == 0 )
			{
				echo ( "selected" );
			}
?>>%</option>
					<option value="1" <?php
			if ( $rs->row["percentage_type"] == 1 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_get_currency_code(1)
?></option>
				</select>
			</td>
			<td>
				<input name="percentage_subscription<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:50px;display:inline" value="<?php
			if ( $rs->row["percentage_subscription_type"] == 0 )
			{
				echo ( round( $rs->row["percentage_subscription"] ) );
			} else
			{
				echo ( pvs_price_format( $rs->row["percentage_subscription"], 2 ) );
			}
?>">
				<select name="percentage_subscription_type<?php
			echo $rs->row["id_parent"]
?>" style="width:70px;display:inline">
					<option value="0" <?php
			if ( $rs->row["percentage_subscription_type"] == 0 )
			{
				echo ( "selected" );
			}
?>>%</option>
					<option value="1" <?php
			if ( $rs->row["percentage_subscription_type"] == 1 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_get_currency_code(1)
?></option>
				</select>
			</td>
			<td>
				<input name="percentage_prints<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:50px;display:inline" value="<?php
			if ( $rs->row["percentage_prints_type"] == 0 )
			{
				echo ( round( $rs->row["percentage_prints"] ) );
			} else
			{
				echo ( pvs_price_format( $rs->row["percentage_prints"], 2 ) );
			}
?>">
				<select name="percentage_prints_type<?php
			echo $rs->row["id_parent"]
?>" style="width:70px;display:inline">
					<option value="0" <?php
			if ( $rs->row["percentage_prints_type"] == 0 )
			{
				echo ( "selected" );
			}
?>>%</option>
					<option value="1" <?php
			if ( $rs->row["percentage_prints_type"] == 1 )
			{
				echo ( "selected" );
			}
?>><?php
			echo pvs_get_currency_code(1)
?></option>
				</select>
			</td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'seller_categories/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td>
			<div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'seller_categories/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div>
			</td>
			</tr>
			<?php
			$rs->movenext();
		}
?>
		</table>
		<br><p><input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "save" )
?>"></p>
		</form><br>
	<?php
	}
}
?>





<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>