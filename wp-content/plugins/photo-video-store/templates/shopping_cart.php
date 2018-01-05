<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div class="page_internal">
<h1><?php echo pvs_word_lang( "shopping cart" );?></h1>


<script>

function cart_delete(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
			document.getElementById('shopping_cart2').innerHTML =req.responseText;
			
			reload_flow('<?php echo site_url();
?>');
			
   			if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url();
?>/shopping-cart-delete/', true);
    req.send( {id: value} );
}


function cart_change(value,value2,stock_limit) {
    var req = new JsHttpRequest();

	qty = $("#qty"+value).val()*1+value2;
    if(qty < 0){qty=0;}
      
    if(stock_limit != -1 && qty > stock_limit)
    {
    	flag = false;
    }
    else
    {
    	 flag = true;
    }
	
	if(flag) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
	document.getElementById('shopping_cart2').innerHTML =req.responseText;
			}
		  
			reload_flow('<?php echo site_url();
?>');
			
			if(typeof set_styles == 'function') 
			{
	set_styles();
			}
		}
		
		req.open(null, '<?php echo site_url();
?>/shopping-cart-change/', true);
		req.send( {id: value,qty: qty} );
    }
}

function cart_add(value,value2) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
			document.getElementById('shopping_cart2').innerHTML =req.responseText;
			
			reload_flow('<?php echo site_url();
?>');
			
   			if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url();
?>/shopping-cart-change-new/', true);
    req.send( {id: value,id2: value2} );
}


function cart_clear(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
			document.getElementById('shopping_cart2').innerHTML =req.responseText;
			
			reload_flow('<?php echo site_url();
?>');
			
   			if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url();
?>/shopping-cart-clear/', true);
    req.send( {id: value} );
}


function cart_change_option(value2,value3,value4,value5) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
			document.getElementById('shopping_cart2').innerHTML =req.responseText;
			
			reload_flow('<?php echo site_url();
?>');
			
   			if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url();
?>/shopping-cart-change-option/', true);
    req.send( {id: value2,i: value3,option_id: value4,option_value: value5} );
}

</script>
<link href="<?php echo(pvs_plugins_url());?>/includes/prints/style.css" rel="stylesheet">


<?php
if ( pvs_get_user_type () == "buyer" or
	pvs_get_user_type () == "common" ) {
?>
	<div id="shopping_cart2" name="shopping_cart2"><?php
	include ( "shopping_cart_content.php" );?></div>
<?php
} else
{
?>
	<p><b><?php echo pvs_word_lang( "the seller may not buy items" );?></b></p>
<?php
}
?>
</div>
