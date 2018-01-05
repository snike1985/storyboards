<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "my profile" );?></h1>


		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
		
		<tr>
			<th colspan="3"><?php echo pvs_word_lang( "stats" );?></th>
		</tr>







<?php
if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
?>
		<?php
	if ( $pvs_global_settings["credits"] == 1 ) {
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "balance" );?>:</b></td>
	 		<td><div class="link_total"><span class="price"><b><?php echo pvs_price_format( pvs_credits_balance(), 2 );?> <?php echo pvs_word_lang( "credits" );?></b></span></div></td>
	 		<td class='hidden-phone hidden-tablet'>[<a href="<?php echo (site_url( ) );?>/credits/?d=1"><?php echo pvs_word_lang( "buy credits" );?></a>]</td>
	 	</tr>
	 	<?php
	}
?>
	 	
	 	<?php
	if ( $pvs_global_settings["subscription"] == 1 ) {
?>
		<tr>
			<td><b><?php echo pvs_word_lang( "subscription" );?>:</b></td>
			<?php
		$sql = "select title from " . PVS_DB_PREFIX . "subscription_list where user='" .
			pvs_result( pvs_get_user_login () ) . "' and approved=1 and data2>" .
			pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
			date( "Y" ) ) . " order by data2 desc";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
?>
	 			<td><div class="link_subscription"><?php
			echo $ds->row["title"];
?></div></td>
	 			<td class='hidden-phone hidden-tablet'></td>
	 		<?php
		} else {
?>
	 			<td><div class="link_date"><?php
			echo pvs_word_lang( "no" );?></div></td>
	 			<td class='hidden-phone hidden-tablet'>[<a href="<?php echo (site_url( ) );?>/subscription/"><?php
			echo pvs_word_lang( "buy subscription" );?></a>]</td>
	 		<?php
		}
?>
	 	</tr>
	 	<?php
	}
?>
	 	
	 	<tr>
			<td><b><?php echo pvs_word_lang( "my downloads" );?>:</b></td>
	 		<td>
	 			<?php
	$download_count = 0;
	$sql = "select count(id) as download_count from " . PVS_DB_PREFIX .
		"downloads where user_id=" . get_current_user_id() . " and data>" .
		pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) );
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$download_count = $ds->row["download_count"];
	}
?>
	 			<div class="link_download"><a href="<?php echo (site_url( ) );?>/profile-downloads/"><?php echo $download_count;
?></a></div>
	 		</td>
	 		<td class='hidden-phone hidden-tablet'></td>
	 	</tr>
	<?php
	if ( $pvs_global_settings["lightboxes"] == 1 ) {
	?>	 	
			<tr>
				<td><b><?php echo pvs_word_lang( "my favorite list" );?>:</b></td>
				<td>
					<?php
		$lightbox_count = 0;
	
		$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_admin where user=" . ( int )
			get_current_user_id();
		$rs->open( $sql );
		while ( ! $rs->eof ) {
			$sql = "select title from " . PVS_DB_PREFIX . "lightboxes where id=" . $rs->row["id_parent"] .
				" order by title";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
				$lightbox_count++;
			}
			$rs->movenext();
		}
	?>
					<div class="link_lightbox"><a href="<?php echo (site_url( ) );?>/my-favorite-list/"><?php echo $lightbox_count;
	?></a></div>
				</td>
				<td class='hidden-phone hidden-tablet'></td>
			</tr>
	<?php
	}
}
?> 	
	 	
	
	
	







<?php
if ( ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["userupload"] ) {
?>
	
	<?php
	$userbalance = 0;
	$sales_count = 0;
	$payout = 0;

	$sql = "select user,total from " . PVS_DB_PREFIX . "commission where user=" . ( int )
		get_current_user_id() . " and status=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		if ( $ds->row["total"] > 0 ) {
			$sales_count++;
			$userbalance += $ds->row["total"];
		} else {
			$payout += -1 * $ds->row["total"];
		}
		$ds->movenext();
	}
?>
	<tr>
		<td><b><?php echo pvs_word_lang( "files" );?>:</b></td>
		<td>
			<?php
	$count_files = 0;
	$sql = "select count(id) as count_files from " . PVS_DB_PREFIX .
		"media where userid=" . get_current_user_id() . " or author='" .
		pvs_result( pvs_get_user_login () ) . "'";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$count_files += $ds->row["count_files"];
	}
?>
			<div class="link_files"><a href="<?php echo (site_url( ) );?>/publications/"><?php echo $count_files;
?></a></div>
		</td>
		<td class='hidden-phone hidden-tablet'></td>
	</tr>
	
	<tr>
		<td><b><?php echo pvs_word_lang( "sales" );?>:</b></td>
		<td><div class="link_commission"><a href="<?php echo (site_url( ) );?>/commission/?d=2"><?php echo $sales_count;
?></a></div></td>
		<td class='hidden-phone hidden-tablet'></td>
	</tr>	
	
	<tr>
		<td><b><?php echo pvs_word_lang( "commission" );?>:</b></td>
		<td><div class="link_credits"><?php echo pvs_currency( 1, true, "credits" );?><a href="<?php echo (site_url( ) );?>/commission/?d=2"><?php echo $userbalance;
?></a>
	 <?php echo pvs_currency( 2, true, "credits" );?></div></td>
		<td class='hidden-phone hidden-tablet'></td>
	</tr>
	
	<tr>
		<td><b><?php echo pvs_word_lang( "refund" );?>:</b></td>
		<td><div class="link_payout"><?php echo pvs_currency( 1, false );?><a href="<?php echo (site_url( ) );?>/commission/?d=3"><?php echo $payout;
?></a>
	 <?php echo pvs_currency( 2, false );?></div></td>
		<td class='hidden-phone hidden-tablet'></td>
	</tr>


<?php
}
?>










<?php
if ( ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["affiliates"] ) {
?>

<?php
	$affbalance = 0;
	$affcount = 0;
	$affpayout = 0;

	$sql = "select total from " . PVS_DB_PREFIX .
		"affiliates_signups where aff_referal=" . get_current_user_id() .
		" and status=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		if ( $ds->row["total"] > 0 ) {
			$affbalance += $ds->row["total"];
		} else {
			$affpayout += -1 * $ds->row["total"];
		}
		$affcount++;
		$ds->movenext();
	}
?>
<tr>
	<td><b><?php echo pvs_word_lang( "affiliate" );?> &mdash; <?php echo pvs_word_lang( "sales" );?>:</b></td>
	<td><div class="link_commission"><a href="<?php echo (site_url( ) );?>/affiliate/?d=2"><?php echo $affcount;
?></a></div></td>
	<td class='hidden-phone hidden-tablet'></td>
</tr>

<tr>
	<td><b><?php echo pvs_word_lang( "affiliate" );?> &mdash; <?php echo pvs_word_lang( "commission" );?>:</b></td>
	<td><div class="link_credits"><a href="<?php echo (site_url( ) );?>/affiliate/?d=2"><?php echo pvs_currency( 1, true, "credits" );?><?php echo $affbalance;
?>
	 <?php echo pvs_currency( 2, true, "credits" );?></a></div></td>
	<td class='hidden-phone hidden-tablet'></td>
</tr>

<tr>
	<td><b><?php echo pvs_word_lang( "affiliate" );?> &mdash; <?php echo pvs_word_lang( "refund" );?>:</b></td>
	<td><div class="link_payout"><?php echo pvs_currency( 1, false );?><a href="<?php echo (site_url( ) );?>/affiliate/?d=3"><?php echo $affpayout;
?></a>
	 <?php echo pvs_currency( 2, false );?></div></td>
	<td class='hidden-phone hidden-tablet'></td>
</tr>





<?php
}
?>





	 	</table>

<p>&nbsp;</p>














<?php
if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
?>	 	
	 	<?php
	$sql = "select publication_id,link,collection_id from " . PVS_DB_PREFIX .
		"downloads where user_id=" . get_current_user_id() . " and data>" .
		pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) );
	$ds->open( $sql );
	if ( ! $ds->eof ) {
?>
	 		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
		
			<tr>
	<th colspan="3"><?php echo pvs_word_lang( "Last downloads" );?></th>
			</tr>
			<?php
		$n = 0;
		while ( ! $ds->eof ) {
			if ( $n < 7 )
			{
?>
			<tr>
				<?php
				if ($ds->row["publication_id"] != 0) {					
					$sql = "select title,media_id from " . PVS_DB_PREFIX . "media where id=" .
						$ds->row["publication_id"];
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$img_preview = "";
						if ( $dr->row["media_id"] == 1 )
						{
							$img_preview = pvs_show_preview( $ds->row["publication_id"], "photo", 1, 1, "",
								"" );
						}
						if ( $dr->row["media_id"] == 2 )
						{
							$img_preview = pvs_show_preview( $ds->row["publication_id"], "video", 1, 1, "",
								"" );
						}
						if ( $dr->row["media_id"] == 3 )
						{
							$img_preview = pvs_show_preview( $ds->row["publication_id"], "audio", 1, 1, "",
								"" );
						}
						if ( $dr->row["media_id"] == 4 )
						{
							$img_preview = pvs_show_preview( $ds->row["publication_id"], "vector", 1, 1, "",
								"" );
						}
					}
				} else {
					$collection_result = pvs_show_collection_preview($ds->row["collection_id"]);
					$img_preview = @$collection_result["photo"];
				}
?>
		<td><div class="profile_home_preview" style="background:url('<?php
					echo $img_preview;
?>')" onClick="location.href='<?php echo (site_url( ) );?>/download/?f=<?php
					echo $ds->row["link"];
?>'"></div></td>
		<td class='hidden-phone hidden-tablet'>
			<?php
				if ($ds->row["publication_id"] != 0) {
					echo pvs_word_lang('file') . ' #' . $ds->row["publication_id"] . " - " .$dr->row["title"];
				} else {
					echo pvs_word_lang('Collections') . ' #' . $ds->row["collection_id"];
				}
			?>
		</td>
				<?php
?>
				<td><div class="link_download"><a href="<?php echo (site_url( ) );?>/download/?f=<?php
				echo $ds->row["link"];
?>"><?php
				echo pvs_word_lang( "download" );?></a></div></td>
			</tr>
		<?php
			}
			$n++;
			$ds->movenext();
		}
?>
			</table>
			<p>&nbsp;</p>
	 		<?php
	}
?>
<?php
}
?>














<?php
if ( ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["userupload"] ) {
	$sql = "select total,user,orderid,item,publication,types,data from " .
		PVS_DB_PREFIX . "commission where user=" . get_current_user_id() .
		" and total>0 order by data desc";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
?>
		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
		
			<tr class='main'>
	<th colspan="4"><?php echo pvs_word_lang( "Last sales" );?></th>
			</tr>
			<?php
		$n = 0;
		while ( ! $rs->eof ) {
			if ( $n < 7 )
			{
				$idp = $rs->row["publication"];
				$url = "";
				$title = "";

				if ( $rs->row["types"] != "prints_items" )
				{
					$sql = "select id,title from " . PVS_DB_PREFIX .
						"media where id=" . $idp;
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$url = pvs_item_url( $dr->row["id"] );
						$title = $dr->row["title"];
					}
				} else
				{
					$sql = "select id_parent,title,itemid from " . PVS_DB_PREFIX . $rs->row["types"] .
						" where id_parent=" . $idp;
					$dr->open( $sql );
					if ( ! $dr->eof )
					{
						$url = pvs_item_url( $dr->row["itemid"] );
						$title = $dr->row["title"];
					}
				}
?>
		<tr>
			<td>
			<?php
			if ( $rs->row["types"] != "prints_items" ) {
				$sql = "select title,media_id from " . PVS_DB_PREFIX . "media where id=" . $idp;
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$img_preview = "";
					if ( $dr->row["media_id"] == 1 )
					{
						$img_preview = pvs_show_preview( $idp, "photo", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 2 )
					{
						$img_preview = pvs_show_preview( $idp, "video", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 3 )
					{
						$img_preview = pvs_show_preview( $idp, "audio", 1, 1, "", "" );
					}
					if ( $dr->row["media_id"] == 4 )
					{
						$img_preview = pvs_show_preview( $idp, "vector", 1, 1, "", "" );
					}
				}
			} else {
				$sql = "select id_parent,title,itemid from " . PVS_DB_PREFIX . "prints_items where id_parent=" . $idp;
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$img_preview = pvs_show_preview( $dr->row['itemid'], "photo", 1, 1, "", "" );
				}	
			}
?>
		<div class="profile_home_preview" style="background:url('<?php
					echo $img_preview;
?>')" onClick="location.href='<?php
					echo $url;
?>'"></div>

			</td>
			<td>#<?php
				echo $idp;
?> - <a href="<?php
				echo $url;
?>"><?php
				echo $title;
?></a></td>
			<td><span class="price"><?php
				echo pvs_currency( 1, true, "credits" );?><?php
				echo pvs_price_format( $rs->row["total"], 2 );?> <?php
				echo pvs_currency( 2, true, "credits" );?></span></td>
			<td><div class="link_date"><?php
				echo date( date_format, $rs->row["data"] );?></div></td>
		</tr>
		<?php
			}
			$n++;
			$rs->movenext();
		}
?>
		</table>
		<p>&nbsp;</p>
		<?php
	}
}
?>















<?php
if ( ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
	"common" ) and $pvs_global_settings["affiliates"] ) {
	$sql = "select userid,types,types_id,rates,total,data from " . PVS_DB_PREFIX .
		"affiliates_signups where aff_referal=" . get_current_user_id() .
		" and total>0 order by data desc";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
?>
		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
		
			<tr class='main'>
	<th colspan="4"><?php echo pvs_word_lang( "Last sales" );?></th>
			</tr>
			<?php
		$n = 0;
		while ( ! $rs->eof ) {
			if ( $n < 7 )
			{
?>
		<tr>
			<td><?php
				echo pvs_word_lang( $rs->row["types"] );?> # <?php
				echo $rs->row["types_id"];
?></td>
			<td><div class="link_date"><?php
				echo date( date_format, $rs->row["data"] );?></div></td>
			<td><span class="price"><?php
				echo pvs_currency( 1 );?><?php
				echo pvs_price_format( $rs->row["total"], 2 );?> <?php
				echo pvs_currency( 2 );?></span> (<?php
				echo $rs->row["rates"];
?>%)</td>
		</tr>
		<?php
			}
			$n++;
			$rs->movenext();
		}
?>
		</table>
		<p>&nbsp;</p>
		<?php
	}
}
?>


<?php
if ( PVS_LICENSE != 'Free' ) {
	$com = "";
	if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "common" ) {
		$com = " and buyer=1 ";
	}
	if ( pvs_get_user_type () == "seller" or pvs_get_user_type () ==
		"common" ) {
		$com = " and seller=1 ";
	}
	if ( pvs_get_user_type () == "affiliate" or pvs_get_user_type () ==
		"common" ) {
		$com = " and affiliate=1 ";
	}
	
	$sql = "select id,title,description from " . PVS_DB_PREFIX .
		"documents_types where enabled=1 " . $com . " order by priority";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
	?>
			<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">		
				<tr class='main'>
		<th colspan="4"><?php echo pvs_word_lang( "Documents" );?></th>
				</tr>
				<?php
		while ( ! $rs->eof ) {
	?>
		<tr>
			<td><b><?php echo $rs->row["title"];
	?></b><br><small><?php echo $rs->row["description"];
	?></small></td>
			<?php
			$sql = "select title,status,comment from " . PVS_DB_PREFIX .
				"documents where user_id=" . get_current_user_id() . " and id_parent=" .
				$rs->row["id"] . " order by data desc";
			$ds->open( $sql );
			if ( ! $ds->eof ) {
	?>
				<td><span class="label label-success"><?php
				echo pvs_word_lang( "Uploaded" );?></span></td>
				<td>
				<?php
				if ( $ds->row["status"] == 1 )
				{
	?>
					<span class="label label-success"><?php
					echo pvs_word_lang( "approved" );?></span>
					<?php
				}
				if ( $ds->row["status"] == 0 )
				{
	?>
					<span class="label label-warning"><?php
					echo pvs_word_lang( "pending" );?></span>
					<?php
				}
				if ( $ds->row["status"] == -1 )
				{
	?>
					<span class="label label-danger"><?php
					echo pvs_word_lang( "declined" );?></span>
					<?php
					if ( $ds->row["comment"] != "" )
					{
	?>
			<br><small><?php
						echo $ds->row["comment"];
	?></small>
			<?php
					}
				}
	?>
				</td>
				<?php
			} else {
	?>
				<td><span class="label label-danger"><?php
				echo pvs_word_lang( "Not Uploaded" );?></span></td>
				<td></td>
				<?php
			}
	?>
			<td>[<a href="<?php echo (site_url( ) );?>/profile_about/#documents"><?php echo pvs_word_lang( "upload" );?></a>]</td>
		</tr>
		<?php
			$rs->movenext();
		}
	?>
			</table>
			<p>&nbsp;</p>
		<?php
	}
}
?>



<?php
include ( "profile_bottom.php" );
?>