<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_support" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>





<div class="back"><a href="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&" class="btn btn-primary btn-sm btn-mini"><i class="icon-arrow-left fa fa-arrow-left"></i> <?php echo pvs_word_lang( "back" )?></a></div>

<script src="<?php echo pvs_plugins_url()?>/assets/js/raty/jquery.raty.min.js"></script>

<script>
    $(function() {
      $.fn.raty.defaults.path = '<?php echo pvs_plugins_url()?>/assets/js/raty/img';

      $('.star').raty({ score: 3 });
      
    });
</script>


<?php
if ( isset( $_GET["id"] ) ) {
	$sql = "update " . PVS_DB_PREFIX .
		"support_tickets set viewed_admin=1 where id=" . ( int )$_GET["id"] .
		" or id_parent=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$sql = "select id,subject,message,data,user_id,closed from " . PVS_DB_PREFIX .
		"support_tickets where id=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
?>

		<h1 style="margin-bottom:25px"><?php echo pvs_word_lang( "support" )?> &mdash; <?php echo $rs->row["subject"] ?></h1>

		<div class="shadow_box box box_padding">
			<div class="shadow_box_title">			
				<div class="shadow_box_date"><?php echo pvs_show_time_ago( $rs->row["data"] )?></div>
				<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user_id"] )?></a></div>
			</div>
			<div class="shadow_box_content">
				<?php echo str_replace( "\n", "<br>", $rs->row["message"] )?>
			</div>
		</div>
		
		<?php
		$sql = "select id,subject,message,data,user_id,closed,admin_id,rating from " .
			PVS_DB_PREFIX . "support_tickets where id_parent=" . ( int )$_GET["id"] .
			" order by id";
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$box_style = "";
			$box_style2 = "box-success";
			if ( $ds->row["admin_id"] != 0 )
			{
				$box_style = "2";
				$box_style2 = "box-primary";
			}
?>
			<div class="shadow_box<?php
			echo $box_style
?> box box_padding <?php
			echo $box_style2
?>">
			<div class="shadow_box_title<?php
			echo $box_style
?>">			
				<div class="shadow_box_date"><?php
			echo pvs_show_time_ago( $ds->row["data"] )?></div>
				<?php
			if ( $ds->row["user_id"] != 0 )
			{
?>
					<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $ds->row["user_id"]?>"><?php
			echo pvs_user_id_to_login( $ds->row["user_id"] )?></a></div>
				<?php
			}
			
			if ( $ds->row["admin_id"] != 0 )
			{
?>
					<div class="link_user"><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $ds->row["admin_id"]?>"><?php
			echo pvs_user_id_to_login( $ds->row["admin_id"] )?></a></div>
				<?php
			}
?>
			</div>
			<div class="shadow_box_content">
				<?php
			echo str_replace( "\n", "<br>", $ds->row["message"] )?>
				

				
				<div class="shadow_box_footer">
					<input type="button" value="<?php
			echo pvs_word_lang( "delete" )?>" class="btn btn-small btn-sm btn-danger" style="margin:10px 0px 0px 0px;float:right" onClick="location.href='<?php echo(pvs_plugins_admin_url('support/index.php'));?>&action=delete_post&id=<?php
			echo $ds->row["id"] ?>&id_parent=<?php
			echo $rs->row["id"] ?>'">
					
			<?php
			if ( $ds->row["admin_id"] != 0 )
			{
?>
				<script>
    			$(function() {
      				$('#star<?php
				echo $ds->row["id"] ?>').raty({
      				score: <?php
				echo $ds->row["rating"] ?>,
 					half: true,
  					number: 5,
					readOnly   : true
				});
    			});
				</script>
				<div id="star<?php
				echo $ds->row["id"] ?>" style="margin-top:7px"></div>
				<?php
			}
?>
					
					<div class="clear"></div>
				</div>
							
			</div>
			</div>
			<?php
			$ds->movenext();
		}
?>


			<div class="shadow_box box box_padding">

			
				<form method="post" action="<?php echo(pvs_plugins_admin_url('support/index.php'));?>&action=add&id=<?php echo ( int )$_GET["id"] ?>">
								
				<textarea class="ibox form-control" style="width:90%;height:150px;margin:20px" name="message" id="message"></textarea>

				<input type="submit" value="<?php echo pvs_word_lang( "send" )?>" class="btn btn-primary" style="margin:0px 0px 20px 20px">
				
				</form>
			</div>
			<?php
	}
}
?>



<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>