<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_invoices" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$param_settings = array(
		'invoice_prefix',
		'invoice_number',
		'credit_notes_prefix',
		'credit_notes_number',
		'company_name',
		'company_address1',
		'company_address2',
		'company_country',
		'company_vat_number' );

	for ( $i = 0; $i < count( $param_settings ); $i++ )
	{
		pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
	}
	
	pvs_update_setting('invoice_publish', ( int )@$_POST['invoice_publish']);
}

//Upload
if ( @$_REQUEST["action"] == 'upload' )
{
	$param_settings = array( 'invoice_logo_size' );

	for ( $i = 0; $i < count( $param_settings ); $i++ )
	{
		pvs_update_setting($param_settings[$i], pvs_result( $_POST[$param_settings[$i]] ));
	}

	//Upload photos
	$images_types = array( "logo_photo" );

	for ( $i = 0; $i < count( $images_types ); $i++ )
	{
		if ( isset( $_FILES[$images_types[$i]]['name'] ) )
		{
			$_FILES[$images_types[$i]]['name'] = pvs_result_file( $_FILES[$images_types[$i]]['name'] );

			if ( $_FILES[$images_types[$i]]['size'] > 0 )
			{
				$file_extention = strtolower( pvs_get_file_info( $_FILES[$images_types[$i]]['name'],
					"extention" ) );

				if ( $file_extention == "jpg" and ! preg_match( "/text/i", $_FILES[$images_types[$i]]['type'] ) )
				{
					$img = pvs_upload_dir() . "/content/invoice_logo" . "." . $file_extention;
					move_uploaded_file( $_FILES[$images_types[$i]]['tmp_name'], $img );
					pvs_easyResize( $img, $img, 100, ( int )$_POST['invoice_logo_size'] );
				}
			}
		}
	}
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	if ( file_exists( pvs_upload_dir() . "/content/invoice_logo.jpg" ) )
	{
		unlink( pvs_upload_dir() . "/content/invoice_logo.jpg" );
	}
}

//Regenerate
if ( @$_REQUEST["action"] == 'regenerate' )
{
	$mass_orders = array();

	if ( $pvs_global_settings["credits"] )
	{
		$sql = "select data,id_parent from " . PVS_DB_PREFIX .
			"credits_list where approved=1 and quantity>0 and total>0 order by data";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			$mass_orders[$rs->row["data"]] = "credits-" . $rs->row["id_parent"];
			$rs->movenext();
		}
	} else
	{
		$sql = "select data,id from " . PVS_DB_PREFIX .
			"orders where status=1 order by data";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			$mass_orders[$rs->row["data"]] = "orders-" . $rs->row["id"];
			$rs->movenext();
		}
	}

	if ( $pvs_global_settings["subscription"] )
	{
		$sql = "select data1,id_parent from " . PVS_DB_PREFIX .
			"subscription_list where approved=1 and total>0 order by data1";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			$mass_orders[$rs->row["data1"]] = "subscription-" . $rs->row["id_parent"];
			$rs->movenext();
		}
	}

	ksort( $mass_orders );

	var_dump( $mass_orders );
	$i = 0;
	foreach ( $mass_orders as $key => $value )
	{
		$order_element = explode( "-", $value );
		$order_id = $order_element[1];
		$order_type = $order_element[0];

		$sql = "select id from " . PVS_DB_PREFIX . "invoices where order_id=" . $order_id .
			" and order_type='" . $order_type . "'";
		$rs->open( $sql );
		if ( $rs->eof )
		{
			$i++;

			$invoice_number = $pvs_global_settings["invoice_number"] + $i;

			$sql = "insert into " . PVS_DB_PREFIX .
				"invoices (invoice_number,order_id,order_type) values (" . $invoice_number . "," .
				$order_id . ",'" . $order_type . "')";
			$db->execute( $sql );
		}
		
		pvs_update_setting('invoice_number', $invoice_number);
	}
}


if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>






<h1><?php
echo pvs_word_lang( "Invoices" )
?></h1>




<div class="box box_padding">

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<form method="post">
	<input type="hidden" name="action" value="change">

	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Publish an invoice automatically when a transaction is successful" )
?>:</span>
	<small>Sometimes you have to add some text comment to an invoice and only then make it available for a user. In this case you should disable the checkbox. When an invoice is published you may not change it.</small><br>
	<input type="checkbox" name="invoice_publish" value="1" <?php
if ( $pvs_global_settings["invoice_publish"] )
{
	echo ( "checked" );
}
?>><br>
	
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Invoice prefix" )
?>:</span>
	<input type="text" name="invoice_prefix" value="<?php
echo $pvs_global_settings["invoice_prefix"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Next invoice number" )
?>:</span>
	<input type="text" name="invoice_number" value="<?php
echo $pvs_global_settings["invoice_number"]
?>" style="width:250px;display:inline"><!--&nbsp;&nbsp;<a href="regenerate_invoices.php" class="btn btn-danger"><i class="fa fa-refresh"></i>
<?php
echo pvs_word_lang( "Regenerate invoices for old orders" )
?></a><br>-->
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Credit notes prefix" )
?>:</span>
	<input type="text" name="credit_notes_prefix" value="<?php
echo $pvs_global_settings["credit_notes_prefix"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Next credit notes number" )
?>:</span>
	<input type="text" name="credit_notes_number" value="<?php
echo $pvs_global_settings["credit_notes_number"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Company name" )
?>:</span>
	<input type="text" name="company_name" value="<?php
echo $pvs_global_settings["company_name"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Company address" )
?> 1:</span>
	<input type="text" name="company_address1" value="<?php
echo $pvs_global_settings["company_address1"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Company address" )
?> 2:</span>
	<input type="text" name="company_address2" value="<?php
echo $pvs_global_settings["company_address2"]
?>" style="width:250px"><br>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Country" )
?>:</span>
	<select name="company_country" style="width:250px">
	<option value=""></option>
			<?php
$sql = "select name from " . PVS_DB_PREFIX .
	"countries where activ=1 order by priority,name";
$dd->open( $sql );
while ( ! $dd->eof )
{
	$sel = "";
	if ( $dd->row["name"] == $pvs_global_settings["company_country"] )
	{
		$sel = "selected";
	}
?>
				<option value="<?php
	echo $dd->row["name"]
?>" <?php
	echo $sel
?>><?php
	echo $dd->row["name"]
?></option>
				<?php
	$dd->movenext();
}
?>
	</select>
	</div>
	
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "EU VAT Reg No" )
?> (<?php
echo pvs_word_lang( "only for EU" )
?>):</span>
	<input type="text" name="company_vat_number" value="<?php
echo $pvs_global_settings["company_vat_number"]
?>" style="width:250px"><br>
	</div>
	

	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>
</div>



<div class="subheader"><?php
echo pvs_word_lang( "Logo" )
?></div>
<div class="subheader_text">

	<form method="post" Enctype="multipart/form-data">
	<input type="hidden" name="action" value="upload">
	

	<p>You should upload an invoice's logo. (*.jpg)</p>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "file" )
?>:</span>
		<input name="logo_photo" type="file"><br>
		<?php
if ( file_exists( pvs_upload_dir() . "/content/invoice_logo.jpg" ) )
{
?><img src="<?php
	echo pvs_upload_dir( 'baseurl' );
?>/content/invoice_logo.jpg" style="margin-bottom:3px;border:1px solid #f5f5f5"><br><a href="<?php
	echo ( pvs_plugins_admin_url( 'invoices_settings/index.php' ) );
?>&action=delete"><i class="fa fa-remove"> </i> <?php
	echo pvs_word_lang( "delete" )
?></a><?php
}
?>
	</div>
	
	<div class='admin_field'>
		<span><?php
echo pvs_word_lang( "size" )
?> (<?php
echo pvs_word_lang( "pixels" )
?>):</span>
		<input type="text" name="invoice_logo_size" value="<?php
echo $pvs_global_settings["invoice_logo_size"]
?>" style="width:250px"><br>
	</div>

	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>

	</form>


</div>





</div>











<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>