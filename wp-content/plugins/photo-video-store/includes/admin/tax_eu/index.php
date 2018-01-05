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
	pvs_update_setting('eu_tax', ( int )@$_POST['eu_tax_active']);
	pvs_update_setting('eu_tax_b2b', ( int )@$_POST['eu_tax_b2b']);
	pvs_update_setting('eu_tax_commission', ( int )@$_POST['eu_tax_commission']);
	pvs_update_setting('eu_tax_payout', ( int )@$_POST['eu_tax_payout']);

	//Update settings
	pvs_get_settings();
}
?>






<h1><?php
echo pvs_word_lang( "EU VAT law compliance" )
?></h1>


<script language="javascript">

function show_fields(types)
{
	if(types==0)
	{
		document.getElementById('field_b2b').style.display="none";
		document.getElementById('field_commission').style.display="none";
		document.getElementById('field_payout').style.display="none";									
	}
	if(types==1)
	{
		document.getElementById('field_b2b').style.display="block";
		document.getElementById('field_commission').style.display="block";
		document.getElementById('field_payout').style.display="block";		
	}
}

</script>

<div class="box box_padding">

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<h3>Rules for invoicing if agency is inside EC:</h3>
<h4>Private customer</h4>



<ul>
<li>The same EC country:<br>
 digital good (files, credits and subscription) -> local VAT<br>
 non digital delivery (prints and shipped products) -> local VAT
</li><li>Other EC country:<br>
 digital good -> customers country VAT<br>
 non digital delivery -> local VAT
</li><li>Non EC country:<br>
 digital good -> no VAT<br>
 non digital delivery -> no VAT
</li>
</ul>

<small>* Without country of origin declaration handled as private customer, same country. Note on invoice</small>

<hr />

<h4>Business customer with valid VAT ID or based in non EC country</h4>


<ul>
<li>The same EC country:<br>
 digital good (files, credits and subscription) -> local VAT<br>
 non digital delivery (prints and shipped products) -> local VAT
</li><li>Other EC country:<br>
 digital good -> no VAT. Note on invoice<br>
 non digital delivery -> no VAT. Note on invoice<br>
</li><li>Non EC country:<br>
 digital good -> no VAT. Note that delivery is outside of EC on invoice<br>
 non digital delivery -> no VAT. Note that delivery is outside of EC on
invoice
</li>
</ul>

<small>* Without valid VAT-ID /country of origin handled as private, same country. Note on invoice</small>

</div>

<div class="subheader"><?php
echo pvs_word_lang( "settings" )
?></div>
<div class="subheader_text">
	<form method="post">
	<input type="hidden" name="action" value="change">
	<div class='admin_field'>
	<span><?php
echo pvs_word_lang( "Apply EU tax rules" )
?>:</span>
	<input type="radio" name="eu_tax_active" <?php
if ( ( int )@$pvs_global_settings["eu_tax"] == 1 )
{
	echo ( "checked" );
}
?> onClick="show_fields(1)" value="1"> <?php
echo pvs_word_lang( "yes" )
?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="eu_tax_active" <?php
if ( ( int )@$pvs_global_settings["eu_tax"] == 0 )
{
	echo ( "checked" );
}
?> onClick="show_fields(0)" value="0"> <?php
echo pvs_word_lang( "no" )
?>
	</div>
	
	<div class='admin_field' id="field_b2b">
	<span>Allow B2B sales only:</span>
	<input type="checkbox" name="eu_tax_b2b" value="1" <?php
if ( @$pvs_global_settings["eu_tax_b2b"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field' id="field_commission">
	<span>Commission from net price:</span>
	<input type="checkbox" name="eu_tax_commission" value="1" <?php
if ( @$pvs_global_settings["eu_tax_commission"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field' id="field_payout">
	<span>Payout with VAT:</span>
	<input type="checkbox" name="eu_tax_payout" value="1" <?php
if ( @$pvs_global_settings["eu_tax_payout"] )
{
	echo ( "checked" );
}
?>><br>
	</div>
	
	<div class='admin_field'>
	<input  class="btn btn-primary" type="submit" value="<?php
echo pvs_word_lang( "save" )
?>">
	</div>
	
	<script>
		show_fields(<?php
echo ( int )@$pvs_global_settings["eu_tax"]
?>);
	</script>
	</form>
</div>






</div>










<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>