//Products settings
iphone_width = 238;
iphone_height = 482;
galaxy_width = 287;
galaxy_height = 569;
pillow_width = 455;
pillow_height = 455;
bag_width = 355;
bag_height = 355;
duvet_width = 481;
duvet_height = 572;
curtain_width = 419;
curtain_height = 500;
tshirt_width = 170;

//Visible area size. It is the same for the prints but different for iphone.
if(print_type == 'iphone_cases') {
	print_width2 = iphone_width;
	print_height2 = iphone_height;
}
else if(print_type == 'galaxy_cases') {
	print_width2 = galaxy_width;
	print_height2 = galaxy_height;
}
else if(print_type == 'pillow') {
	print_width2 = pillow_width;
	print_height2 = pillow_height;
}
else if(print_type == 'shower_curtain') {
	print_width2 = curtain_width;
	print_height2 = curtain_height;
}
else if(print_type == 'duvet_cover') {
	print_width2 = duvet_width;
	print_height2 = duvet_height;
}
else if(print_type == 'bag') {
	print_width2 = bag_width;
	print_height2 = bag_height;
}
else if(print_type == 'tshirt') {
	print_width2 = tshirt_width;
	print_height2 =Math.round(tshirt_width*print_height/print_width);	
}
else
{
	print_width2 = print_width;
	print_height2 = print_height;
}



wrap_top = 0;
wrap_left = 0;

border_width = 10;
frame_size_default = 0;

flag_resize = false;



if(print_type == 'iphone_cases') {
	$.preloadImages(site_root+"includes/prints/images/iphone_overlay_big_horizontal_left.png");
	$.preloadImages(site_root+"includes/prints/images/iphone_overlay_big_horizontal_right.png");
	$.preloadImages(site_root+"includes/prints/images/iphone_overlay_big.png");
}

if(print_type == 'galaxy_cases') {
	$.preloadImages(site_root+"includes/prints/images/galaxy_overlay_big_horizontal_left.png");
	$.preloadImages(site_root+"includes/prints/images/galaxy_overlay_big_horizontal_right.png");
	$.preloadImages(site_root+"includes/prints/images/galaxy_overlay_big.png");
}

//Calculate max image size
function get_image_size() {
	if(print_width !=0) {
		image_width = $( "#print_size" ).val();
		image_height = Math.round(image_width*print_height/print_width);	
	}	
}


$(function() {
	if(print_type == 'canvas_prints' || print_type == 'acrylic_prints' || print_type == 'iphone_cases' || print_type == 'galaxy_cases') {
		border_width = 10;
	}
	else if(print_type == 'metal_prints') {
		border_width =  5;	
	}
	else {
		border_width = 0;
	}
	
	$('.print_wrap').mousedown(function(eventObject){
	  show_image();
	});
	
	$('.print_wrap').mouseup(function(eventObject){
	  show_print();
	});
	
	get_image_size();
	
	offset = $('#print_preview').offset();	
	$('.print_wrap').css("width", print_width2);
	$('.print_wrap').css("height", print_height2);
	$(".print_wrap").offset({top:offset.top, left:offset.left});
	$('.print_wrap').draggable({containment:[offset.left-image_width+print_width2+border_width,offset.top-image_height+print_height2+border_width,offset.left-border_width,offset.top-border_width]});	
});


function show_image() {
	if($( "#print_size" ).val() > print_width + 2*border_width) {
		flag_resize = true;
		
		get_image_size();
	
		$('.print_wrap').draggable({containment:[offset.left-image_width+print_width2+border_width,offset.top-image_height+print_height2+border_width,offset.left-border_width,offset.top-border_width]});
		
		$('.print_display').css("display", "block");
		
		offset = $('#print_preview').offset();	
		image_left = offset.left - Math.round((image_width - print_width2)/2);
		image_top = offset.top - Math.round((image_height - print_height2)/2);
		wrap_top = image_top;
		wrap_left = image_left;
		
		$('.print_wrap').css("width", image_width+"px");
		$('.print_wrap').css("height", image_height+"px");
		$('.print_wrap').css("background", "url("+print_image+")");
		$('.print_wrap').css("background-size", "cover");
		$('.print_wrap').offset({top:image_top, left:image_left});
		
		$('.print_border_left').offset({top:offset.top, left:offset.left});
		$('.print_border_left').css("width", "1px");
		$('.print_border_left').css("height", print_height2+"px");
		$('.print_border_left').css("border-left", "1px dashed #FFFFFF");
		
		$('.print_border_top').offset({top:offset.top, left:offset.left});
		$('.print_border_top').css("width", print_width2+"px");
		$('.print_border_top').css("height", "1px");
		$('.print_border_top').css("border-top", "1px dashed #FFFFFF");
		
		$('.print_border_right').offset({top:offset.top, left:offset.left+print_width2});
		$('.print_border_right').css("width", "1px");
		$('.print_border_right').css("height", print_height2+"px");
		$('.print_border_right').css("border-right", "1px dashed #FFFFFF");
		
		$('.print_border_bottom').offset({top:offset.top+print_height2, left:offset.left});
		$('.print_border_bottom').css("width", print_width2+"px");
		$('.print_border_bottom').css("height", "1px");
		$('.print_border_bottom').css("border-bottom", "1px dashed #FFFFFF");
		
		if(border_width > 0) {
			$('.print_border_left2').offset({top:offset.top-border_width, left:offset.left-border_width});
			$('.print_border_left2').css("width", "1px");
			$('.print_border_left2').css("height", (print_height2+2*border_width)+"px");
			$('.print_border_left2').css("border-left", "1px dashed #FFFFFF");
			
			$('.print_border_top2').offset({top:offset.top-border_width, left:offset.left-border_width});
			$('.print_border_top2').css("width", (print_width2+2*border_width)+"px");
			$('.print_border_top2').css("height", "1px");
			$('.print_border_top2').css("border-top", "1px dashed #FFFFFF");
			
			$('.print_border_right2').offset({top:offset.top-border_width, left:offset.left+print_width2+border_width});
			$('.print_border_right2').css("width", "1px");
			$('.print_border_right2').css("height", (print_height2+2*border_width)+"px");
			$('.print_border_right2').css("border-right", "1px dashed #FFFFFF");
			
			$('.print_border_bottom2').offset({top:offset.top+print_height2+border_width, left:offset.left-border_width});
			$('.print_border_bottom2').css("width", (print_width2+2*border_width)+"px");
			$('.print_border_bottom2').css("height", "1px");
			$('.print_border_bottom2').css("border-bottom", "1px dashed #FFFFFF");		
		}
	}
}

function show_print() {
	if($( "#print_size" ).val() > print_width + 2*border_width || flag_resize == true) {
		$('.print_display').css("display", "none");
		offset = $('#print_preview').offset();
		offset_image = $('.print_wrap').offset();
		wrap_top = offset_image.top;
		wrap_left = offset_image.left;
		
		$('.print_wrap').offset({top:offset.top, left:offset.left});	
		$('.print_wrap').css("width", print_width+"px");
		$('.print_wrap').css("height", print_height+"px");
		$('.print_wrap').css("background", "");
		$('#print_preview').css("background","url("+print_image+")");
		$('#print_preview').css("background-position",(offset_image.left-offset.left)+"px "+(offset_image.top-offset.top)+"px");
		$('#print_preview').css("background-repeat","no-repeat");
		$('#print_preview').css("background-size",image_width+"px "+image_height+"px");
		$('#print_x1').val(Math.round((offset.left-offset_image.left-border_width)*default_width/image_width));
		$('#print_y1').val(Math.round((offset.top-offset_image.top-border_width)*default_height/image_height));
		$('#print_x2').val(Math.round((offset.left-offset_image.left+border_width+print_width2)*default_width/image_width));
		$('#print_y2').val(Math.round((offset.top-offset_image.top+border_width+print_height2)*default_height/image_height));
		
		if(print_type == 'canvas_prints') {
			flag_mirrowed = check_property('Mirrored Sides');
			if(flag_mirrowed)
			{
				$('.canvas_prints_big_left').css("background","url("+print_image+")");
				$('.canvas_prints_big_left').css("background-position","-"+(offset.left-offset_image.left+print_width)+"px -"+(offset.top-offset_image.top)+"px");
				$('.canvas_prints_big_left').css("background-size",image_width+"px "+image_height+"px");
				
				$('.canvas_prints_big_bottom').css("background","url("+print_image+")");
				$('.canvas_prints_big_bottom').css("background-position","-"+(offset.left-offset_image.left)+"px -"+(offset.top-offset_image.top+print_height)+"px");
				$('.canvas_prints_big_bottom').css("background-size",image_width+"px "+image_height+"px");
			}
		}
		
		if(print_type == 'acrylic_prints') {
			$('.acrylic_prints_big_left').css("background","url("+print_image+")");
			$('.acrylic_prints_big_left').css("background-position","-"+(offset.left-offset_image.left+print_width)+"px -"+(offset.top-offset_image.top)+"px");
			$('.acrylic_prints_big_left').css("background-size",image_width+"px "+image_height+"px");
			
			$('.acrylic_prints_big_bottom').css("background","url("+print_image+")");
			$('.acrylic_prints_big_bottom').css("background-position","-"+(offset.left-offset_image.left)+"px -"+(offset.top-offset_image.top+print_height)+"px");
			$('.acrylic_prints_big_bottom').css("background-size",image_width+"px "+image_height+"px");
		}
	}
}

function show_print_default() {
	if(print_type == 'iphone_cases' || print_type == 'galaxy_cases' || print_type == 'pillow' || print_type == 'bag' || print_type == 'duvet_cover' || print_type == 'shower_curtain') {
		$('#print_preview').css("background","url("+print_image+")");
		$('#print_preview').css("background-position","center center");
		$('#print_preview').css("background-repeat","no-repeat");
		$('#print_preview').css("background-size","cover");
	}
	else {
		$('#print_preview').css("background","url("+print_image+")");
		$('#print_preview').css("background-position","0px 0px");
		$('#print_preview').css("background-repeat","no-repeat");
		$('#print_preview').css("background-size",(print_width+border_width)+"px "+(print_height+border_width)+"px");	
	}
	
	if(print_type == 'canvas_prints') {
		flag_mirrowed = check_property('Mirrored Sides');
		if(flag_mirrowed) {
			$('.canvas_prints_big_left').css("background","url("+print_image+")");
			$('.canvas_prints_big_left').css("background-position","top right");
			$('.canvas_prints_big_left').css("background-size",print_width+"px "+print_height+"px");
			
			$('.canvas_prints_big_bottom').css("background","url("+print_image+")");
			$('.canvas_prints_big_bottom').css("background-position","bottom left");
			$('.canvas_prints_big_bottom').css("background-size",print_width+"px "+print_height+"px");
		}
	}
	
	if(print_type == 'acrylic_prints') {
		$('.acrylic_prints_big_left').css("background","url("+print_image+")");
		$('.acrylic_prints_big_left').css("background-position","top right");
		$('.acrylic_prints_big_left').css("background-size",print_width+"px "+print_height+"px");
		
		$('.acrylic_prints_big_bottom').css("background","url("+print_image+")");
		$('.acrylic_prints_big_bottom').css("background-position","bottom left");
		$('.acrylic_prints_big_bottom').css("background-size",print_width+"px "+print_height+"px");
	}
}

function show_print_cart_default() {
	get_image_size();	
	
	$('#print_preview').css("background","url("+print_image+")");
	$('#print_preview').css("background-position","-"+(Math.round($('#print_x1').val()*$( "#print_size" ).val()/default_width))+"px -"+(Math.round($('#print_y1').val()*$( "#print_size" ).val()/default_width))+"px");
	$('#print_preview').css("background-repeat","no-repeat");
	$('#print_preview').css("background-size",image_width+"px "+image_height+"px");
	
	if(print_type == 'canvas_prints') {
		flag_mirrowed = check_property('Mirrored Sides');
		if(flag_mirrowed) {
			$('.canvas_prints_big_left').css("background","url("+print_image+")");
			$('.canvas_prints_big_left').css("background-position","-"+(Math.round($('#print_x1').val()*$( "#print_size" ).val()/default_width)+print_width)+"px -"+(Math.round($('#print_y1').val()*$( "#print_size" ).val()/default_width))+"px");
			$('.canvas_prints_big_left').css("background-size",image_width+"px "+image_height+"px");
			
			$('.canvas_prints_big_bottom').css("background","url("+print_image+")");
			$('.canvas_prints_big_bottom').css("background-position","-"+(Math.round($('#print_x1').val()*$( "#print_size" ).val()/default_width))+"px -"+(Math.round($('#print_y1').val()*$( "#print_size" ).val()/default_width)+print_height-border_width)+"px");
			$('.canvas_prints_big_bottom').css("background-size",image_width+"px "+image_height+"px");
		}
	}
	
	if(print_type == 'acrylic_prints') {
		$('.acrylic_prints_big_left').css("background","url("+print_image+")");
		$('.acrylic_prints_big_left').css("background-position","-"+(Math.round($('#print_x1').val()*$( "#print_size" ).val()/default_width)+print_width)+"px -"+(Math.round($('#print_y1').val()*$( "#print_size" ).val()/default_width))+"px");
		$('.acrylic_prints_big_left').css("background-size",image_width+"px "+image_height+"px");
		
		$('.acrylic_prints_big_bottom').css("background","url("+print_image+")");
		$('.acrylic_prints_big_bottom').css("background-position","-"+(Math.round($('#print_x1').val()*$( "#print_size" ).val()/default_width))+"px -"+(Math.round($('#print_y1').val()*$( "#print_size" ).val()/default_width)+print_height-border_width)+"px");
		$('.acrylic_prints_big_bottom').css("background-size",image_width+"px "+image_height+"px");
	}
}

function change_color(color_code,property_number,property_id,property_name) {
	$(".prints_colors2").removeClass("prints_colors2").addClass("prints_colors");
	$("#color_"+property_number+"_"+property_id).removeClass("prints_colors").addClass("prints_colors2");
	$("#property"+property_number).val(color_code);
	
	change_option(property_name,color_code);
}

function change_frame(frame_code,property_number,property_id,property_name,property_value) {
	$(".prints_frame2").removeClass("prints_frame2").addClass("prints_frame");
	$("#frame_"+property_number+"_"+property_id).removeClass("prints_frame").addClass("prints_frame2");
	$("#property"+property_number).val(frame_code);
	
	change_option(property_name,frame_code);
}

function change_background(background_code,property_number,property_id,property_name,property_value) {
	$(".prints_background2").removeClass("prints_background2").addClass("prints_background");
	$("#background_"+property_number+"_"+property_id).removeClass("prints_background").addClass("prints_background2");
	$("#property"+property_number).val(background_code);
	
	change_option(property_name,background_code);
}

function change_price() {
    var req = new JsHttpRequest();
    // Code automatically called on load finishing.
    req.onreadystatechange = function()
    {
        if (req.readyState == 4)
        {
			document.getElementById('print_price').innerHTML =req.responseText;
        }
    }
    req.open(null, site_root2+'/content-print-price/', true);
    req.send( {'form': document.getElementById("print_form") } );
}


function change_option(property_name,property_value) {
	if(property_name == 'print_wrap') {
		if(property_value == 'No Wrap - Rolled In A Tube') {
			$('.canvas_prints_big_left').css("background","none");
			$('.canvas_prints_big_left').css("background-color","#FFFFFF");
			$('.canvas_prints_big_left').css("border","0px");
			$('.canvas_prints_big_bottom').css("background","none");
			$('.canvas_prints_big_bottom').css("background-color","#FFFFFF");
			$('.canvas_prints_big_bottom').css("border","0px");
			$('.canvas_prints_big_shadow').css("display","none");
		}
		if(property_value == 'White Sides') {
			$('.canvas_prints_big_left').css("background","none");
			$('.canvas_prints_big_left').css("background-color","#FFFFFF");
			$('.canvas_prints_big_left').css("border","#d2d0d0 solid 1px");
			$('.canvas_prints_big_bottom').css("background","none");
			$('.canvas_prints_big_bottom').css("background-color","#FFFFFF");
			$('.canvas_prints_big_bottom').css("border","#d2d0d0 solid 1px");
			$('.canvas_prints_big_shadow').css("display","table");
		}
		if(property_value == 'Black Sides') {
			$('.canvas_prints_big_left').css("background","none");
			$('.canvas_prints_big_left').css("background-color","#272727");
			$('.canvas_prints_big_left').css("border-width","0px");
			$('.canvas_prints_big_bottom').css("background","none");
			$('.canvas_prints_big_bottom').css("background-color","#000000");
			$('.canvas_prints_big_bottom').css("border-width","0px");
			$('.canvas_prints_big_shadow').css("display","table");
		}
		if(property_value == 'Mirrored Sides') {
			$('.canvas_prints_big_left').css("background","url("+print_image+")");
			$('.canvas_prints_big_left').css("background-size",image_width+"px "+image_height+"px");
						
			$('.canvas_prints_big_bottom').css("background","url("+print_image+")");
			$('.canvas_prints_big_bottom').css("background-size",image_width+"px "+image_height+"px");
			
			if(flag_resize)
			{
				$('.canvas_prints_big_left').css("background-position","-"+(offset.left-wrap_left+print_width)+"px -"+(offset.top-wrap_top)+"px");
				$('.canvas_prints_big_bottom').css("background-position","-"+(offset.left-wrap_left)+"px -"+(offset.top-wrap_top+print_height)+"px");
			}
			else
			{
				$('.canvas_prints_big_left').css("background-position","bottom right");
				$('.canvas_prints_big_bottom').css("background-position","bottom right");			
			}
			
			$('.canvas_prints_big_left').css("border-width","0px");
			$('.canvas_prints_big_bottom').css("border-width","0px");
			
			$('.canvas_prints_big_left').css("background-color","transparent");
			$('.canvas_prints_big_bottom').css("background-color","transparent");
			$('.canvas_prints_big_shadow').css("display","table");
		}
	}
	
	if(property_name == 'top_mat_size' || property_name == 'bottom_mat_size' || property_name == 'print_size') {		
		if($('.property_print_size').length > 0) {
			pr_print_size = $('.property_print_size').val();
			pr_print_size  = pr_print_size.replace(/cm/g,"");
			pr_print_size  = pr_print_size.replace(/\"/g,"");
		}
		else
		{
			pr_print_size =  0;
		}
		
		if($('.property_top_mat_size').length > 0) {
			top_mat_size = $('.property_top_mat_size').val();
			top_mat_size = top_mat_size.replace(/cm/g,"");
			top_mat_size = top_mat_size.replace(/\"/g,"");
		}
		else
		{
			top_mat_size = 0;
		}
				
		if($('.property_bottom_mat_size').length > 0) {
			bottom_mat_size = $('.property_bottom_mat_size').val();
			bottom_mat_size = bottom_mat_size.replace(/cm/g,"");
			bottom_mat_size = bottom_mat_size.replace(/\"/g,"");
		}
		else
		{
			bottom_mat_size = 0;
		}
		
		if(pr_print_size*1 != 0) {
			top_mat_width = Math.round(print_width*top_mat_size/pr_print_size);
			//$('.prints_top_mat').css("padding",top_mat_width + "px");
			$('.prints_bottom_mat').css("margin",top_mat_width + "px");
			$('.prints_top_mat').css("background-color",$('.property_top_mat_color').val());
		}
		
		if(pr_print_size*1 != 0) {
			bottom_mat_width = Math.round(print_width*bottom_mat_size/pr_print_size);
			//$('.prints_bottom_mat').css("padding",bottom_mat_width + "px");
			$('#print_preview').css("margin",bottom_mat_width + "px");
			$('.prints_bottom_mat').css("background-color",$('.property_bottom_mat_color').val());
		}
	}
	
	if(property_name == 'top_mat_color' || property_name == 'bottom_mat_color') {
		if($('.prints_top_mat').length > 0 && $('.property_top_mat_color').length > 0) {
			$('.prints_top_mat').css("background-color",$('.property_top_mat_color').val());
		}
		if($('.prints_bottom_mat').length > 0 && $('.property_bottom_mat_color').length > 0) {
			$('.prints_bottom_mat').css("background-color",$('.property_bottom_mat_color').val());
		}
	}
	
	if(property_name == 'print_mounting') {
		if(property_value == 'Aluminum Mounting Posts') {
			$('.acrylic_prints_big_mounting1').css("display","block");
			$('.acrylic_prints_big_mounting2').css("display","block");
			$('.acrylic_prints_big_mounting3').css("display","block");
			$('.acrylic_prints_big_mounting4').css("display","block");
		}
		else
		{
			$('.acrylic_prints_big_mounting1').css("display","none");
			$('.acrylic_prints_big_mounting2').css("display","none");
			$('.acrylic_prints_big_mounting3').css("display","none");
			$('.acrylic_prints_big_mounting4').css("display","none");		
		}
	}
	
	if(property_name == 'print_frame'  || property_name == 'print_size') {
		frame_size=0;
		
		if($('.property_print_size').length > 0) {
			pr_print_size = $('.property_print_size').val();
			pr_print_size  = pr_print_size.replace(/cm/g,"");
			pr_print_size  = pr_print_size.replace(/\"/g,"");
		}
		else
		{
			pr_print_size =  0;
		}
		
		if($('#frame_'+property_value+'_width').length > 0 && property_name == 'print_frame') {
			frame_size = $('#frame_'+property_value+'_width').val();
			frame_size = frame_size.replace(/cm/g,"");
			frame_size = frame_size.replace(/\"/g,"");
			frame_size_default=frame_size;
			if(pr_print_size*1 !=  0)
			{
				frame_size = Math.round(print_width*frame_size/pr_print_size);
			}			
		}
		else
		{
			if(pr_print_size*1 !=  0)
			{
				frame_size = Math.round(print_width*frame_size_default/pr_print_size);
			}		
		}
		
		$('#frame_top_left').css("width",frame_size+"px");
		$('#frame_top_left').css("height",frame_size+"px");
		$('#frame_top_right').css("width",frame_size+"px");
		$('#frame_top_right').css("height",frame_size+"px");
		
		$('#frame_bottom_left').css("width",frame_size+"px");
		$('#frame_bottom_left').css("height",frame_size+"px");
		$('#frame_bottom_right').css("width",frame_size+"px");
		$('#frame_bottom_right').css("height",frame_size+"px");
		

		if(property_value != '' && property_name == 'print_frame') {
			$('#frame_top_left').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_top_left.jpg')");
			$('#frame_top_left').css("background-size","100% 100%");
			$('#frame_top_left').css("background-repeat","no-repeat");
			
			$('#frame_top_center').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_top_center.jpg')");
			$('#frame_top_center').css("background-size","auto 100%");
			$('#frame_top_center').css("background-repeat","repeat-x");
			
			$('#frame_top_right').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_top_right.jpg')");
			$('#frame_top_right').css("background-size","100% 100%");
			$('#frame_top_right').css("background-repeat","no-repeat");
			
			$('#frame_center_left').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_center_left.jpg')");
			$('#frame_center_left').css("background-size","100% auto");
			$('#frame_center_left').css("background-repeat","repeat-y");
			
			$('#frame_center_right').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_center_right.jpg')");
			$('#frame_center_right').css("background-size","100% auto");
			$('#frame_center_right').css("background-repeat","repeat-y");
			
			$('#frame_bottom_left').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_bottom_left.jpg')");
			$('#frame_bottom_left').css("background-size","100% 100%");
			$('#frame_bottom_left').css("background-repeat","no-repeat");
			
			$('#frame_bottom_center').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_bottom_center.jpg')");
			$('#frame_bottom_center').css("background-size","auto 100%");
			$('#frame_bottom_center').css("background-repeat","repeat-x");
			
			$('#frame_bottom_right').css("background","url('"+site_root+"includes/prints/images/"+property_value+"_bottom_right.jpg')");
			$('#frame_bottom_right').css("background-size","100% 100%");
			$('#frame_bottom_right').css("background-repeat","no-repeat");
		}

		
		/*
		if(property_value != '' && property_name == 'print_frame') {
			$('#frame_top_left').attr('class',property_value+'_top_left');	
			$('#frame_top_center').attr('class',property_value+'_top_center');	
			$('#frame_top_right').attr('class',property_value+'_top_right');	
			$('#frame_center_left').attr('class',property_value+'_center_left');	
			$('#frame_center_right').attr('class',property_value+'_center_right');	
			$('#frame_bottom_left').attr('class',property_value+'_bottom_left');	
			$('#frame_bottom_center').attr('class',property_value+'_bottom_center');	
			$('#frame_bottom_right').attr('class',property_value+'_bottom_right');	
		}
		*/
	}
	
	if(property_name == 'orientation_case') {
		if(print_type == 'iphone_cases') {
			if(property_value == 'Horizontal Right')
			{
				print_width2 = iphone_height;
				print_height2 = iphone_width;
				$('#print_preview').css("width",iphone_height + "px");
				$('#print_preview').css("height",iphone_width + "px");
				$('#iphone_overlay').attr("src",site_root+"includes/prints/images/iphone_overlay_big_horizontal_right.png");
			}
			else if(property_value == 'Horizontal Left')
			{
				print_width2 = iphone_height;
				print_height2 = iphone_width;
				$('#print_preview').css("width",iphone_height + "px");
				$('#print_preview').css("height",iphone_width + "px");
				$('#iphone_overlay').attr("src",site_root+"includes/prints/images/iphone_overlay_big_horizontal_left.png");
			}
			else  if(property_value == 'Vertical')
			{
				print_width2 = iphone_width;
				print_height2 = iphone_height;
				$('#print_preview').css("width",iphone_width + "px");
				$('#print_preview').css("height",iphone_height + "px");
				$('#iphone_overlay').attr("src",site_root+"includes/prints/images/iphone_overlay_big.png");
			}
			else
			{
				print_width2 = iphone_width;
				print_height2 = iphone_height;
				$('#print_preview').css("width",iphone_width + "px");
				$('#print_preview').css("height",iphone_height + "px");
				$('#iphone_overlay').attr("src",site_root+"includes/prints/images/iphone_overlay_big.png");
			}
		}
		
		if(print_type == 'galaxy_cases') {
			if(property_value == 'Horizontal Right')
			{
				print_width2 = galaxy_height;
				print_height2 = galaxy_width;
				$('#print_preview').css("width",galaxy_height + "px");
				$('#print_preview').css("height",galaxy_width + "px");
				$('#galaxy_overlay').attr("src",site_root+"includes/prints/images/galaxy_overlay_big_horizontal_right.png");
			}
			else if(property_value == 'Horizontal Left')
			{
				print_width2 = galaxy_height;
				print_height2 = galaxy_width;
				$('#print_preview').css("width",galaxy_height + "px");
				$('#print_preview').css("height",galaxy_width + "px");
				$('#galaxy_overlay').attr("src",site_root+"includes/prints/images/galaxy_overlay_big_horizontal_left.png");
			}
			else  if(property_value == 'Vertical')
			{
				print_width2 = galaxy_width;
				print_height2 = galaxy_height;
				$('#print_preview').css("width",galaxy_width + "px");
				$('#print_preview').css("height",galaxy_height + "px");
				$('#galaxy_overlay').attr("src",site_root+"includes/prints/images/galaxy_overlay_big.png");
			}
			else
			{
				print_width2 = galaxy_width;
				print_height2 = galaxy_height;
				$('#print_preview').css("width",galaxy_width + "px");
				$('#print_preview').css("height",galaxy_height + "px");
				$('#galaxy_overlay').attr("src",site_root+"includes/prints/images/galaxy_overlay_big.png");
			}
		}
		
		$('#print_preview').css("background","url("+print_image+")");
		$('#print_preview').css("background-position","center center");
		$('#print_preview').css("background-repeat","no-repeat");
		$('#print_preview').css("background-size","cover");
		show_print_default();
	}
				
	if(property_value != '' && property_name == 'tshirt_color') {
		$('.tshirt_big').css("background","url('"+site_root+"includes/prints/images/"+property_value+"')");
	}
}

function check_property(value) {
	flag_property = false;
	
	for(i=1;i<11;i++) {
		element_name = '[name = "property'+i+'"]';
		if($(element_name) && $(element_name).val() == value) {
			flag_property = true;
		}
	}
	
	return flag_property;
}


