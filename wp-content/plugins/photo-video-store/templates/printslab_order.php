<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
include ( "profile_top.php" );?>


<h1><?php echo pvs_word_lang( "prints lab" )?> &mdash; 

<?php
if ( isset( $_GET["id"] ) ) {
	$sql = "select title from " . PVS_DB_PREFIX . "galleries where id=" . ( int )$_GET["id"] .
		" and user_id=" . get_current_user_id();
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		echo ( $rs->row["title"] );
	} else {
		exit();
	}
}
?>
</h1>

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

function change_prints(prints_id,prints_value) {	
	if(document.getElementById('thesame').checked) {
		$(".printsclass").val(prints_value);
		$(".prints_options").css("display","none");
		$(".prints_options_value"+prints_value).css("display","block");
	}
	else {
		$(".prints_options"+prints_id).css("display","none");
		$("#prints_options"+prints_id+"_"+prints_value).css("display","block");
	}
}

function change_prints_option(prints_id,prints_value,option_id,option_value,option_value_id,flag_radio) {	
	if(document.getElementById('thesame').checked) {
		$(".product_option"+option_id).val(option_value);
		
		if(flag_radio) {
			$(".product_option"+prints_value).removeAttr("checked");
			$(".product_option_value"+option_value_id).attr('checked',true);		
		}
	}
}


</script>

<?php
if ( ! $pvs_global_settings["prints_previews"] ) {
?>
<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/printslab-add-to-cart/" name="printslabform">

<input type="hidden" name="gallery_id" value="<?php echo ( int )$_GET["id"] ?>">
<?php
}
?>

<?php
$prints_mass = array();

$sql = "select id from " . PVS_DB_PREFIX .
	"prints_categories where active=1 order by priority";
$dd->open( $sql );
while ( ! $dd->eof ) {
	$prints_mass[] = $dd->row["id"];
	$dd->movenext();
}
$prints_mass[] = 0;

if ( isset( $_GET["id"] ) and ( int )$_GET["id"] > 0 ) {
	$sql = "select * from " . PVS_DB_PREFIX . "galleries where user_id='" . ( int )
		get_current_user_id() . "' and id=" . ( int )$_GET["id"] .
		" order by data desc";
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$sql = "select * from " . PVS_DB_PREFIX . "galleries_photos where id_parent=" . ( int )
			$_GET["id"] . " order by data desc";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			if ( ! $pvs_global_settings["prints_previews"] )
			{
?>
			<input type="checkbox" id="thesame" checked> - <?php
				echo pvs_word_lang( "Use the same prints options for the gallery" )?>
			<?php
			}
?>
		
		<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%" style="margin-top:15px">
		<tr>
		<?php
			if ( ! $pvs_global_settings["prints_previews"] )
			{
?>
			<th style="text-align:center"><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.printslabform);" checked></th>
			<?php
			}
?>
		<th><?php
			echo pvs_word_lang( "preview" )?></th>	
		<th><?php
			echo pvs_word_lang( "title" )?></th>
		<th><?php
			echo pvs_word_lang( "size" )?></th>
		<th style="width:50%"><?php
			echo pvs_word_lang( "prints and products" )?></th>
	
		</tr>
		<?php
			$tr = 1;
			while ( ! $rs->eof )
			{
?>
			<tr valign="top" <?php
				if ( $tr % 2 == 0 )
				{
					echo ( "class='snd'" );
				}
?>>
			<?php
				if ( ! $pvs_global_settings["prints_previews"] )
				{
?>
	<td style="text-align:center"><input type="checkbox" name="sel<?php
					echo $rs->row["id"] ?>" checked></td>
	<?php
				}
?>
			<td><div class="t"><div class="b"><div class="l"><div class="r"><div class="bl"><div class="br"><div class="tl"><div class="tr2"><img src="<?php
				echo pvs_upload_dir('baseurl')?>/content/galleries/<?php
				echo $rs->row["id_parent"] ?>/thumb<?php
				echo $rs->row["id"] ?>.jpg"></div></div></div></div></div></div></div></div></td>		
			<td><span class="label"><?php
				echo $rs->row["title"] ?></span></td>
			<td>
			<?php
				$img = pvs_upload_dir() . "/content/galleries/" . ( int )$_GET["id"] .
					"/" . $rs->row["photo"];
				if ( file_exists( $img ) )
				{
					echo ( pvs_get_exif( $img, true ) );
				}
?>
			</td>
			<td>
			<?php
				$prints_content = "<div class='form_field'><span><b>" . pvs_word_lang( "type" ) .
					":</b></span><select name='prints" . $rs->row["id"] .
					"' class='printsclass form-control' onChange='change_prints(" . $rs->row["id"] .
					",this.value)'>";

				foreach ( $prints_mass as $key => $value )
				{
					$sql = "select id_parent,title,price,priority,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
						PVS_DB_PREFIX . "prints where category=" . $value .
						" and printslab=1 order by priority";
					$dd->open( $sql );
					while ( ! $dd->eof )
					{
						$prints_content .= "<option value='" . $dd->row["id_parent"] . "'>" . $dd->row["title"] .
							"</option>";
						$dd->movenext();
					}
				}

				$prints_content .= "</select></div>";

				$flag_active = true;

				foreach ( $prints_mass as $key => $value )
				{
					$sql = "select id_parent,title,price,priority,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
						PVS_DB_PREFIX . "prints where category=" . $value .
						" and printslab=1 order by priority";
					$dd->open( $sql );
					while ( ! $dd->eof )
					{
						if ( $flag_active )
						{
							$style = "block";
							$flag_active = false;
						} else
						{
							$style = "none";
						}

						$prints_content .= "<div class='prints_options prints_options" . $rs->row["id"] .
							" prints_options_value" . $dd->row["id_parent"] . "' id='prints_options" . $rs->
							row["id"] . "_" . $dd->row["id_parent"] . "' style='display:" . $style . "'>";
						for ( $i = 1; $i < 11; $i++ )
						{
							if ( $dd->row["option" . $i] != 0 )
							{
								$sql = "select title,type,activ,required from " . PVS_DB_PREFIX .
									"products_options where activ=1 and id=" . $dd->row["option" . $i];
								$dn->open( $sql );
								if ( ! $dn->eof )
								{
									$prints_content .= "<div class='ttl' style='margin-top:15px'>" . $dn->row["title"] .
										":</div><div>";

									if ( $dn->row["type"] == "selectform" or $dn->row["type"] == "colors" or $dn->
										row["type"] == "frame" or $dn->row["type"] == "background" )
									{
										$prints_content .= "<select name='option" . $rs->row["id"] . "_" . $dd->row["id_parent"] .
											"_" . $i . "_" . $dd->row["option" . $i] . "' onChange=\"change_prints_option(" .
											$rs->row["id"] . "," . $dd->row["id_parent"] . "," . $dd->row["option" . $i] .
											",this.value,0,false)\" class='ibox  form-control product_option" . $dd->row["option" .
											$i] . "' style='width:150px'>";
									}

									$flag_checked = true;

									$sql = "select id,title,price,adjust from " . PVS_DB_PREFIX .
										"products_options_items where id_parent=" . $dd->row["option" . $i] .
										" order by id";
									$ds->open( $sql );
									while ( ! $ds->eof )
									{
										$sel = "";
										$sel2 = "";

										if ( $flag_checked )
										{
											$sel = "selected";
											$sel2 = "checked";
											$flag_checked = false;
										}

										if ( $dn->row["type"] == "selectform" or $dn->row["type"] == "colors" or $dn->
											row["type"] == "frame" or $dn->row["type"] == "background" )
										{
											$prints_content .= "<option value='" . $ds->row["title"] . "' " . $sel . ">" . $ds->
												row["title"] . "</option>";
										}
										if ( $dn->row["type"] == "radio" )
										{
											$prints_content .= "<input name='option" . $rs->row["id"] . "_" . $dd->row["id_parent"] .
												"_" . $i . "_" . $dd->row["option" . $i] . "' onClick=\"change_prints_option(" .
												$rs->row["id"] . "," . $dd->row["id_parent"] . "," . $dd->row["option" . $i] .
												",'" . $ds->row["title"] . "'," . $ds->row["id"] . ",true)\" class='product_option" .
												$dd->row["id_parent"] . " product_option_value" . $ds->row["id"] .
												"' type='radio' value='" . $ds->row["title"] . "' " . $sel2 . ">&nbsp;" . $ds->
												row["title"] . "&nbsp;&nbsp;";
										}

										$ds->movenext();
									}

									if ( $dn->row["type"] == "selectform" or $dn->row["type"] == "colors" or $dn->
										row["type"] == "frame" or $dn->row["type"] == "background" )
									{
										$prints_content .= "</select>";
									}

									$prints_content .= "</div>";
								}
							}
						}
						$prints_content .= "</div>";
						$dd->movenext();
					}
				}
				if ( ! $pvs_global_settings["prints_previews"] )
				{
					echo ( $prints_content );
				} else
				{
					$prints_content = "<form method='get' action='" . site_url( ). "/printslab-mockup/'><div class='form_field'><span><b>" .
						pvs_word_lang( "type" ) . ":</b></span><input type='hidden' name='id' value='" . ( int )
						$_GET["id"] . "'><input type='hidden' name='photo' value='" . $rs->row["id"] .
						"'><select name='print_id' class='printsclass form-control'>";

					foreach ( $prints_mass as $key => $value )
					{
						$sql = "select id_parent,title,price,priority,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10 from " .
							PVS_DB_PREFIX . "prints where category=" . $value .
							" and printslab=1 order by priority";
						$dd->open( $sql );
						while ( ! $dd->eof )
						{
							$prints_content .= "<option value='" . $dd->row["id_parent"] . "'>" . $dd->row["title"] .
								"</option>";
							$dd->movenext();
						}
					}

					$prints_content .= "</select></div><div class='form_field'><input type='submit' value='" .
						pvs_word_lang( "Order prints" ) . "' class='isubmit'></div></form>";

					echo ( $prints_content );
				}
?>
			</td>
			
			</tr>
			<?php
				$tr++;
				$rs->movenext();
			}
?>
		</table>
		<?php
		}
	}
}
?>


<?php
if ( ! $pvs_global_settings["prints_previews"] ) {
?>
<div class="form_field">
	<input class='isubmit' value="<?php echo pvs_word_lang( "add to cart" )?>" name="subm" type="submit">
</div>
</form>
<?php
}

include ( "profile_bottom.php" );
?>