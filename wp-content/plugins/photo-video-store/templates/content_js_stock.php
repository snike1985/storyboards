<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<script src="<?php echo pvs_plugins_url()?>/assets/js/raty/jquery.raty.min.js"></script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/colorpicker.js"></script>
<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/eye.js'></script>
<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/utils.js'></script>
<link href="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/css/colorpicker.css" rel="stylesheet">
<link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">

<script src='<?php echo(pvs_plugins_url());?>/includes/plugins/galleria/galleria-1.2.9.js'></script>
<script>
//Add stock print in the cart
function prints_stock(stock_type,stock_id,stock_url,stock_preview,stock_site_url,stock_title) {
	var req = new JsHttpRequest();
	
	var IE='\v'=='v';
	
	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			if(document.getElementById('shopping_cart'))
			{
	document.getElementById('shopping_cart').innerHTML =req.responseJS.box_shopping_cart;
			}
			if(document.getElementById('shopping_cart_lite'))
			{
	document.getElementById('shopping_cart_lite').innerHTML =req.responseJS.box_shopping_cart_lite;
			}
			
			<?php
if ( ! $pvs_global_settings["prints_previews"] ) {
?>
	if(!IE) 
	{
		$.colorbox({html:req.responseJS.cart_content,width:'600px',scrolling:false});
	}
	<?php
} else
{
?>
	location.href = req.responseJS.redirect_url;
	<?php
}
?>
			
			if(typeof set_styles == 'function') 
			{
	set_styles();
			}
			
			if(typeof reload_cart == 'function') 
			{
	reload_cart();
			}
		}
	}
	req.open(null, '<?php echo site_url()?>/shopping-cart-add-prints-stock/', true);
	req.send( {stock_type:stock_type,stock_id:stock_id,stock_url:stock_url,stock_preview:stock_preview,stock_site_url:stock_site_url,print_id:document.getElementById('cartprint').value,stock_title:stock_title} );
}


function apanel(x) {
	if(x == 0) {
		document.getElementById('prices_files').style.display = 'block';
		document.getElementById('prices_prints').style.display = 'none';
	}
	else {
		document.getElementById('prices_files').style.display = 'none';
		document.getElementById('prices_prints').style.display = 'block';
	}
}


function show_prints_preview(id) {
    var req = new JsHttpRequest();
        
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
        	$.colorbox({html:req.responseJS.prints_content,width:'600px',scrolling:false});
        	
        	if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url()?>/prints-preview/', true);
    req.send( {id: id } );
}

//Show added prints
function xprint(x) {

	printitems=new Array();
	<?php
$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
	"prints order by priority";
$rs->open( $sql );
$nn = 0;
while ( ! $rs->eof ) {
?>
		printitems[<?php echo $nn
?>]=<?php echo $rs->row["id_parent"] ?>;
		<?php
	$nn++;
	$rs->movenext();
}
?>


	for(i=0;i<printitems.length;i++) {
		if(document.getElementById('tr_cart'+printitems[i].toString())) {
			if(printitems[i]==x)
			{
	document.getElementById('tr_cart'+printitems[i].toString()).className ='tr_cart_active';
	document.getElementById('cartprint').value =x;
			}
			else
			{
	document.getElementById('tr_cart'+printitems[i].toString()).className ='tr_cart';
			}
		}
	}


	    var aRadio = document.getElementsByTagName('input'); 
	    for (var i=0; i < aRadio.length; i++)
	    { 
	        if (aRadio[i].type != 'radio') continue; 
	        if (aRadio[i].value == x) 
	        {
	        	aRadio[i].checked = true; 
	        }
	    } 

}

function show_more(value) {
	$.colorbox({width:"700",height:"500", href:value});
}

//Print's quantity
function quantity_change(value,quantity_limit) {
	quantity = $("#quantity").val()*1+value;
	
	if(quantity< 0) {
		quantity = 0;
	}
	
	if(quantity> quantity_limit && quantity_limit != -1) {
		quantity = quantity_limit;
	}
	
	$("#quantity").val(quantity);
}
</script>