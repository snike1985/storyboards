<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_creditstypes" );
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
?>


<script>
$(document).ready(function(){
	$("#add_new").colorbox({width:"970",height:"", inline:true, href:"#new_box",scrolling:false});
});
</script>


<a id="add_new" class="btn btn-success toright" href="#"><i class="icon-tags icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add" )
?></a>


<h1><?php
echo pvs_word_lang( "credits types" )
?>:</h1>


<p>The Credits can have an <b>expiration date</b>. If you don't want to have the expiration you should set <b>"<?php
echo pvs_word_lang( "days till expiration" )
?>" = 0</b></p>

<br>




<?php
$sql = "select id_parent,title,quantity,price,priority,days from " .
	PVS_DB_PREFIX . "credits order by priority";
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
	<th><b><?php
	echo pvs_word_lang( "quantity" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "price" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "days till expiration" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "orders" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr valign="top">
		<td><input name="priority<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
		echo $rs->row["priority"]
?>"></td>
		<td><input name="title<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:170px" value="<?php
		echo $rs->row["title"]
?>"></td>
		<td><input name="quantity<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:60px"  value="<?php
		echo $rs->row["quantity"]
?>"></td>
		<td><input name="price<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:60px"  value="<?php
		echo pvs_price_format( $rs->row["price"], 2 )
?>"></td>
		<td><input name="days<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:40px"  value="<?php
		echo $rs->row["days"]
?>"></td>
		<td><div class="link_order">
		<?php
		$count_credits = 0;
		$sql = "select count(id_parent) as count_credits from " . PVS_DB_PREFIX .
			"credits_list where credits=" . $rs->row["id_parent"] . " group by credits";
		$dr->open( $sql );
		if ( ! $dr->eof )
		{
			$count_credits = $dr->row["count_credits"];
		}
?><a href="<?php
		echo ( pvs_plugins_admin_url( 'credits/index.php' ) );
?>credits_type=<?php
		echo $rs->row["id_parent"]
?>"><?php
		echo $count_credits
?></a></div>
		</td>
		<td>
		<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'credits_types/index.php' ) );
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










<div style='display:none'>
		<div id='new_box'>
		
		<div class="modal_header"><?php
echo pvs_word_lang( "credits types" )
?></div>

<form method="post">
<input type="hidden" name="action" value="add">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php
echo pvs_word_lang( "priority" )
?>:</b></th>
<th><b><?php
echo pvs_word_lang( "title" )
?>:</b></th>
<th><b><?php
echo pvs_word_lang( "quantity" )
?>:</b></th>
<th><b><?php
echo pvs_word_lang( "price" )
?>:</b></th>
<th><b><?php
echo pvs_word_lang( "days till expiration" )
?>:</b></th>
</tr>
</thead>
<tr>
<td><input name="priority" type="text" style="width:60px" value="1"></td>
<td><input name="title" type="text" style="width:250px" value='New'></td>
<td><input name="quantity" type="text" style="width:60px" value="1"></td>
<td><input name="price" type="text" style="width:60px" value="1.00"></td>
<td><input name="days" type="text" style="width:40px" value="0"></td>
</tr>
</table>
<br>
<p><input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "add" )
?>"></p>
</form>


</div>
</div>















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>