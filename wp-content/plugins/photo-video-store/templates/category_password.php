<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$idt = pvs_check_password( 0, ( int )$_POST["id_parent"], 1 );

if ( $idt != 0 ) {
	$sql = "select id,password from " . PVS_DB_PREFIX .
		"category where id=" . ( int )$idt;
	$rs->open( $sql );
	if ( $rs->row["password"] == $_POST["password"] ) {
		if ( ! isset( $_SESSION["cprotected"] ) ) {
			$_SESSION["cprotected"] = strval( $idt );
		} else {
			$_SESSION["cprotected"] .= "|" . strval( $idt );
		}
	}
}

header( "location:" . $_POST["back_url"] );
?>