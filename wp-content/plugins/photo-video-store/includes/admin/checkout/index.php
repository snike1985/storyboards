<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_checkout" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Change terms
if ( @$_REQUEST["action"] == 'change_terms' )
{
	include ( "change_terms.php" );
}

//New
if ( @$_REQUEST["action"] == 'new' )
{
	include ( "new.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>

<h1><?php
echo pvs_word_lang( "checkout" )
?></h1>

<div class="box box_padding">



<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<form method="post">
	<input type="hidden" name="action" value="change">
	<?php
if ( ! $pvs_global_settings["subscription_only"] )
{
?>
		<div class='admin_field'>
			<div><?php
	echo pvs_word_lang( "Require Billing Address for the Order Checkout" )
?>:</div>
			<input type="checkbox" name="checkout_order_billing" value="1" <?php
	if ( $pvs_global_settings["checkout_order_billing"] )
	{
		echo ( "checked" );
	}
?>>
		</div>
	
		<div class='admin_field'>
			<div><?php
	echo pvs_word_lang( "Require Shipping Address for the Order Checkout" )
?>:</div>
			<input type="checkbox" name="checkout_order_shipping" value="1" <?php
	if ( $pvs_global_settings["checkout_order_shipping"] )
	{
		echo ( "checked" );
	}
?>>
		</div>
	<?php
}
?>
	
	<?php
if ( $pvs_global_settings["credits"] )
{
?>
		<div class='admin_field'>
			<div><?php
	echo pvs_word_lang( "Require Billing Address for the Credits Checkout" )
?>:</div>
			<input type="checkbox" name="checkout_credits_billing" value="1" <?php
	if ( $pvs_global_settings["checkout_credits_billing"] )
	{
		echo ( "checked" );
	}
?>>
		</div>	
	<?php
}
?>
	
	<?php
if ( $pvs_global_settings["subscription"] )
{
?>
		<div class='admin_field'>
			<div><?php
	echo pvs_word_lang( "Require Billing Address for the Subscription Checkout" )
?>:</div>
			<input type="checkbox" name="checkout_subscription_billing" value="1" <?php
	if ( $pvs_global_settings["checkout_subscription_billing"] )
	{
		echo ( "checked" );
	}
?>>
		</div>		
	<?php
}
?>
	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>
	
	</form>
</div>




<div class="subheader"><?php
echo pvs_word_lang( "terms and conditions" )
?></div>
<div class="subheader_text">

<a class="btn btn-success toright" href="<?php
echo ( pvs_plugins_admin_url( 'checkout/index.php' ) );
?>&action=new"><i class="icon-file icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add" )
?></a>
<p>Here you can specify 'Terms and Conditions' checkboxes for the checkout process:</p>



<br>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "terms order by types,priority";
$rs->open( $sql );
if ( ! $rs->eof )
{
	
?>
	<form method="post">
	<input type="hidden" name="action" value="change_terms">
 	<table class="wp-list-table widefat fixed striped posts">
	<tr>
	<th><b><?php
	echo pvs_word_lang( "type" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "priority" )
?>:</b></th>
	<th style="width:30%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th style="width:30%"><b><?php
	echo pvs_word_lang( "content" )
?></b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
	</tr>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<td>
			<select name="types<?php
		echo $rs->row["id"]
?>" style="width:150px">
				<option value="1" <?php
		if ( $rs->row["types"] == 1 )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "order" )
?></option>
				<option value="2" <?php
		if ( $rs->row["types"] == 2 )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "credits" )
?></option>
				<option value="3" <?php
		if ( $rs->row["types"] == 3 )
		{
			echo ( "selected" );
		}
?>><?php
		echo pvs_word_lang( "subscription" )
?></option>
			</select>
		</td>
		<td align="center"><input name="priority<?php
		echo $rs->row["id"]
?>" type="text" style="width:40px" value="<?php
		echo $rs->row["priority"]
?>"></td>
		<td><input name="title<?php
		echo $rs->row["id"]
?>" type="text" style="width:250px" value="<?php
		echo $rs->row["title"]
?>"></td>
		<td>
			<select name="page_id<?php
		echo $rs->row["id"]
?>" style="width:250px">
				<option value="0"></option>
				<?php
		$sql = "select ID, post_title from " . $table_prefix .
			"posts where post_type = 'page' and post_status = 'publish' order by post_title";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sel = "";
			if ( $ds->row["ID"] == $rs->row["page_id"] )
			{
				$sel = "selected";
			}
?>
					<option value="<?php
			echo $ds->row["ID"]
?>" <?php
			echo $sel
?>><?php
			echo $ds->row["post_title"]
?></option>
					<?php
			$ds->movenext();
		}
?>
			</select>
		</td>
		<td><input name="delete<?php
		echo $rs->row["id"]
?>" type="checkbox"></td>
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


</div>


</div>















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>