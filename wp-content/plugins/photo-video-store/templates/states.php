<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

if ( ! isset( $_REQUEST['country'] ) ) {
	exit();
}
if ( ! isset( $_REQUEST['state'] ) ) {
	exit();
}

$type = "";
if ( isset( $_REQUEST['type'] ) ) {
	$type = pvs_result( $_REQUEST['type'] ) . "_";
}

$country = pvs_result( $_REQUEST['country'] );
if ( isset( $mstates[$country] ) ) {
	$res = "<select name='" . $type . "state' id='" . $type .
		"state' style='width:310px;' class='ibox form-control' onChange=\"check_field('state');\"><option value=''></option>";
	foreach ( $mstates[$country] as $key => $value ) {
		$sel = "";
		if ( $_REQUEST['state'] == $value ) {
			$sel = "selected";
		}
		$res .= "<option value='" . $value . "' " . $sel . ">" . $value . "</option>";
	}
	$res .= "</select>";
	echo ( $res );
} else
{
?>
	<input type="text" name="<?php echo $type;
?>state" id="<?php echo $type;
?>state" style="width:300px" value="<?php echo pvs_result( $_REQUEST['state'] );?>" class="ibox form-control" onChange="check_field('state');">
	<?php
}

?>