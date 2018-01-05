<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">
<a href="http://www.pwinty.com/"><b>Pwinty.com</b></a> provides an easy way to let your users order photo prints from within your website. <br><br>

The users order prints on your site. Pwinty prints them and deliver to your customers.<br><br>

At the moment they are offering photo prints and posters of different sizes. All printing is done on high-quality commercial photo equipment, so your prints will look great too.
</div>

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
<?php
$sql = "select * from " . PVS_DB_PREFIX . "pwinty";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
<form method="post">
<input type="hidden" name="action" value="change">

<div class="admin_field">
	<span>Merchant ID</span>
	<input type="text" name="account" value="<?php
	echo $rs->row["account"]
?>" style="width:300px">
</div>

<div class="admin_field">
	<span>API Key</span>
	<input type="text" name="password" value="<?php
	echo $rs->row["password"]
?>" style="width:300px">
</div>

<div class="admin_field">
	<span>Order ID</span>
	<input type="text" name="order_number" value="<?php
	echo $rs->row["order_number"]
?>" style="width:100px">
	<div class="smalltext">Starting with this ID the orders will be sent to Pwinty.</div>
</div>

<div class="admin_field">
	<span>Test mode</span>
	<input type="checkbox" name="testmode" <?php
	if ( $rs->row["testmode"] == 1 )
	{
		echo ( "checked" );
	}
?>>
</div>



<div class="admin_field">
	<span>Use Tracked Shipping</span>
	<input type="checkbox" name="usetrackedshipping" <?php
	if ( $rs->row["usetrackedshipping"] == 1 )
	{
		echo ( "checked" );
	}
?>>
</div>

<div class="admin_field">
	<span>Payment</span>
	<select name="payment" style="width:300px">
		<option value="InvoiceMe" <?php
	if ( $rs->row["payment"] == "InvoiceMe" )
	{
		echo ( "selected" );
	}
?>>Invoice Me</option>
		<option value="InvoiceRecipient" <?php
	if ( $rs->row["payment"] == "InvoiceRecipient" )
	{
		echo ( "selected" );
	}
?>>Invoice Recipient</option>
	</select>
</div>

<div class="admin_field">
	<span>Quality Level</span>
	<select name="qualitylevel" style="width:300px">
		<option value="Standard" <?php
	if ( $rs->row["qualitylevel"] == "Standard" )
	{
		echo ( "selected" );
	}
?>>Standard</option>
		<option value="Pro" <?php
	if ( $rs->row["qualitylevel"] == "Pro" )
	{
		echo ( "selected" );
	}
?>>Pro</option>
	</select>
</div>

<div class="admin_field">
	<span>Photo resizing</span>
	<select name="photoresizing" style="width:300px">
		<option value="Crop" <?php
	if ( $rs->row["photoresizing"] == "Crop" )
	{
		echo ( "selected" );
	}
?>>Crop</option>
		<option value="ShrinkToFit" <?php
	if ( $rs->row["photoresizing"] == "ShrinkToFit" )
	{
		echo ( "selected" );
	}
?>>ShrinkToFit</option>
		<option value="ShrinkToExactFit" <?php
	if ( $rs->row["photoresizing"] == "ShrinkToExactFit" )
	{
		echo ( "selected" );
	}
?>>ShrinkToExactFit</option>
	</select>
</div>

<div class="admin_field">
	<input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>">
</div>

</form>
<?php
}
?>
</div>


<div class="subheader"><?php
echo pvs_word_lang( "prints" )
?></div>
<div class="subheader_text">
<?php
$id_list = "";
$sql = "select id_parent from " . PVS_DB_PREFIX . "prints";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sql = "select print_id from " . PVS_DB_PREFIX . "pwinty_prints where print_id=" .
		$rs->row["id_parent"];
	$ds->open( $sql );
	if ( $ds->eof )
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"pwinty_prints (print_id,activ) values (" . $rs->row["id_parent"] . ",0)";
		$db->execute( $sql );
	}

	if ( $id_list != "" )
	{
		$id_list .= "and print_id<>" . $rs->row["id_parent"];
	}

	$rs->movenext();
}

$sql = "delete from " . PVS_DB_PREFIX . "pwinty_prints where " . $id_list;
$db->execute( $sql );

$sql = "select id_parent,title from " . PVS_DB_PREFIX .
	"prints order by priority";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<form method="post">
	<input type="hidden" name="action" value="change_prints">
<table class="wp-list-table widefat fixed striped posts">
<thead>
	<tr>
	<th>*<?php
	echo pvs_word_lang( "title" )
?> in Pwinty system</th>
	<th><?php
	echo pvs_word_lang( "prints" )
?></th>
	<th><?php
	echo pvs_word_lang( "enabled" )
?></th>
	</tr>
</thead>
	<?php
	while ( ! $rs->eof )
	{
		$sql = "select title,print_id,activ from " . PVS_DB_PREFIX .
			"pwinty_prints where print_id=" . $rs->row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
?>
			<tr>
				<td><input type="text" name="title<?php
			echo $rs->row["id_parent"]
?>" value="<?php
			echo $ds->row["title"]
?>" style="width:100px"></td>
				<td><?php
			echo $rs->row["title"]
?></td>
				<td><input type="checkbox" name="print<?php
			echo $rs->row["id_parent"]
?>" <?php
			if ( $ds->row["activ"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			</tr>
			<?php
		}

		$rs->movenext();
	}
?>
	</table>
	<input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>" style="margin:10px 0px 20px 6px">
	<p class="smalltext">* It must be like 4x4, 4x6 for Prints. P16x24, P18x18 - for Posters. C10x12,C12x12 - for Canvases.</p>
	</form>
	<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

</div>