$( function(){

    $('.most-downloads, .recent-downloads, .main-section').each(function(){
        new Gallery($(this));
    });

});

var Gallery = function (obj) {
    var _self = this,
        _obj = obj,
        _popup = $('.popup,.popup_overlay'),
        _close = $('.closer,.popup_overlay'),
        _slider = $('.newslider'),
        _sliderNav = $('.slider-nav'),
        _item = _obj.find('.content-element');

    var _onEvents = function () {

        _item.on({
            click: function () {
                var galleryImage = $(this).attr('data-gallery');
                if ( galleryImage ) {
                    galleryImage =  JSON.parse(galleryImage);
                    _popup.fadeIn(400);

                    galleryImage.forEach(function(item){
                        _slider.append('<div><img src="'+ item +'"/></div>');
                        _sliderNav.append('<div><img src="'+ item +'" width="106" /></div>');
                    });

                    //_slider.slick('refresh');
                    _sliderInit();
                }

                return false;
            }
        });
        _close.on({
            click: function () {

                _popup.fadeOut(400);

                setTimeout(function () {
                    _sliderDestroy();

                    _slider.empty ();
                    _sliderNav.empty ();
                }, 400);

            }
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
    _init = function(){

        _onEvents();
    };

    _init();
};