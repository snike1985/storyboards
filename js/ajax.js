$('.content-more a').click(function(e) {
   e.preventDefault();
   $.ajax({
    url: '/seemore.php',
    type: 'JSON',
    error: function() {
		alert("ошибка");
		},
	beforeSend: function(){

	    $('.content-more').append('<div id="hellopreloader"><div id="hellopreloader_preload"></div></div>');
	},
    success: function(data) {
    $('.add-content').empty();
		var data = JSON.parse(data)
		for (i=0; i<Object.keys(data).length; i=i+4) {
			var res='<div class="main-content">'
			for (ii=0; ii<4; ii++) {

				res = res+ '<div class="content-element">'+
							'<a href="#">'+
								'<img src="'+data[ii+i]['img']+'" alt="">'+
								'<div class="board">'+
									'<div class="board-info">'+
										'<div class="board-name">'+data[ii+i]['board-name']+'</div>'+
										'<div class="board-downloads">'+data[ii+i]['board-downloads']+'</div>'+
									'</div>'+
									'<div class="board-author">'+
										'<img src="'+data[ii+i]['author']+'" alt="" width="30" height="30">'+
									'</div>'+
								'</div>'+
							'</a>'+
						'</div>';

				if ((ii+i)>=(Object.keys(data).length-1)) {break};
			}
			res=res+'</div>'
			$('.main-section .container').append(res);
			$('.main-section .main-content').css({opacity: 0}).animate({opacity:1},800);
			$('.content-more').remove();
		}
	}
   });
});