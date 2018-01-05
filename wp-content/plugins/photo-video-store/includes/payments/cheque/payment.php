<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<h1><?php echo(pvs_word_lang("check or money order"));?></h1>
<?php
		$sql = "select post_content from " . $table_prefix .
			"posts where post_type = 'page' and ID = " . (int)$pvs_global_settings["cheque_account2"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			echo(pvs_translate_text($ds->row["post_content"]));
		}
?>
<br>

<?php
include ( PVS_PATH. "templates/payment_statement.php" );
?>
