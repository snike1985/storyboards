<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );
?>


<form method="post">
	<input type="hidden" name="action" value="change2">
 	<table class="wp-list-table widefat fixed striped posts">
 	<thead>
	<tr>
	<th><?php
echo pvs_word_lang( "credits" )
?></th>
	<th><?php
echo pvs_word_lang( "price" )
?>:</th>
	</tr>
	</thead>
<tr>
<td class="big">1 Credit</td>
<td><input type="text" name="price" value="<?php
echo pvs_price_format( $pvs_global_settings["payout_price"], 2 )
?>" style="width:70px"></td>
</tr>
</table>
<br>
<p><input type="submit" class="btn btn-primary" value="<?php
echo pvs_word_lang( "save" )
?>"></p>
</form>
