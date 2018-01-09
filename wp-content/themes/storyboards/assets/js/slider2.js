 $(function(){
     var _slider = $('.popup').find('.newslider'),
         _sliderNav = $('.popup').find('.slider-nav'),
         _sliderInit = function () {
             _slider.slick({
                 slidesToShow: 1,
                 slidesToScroll: 1,
                 arrows: false,
                 fade: true,
                 asNavFor: _sliderNav
             });
             _sliderNav.slick({
                 slidesToShow: 3,
                 slidesToScroll: 1,
                 asNavFor: _slider,
                 dots: false,
                 centerMode: false,
                 focusOnSelect: true
             });
         },
         _sliderDestroy = function () {
             _slider.slick('unslick');
             _sliderNav.slick('unslick');
         };
     $('.newsliderClick').click(function(){
        console.log($(this));
         var galleryImage = $(this).attr('data-gallery');
         if ( galleryImage ) {
             galleryImage =  JSON.parse(galleryImage);
             $('.popup,.popup_overlay').fadeIn(400);

             galleryImage.forEach(function(item){
                 _slider.append('<div><img src="'+ item +'"/></div>');
                 _sliderNav.append('<div><img src="'+ item +'" width="106" /></div>');
             });

             _sliderInit();

         }

     });

     $('.closer,.popup_overlay').click(function(){
         _sliderDestroy();
         _slider.empty();
         _sliderNav.empty();
         $('.popup,.popup_overlay').fadeOut(400); //скрываем всплывающее окно
     });
 });


 $('.newslider2').slick({
     slidesToShow: 1,
     slidesToScroll: 1,
     arrows: false,
     fade: true,
     asNavFor: '.slider-nav2'
 });
 $('.slider-nav2').slick({
     slidesToShow: 3,
     slidesToScroll: 1,
     asNavFor: '.newslider2',
     dots: false,
     centerMode: false,
     focusOnSelect: true
 });