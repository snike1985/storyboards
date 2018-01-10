
var show = '.show-more-option';
var hidden = '.story-tag-hidden';

$(show).on('click', function(){
    $(hidden).removeClass('active');
    $(this).removeClass('active');
    $(hidden).addClass('active');
    $(this).removeClass('active');

});

var header = $('.header'),
    wrap = $('body');

$('.menu-btn').on('click', function () {
    if (!header.hasClass('menu-open')) {
        header.addClass('menu-open');
        wrap.addClass('body-fixed');
    } else {
        header.removeClass('menu-open');
        wrap.removeClass('body-fixed');
    }

});
