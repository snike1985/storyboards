<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );
?><img src='<?php echo site_url()?>/image/?id=<?php echo $_REQUEST["id"] ?>&x1=<?php echo $_REQUEST["x1"] ?>&x0=<?php echo $_REQUEST["x0"] ?>&y1=<?php echo $_REQUEST["y1"] ?>&y0=<?php echo $_REQUEST["y0"] ?>&z=<?php echo $_REQUEST["z"] ?>&width=<?php echo $_REQUEST["width"] ?>&height=<?php echo $_REQUEST["height"] ?>'>