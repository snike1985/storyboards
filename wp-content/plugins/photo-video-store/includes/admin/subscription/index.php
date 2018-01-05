<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_subscription" );
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

//Change limit
if ( @$_REQUEST["action"] == 'change_limit' )
{
	include ( "change_limit.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>



<script>
$(document).ready(function(){
	$("#add_new").colorbox({width:"400",height:"", inline:true, href:"#new_box",scrolling:false});
});
</script>

<?php
$subscription_limit = $pvs_global_settings["subscription_limit"];
?>



<a class="btn btn-success toright" id="add_new" href="#"><i class="icon-time icon-white fa fa-plus"></i>&nbsp <?php
echo pvs_word_lang( "add" )
?></a>


<h1><?php
echo pvs_word_lang( "subscription" )
?>:</h1>


<p>To set a subscription plan you should define <a href="<?php
echo ( pvs_plugins_admin_url( 'content_types/index.php' ) );
?>"><b>Content Types</b></a> first. Content type is a method to divide all files into several global categories. For example: Premium files, usual files and etc.</p>

<br>


<h2>Subscription limit:</h2>

<p>The seller's commission depends on the file's price only when the subscription limit is "By Credits".</p>

<form method="post">
<input type="hidden" name="action" value="change_limit">
<select class="form-control" name="subscription_limit" style="width:200px">
	<option value="Credits" <?php
if ( $pvs_global_settings["subscription_limit"] == 'Credits' )
{
	echo ( "selected" );
}
?>><?php
echo ( "Credits" );
?></option>
	<option value="Downloads" <?php
if ( $pvs_global_settings["subscription_limit"] == 'Downloads' )
{
	echo ( "selected" );
}
?>><?php
echo ( "Downloads" );
?></option>
	<option value="Bandwidth" <?php
if ( $pvs_global_settings["subscription_limit"] == 'Bandwidth' )
{
	echo ( "selected" );
}
?>><?php
echo ( "Bandwidth" );
?></option>
</select>
<br>
<p>
<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>">
</p>
</form><br>




<br>
<h2><?php
echo pvs_word_lang( "subscription" )
?>:</h2>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "subscription order by priority";
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
<th style="width:25%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "price" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "days till expiration" )
?>:</b></th>
<th><b>*<?php
	echo pvs_word_lang( "recurring payments" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "content type" )
?>:</b></th>
<th><b><?php
	echo pvs_word_lang( "limit" )
?> (<?php
	echo $subscription_limit
?><?php
	if ( $subscription_limit == "Bandwidth" )
	{
		echo ( " Mb." );
	}
?>)</b></th>
<th><b>**<?php
	echo pvs_word_lang( "daily limit" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof )
	{
?>
<tr>
<td align="center"><input name="priority<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
		echo $rs->row["priority"]
?>"></td>
<td><input name="title<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:250px" value="<?php
		echo $rs->row["title"]
?>"></td>
<td align="center"><input name="price<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:100px"  value="<?php
		echo pvs_price_format( $rs->row["price"], 2 )
?>"></td>
<td align="center"><input name="days<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:100px"  value="<?php
		echo $rs->row["days"]
?>"></td>
<td align="center"><input name="recurring<?php
		echo $rs->row["id_parent"]
?>" type="checkbox" <?php
		if ( $rs->row["recurring"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
<td>


<?php
		$sql = "select * from " . PVS_DB_PREFIX . "content_type order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
?>
<div style="margin-bottom:2px"><input name="type<?php
			echo $rs->row["id_parent"]
?>_<?php
			echo $ds->row["id_parent"]
?>" type="checkbox" <?php
			if ( preg_match( "/" . $ds->row["name"] . "/i", $rs->row["content_type"] ) )
			{
				echo ( "checked" );
			}
?>>&nbsp;<?php
			echo $ds->row["name"]
?></div>
<?php
			$ds->movenext();
		}
?>



</td>
<td align="center"><input name="bandwidth<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:100px"  value="<?php
		echo $rs->row["bandwidth"]
?>"></td>
<td align="center"><input name="bandwidth_daily<?php
		echo $rs->row["id_parent"]
?>" type="text" style="width:100px"  value="<?php
		echo $rs->row["bandwidth_daily"]
?>"></td>
<td>
<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'subscription/index.php' ) );
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
<br><p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p>
</form><br>
<?php
}
?>


<p>* - for Paypal and Stripe only.</p>
<p>** - if 0 there is no daily limit.</p>









<div style='display:none'>
		<div id='new_box'>
		<div class="modal_header"><?php
echo pvs_word_lang( "subscription" )
?></div>

<form method="post">
<input type="hidden" name="action" value="add">


<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "title" )
?>:</b></span>
<input name="title" type="text" style="width:250px">
</div>
<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "price" )
?>:</b></span>
<input name="price" type="text" style="width:60px" value="1.00">
</div>
<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "days till expiration" )
?>:</b></span>
<input name="days" type="text" style="width:40px" value="10">
</div>
<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "recurring payments" )
?>:</b></span>
<input name="recurring" type="checkbox"></td>
</div>
<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "content type" )
?>:</b></span>
<?php
$sql = "select * from " . PVS_DB_PREFIX . "content_type order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
?>
<div style="margin-bottom:2px"><input name="type<?php
	echo $rs->row["id_parent"]
?>" type="checkbox" checked>&nbsp;<?php
	echo $rs->row["name"]
?></div>
<?php
	$rs->movenext();
}
?>
</div>
<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "limit" )
?> (<?php
echo $subscription_limit
?><?php
if ( $subscription_limit == "Bandwidth" )
{
	echo ( " Mb." );
}
?>)</b></span>
<input name="bandwidth" type="text" style="width:40px" value="1">
</div>


<div class="admin_field">
<span><b><?php
echo pvs_word_lang( "daily limit" )
?>:</b></span>
<input name="bandwidth_daily" type="text" style="width:40px" value="1">
</div>


<div class="admin_field">
<input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "add" )
?>">
</div>
</form>


</div>
</div>















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>