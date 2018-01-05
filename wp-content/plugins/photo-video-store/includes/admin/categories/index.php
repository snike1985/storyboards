<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_categories" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );



//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Delete thumb
if ( @$_REQUEST["action"] == 'delete_thumb' )
{
	include ( "delete_thumb.php" );
}

//Edit
if ( @$_REQUEST["action"] == 'edit' )
{
	include ( PVS_PATH . "includes/admin/categories/edit.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else if ((isset($_REQUEST["formaction"]) and $_REQUEST["formaction"] != 'delete_publication' and $_REQUEST["formaction"] != 'priority') and @$_REQUEST["step"] != 2) {

} else {
?>
	
	
	
	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'categories/index.php' ) );
?>&action=content"><i class="icon-folder-open icon-white fa fa-folder-o"></i>&nbsp; <?php
	echo pvs_word_lang( "Add category" )
?></a>
	
	<h1><?php
	echo pvs_word_lang( "categories" )
?>:</h1>
	
	<script languages="javascript">
	
	img_plus=new Image();
	img_plus.src="<?php
	echo ( pvs_plugins_url() . '/includes/admin/includes/img/' );
?>plus.gif";
	
	img_minus=new Image();
	img_minus.src="<?php
	echo ( pvs_plugins_url() . '/includes/admin/includes/img/' );
?>minus.gif";
	
	mcategories=new Array();
	mparent=new Array();
	mopen=new Array();
	<?php
	$n = 0;
	$sql = "select id,id_parent from " . PVS_DB_PREFIX . "category";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
?>
		mcategories[<?php
		echo $n
?>]=<?php
		echo $rs->row["id"]
?>;
		
		<?php
		if ( isset( $_COOKIE["sub_" . $rs->row["id"]] ) and ( int )$_COOKIE["sub_" . $rs->
			row["id"]] == 0 )
		{
?>
			mopen[<?php
			echo $rs->row["id"]
?>]=0;
			<?php
		} else
		{
?>
			mopen[<?php
			echo $rs->row["id"]
?>]=1;
			<?php
		}
?>
		mparent[<?php
		echo $n
?>]=<?php
		echo $rs->row["id_parent"]
?>;
		<?php
		$n++;
		$rs->movenext();
	}
?>
	
	function category_select_all()
	{
		if(document.getElementById("selectall").checked)
		{
			sel=true;
		}
		else
		{
			sel=false;
		}
		
		for(i=0;i<mcategories.length;i++)
		{
			document.getElementById("sel"+mcategories[i].toString()).checked=sel;
		}
	}
	
	
	function subopen(value)
	{
	
		for(i=0;i<mparent.length;i++)
		{
			if(value==mparent[i])
			{
				if(mopen[value]==1)
				{
					document.getElementById("row"+mcategories[i].toString()).style.display='none';
				}
				else
				{
					document.getElementById("row"+mcategories[i].toString()).style.display='table-row';
				}
			}
		}
		
		if(mopen[value]==1)
		{
			document.getElementById("plus"+value.toString()).src=img_plus.src;
			mopen[value]=0;
			document.cookie = "sub_" + value + "=" + escape (0) + ";path=/";
		}
		else
		{
			document.getElementById("plus"+value.toString()).src=img_minus.src;
			mopen[value]=1;
			document.cookie = "sub_" + value + "=" + escape (1) + ";path=/";
		}
	}
	
	
	
	function bulk_action(value)
	{
		document.getElementById("formaction").value=value;
	
		document.getElementById("adminform").submit();
	}
	
	
	function publications_select_all(sel_form)
	{
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
	
	
	
	
	<form method="post" action="<?php
	echo ( pvs_plugins_admin_url( 'categories/index.php' ) );
?>" id="adminform" name="adminform">
	<input type="hidden" name="action" value="edit">
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><input type="checkbox"   name="selector"  onClick="publications_select_all(document.adminform);"></th>
	<th></th>
	<th><?php
	echo pvs_word_lang( "priority" )
?></th>
	<th style="width:60%"><?php
	echo pvs_word_lang( "title" )
?></th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<?php
	$itg = "";
	$nlimit = 0;
	pvs_build_menu_admin_categories( 0, 1 );
	echo ( $itg );
?>
	
	</table>
	
	
	
	
	<div id="button_bottom_static">
			<div id="button_bottom_layout"></div>
			<div id="button_bottom">
	
	<div id="actions">
		<input type="hidden" name="formaction" id="formaction" value="priority">
		<input type="button" class="btn btn-warning" class="isubmit" value="<?php
	echo pvs_word_lang( "save" )
?>" onClick="bulk_action('priority');">&nbsp;&nbsp;<?php
	echo pvs_word_lang( "or" )
?>&nbsp;&nbsp;<div class="btn-group dropup">
		<a class="btn btn-primary" href="#"><?php
	echo pvs_word_lang( "select action" )
?></a>
		<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		<ul class="dropdown-menu">
				<li><a href="javascript:bulk_action('delete_category');"><i class="icon-trash"></i> <?php
	echo pvs_word_lang( "delete selected" )
?></a></li>
				
				<?php
	if ( $pvs_global_settings["allow_photo"] )
	{
?>
					<li><a href="javascript:bulk_action('thumbs');"><i class="icon-refresh"></i> <?php
		echo pvs_word_lang( "regenerate thumbs" )
?></a></li>
				<?php
	}
?>
				
				<li><a href="javascript:bulk_action('bulk_change');"><i class="icon-tasks"></i> <?php
	echo pvs_word_lang( "Bulk change titles, keywords, description" )
?></a></li>
				
				<li><a href="javascript:bulk_action('bulk_keywords');"><i class="icon-tags"></i> <?php
	echo pvs_word_lang( "Bulk add/remove keywords" )
?></a></li>
		
				
				<li><a href="javascript:bulk_action('content');"><i class="icon-th"></i> <?php
	echo pvs_word_lang( "change content type" )
?></a></li>
				
				<li><a href="javascript:bulk_action('free');"><i class="icon-download-alt"></i> <?php
	echo pvs_word_lang( "change files to free/paid" )
?></a></li>
				
				<li><a href="javascript:bulk_action('featured');"><i class="icon-thumbs-up"></i> <?php
	echo pvs_word_lang( "change files to featured" )
?></a></li>
				
				<?php
	if ( $pvs_global_settings["allow_photo"] )
	{
?>
					<li><a href="javascript:bulk_action('editorial');"><i class="icon-picture"></i> <?php
		echo pvs_word_lang( "change photos to editorial" )
?></a></li>
				<?php
	}
?>
				
				<?php
	if ( $pvs_global_settings["adult_content"] )
	{
?>
					<li><a href="javascript:bulk_action('adult');"><i class="icon-user"></i> <?php
		echo pvs_word_lang( "change files to adult" )
?></a></li>
				<?php
	}
?>
				
				<?php
	if ( $pvs_global_settings["exclusive_price"] )
	{
?>
					<li><a href="javascript:bulk_action('exclusive');"><i class="icon-gift"></i> <?php
		echo pvs_word_lang( "change files to exclusive" )
?></a></li>
				<?php
	}
?>
				
				<?php
	if ( $pvs_global_settings["contacts_price"] )
	{
?>
					<li><a href="javascript:bulk_action('contacts');"><i class="icon-envelope"></i> <?php
		echo pvs_word_lang( "change files to 'contact us to get the price'" )
?></a></li>
				<?php
	}
?>
				
				<li><a href="javascript:bulk_action('approve');"><i class="icon-ok"></i> <?php
	echo pvs_word_lang( "approve" )
?>/<?php
	echo pvs_word_lang( "decline" )
?></a></li>
				
				<?php
	if ( $pvs_global_settings["rights_managed"] )
	{
?>
					<li><a href="javascript:bulk_action('rights_managed_categories');"><i class="icon-list-alt"></i> <?php
		echo pvs_word_lang( "change rights-managed price" )
?></a></li>
				<?php
	}
?>
		</ul>
		</div>
		
	
		
	
	</div>
	
			</div>
		</div>
	</form>
	
	<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>