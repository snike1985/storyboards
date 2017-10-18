//
// var main = function() {
//
//     $('.c-hamburger').click(function() {
//         $('.navbar-mobile-menu').animate({
//             left: '0%'
//         }, 400);
//     });
//
//     $('.is-active').click(function() {
//         $('.navbar-mobile-menu').animate({
//             left: '-100%'
//         }, 400);
//
//     });
// };

// $(document).ready(main);
//
var selector = '.option-element';

$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

const burger = document.querySelector(".c-hamburger");
const wrap = document.querySelector('.wrapper');

burger.addEventListener('click', () => {
  burger.classList.toggle('active');
   wrap.classList.toggle('fixed')
})




$(function(){
  $('.newslider').click(function(){
    $('.popup,.popup_overlay').fadeIn(400); //показываем всплывающее окно
  });
  $('.closer,.popup_overlay').click(function(){
    $('.popup,.popup_overlay').fadeOut(400); //скрываем всплывающее окно
  });
});

$(document).ready(function(){
  $('.newslider').slick({
    'setting-name':'setting-value'
  });
});

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
