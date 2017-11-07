
var selector = '.option-element';
var show = '.show-more-option';
var hidden = '.story-tag-hidden';

$(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

$(show).on('click', function(){
    $(hidden).removeClass('active');
    $(this).removeClass('active');
    $(hidden).addClass('active');
    $(this).removeClass('active');

});


const burger = document.querySelector(".c-hamburger");
const wrap = document.querySelector('html');

burger.addEventListener('click', () => {
  burger.classList.toggle('active');
   wrap.classList.toggle('fixed')
})
