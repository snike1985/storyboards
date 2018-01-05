<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_coupons" );
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
?>





<h1><?php
echo pvs_word_lang( "types of coupons" )
?></h1>

<p>Here you can set a discount/coupon for the customers. The coupons can be sent to a buyer automatically in the next cases:</p>

<ul>
<li><b><?php
echo pvs_word_lang( "new signup" )
?></b>. When a user registers on the site</li>
<li><b><?php
echo pvs_word_lang( "new order" )
?></b>. When a user orders the second time.</li>

</ul>

<p>
3 types of the coupons are available:
</p>

<ul>
<li><b><?php
echo pvs_word_lang( "bonus" )
?></b> in Credits</li>
<li><b><?php
echo pvs_word_lang( "total discount" )
?></b></li>
<li><b><?php
echo pvs_word_lang( "percentage discount" )
?></b></li>
</ul>


<br>

<?php
$sql = "select id_parent,title,days,total,percentage,url,events,ulimit,bonus from " .
	PVS_DB_PREFIX . "coupons_types";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="change">
 	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th style="width:15%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "limit of usage" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "days till expiration" )
?>:</b></th>
	<th style="width:15%"><b><?php
	echo pvs_word_lang( "discount" )
?>:</b></th>
	<th style="width:15%"><b><?php
	echo pvs_word_lang( "events" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "bonus" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "quantity" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{

		$discount = 0;
		$discount_type = "total";
		if ( $rs->row["total"] != 0 )
		{
			$discount = $rs->row["total"];
			$discount_type = "total";
		}
		if ( $rs->row["percentage"] != 0 )
		{
			$discount = $rs->row["percentage"];
			$discount_type = "percentage";
		}
?>
		<tr>
		<td><input name="title<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:150px" value="<?php
		echo $rs->row["title"]
?>"></td>
		<td><input name="ulimit<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:50px" value="<?php
		echo $rs->row["ulimit"]
?>"></td>
		<td><input name="days<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:50px" value="<?php
		echo $rs->row["days"]
?>"></td>
		<td><input name="discount<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:40px;display:inline" value="<?php
		echo $discount
?>">&nbsp;<select name="discount_type<?php
		echo $rs->row["id_parent"]
?>" style="width:80px;display:inline">
			<option value="percentage" <?php
		if ( $discount_type == "percentage" )
		{
			echo ( " selected" );
		}
?>>%</option>
			<option value="total" <?php
		if ( $discount_type == "total" )
		{
			echo ( " selected" );
		}
?>><?php
		echo pvs_currency( 1 )
?><?php
		echo pvs_currency( 2 )
?></option>
		</select>
		</td>

		<td>
		<select name="events<?php
		echo $rs->row["id_parent"]
?>" style="width:150px">
			<option value="New Order" <?php
		if ( $rs->row["events"] == "New Order" )
		{
			echo ( " selected" );
		}
?>><?php
		echo pvs_word_lang( "new order" )
?></option>
			<option value="New Signup" <?php
		if ( $rs->row["events"] == "New Signup" )
		{
			echo ( " selected" );
		}
?>><?php
		echo pvs_word_lang( "new signup" )
?></option>
		</select>
		</td>
		<td><input name="bonus<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:50px" value="<?php
		echo $rs->row["bonus"]
?>"></td>
		<td>
		<?php
		$coupons_count = 0;
		$sql = "select count(id_parent) as coupons_count from " . PVS_DB_PREFIX .
			"coupons where coupon_id=" . $rs->row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$coupons_count = $ds->row["coupons_count"];
		}
?><a href="<?php echo(pvs_plugins_admin_url('coupons/index.php'));?>&coupon_id=<?php
		echo $rs->row["id_parent"]
?>"><?php
		echo $coupons_count
?></a>
		</td>
		<td>
		<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'coupons_types/index.php' ) );
?>&action=delete&id=<?php
		echo $rs->row["id_parent"]
?>' onClick="return confirm('<?php
		echo pvs_word_lang( "delete" )
?>?');"><?php
		echo pvs_word_lang( "delete" )
?></a></div>
		</td>
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
	</form><br>
	<?php
}
?>










<h2><?php
echo pvs_word_lang( "new" )
?></h2>

<form method="post">
	<input type="hidden" name="action" value="add">
 	<table class="wp-list-table widefat fixed striped posts">
 	<thead>
<tr>
	<th><b><?php
echo pvs_word_lang( "title" )
?>:</b></th>
	<th><b><?php
echo pvs_word_lang( "limit of usage" )
?>:</b></th>
	<th><b><?php
echo pvs_word_lang( "days till expiration" )
?>:</b></th>
	<th><b><?php
echo pvs_word_lang( "discount" )
?>:</b></th>

	<th><b><?php
echo pvs_word_lang( "events" )
?>:</b></th>
	<th><b><?php
echo pvs_word_lang( "bonus" )
?>:</b></th>
</tr>
</thead>
<tr>
		<td><input name="title" type="text" style="width:150px" value="New"></td>
		<td><input name="ulimit" type="text" style="width:100px" value="1"></td>
		<td><input name="days" type="text" style="width:100px" value="30"></td>
		<td><input name="discount" type="text" style="width:40px;display:inline" value="0">&nbsp;<select name="discount_type" style="width:80px;display:inline">
			<option value="percentage">%</option>
			<option value="total"><?php
echo pvs_currency( 1 )
?><?php
echo pvs_currency( 2 )
?></option>
		</select>
		</td>
		<td>
		<select name="events" style="width:150px">
			<option value="New Order"><?php
echo pvs_word_lang( "new order" )
?></option>
			<option value="New Signup"><?php
echo pvs_word_lang( "new signup" )
?></option>
		</select>
		</td>
		<td><input name="bonus" type="text" style="width:50px" value="0"></td>
</tr>
</table>
<br>
	<p><input type="submit" class="btn btn-success" value="<?php
echo pvs_word_lang( "add" )
?>"></p>
</form>

















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>