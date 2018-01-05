<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printful" );
?>

<p>The new prints orders are not sent to printful service automatically. You have 2 ways to place them:</p>

<ul>
	<li><b>Manually</b> in <a href="<?php
echo ( pvs_plugins_admin_url( 'prints_printful/index.php' ) );
?>&d=2">Orders</a> section</li>
	<li>Set a <b>Cron task</b> on your server which will move all new orders to printful with some periodicity (once per day for example).</li>
</ul>

<p>
You can find the cron script here: 
<b><?php
echo site_url()
?>/cron-printful/</b>
</p>


<p><b>Examples of the cron commands:</b></p>

<ul>
<li>/usr/bin/lynx -source <?php
echo site_url()
?>/cron-printful/</li>
<li>GET <?php
echo site_url()
?>/cron-printful/ > /dev/null</li>
</ul>
