<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "catalog_search" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

?>



<a class="btn btn-danger toright" href="<?php echo(pvs_plugins_admin_url('search/index.php'));?>&action=delete"><i class="icon-trash icon-white"></i> <?php echo pvs_word_lang( "remove all" )?></a>


<h1><?php echo pvs_word_lang( "search history" )?>:</h1>



<div id="catalog_menu">
<form method="post">





<?php
//Текущая страница
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//Количество новостей на странице
$kolvo = $pvs_global_settings["k_str"];

//Количество страниц на странице
$kolvo2 = PVS_PAGE_NUMBER;

$query = "";
if ( isset( $_POST["query"] ) ) {
	$query = pvs_result( $_POST["query"] );
}
if ( isset( $_GET["query"] ) ) {
	$query = pvs_result( $_GET["query"] );
}

if ( isset( $_POST["d1"] ) and isset( $_POST["m1"] ) and isset( $_POST["y1"] ) ) {
	$data1 = pvs_get_time( 0, 0, 0, $_POST["m1"], $_POST["d1"], $_POST["y1"] );
} elseif ( isset( $_GET["d1"] ) and isset( $_GET["m1"] ) and isset( $_GET["y1"] ) ) {
	$data1 = pvs_get_time( 0, 0, 0, $_GET["m1"], $_GET["d1"], $_GET["y1"] );
} else
{
	$data1 = pvs_get_time( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) ) - 3600 *
		24 - 7;
}

if ( isset( $_POST["d2"] ) and isset( $_POST["m2"] ) and isset( $_POST["y2"] ) ) {
	$data2 = pvs_get_time( 23, 59, 59, $_POST["m2"], $_POST["d2"], $_POST["y2"] );
} elseif ( isset( $_GET["d2"] ) and isset( $_GET["m2"] ) and isset( $_GET["y2"] ) ) {
	$data2 = pvs_get_time( 23, 59, 59, $_GET["m2"], $_GET["d2"], $_GET["y2"] );
} else
{
	$data2 = pvs_get_time( 23, 59, 59, date( "m" ), date( "d" ), date( "Y" ) );
}

$d1 = date( "d", $data1 );
$m1 = date( "m", $data1 );
$y1 = date( "Y", $data1 );

$d2 = date( "d", $data2 );
$m2 = date( "m", $data2 );
$y2 = date( "Y", $data2 );
?>


<div class="toleft">


<span><?php echo pvs_word_lang( "query" )?>:</span>
<input type="text" name="query" value="<?php echo $query
?>" style="width:185px"><br>
</div>
<div class="toleft">

<span>From:</span>

<select name="d1" style="width:70px;display:inline">
<?php
for ( $i = 1; $i < 32; $i++ ) {
	$sel = "";
	if ( $d1 == $i ) {
		$sel = "selected";
	}
?>
<option value="<?php echo $i
?>" <?php echo $sel;
?>><?php echo $i;

}
?>
</select>&nbsp;<select name="m1" style="width:150px;display:inline">
<?php
for ( $i = 0; $i < count( $m_month ); $i++ ) {
	$sel = "";
	if ( $m1 == $i + 1 ) {
		$sel = "selected";
	}
?>
<option value='<?php echo $i + 1
?>' <?php echo $sel
?>><?php echo pvs_word_lang( strtolower( $m_month[$i] ) );
}
?>
</select>&nbsp;<select name=y1 style="width:80px;display:inline">
<?php
for ( $i = 2005; $i < date( "Y" ) + 1; $i++ ) {
	$sel = "";
	if ( $y1 == $i ) {
		$sel = "selected";
	}
?>
<option value='<?php echo $i
?>' <?php echo $sel
?>><?php echo $i;

}
?>
</select>

</div>
<div class="toleft">

<span>To:</span>
<select name="d2" style="width:70px;display:inline">
<?php
for ( $i = 1; $i < 32; $i++ ) {
	$sel = "";
	if ( $d2 == $i ) {
		$sel = "selected";
	}
?>
<option value="<?php echo $i
?>" <?php echo $sel;
?>><?php echo $i;

}
?>
</select>&nbsp;<select name="m2" style="width:150px;display:inline">
<?php
for ( $i = 0; $i < count( $m_month ); $i++ ) {
	$sel = "";
	if ( $m2 == $i + 1 ) {
		$sel = "selected";
	}
?>
<option value='<?php echo $i + 1
?>' <?php echo $sel;
?>><?php echo pvs_word_lang( strtolower( $m_month[$i] ) );
}
?>
</select>&nbsp;<select name=y2 style="width:80px;display:inline">
<?php
for ( $i = 2005; $i < date( "Y" ) + 1; $i++ ) {
	$sel = "";
	if ( $y2 == $i ) {
		$sel = "selected";
	}
?>
<option value='<?php echo $i
?>' <?php echo $sel;
?>><?php echo $i;

}
?>
</select>

</div>

<div class="toleft">
<span>&nbsp;</span>
<input type="submit" class="btn btn-danger" value="<?php echo pvs_word_lang( "search" )?>">
</div>


<div class="toleft_clear"></div>


</form>

</div>




    <div class="alert  alert-warning" style="margin:0px 5px 15px 5px">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    We advice you to clear Search history from time to time. It can strongly increase the database's size. <br>You can disable it in <b>PVS Settings - >Site settings -> Search history</b>
    </div>













<?php
$com = "";
if ( $query != "" ) {
	$com = " and zapros like '%" . $query . "%'";
}

$sql = "select zapros, count(zapros) as quantity from " . PVS_DB_PREFIX .
	"search_history where data>" . ( $data1 - 1 ) . " and data<" . ( $data2 + 1 ) .
	$com . " group by zapros order by quantity desc,zapros";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b><?php echo pvs_word_lang( "query" )?></b></th>
<th><b><?php echo pvs_word_lang( "quantity" )?></b></th>
</tr>
</thead>
<?php
	$n = 0;
	
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
<tr valign="top">

<td><div class="link_preview"><?php
			echo $rs->row["zapros"] ?></div></td>
<td><?php
			echo $rs->row["quantity"] ?></td>

</tr>
<?php
		}
		$n++;
		
		$rs->movenext();
	}
?>
</table>
<br>
<?php echo ( "<p>" . pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('search/index.php'), "&d1=" . $d1 .
		"&m1=" . $m1 . "&y1=" . $y1 . "&d2=" . $d2 . "&m2=" . $m2 . "&y2=" . $y2 .
		"&query=" . $query ) . "</p>" );
} else
{
?>
<p>Not found.</p>
<?php
}
?>















<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>