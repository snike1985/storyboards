<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<html>
<head>
<title><?php echo pvs_word_lang( "print version" )?></title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<style>
table.profile_table th
{
padding:5px;
border-top: 1px #e2e2e2 solid;
background-color:#f2f2f2;
margin:0px;
font: 12px Arial;
text-align:left;
}

table.profile_table tr
{
background-color:#ffffff;
}


table.profile_table td
{
padding:10px 5px 10px 5px;
margin:0px;
}


.payment_table
{
width:100%;
}

.payment_table td
{
padding: 5px;
}

.payment_table th
{
background-color:#eeeeee;
color:#42433e;
font: 13px Arial;
font-weight:bold;
padding: 5px;
text-align:left;
}

.payment_table tr
{
vertical-align: top;
}

.payment_table2
{
width:100%;
}

.payment_table2 td
{
paddingt: 5px 20px 20px 0px;
font: 12px Arial;
}

</style>
</head>
<body>
<div style="width:1000px">
<?php
include ( "payments_statement.php" );?>
</div>
</body>
</html>
<?php
?>





