<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_subscription" );
?>



<div class="back"><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>" class="btn btn-default"><i class="icon-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<h1><?php echo pvs_word_lang( "Subscription" )?> #<?php echo ( int )$_GET["id"] ?>:</h1>
<div class="box box_padding">
<?php
$sql = "select id_parent,title,user,data1,data2,bandwidth,bandwidth_limit,subscription,bandwidth_daily,bandwidth_daily_limit from " .
	PVS_DB_PREFIX . "subscription_list where id_parent=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {

	$d1 = date( "d", $rs->row["data1"] );
	$m1 = date( "m", $rs->row["data1"] );
	$y1 = date( "Y", $rs->row["data1"] );

	$d2 = date( "d", $rs->row["data2"] );
	$m2 = date( "m", $rs->row["data2"] );
	$y2 = date( "Y", $rs->row["data2"] );
?>
	<form method="post" action="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&id=<?php echo ( int )$_GET["id"] ?>">
	<input type="hidden" name="action" value="change">
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "subscription" )?>:</span>
	<select name="subscription" style="width:300px" class="ibox form-control">
		<?php
	$sql = "select id_parent,title from " . PVS_DB_PREFIX .
		"subscription order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$sel = "";
		if ( $ds->row["id_parent"] == $rs->row["subscription"] ) {
			$sel = "selected";
		}
?>
			<option value="<?php echo $ds->row["id_parent"] ?>" <?php echo $sel
?>><?php echo $ds->row["title"] ?></option>
			<?php
		$ds->movenext();
	}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "setup date" )?>:</span>
<table border="0" cellpadding="3" cellspacing="0">
<tr>
<td><select name="d1" style="width:70px;display:inline" class="ibox form-control">
<?php
	for ( $i = 1; $i < 32; $i++ ) {
		$sel = "";
		if ( $d1 == $i ) {
			$sel = "selected";
		}
?>
<option value="<?php echo $i
?>" <?php echo $sel
?>><?php echo $i;

	}
?>
</select>&nbsp;<select name="m1" style="width:100px;display:inline" class="ibox form-control">
<?php
	for ( $i = 0; $i < count( $m_month ); $i++ ) {
		$sel = "";
		if ( $m1 == $i + 1 ) {
			$sel = "selected";
		}
?>
<option value='<?php echo $i + 1
?>' <?php echo $sel
?>><?php echo pvs_word_lang( strtolower( $m_month[$i] ) );
	}
?>
</select>&nbsp;<select name=y1 style="width:80px;display:inline" class="ibox form-control">
<?php
	for ( $i = date( "Y" ) - 5; $i < date( "Y" ) + 5; $i++ ) {
		$sel = "";
		if ( $y1 == $i ) {
			$sel = "selected";
		}
?>
<option value='<?php echo $i
?>' <?php echo $sel
?>><?php echo $i;

	}
?>
</select></td>
</tr>
</table>
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "expiration date" )?>:</span>
<table border="0" cellpadding="3" cellspacing="0">
<tr>
<td><select name="d2" style="width:70px;display:inline" class="ibox form-control">
<?php
	for ( $i = 1; $i < 32; $i++ ) {
		$sel = "";
		if ( $d2 == $i ) {
			$sel = "selected";
		}
?>
<option value="<?php echo $i
?>" <?php echo $sel
?>><?php echo $i;

	}
?>
</select>&nbsp;<select name="m2" style="width:100px;display:inline" class="ibox form-control">
<?php
	for ( $i = 0; $i < count( $m_month ); $i++ ) {
		$sel = "";
		if ( $m2 == $i + 1 ) {
			$sel = "selected";
		}
?>
<option value='<?php echo $i + 1
?>' <?php echo $sel
?>><?php echo pvs_word_lang( strtolower( $m_month[$i] ) );
	}
?>
</select>&nbsp;<select name=y2 style="width:80px;display:inline" class="ibox form-control">
<?php
	for ( $i = date( "Y" ) - 5; $i < date( "Y" ) + 5; $i++ ) {
		$sel = "";
		if ( $y2 == $i ) {
			$sel = "selected";
		}
?>
<option value='<?php echo $i
?>' <?php echo $sel
?>><?php echo $i;

	}
?>
</select></td>
</tr>
</table>
	</div>
	
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "user" )?>:</span>
	<input type="text" name="user" value="<?php echo $rs->row["user"] ?>" style="width:150px" class="ibox form-control">
	</div>
	

	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "times usage" )?>:</span>
	<input type="text" name="bandwidth" value="<?php echo $rs->row["bandwidth"] ?>" style="width:150px" class="ibox form-control">
	</div>
	
	<div class='admin_field'>
	<span><?php echo pvs_word_lang( "limit" )?>:</span>
	<input type="text" name="bandwidth_limit" value="<?php echo $rs->row["bandwidth_limit"] ?>" style="width:150px" class="ibox form-control">
	</div>
	
	<div class='admin_field'>
	<span>* <?php echo pvs_word_lang( "daily limit" )?>:</span>
	<input type="text" name="bandwidth_daily" value="<?php echo $rs->row["bandwidth_daily_limit"] ?>" style="width:150px" class="ibox form-control">
	</div>
	
	<div class='admin_field'>
	<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
	</div>
	</form>
	<?php
}
?>

<p>* - if 0 there is no any limit.<p>
</div>
