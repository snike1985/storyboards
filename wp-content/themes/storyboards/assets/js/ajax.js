var more = $('.content-more'),
	main = $('.main-section'),
	container = main.find('.container');

    more.find('a').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: $('body').data('action'),
        data: {action: "image",page: container.attr('data-page'),author: container.attr('data-author')},
        dataType: 'json',
        type: "GET",
        error: function() {
            console.log("ошибка");
        },
        beforeSend: function(){
            more.append('<div id="loading"><div id="loading-center"><div id="loading-center-absolute"><div class="object" id="object_four"></div> <div class="object" id="object_three"></div><div class="object" id="object_two"></div><div class="object" id="object_one"></div></div></div></div>');
        },
        success: function(data) {
            var res='<div class="main-content">';
            container.attr('data-page', parseInt(container.attr('data-page')) + 1);
            for (var i = 0; i < data['items'].length; i++) {

                if(i === 4) {
                    res +='</div><div class="main-content">';
                }

                res += '<div class="content-element">'+
                    '<a href="'+data['items'][i]['img']+'" class="popup__open" data-popup="image">'+
                    '<img src="'+data['items'][i]['img']+'" alt="">'+
                    '<div class="board">'+
                    '<div class="board-info">'+
                    '<div class="board-name">'+data['items'][i]['board-name']+'</div>'+
                    '<div class="board-downloads">'+data['items'][i]['board-downloads']+'</div>'+
                    '</div>'+
                    '<div class="board-author">'+
                    '<img src="'+data['items'][i]['author']+'" alt="" width="30" height="30">'+
                    '</div>'+
                    '</div>'+
                    '</a>'+
                    '</div>';
            }

            res += '</div>';

            $(res).insertBefore( more );
            main.find('.main-content').css({opacity: 0}).animate({opacity:1},800);

            if(data['has_items']) {
                more.find('#hellopreloader').remove();
            } else {
                more.remove();
            }

            $( '.popup' ).each(function(){

                new Popup($(this));

            });

        }
    });
});