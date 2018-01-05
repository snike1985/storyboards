<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_invoices" );

?>

<?php
$sql = "select id,invoice_number,order_id,order_type,comments,refund from " .
	PVS_DB_PREFIX . "invoices where invoice_number=" . ( int )$_GET["id"];
$ds->open( $sql );
if ( ! $ds->eof ) {
?>
	<a href="<?php echo (site_url( ) );?>/invoice-html/?id=<?php echo ( int )@$_GET["id"] ?>" target="blank" class="btn btn-success pull-right" style="margin-right: 25px;"><i class="fa fa-file-text"> </i>
	  <?php echo pvs_word_lang( "download" )?> HTML</a>
	<a href="<?php echo (site_url( ) );?>/invoice-pdf/?id=<?php echo ( int )@$_GET["id"] ?>" target="blank" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"> </i>
	 <?php echo pvs_word_lang( "download" )?> PDF</a>
	 <?php
	if ( $ds->row["refund"] != 1 ) {
?>
		 <a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&action=refund&id=<?php echo ( int )@$_GET["id"] ?>" class="btn btn-warning pull-right" style="margin-right: 5px;"><i class="fa fa-repeat"> </i>
		 <?php echo pvs_word_lang( "Refund money" )?></a>
		 <?php
	}
	if ( ! isset( $_GET["change"] ) ) {
?>
		 <a href="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&action=invoice&id=<?php echo ( int )@$_GET["id"] ?>&change=1" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-edit"> </i>
		 <?php echo pvs_word_lang( "edit" )?></a>
		 <?php
	}

	if ( $ds->row["refund"] == 1 ) {
?>
		<h1 style="margin-left:25px"><?php echo pvs_word_lang( "Credit notes" )?> 
		<small><?php echo $pvs_global_settings["credit_notes_prefix"] ?><?php echo @$_GET["id"] ?></small></h1>
		<?php
	} else {
?>
		<h1 style="margin-left:25px"><?php echo pvs_word_lang( "Invoice" )?> 
		<small><?php echo $pvs_global_settings["invoice_prefix"] ?><?php echo @$_GET["id"] ?></small></h1>
		<?php
	}

	if ( isset( $_GET["change"] ) ) {
?>
			<form method="post" action="<?php echo(pvs_plugins_admin_url('invoices/index.php'));?>&id=<?php echo $ds->row["id"] ?>" style="margin-left:20px">
			<input type="hidden" name="action" value="change">
			<div class="form_field">
				<span><?php echo pvs_word_lang( "Invoice Number" )?>:</span>
				<input name="invoice_number" type="text" value="<?php echo @$_GET["id"] ?>" style="width:120px" class="form-control">
			</div>
			
			<div class="form_field">
				<span><?php echo pvs_word_lang( "Note on Invoice" )?>:</span>
				<textarea name="comments" type="text" style="width:500px;height:100px" class="form-control"><?php echo $ds->row["comments"] ?></textarea>
			</div>
			
			<div class="form_field">
				<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
			</div>
	
			</form><br>
			<?php
	}
}
?>



<?php
$invoice_content = '';
include ( "invoice_content.php" );
echo ( $invoice_content );
?>
