<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "prints_prints" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>





<h1><?php echo pvs_word_lang( "prints" )?>:</h1>


<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">



<?php
//Get Search
$search = "";
if ( isset( $_REQUEST["search"] ) ) {
	$search = pvs_result( $_REQUEST["search"] );
}

//Get Search type
$search_type = "";
if ( isset( $_REQUEST["search_type"] ) ) {
	$search_type = pvs_result( $_REQUEST["search_type"] );
}

//Get print_id
$print_id = 0;
if ( isset( $_REQUEST["print_id"] ) ) {
	$print_id = pvs_result( $_REQUEST["print_id"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) ) {
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items . "&print_id=" . $print_id;

//Add sort variable
$com = "order by id_parent desc";

//Items on the page
$items_mass = array(
	10,
	20,
	30,
	50,
	75,
	100 );

//Search parameter
$com2 = "";

if ( $search != "" ) {
	$com2 .= " and itemid=" . ( int )$search . " ";
}

if ( $search_type == "unlimited" ) {
	$com2 .= " and in_stock = -1 ";
}

if ( $search_type == "in_stock" ) {
	$com2 .= " and in_stock > 0 ";
}

if ( $search_type == "not_in_stock" ) {
	$com2 .= " and in_stock = 0 ";
}

if ( $print_id != 0 ) {
	$com2 .= " and printsid = " . $print_id . " ";
}

if ( (int)@$_GET["id"] > 0  ) {
	$com2 .= " and id_parent=" . (int)@$_GET["id"] . " ";
}

//Item's quantity
$kolvo = $items;

//Pages quantity
$kolvo2 = PVS_PAGE_NUMBER;

//Page number
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

$n = 0;

$sql = "select id_parent, title, price, itemid, priority, printsid, in_stock from " .
	PVS_DB_PREFIX . "prints_items where id_parent>0 ";

$sql .= $com2 . $com;

$rs->open( $sql );
$record_count = $rs->rc;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );
?>
<div id="catalog_menu">


<form method="post">
<div class="toleft">
<span><?php echo pvs_word_lang( "search" )?>:</span>
<input type="text" name="search" style="width:200px;display:inline" class="ft" value="<?php echo $search
?>" onClick="this.value=''" placeholder="<?php echo pvs_word_lang( "photo" )?> ID">
</div>










<div class="toleft">
<span><?php echo pvs_word_lang( "quantity" )?>:</span>
<select name="search_type" style="width:150px" class="ft">
<option value="all"></option>
<option value="unlimited" <?php
if ( $search_type == "unlimited" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "Unlimited" )?></option>
<option value="in_stock" <?php
if ( $search_type == "in_stock" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "In stock" )?></option>
<option value="not_in_stock" <?php
if ( $search_type == "not_in_stock" ) {
	echo ( "selected" );
}
?>><?php echo pvs_word_lang( "Not in stock" )?></option>
</select>
</div>


<div class="toleft">
<span><?php echo pvs_word_lang( "prints" )?>:</span>
<select name="print_id" class='form-control' style="width:200px">
<option value="0"><?php echo pvs_word_lang( "all" )?></option>
<?php
$prints_mass = array();

$sql_prints = "select id from " . PVS_DB_PREFIX .
	"prints_categories where active=1 order by priority";
$dr->open( $sql_prints );
while ( ! $dr->eof ) {
	$prints_mass[] = $dr->row["id"];
	$dr->movenext();
}
$prints_mass[] = 0;

foreach ( $prints_mass as $key => $value ) {
	$sql_prints = "select id_parent,title from " . PVS_DB_PREFIX .
		"prints where category=" . $value . " order by priority";
	$dd->open( $sql_prints );
	while ( ! $dd->eof ) {
		$chk = "";
		if ( @$_REQUEST["print_id"] == $dd->row["id_parent"] ) {
			$chk = "selected";
		}
?>
			<option value="<?php echo $dd->row["id_parent"] ?>" <?php echo $chk
?>><?php echo pvs_word_lang( $dd->row["title"] )?></option>
		<?php
		$dd->movenext();
	}
}
?>
</select>
</div>




<div class="toleft">
<span><?php echo pvs_word_lang( "page" )?>:</span>
<select name="items" style="width:70px" class="ft">
<?php
for ( $i = 0; $i < count( $items_mass ); $i++ ) {
	$sel = "";
	if ( $items_mass[$i] == $items ) {
		$sel = "selected";
	}
?>
<option value="<?php echo $items_mass[$i] ?>" <?php echo $sel
?>><?php echo $items_mass[$i] ?></option>
<?php
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



<?php
if ( ! $rs->eof ) {
?>




<script language="javascript">
function publications_select_all(sel_form) {
    if(sel_form.selector.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}

function change_quantity(print,value) {
	if(value == -1) {
		$("#quantity"+print).css("display","none");
	}
	else {
		$("#quantity"+print).css("display","block");
	}
}

function bulk_change_price(value) {
	$(".prints_price").val(value);
}

function bulk_change_quantity(value) {
	if(value == -1) {
		$("#quantity").css("display","none");
		$(".text_quantity").css("display","none");
	}
	else {
		$("#quantity").css("display","block");
		$(".text_quantity").css("display","block");
	}
	
	$(".select_quantity").val(value);
}

function bulk_change_quantity2(value) {
	$(".text_quantity").val(value);
}
</script>



<form method="post" action="change.php" style="margin:0px"  id="adminform" name="adminform">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th style="width:20%"><?php echo pvs_word_lang( "prints" )?></th>
<th class="hidden-phone hidden-tablet">ID</th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "title" )?></th>
<th><?php echo pvs_word_lang( "quantity" )?><br><select id='quantity_type' name='quantity_type' class='form-control' onChange="bulk_change_quantity(this.value)" style="width:150px">
			<option value="-1"><?php echo pvs_word_lang( "Unlimited" )?></option>
			<option value="0"><?php echo pvs_word_lang( "Value" )?></option>
		</select>
		<input type="text"  id='quantity' name='quantity' value="0"  style="width:150px;margin-top:3px;display:none" onkeyup="bulk_change_quantity2(this.value)"></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "price" )?> <input type="text" name="price" value="" style="width:100px"  onkeyup="bulk_change_price(this.value)"></th>
<th class="hidden-phone hidden-tablet"><?php echo pvs_word_lang( "photo" )?></th>
<th class="hidden-phone hidden-tablet"><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"> <?php echo pvs_word_lang( "delete" )?></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof ) {
?>
	<tr valign="top" <?php
		if ( $rs->row["in_stock"] == 0 ) {
			echo ( ' class="danger"' );
		}
?>>
	<td>
	<?php
		$sql = "select id,title,server1 from " . PVS_DB_PREFIX .
			"media where id=" . ( int )$rs->row["itemid"];
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			if ( $pvs_global_settings["prints_previews"] )
			{
				$print_info = pvs_get_print_preview_info( $rs->row["printsid"] );
				if ( $print_info["flag"] )
				{
					$url = pvs_print_url( $rs->row["itemid"], $rs->row["printsid"], $dr->row["title"],
						$print_info["preview"], '' );
				} else
				{
					$url = pvs_item_url( $rs->row["itemid"] );
				}

				$preview = pvs_show_print_preview( $rs->row["itemid"], $rs->row["printsid"] );
				echo ( $preview );
			} else
			{
				$url = pvs_item_url( $rs->row["itemid"] );
				$preview = '<a href="' . $url . '"><img src="' . pvs_show_preview( $rs->row["itemid"],
					"photo", 1, 1, $dr->row["server1"], $rs->row["itemid"] ) . '"></a>';
				echo ( $preview );
			}
		}
?>
	</td>
	<td class="hidden-phone hidden-tablet"><?php echo $rs->row["id_parent"] ?></td>
	<td class="big hidden-phone hidden-tablet"><?php echo pvs_word_lang( $rs->row["title"] )?></td>
	<td>
		<select id='quantity_type<?php echo $rs->row["id_parent"] ?>' name='quantity_type<?php echo $rs->row["id_parent"] ?>' class='form-control select_quantity' onChange="change_quantity('<?php echo $rs->row["id_parent"] ?>',this.value)" style="width:150px">
			<option value="-1" <?php
		if ( $rs->row["in_stock"] == -1 ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "Unlimited" )?></option>
			<option value="0" <?php
		if ( $rs->row["in_stock"] >= 0 ) {
			echo ( "selected" );
		}
?>><?php echo pvs_word_lang( "Value" )?></option>
		</select>
		<input type="text"  id='quantity<?php echo $rs->row["id_parent"] ?>' name='quantity<?php echo $rs->row["id_parent"] ?>' value="<?php
		if ( $rs->row["in_stock"] >= 0 ) {
			echo ( $rs->row["in_stock"] );
		} else {
			echo ( 0 );
		}
?>"  style="width:150px;margin-top:3px;<?php
		if ( $rs->row["in_stock"] == -1 ) {
			echo ( "display:none" );
		}
?>" class='form-control text_quantity'>
	</td>
	<td><input type="text" name="price<?php echo $rs->row["id_parent"] ?>" value="<?php echo pvs_price_format( $rs->row["price"], 2 )?>" class="form-control prints_price" style="width:100px"></td>
	<td><a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php echo $rs->row["itemid"] ?>">#<?php echo $rs->row["itemid"] ?></a></td>
	<td><input type="checkbox" name="sel<?php echo $rs->row["id_parent"] ?>" id="sel<?php echo $rs->row["id_parent"] ?>"></td>
	</tr>
	<?php
		$n++;
		$rs->movenext();
	}
?>
</table>



<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>"  style="margin:15px 0px 0px 6px;">






</form>
<div style="padding:25px 0px 0px 6px;"><?php echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('prints/index.php'), "&" . $var_search ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>