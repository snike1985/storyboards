<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_exam" );

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( @$_REQUEST["action"] == 'delete_file' )
{
	include ( "delete_file.php" );
}

if ( @$_REQUEST["action"] == 'exam_delete' )
{
	include ( "exam_delete.php" );
}

//Content
if ( @$_REQUEST["action"] == 'exam_content' )
{
	include ( "exam_content.php" );
} else {
	?>
	
	
	<h1><?php echo pvs_word_lang( "seller examination" )?></h1>
	

	
	
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
	
	$sql = "select * from " . PVS_DB_PREFIX .
		"examinations order by data desc,id desc";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
	?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><b><?php echo pvs_word_lang( "examination" )?></b></th>
	<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "date" )?></b></th>
	<th><b><?php echo pvs_word_lang( "status" )?></b></th>
	<th><b><?php echo pvs_word_lang( "user" )?></b></th>
	<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "delete" )?></b></th>
	</tr>
	</thead>
	<?php
		$n = 0;
		while ( ! $rs->eof ) {
			$cl3 = "";
			$cl_script = "";
			if ( isset( $_SESSION["user_exams_id"] ) and ! isset( $_SESSION["admin_rows_exams" .
				$rs->row["id"]] ) and $rs->row["id"] > $_SESSION["user_exams_id"] ) {
				$cl3 = "<span class='label label-danger exams" . $rs->row["id"] . "'>" . pvs_word_lang("new") . "</span>";
				$cl_script = "onMouseover=\"pvs_deselect_row('exams" . $rs->row["id"] . "')\"";
			}
	
			if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
	?>
	<tr valign="top" <?php
				echo $cl_script
	?>>
	
	<td>
	
	<div class="link_exam"><a href="<?php echo(pvs_plugins_admin_url('exam/index.php'));
?>&action=exam_content&	id=<?php
				echo $rs->row["id"] ?>"><b># <?php
				echo $rs->row["id"] ?></b></a> <?php
				echo $cl3
	?></div>
	
	
	</td>
	
	<td class="gray hidden-phone hidden-tablet"><?php
				echo date( date_format, $rs->row["data"] )?></td>
	<td><div class="link_status"><?php
				if ( $rs->row["status"] == 0 )
				{
					echo ( '<span class="label label-warning">' . pvs_word_lang( "pending" ) . '</span>' );
				}
	?><?php
				if ( $rs->row["status"] == 1 )
				{
					echo ( '<span class="label label-success">' . pvs_word_lang( "approved" ) . '</span>' );
				}
	?><?php
				if ( $rs->row["status"] == 2 )
				{
					echo ( '<span class="label label-danger">' . pvs_word_lang( "declined" ) . '</span>' );
				}
	?></div></td>
	<td><?php 
				$sql="select ID, user_login from " . $table_prefix . "users where ID=" . $rs->row["user"];
				$ds->open($sql);
				if(!$ds->eof)
				{
					echo("<a href='" . pvs_plugins_admin_url('customers/index.php') . "&action=content&id=".$ds->row["ID"]."'>".$ds->row["user_login"]."</a>");
				}
				?></td>
	
	
	
	<td class="hidden-phone hidden-tablet"><div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('exam/index.php'));
?>&action=exam_delete&id=<?php
				echo $rs->row["id"] ?>' onClick="return confirm('<?php
				echo pvs_word_lang( "delete" )?>?');"><?php
				echo pvs_word_lang( "delete" )?></a></div></td>
	
	</tr>
	<?php
			}
			$n++;
			$rs->movenext();
		}
	?>
	</table>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'exam/index.php' ), "" ) );
	} else
	{
	?>
	<p>Not found.</p>
	<?php
	}
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" ); 
?>