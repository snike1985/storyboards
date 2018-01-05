<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$type = "mine";

include ( "profile_top.php" );

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
?>


<script>
function edit(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('c'+value).innerHTML =req.responseText;

        }
    }
    req.open(null, '<?php echo site_url();
?>/reviews-edit/', true);
    req.send( { id: value } );
}



function change(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
document.getElementById('c'+value).innerHTML =req.responseText;
        }
    }
    req.open(null, '<?php echo site_url();
?>/reviews-change/', true);
    req.send( {'id': value, 'content': document.getElementById("content"+value).value } );
}


</script>


<h1><?php echo pvs_word_lang( "reviews" );?> - <?php echo pvs_word_lang( "mine" );?></h1>






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
</script>






<?php
$n = 0;
$tr = 1;
$sql = "select id_parent,fromuser,data,content,itemid from " . PVS_DB_PREFIX .
	"reviews where fromuser='" . pvs_result( pvs_get_user_login () ) .
	"' order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<form method="post" action="<?php echo (site_url( ) );?>/reviews-delete/" id="reviewsform" name="reviewsform">
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
	<tr>
	<th><input type="checkbox" id="selector" name="selector" onClick="publications_select_all(document.reviewsform);"></th>
	<th colspan="2"><?php echo pvs_word_lang( "item" );?>:</th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" );?>:</th>
	<th width="70%"><?php echo pvs_word_lang( "content" );?>:</th>
	<th></th>
	</tr>
	<?php
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<td><input type="checkbox" id="m<?php
			echo $rs->row["id_parent"];
?>" name="m<?php
			echo $rs->row["id_parent"];
?>" value="1"></td>
			<?php
			$sql = "select title,url,server1,media_id from " . PVS_DB_PREFIX . "media where id=" . $rs->
				row["itemid"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$item_title = $dr->row["title"];
				$item_url = $dr->row["url"];
				$item_img = "";
				if ( $dr->row["media_id"] == 1 )
				{
					$item_img = pvs_show_preview( $rs->row["itemid"], "photo", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 2 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "video", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 3 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "audio", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				if ( $dr->row["media_id"] == 4 )
				{
						$item_img = pvs_show_preview( $rs->row["itemid"], "vector", 1, 1, $dr->row["server1"],
							$rs->row["itemid"] );
				}
				echo ( "<td><a href='" . $item_url . "'><img src='" . $item_img .
					"' width='70' border='0'></a></td>" );
				echo ( "<td class='hidden-phone hidden-tablet'><a href='" . $item_url . "'>" . $item_title .
					"</a></td>" );
			}
?>
			<td nowrap class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo pvs_show_time_ago( $rs->row["data"] );?></div></td>
			<td nowrap><div id="c<?php
			echo $rs->row["id_parent"];
?>" name="c<?php
			echo $rs->row["id_parent"];
?>"><?php
			echo str_replace( "\n", "<br>", $rs->row["content"] );?></div></td>
			<td><div class="link_edit"><a href="javascript:edit(<?php
			echo $rs->row["id_parent"];
?>);"><?php
			echo pvs_word_lang( "edit" );?></a></div></td>
			</tr>
			<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
	</table><input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "delete" );?>" style="margin-top:4px"></form>

	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/reviews/", "" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}

include ( "profile_bottom.php" );
?>