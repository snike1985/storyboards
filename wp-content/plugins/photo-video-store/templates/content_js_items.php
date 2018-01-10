<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["google_coordinates"] ) {
?>
	<script src="https://maps.google.com/maps/api/js?sensor=true&key=<?php echo $pvs_global_settings["google_api"] ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-map/3.0-rc1/min/jquery.ui.map.min.js"></script>
	<script>
	function map_show(x,y) {
		document.getElementById('reviewscontent').style.display='none';
			document.getElementById('reviewscontent').innerHTML ="<div id='map'></div>";
			$("#reviewscontent").slideDown("slow");
			 pos=x+","+y;
			 $('#map').gmap({'zoom':11, 'center': pos}).bind('init', function(ev, map) {
	$('#map').gmap('addMarker', { 'position': map.getCenter(), 'bounds': false})
			});


	}
	</script>
<?php
}
?>
<script src="<?php echo pvs_plugins_url()?>/assets/js/raty/jquery.raty.min.js"></script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/colorpicker.js"></script>
<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/eye.js'></script>
<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/utils.js'></script>
<link href="<?php echo pvs_plugins_url()?>/assets/js/colorpicker/css/colorpicker.css" rel="stylesheet">
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
<link href="<?php echo pvs_plugins_url()?>/includes/prints/style.css" rel="stylesheet">

<script>
    $(function() {
      $.fn.raty.defaults.path = '<?php echo pvs_plugins_url()?>/assets/js/raty/img';

      $('.star').raty({ score: 5 });
      
    });
    
    function vote_rating(id,score)
    {
    	<?php
if ( ! is_user_logged_in() and $pvs_global_settings["auth_rating"] ) {
?>	
			location.href='<?php echo site_url()?>/login/';
		<?php
} else
{
?>
    		var req = new JsHttpRequest();
        
    		// Code automatically called on load finishing.
   	 		req.onreadystatechange = function()
    		{
        		if (req.readyState == 4)
        		{
	
        		}
    		}
    		req.open(null, '<?php echo site_url()?>/vote-add/', true);
    		req.send( {id: id,vote:score } );
    	<?php
}
?>
   	}
</script>


<script>
	 
	function like_dislike(value)
    {
    	<?php
if ( ! is_user_logged_in() and $pvs_global_settings["auth_rating"] ) {
?>	
			location.href='<?php echo site_url()?>/login/';
		<?php
} else
{
?>
    		var req = new JsHttpRequest();
        
    		// Code automatically called on load finishing.
   	 		req.onreadystatechange = function()
    		{
        		if (req.readyState == 4)
        		{
		if(req.responseText!="") {
			if(value>0)
			{
				document.getElementById('vote_like').innerHTML =req.responseText
			}
			else
			{
				document.getElementById('vote_dislike').innerHTML =req.responseText
			}
		}
        		}
    		}
    		req.open(null, '<?php echo site_url()?>/like/', true);
    		req.send( {id: <?php echo ( int )get_query_var('pvs_id')?>,vote:value} );
    	<?php
}
?>
   	}



    $(function(){ 
        $('.like-btn').click(function(){
            $('.dislike-btn').removeClass('dislike-h');    
            $(this).addClass('like-h');
			like_dislike(1);
        });
        $('.dislike-btn').click(function(){
            $('.like-btn').removeClass('like-h');
            $(this).addClass('dislike-h');
			like_dislike(-1)
        });
    });
</script>
	

<script src='<?php echo(pvs_plugins_url());?>/includes/plugins/galleria/galleria-1.2.9.js'></script>
<script>



//Rights-managed photos
function rights_managed(id) {
    var req = new JsHttpRequest();
    
    
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			$.colorbox({html:req.responseJS.cart_content,width:'600px',scrolling:false});
	
			if(typeof set_styles == 'function') 
			{
   	set_styles();
   			}
        }
    }
    req.open(null, '<?php echo site_url()?>/rights-managed/', true);
    req.send( {id: id } );
}

//Rights-managed photos
function change_rights_managed(publication_id,price_id,option_id,option_value) {
    var req = new JsHttpRequest();
    
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
	next_options=req.responseJS.next_options;
	list_options=next_options.split("-");
	$(".group_box").css("display","none");
	
	flag_finish=true;
	
	for(i=0;i<list_options.length;i++) {
		if(document.getElementById("group_box"+list_options[i])) {
			document.getElementById("group_box"+list_options[i]).style.display='block';
			if(document.getElementById("group"+list_options[i]).value==0)
			{
			 	flag_finish=false;
			}
		}
	}	
	
	document.getElementById('rights_managed_price').innerHTML =req.responseJS.price;
	
	if(flag_finish) {
		document.getElementById('lightbox_footer').style.display='block';
		document.getElementById('price_box').style.display='block';
	}
	else {
		document.getElementById('lightbox_footer').style.display='none';
		document.getElementById('price_box').style.display='none';
	}
	
	$.fn.colorbox.resize({});
        }
    }
    req.open(null, '<?php echo site_url()?>/rights-managed-change/', true);
    req.send( {publication_id: publication_id, price_id:price_id,option_id:option_id,option_value:option_value} );
}

	cartitems=new Array();
	cartprices=new Array();
	<?php
$sql = "select id,price from " . PVS_DB_PREFIX . "items where id_parent=" . ( int )get_query_var('pvs_id') .
	" order by priority";
$rs->open( $sql );
$nn = 0;
while ( ! $rs->eof ) {
?>
		cartitems[<?php echo $nn
?>]=<?php echo $rs->row["id"] ?>;
		cartprices[<?php echo $rs->row["id"] ?>]=<?php echo $rs->row["price"] ?>;
		<?php
	$nn++;
	$rs->movenext();
}
?>

//The function adds an item into the shopping cart
function add_cart(x) {

	if(x==0) {
		value=document.getElementById("cart").value;
	}
	if(x==1) {
		value=document.getElementById("cartprint").value;
	}
    var req = new JsHttpRequest();
    
    var IE='\v'=='v';
    
    
    // Code automatically called on load finishing.
    if(cartprices[value]==0 && x==0)
    {
    	location.href="<?php echo site_url()?>/count/?type=<?php echo @$atype
?>&id="+document.getElementById("cart").value+"&id_parent=<?php echo ( int )@get_query_var('pvs_id')
?>";
    }
    else
    {
   	 	req.onreadystatechange = function()
    	{
       	 	if (req.readyState == 4)
        	{
	if(document.getElementById('shopping_cart')) {
		document.getElementById('shopping_cart').innerHTML =req.responseJS.box_shopping_cart;
	}
	if(document.getElementById('shopping_cart_lite')) {
		document.getElementById('shopping_cart_lite').innerHTML =req.responseJS.box_shopping_cart_lite;
	}
	
	if(x==1) {
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
			location.href = req.responseJS.redirect_url
			<?php
}
?>
	}
	else {
		if(!IE) 
		{
			$.colorbox({html:req.responseJS.cart_content,width:'600px',scrolling:false});
		}
	
	}
	
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
   	 	req.open(null, '<?php echo site_url()?>/shopping-cart-add/', true);
    	req.send( {id: value } );
    }
}



//The function shows prints previews

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





//The function shows a download link
function add_download(a_type,a_parent,a_server) {
	if(document.getElementById("cart")) {
		location.href="<?php echo site_url()?>/count/?type="+a_type+"&id="+document.getElementById("cart").value+"&id_parent="+a_parent+"&server="+a_server;
	}
}





//Voting function
function doVote(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			document.getElementById('votebox').innerHTML =req.responseText;
        }
    }
    req.open(null, '<?php echo site_url()?>/vote-add/', true);
    req.send( { id:<?php echo ( int )get_query_var('pvs_id') ?>,vote: value } );
}


//Show reviews
function reviews_show(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			if(document.getElementById('reviewscontent'))
			{
	document.getElementById('reviewscontent').innerHTML =req.responseText;
	document.getElementById('reviewscontent').style.display='none';
	$("#reviewscontent").slideDown("slow");
			}
			if(document.getElementById('comments_content'))
			{
	document.getElementById('comments_content').innerHTML =req.responseText;
			}
        }
    }
    req.open(null, '<?php echo site_url()?>/reviews-content/', true);
    req.send( { id: value } );
}


//Show EXIF
function exif_show(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			if(document.getElementById('reviewscontent'))
			{
	document.getElementById('reviewscontent').innerHTML =req.responseText;
	document.getElementById('reviewscontent').style.display='none';
	$("#reviewscontent").slideDown("slow");
			}
			if(document.getElementById('exif_content'))
			{
	document.getElementById('exif_content').innerHTML =req.responseText;
			}
        }
    }
    req.open(null, '<?php echo site_url()?>/exif/', true);
    req.send( { id: value } );
}

//Add a new review
function reviews_add(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			if(document.getElementById('reviewscontent'))
			{
	document.getElementById('reviewscontent').innerHTML =req.responseText;
	document.getElementById('reviewscontent').style.display='none';
	$("#reviewscontent").slideDown("slow");
			}
			if(document.getElementById('comments_content'))
			{
	document.getElementById('comments_content').innerHTML =req.responseText;
			}
        }
    }
    req.open(null, '<?php echo site_url()?>/reviews-content/', true);
    req.send( {'form': document.getElementById(value) } );
}

//Hide reviews
function reviews_hide() {
	document.getElementById('reviewscontent').innerHTML ="";
	$("#reviewscontent").slideUp("slow");
}






//Show pixels/inches
function show_size(value) {
	if($('#link_size1_'+value).hasClass('link_pixels')) {
		$('#p'+value+' div.item_pixels').css({'display':'none'});
		$('#p'+value+' div.item_inches').css({'display':'block'});
		$('#link_size1_'+value).removeClass("link_pixels");
		$('#link_size1_'+value).addClass("link_inches");
		$('#link_size2_'+value).removeClass("link_inches");
		$('#link_size2_'+value).addClass("link_pixels");
	}
	else {
		$('#p'+value+' div.item_pixels').css({'display':'block'});
		$('#p'+value+' div.item_inches').css({'display':'none'});
		$('#link_size1_'+value).removeClass("link_inches");
		$('#link_size1_'+value).addClass("link_pixels");
		$('#link_size2_'+value).removeClass("link_pixels");
		$('#link_size2_'+value).addClass("link_inches");
	}
}





//Show tell a friend
function tell_show(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			if(document.getElementById('reviewscontent'))
			{
	document.getElementById('reviewscontent').innerHTML =req.responseText;
	document.getElementById('reviewscontent').style.display='none';
	$("#reviewscontent").slideDown("slow");
			}
			if(document.getElementById('tell_content'))
			{
	document.getElementById('tell_content').innerHTML =req.responseText;
			}
        }
    }
    req.open(null, '<?php echo site_url()?>/tell-a-friend/', true);
    req.send( { id: value } );
}


//Show tell a friend form
function tell_add(value) {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			if(document.getElementById('reviewscontent'))
			{
	document.getElementById('reviewscontent').innerHTML =req.responseText;
			}
			if(document.getElementById('tell_content'))
			{
	document.getElementById('tell_content').innerHTML =req.responseText;
			}
        }
    }
    req.open(null, '<?php echo site_url()?>/tell-a-friend/', true);
    req.send( {'form': document.getElementById(value) } );
}










//Related items scrolling
$(function() {
  //Get our elements for faster access and set overlay width
  var div = $('div.sc_menu'),
  ul = $('ul.sc_menu'),
  // unordered list's left margin
  ulPadding = 15;

  //Get menu width
  var divWidth = div.width();

  //Remove scrollbars
  div.css({overflow: 'hidden'});

  //Find last image container
  var lastLi = ul.find('li:last-child');

  //When user move mouse over menu
  div.mousemove(function(e){

    //As images are loaded ul width increases,
    //so we recalculate it each time
    var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth() + ulPadding;

    var left = (e.pageX - div.offset().left) * (ulWidth-divWidth) / divWidth;
    div.scrollLeft(left);
  });
});



rimg=new Image()
rimg.src="<?php echo site_url() . "/"
?>images/rating1.gif"

rimg2=new Image()
rimg2.src="<?php echo site_url() . "/"
?>images/rating2.gif"

//Show rating
function mrating(j) {
	for(i=1;i<6;i++) {
		if(i<=j) {
			document.getElementById("rating"+i.toString()).src =rimg.src
		}
	}
}

//Show rating2
function mrating2(item_rating) {
	for(i=5;i>0;i--) {
		if(i>item_rating) {
			document.getElementById("rating"+i.toString()).src =rimg2.src
		}
	}
}


//Show prices by license
function apanel(x) {

	sizeboxes=new Array();
	<?php
$sql = "select id_parent from " . PVS_DB_PREFIX . "licenses order by priority";
$rs->open( $sql );
$nn = 0;
while ( ! $rs->eof ) {
?>
		sizeboxes[<?php echo $nn
?>]=<?php echo $rs->row["id_parent"] ?>;
		<?php
	$nn++;
	$rs->movenext();
}

if ( ( get_query_var('pvs_page') == 'photo' or get_query_var('pvs_page') == 'vector' ) and $pvs_global_settings["prints"] ) {
?>
		//Prints
		sizeboxes[<?php echo $nn
?>]=0;
	<?php
}
?>
	
	//Rights managed and Contact Us
	if(document.getElementById("license1")) {
		sizeboxes[sizeboxes.length]=1;
	}
	
	//Hide item cart button
	if(document.getElementById("item_button_cart")) {
		if(x==0) {
			document.getElementById("item_button_cart").style.display='none';
		}
		else
		{
			document.getElementById("item_button_cart").style.display='block';
		}
	}


	for(i=0;i<sizeboxes.length;i++) {
		if(document.getElementById('p'+sizeboxes[i].toString())) {
			if(sizeboxes[i]==x)
			{
	document.getElementById('p'+sizeboxes[i].toString()).style.display ='inline';
			}
			else
			{
	document.getElementById('p'+sizeboxes[i].toString()).style.display ='none';
			}
		}
	}
}



//Show added items 
function xcart(x) {




	for(i=0;i<cartitems.length;i++) {
		if(document.getElementById('tr_cart'+cartitems[i].toString())) {
			if(cartitems[i]==x)
			{
	document.getElementById('tr_cart'+cartitems[i].toString()).className ='tr_cart_active';
	document.getElementById('cart').value =x;
			}
			else
			{
	document.getElementById('tr_cart'+cartitems[i].toString()).className ='tr_cart';
			}
		}
	}


	    var aRadio = document.getElementsByTagName('input'); 
	    for (var i=0; i < aRadio.length; i++)
	    { 
	        if (aRadio[i].type != 'radio') continue; 
	        if (aRadio[i].value == x) aRadio[i].checked = true; 
	    } 

}




//Show added prints
function xprint(x) {

	printitems=new Array();
	<?php
$sql = "select id_parent,title,price from " . PVS_DB_PREFIX .
	"prints_items where itemid=" . ( int )get_query_var('pvs_id') . " order by priority";
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
	document.getElementById('cartprint').value =-1*x;
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
	        if (aRadio[i].value == -1*x) 
	        {
	        	aRadio[i].checked = true; 
	        }
	    } 

}

		
//Video mp4/mov preview
function lightboxon_istock(fl,width,height,event,rt) {
	rcontent="<video   width='"+width+"' height='"+height+"' autoplay controls><source src='"+fl+"' type='video/mp4'></video>";

	preview_moving(rcontent,width,height,event);
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