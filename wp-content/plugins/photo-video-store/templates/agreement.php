<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<html>
<title>Agreement</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body style="padding:10px">

<?php
		$sql = "select post_content from " . $table_prefix .
			"posts where post_type = 'page' and ID = " . (int)$_REQUEST["id"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			echo($ds->row["post_content"]);
		}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>