<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if (!is_user_logged_in()) {
	exit;
}

include ( "profile_top.php" );

$flag_exam = false;
//Examination status
$sql = "select data,status,comments from " . PVS_DB_PREFIX .
	"examinations where user=" . get_current_user_id();
$rs->open( $sql );
if ( ! $rs->eof ) {
	$flag_exam = true;
	if ( ! isset( $_GET["t"] ) ) {
?>
		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
		<th><b><?php echo pvs_word_lang( "examination" );?></b></th>
		<tr>
		<td><?php echo pvs_word_lang( "date" );?>:</td>
		<td><div class="link_date"><?php echo date( date_format, $rs->row["data"] );?></div></td>
		</tr>
		<tr>
		<td><?php echo pvs_word_lang( "status" );?>:</td>
		<td><?php
		if ( $rs->row["status"] == 0 ) {
			echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
		}

		if ( $rs->row["status"] == 1 ) {
			echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
		}

		if ( $rs->row["status"] == 2 ) {
			echo ( "<div class='link_pending'>" . pvs_word_lang( "declined" ) . "</div>" );
		}
?></td>
		</tr>
		<?php
		if ( $rs->row["comments"] != "" ) {
?>
			<tr>
			<td><?php
			echo pvs_word_lang( "Comments" );?>:</td> 
			<td><?php
			echo str_replace( "\n", "<br>", $rs->row["comments"] );?></td>
			</tr>
			<?php
		}
?>
		</table>
	<?php
	}
}

//Settings
$scategory = false;
$sphoto = false;
$svideo = false;
$saudio = false;
$svector = false;
$percentage = 0;
$percentage_subscription = 0;
$percentage_prints = 0;
$percentage_type = 0;
$percentage_subscription_type = 0;
$percentage_prints_type = 0;
$sql = "select * from " . PVS_DB_PREFIX . "user_category where name='" .
	pvs_get_user_category () . "'";
$rs->open( $sql );
if ( ! $rs->eof ) {
	if ( $rs->row["category"] == 1 ) {
		$scategory = true;
	}
	if ( $rs->row["upload"] == 1 ) {
		$sphoto = true;
	}
	if ( $rs->row["upload2"] == 1 ) {
		$svideo = true;
	}
	if ( $rs->row["upload3"] == 1 ) {
		$saudio = true;
	}
	if ( $rs->row["upload4"] == 1 ) {
		$svector = true;
	}
	$percentage = $rs->row["percentage"];
	$percentage_prints = $rs->row["percentage_prints"];
	$percentage_subscription = $rs->row["percentage_subscription"];
	$percentage_type = $rs->row["percentage_type"];
	$percentage_prints_type = $rs->row["percentage_prints_type"];
	$percentage_subscription_type = $rs->row["percentage_subscription_type"];
}

if ( $pvs_global_settings["examination"] and ! pvs_get_user_examination () ) {
	if ( ! isset( $_GET["t"] ) ) {
		if ( ! $flag_exam ) {
?>
		<h1><?php
			echo pvs_word_lang( "examination" );?></h1>
		<?php
		}
		//Examination description
		$sql = "select post_content from " . $table_prefix .
			"posts where post_type = 'page' and ID = " . (int)$pvs_global_settings["examination_description"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			echo($ds->row["post_content"]);
		}
	} else {
?>
	<h1><?php echo pvs_word_lang( "examination" );?></h1>
	<?php
		//Thank you after the examination
		$sql = "select post_content from " . $table_prefix .
			"posts where post_type = 'page' and ID = " . (int)$pvs_global_settings["examination_result"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			echo($ds->row["post_content"]);
		}
	}



	$exam_flag = false;
	$sql = "select id, server1, media_id from " . PVS_DB_PREFIX .
		"media where examination=1 and userid=" . get_current_user_id() .
		" order by id";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$n = 0;
?>
	<h2><?php
		echo pvs_word_lang( pvs_media_type ($rs->row["media_id"]) );?>:</h2>
	<table border='0' cellpadding='0' cellspacing='0' style="margin-bottom:25px">
	<tr valign='top'>
	<?php
		while ( ! $rs->eof )
		{
			$exam_flag = true;

			if ( pvs_media_type ($rs->row["media_id"]) == 'photo' )
			{
				$thumb = pvs_show_preview( $rs->row["id"], "photo", 1, 1 );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'video' )
			{
				$thumb = pvs_show_preview( $rs->row["id"], "video", 1, 1 );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'audio' )
			{
				$thumb = pvs_show_preview( $rs->row["id"], "audio", 1, 1 );
			}
			if ( pvs_media_type ($rs->row["media_id"]) == 'vector' )
			{
				$thumb = pvs_show_preview( $rs->row["id"], "vector", 1, 1 );
			}

			if ( $n % 4 == 0 )
			{
				echo ( "</tr><tr valign='top'>" );
			}
?>
		<td style="padding:0px 10px 10px 0px">
		<a href="<?php echo (site_url( ) );?>/filemanager-<?php
			echo pvs_media_type ($rs->row["media_id"]);
?>/?id=<?php
			echo $rs->row["id"];
?>"><img src="<?php
			echo $thumb;
?>" border="0"></a>
		<div style="margin:3px 0px 0px 10px" class="smalltext"><b>ID:</b> <?php
			echo $rs->row["id"];
?></div>
		<div style="margin:3px 0px 0px 10px"><a href="<?php echo (site_url( ) );?>/delete-publication/?id=<?php
			echo $rs->row["id"];
?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i> <?php
			echo pvs_word_lang( "delete" );?></a></div>
		</td>
		<?php
			$n++;
			$rs->movenext();
		}
?>
	</tr>
	</table>
	<?php
	}
?>








<?php
} else
{
?>
		<table border="0" cellpadding="0" cellspacing="0" class="profile_table_home">
<tr>
<th colspan="2"><?php echo pvs_word_lang( "upload files" );?></th>
</tr>

<tr>
<td><?php echo pvs_word_lang( "status" );?></td>
<td><div class="link_status"><?php echo pvs_get_user_category ();
?></div></td>
</tr>

<?php
	if ( $percentage != 0 ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "Your earnings" );?>  &mdash; <?php echo pvs_word_lang( "files" );?></td>
	<td>
		<div class="link_commission">
		<?php
		if ( $percentage_type == 0 ) {
			echo ( round( $percentage ) . "%" );
		} else {
			echo ( pvs_currency( 1, false ) . pvs_price_format( $percentage, 2 ) . " " .
				pvs_currency( 2, false ) . pvs_word_lang( "for download" ) );
		}
?>
		</div>
	</td>
	</tr>
<?php
	}
?>

<?php
	if ( $percentage_prints != 0 and $pvs_global_settings["prints"] and $pvs_global_settings["prints_users"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "Your earnings" );?>  &mdash; <?php echo pvs_word_lang( "subscription" );?></td>
	<td>
		<div class="link_commission">
		<?php
		if ( $percentage_subscription_type == 0 ) {
			echo ( round( $percentage_subscription ) . "%" );
		} else {
			echo ( pvs_currency( 1, false ) . pvs_price_format( $percentage_subscription, 2 ) .
				" " . pvs_currency( 2, false ) . pvs_word_lang( "for download" ) );
		}
?>
		</div>
	</td>
	</tr>
<?php
	}
?>

<?php
	if ( $percentage_prints != 0 and $pvs_global_settings["prints"] and $pvs_global_settings["prints_users"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "Your earnings" );?>  &mdash; <?php echo pvs_word_lang( "prints" );?></td>
	<td>
		<div class="link_commission">
		<?php
		if ( $percentage_prints_type == 0 ) {
			echo ( round( $percentage_prints ) . "%" );
		} else {
			echo ( pvs_currency( 1, false ) . pvs_price_format( $percentage_prints, 2 ) .
				" " . pvs_currency( 2, false ) . pvs_word_lang( "for download" ) );
		}
?>
		</div>
	</td>
	</tr>
<?php
	}
?>



<?php
	if ( $pvs_global_settings["allow_photo"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "upload photo" );?></td>
	<td><?php
		if ( $sphoto ) {
			echo ( pvs_word_lang( "yes" ) );
		} else {
			echo ( pvs_word_lang( "no" ) );
		}
?></td>
	</tr>
<?php
	}
?>

<?php
	if ( $pvs_global_settings["allow_video"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "upload video" );?></td>
	<td><?php
		if ( $svideo ) {
			echo ( pvs_word_lang( "yes" ) );
		} else {
			echo ( pvs_word_lang( "no" ) );
		}
?></td>
	</tr>
<?php
	}
?>

<?php
	if ( $pvs_global_settings["allow_audio"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "upload audio" );?></td>
	<td><?php
		if ( $saudio ) {
			echo ( pvs_word_lang( "yes" ) );
		} else {
			echo ( pvs_word_lang( "no" ) );
		}
?></td>
	</tr>
<?php
	}
?>


<?php
	if ( $pvs_global_settings["allow_vector"] ) {
?>
	<tr>
	<td><?php echo pvs_word_lang( "upload vector" );?></td>
	<td><?php
		if ( $svector ) {
			echo ( pvs_word_lang( "yes" ) );
		} else {
			echo ( pvs_word_lang( "no" ) );
		}
?></td>
	</tr>
<?php
	}
?>

<tr>
<td><?php echo pvs_word_lang( "create category" );?></td>
<td><?php
	if ( $scategory ) {
		echo ( pvs_word_lang( "yes" ) );
	} else {
		echo ( pvs_word_lang( "no" ) );
	}
?></td>
</tr>



</table>
<br>
<?php
}
?>



<?php
if ( $pvs_global_settings["examination"] and pvs_get_user_examination () != 1 ) {
	if ( $exam_flag ) {
		$sql = "select status from " . PVS_DB_PREFIX . "examinations where user=" . ( int )
			get_current_user_id();
		$rs->open( $sql );
		if ( $rs->eof or $rs->row["status"] == 2 ) {
?>
			<input class='isubmit_orange' type="button" value="<?php
			echo pvs_word_lang( "take an examination" );?>" onClick="location.href='<?php echo (site_url( ) );?>/examination-take/'">&nbsp;
			<?php
		}
	}
}

include ( "profile_bottom.php" );
?>