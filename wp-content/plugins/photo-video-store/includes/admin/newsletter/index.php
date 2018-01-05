<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_newsletter" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>




<h1><?php echo pvs_word_lang( "newsletter" )?>:</h1>
<br>
<div class="alert alert-warning">
<p>We advise you to use <a href="https://mailchimp.com/">MailChimp</a> newsletter service.</p>
</div>


<p>Here you can find all user's emails with enabled 'Newsletter' option.</p>
<?php
$emails_buyers = "";
$emails_sellers = "";
$emails_affiliates = "";
$emails_common = "";

$sql = "select ID from " . $table_prefix . "users order by user_login";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$user_info = get_userdata($rs->row["ID"]);

	if ( @$user_info -> user_email != "" and  @$user_info -> newsletter == 1 ) {
		$type = pvs_get_user_type ($rs->row["ID"]);
		if ( $type == "buyer" ) {
			if ( $emails_buyers != "" )
			{
				$emails_buyers .= "; ";
			}
			$emails_buyers .= @$user_info -> user_email;
		}
		if ( $type == "seller" ) {
			if ( $emails_sellers != "" )
			{
				$emails_sellers .= "; ";
			}
			$emails_sellers .= @$user_info -> user_email;
		}
		if ( $type == "affiliate" ) {
			if ( $emails_affiliates != "" )
			{
				$emails_affiliates .= "; ";
			}
			$emails_affiliates .= @$user_info -> user_email;
		}
		if ( $type == "common") {
			if ( $emails_common != "" )
			{
				$emails_common .= "; ";
			}
			$emails_common .= @$user_info -> user_email;
		}
	}
	$rs->movenext();
}
?>
<p><b><?php echo pvs_word_lang( "buyer" )?>:</b></p>
<textarea style="width:600px;height:150px"><?php echo $emails_buyers ?>
</textarea>
<br>
<p><b><?php echo pvs_word_lang( "seller" )?>:</b></p>
<textarea style="width:600px;height:150px"><?php echo $emails_sellers
?></textarea>
<br>
<p><b><?php echo pvs_word_lang( "affiliate" )?>:</b></p>
<textarea style="width:600px;height:150px"><?php echo $emails_affiliates
?></textarea>
<br>
<p><b><?php echo pvs_word_lang( "common" )?>:</b></p>
<textarea style="width:600px;height:150px"><?php echo $emails_common
?></textarea>



<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>