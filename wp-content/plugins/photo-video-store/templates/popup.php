<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}



$sql = "select title,content from " . PVS_DB_PREFIX . "pages where id_parent=" . ( int )
	$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<html>
	<head>
	<title><?php echo $rs->row["title"] ?></title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel=stylesheet type="text/css" href="<?php echo site_url()?>/<?php echo $site_template_url
?>style.css">
	</head>
	<body>
		<div style="padding:20px">
		<h3><?php echo $rs->row["title"] ?></h3>
		<?php echo $rs->row["content"] ?>
		</div>
	</body>
	</html>
	<?php
}
?>





