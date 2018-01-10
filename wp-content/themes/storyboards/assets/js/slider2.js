$( function(){

    $('.storyboard-container').each(function(){
        new Gallery2($(this));
    });

});

var Gallery2 = function (obj) {
    var _self = this,
        _obj = obj,
        _popup = $('.popup'),
        _open = $('.popup,.popup_overlay'),
        _close = $('.closer,.popup_overlay'),
        _slider =_popup.find('.newslider'),
        _sliderNav = _popup.find('.slider-nav'),
        _sliderMain = _obj.find('.newslider'),
        _sliderMainNav =_obj.find('.slider-nav');

    var _onEvents = function () {

            _sliderMain.click(function(){

            var galleryImage = $(this).attr('data-gallery');

            if ( galleryImage ) {

                galleryImage =  JSON.parse(galleryImage);

                _open.fadeIn(400);

                galleryImage.forEach(function(item){
                    _slider.append('<div><img src="'+ item +'"/></div>');
                    _sliderNav.append('<div><img src="'+ item +'" width="106" /></div>');
                });

                _sliderInit();

            }

        });

        _close.click(function(){
            _sliderDestroy();
            _slider.empty();
            _sliderNav.empty();
            _open.fadeOut(400);
        });
    },
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
        },
    _sliderMainInit = function () {
        _sliderMain.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: _sliderMainNav
        });

        _sliderMainNav.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: _sliderMain,
            dots: false,
            centerMode: false,
            focusOnSelect: true
        });
    },
    _init = function(){
        _sliderMainInit();
        _onEvents();
    };

    _init();
};







