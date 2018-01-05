<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$sql = "select * from " . PVS_DB_PREFIX . "licenses order by id_parent";
$rs->open( $sql );
while ( ! $rs->eof ) {
?>
<h1><?php echo $rs->row["name"] ?></h1>

<?php echo pvs_translate_text( $rs->row["description"] )?><br><br><br>
<?php
	$rs->movenext();
}
?>
