<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>

<?php
if ( $site_fortumo_account != "" ) {
?>
<script src="http://fortumo.com/javascripts/fortumopay.js"></script>
<a id="fmp-button" href="#" rel="<?php echo $site_fortumo_account
?>/<?php echo get_current_user_id() ?>">
 <img src="http://fortumo.com/images/fmp/fortumopay_96x47.png" width="96" height="47" alt="Mobile Payments by Fortumo" border="0" />
</a>
<?php
}
?>




