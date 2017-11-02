



$(function(){
  $('.newslider').click(function(){
    $('.popup,.popup_overlay').fadeIn(400);
    $('.newslider').slick('refresh');

  });
  $('.closer,.popup_overlay').click(function(){
    $('.popup,.popup_overlay').fadeOut(400); //скрываем всплывающее окно
  });
});



// $(document).ready(function(){
//   $('.newslider').slick({
//     'setting-name':'setting-value'
//   });
// });


$('.newslider').slick({
 slidesToShow: 1,
 slidesToScroll: 1,
 arrows: false,
 fade: true,
 asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
 slidesToShow: 3,
 slidesToScroll: 1,
 asNavFor: '.newslider',
 dots: false,
 centerMode: false,
 focusOnSelect: true
});
