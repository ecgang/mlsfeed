jQuery(document).ready( function($){

    $('.advmls-properties-carousel-js[id^="advmls-properties-carousel-"]').each(function(){
        var $div = jQuery(this);
        var token = $div.data('token');
        var obj = window['advmls_prop_caoursel_' + token];

        var slides_to_show = parseInt(obj.slides_to_show),
            slides_to_scroll = parseInt(obj.slides_to_scroll),
            navigation = parseBool(obj.navigation),
            auto_play = parseBool(obj.slide_auto),
            auto_play_speed = parseInt(obj.auto_speed),
            slide_infinite = parseBool(obj.slide_infinite),
            dots = parseBool( obj.slide_dots );

        var advmls_rtl = advmls_vars.advmls_rtl;

        if( advmls_rtl == 'yes' ) {
            advmls_rtl = true;
        } else {
            advmls_rtl = false;
        }

        function parseBool(str) {
            if( str == 'true' ) { return true; } else { return false; }
        }

        var advmlsCarousel = $('#advmls-properties-carousel-'+token);

        advmlsCarousel.slick({
            rtl: advmls_rtl,
            lazyLoad: 'ondemand',
            infinite: slide_infinite,
            autoplay: auto_play,
            autoplaySpeed: auto_play_speed,
            speed: 300,
            slidesToShow: slides_to_show,
            slidesToScroll: slides_to_scroll,
            arrows: navigation,
            adaptiveHeight: true,
            dots: dots,
            appendArrows: '.advmls-carousel-arrows-'+token,
            prevArrow: $('.slick-prev-js-'+token),
            nextArrow: $('.slick-next-js-'+token),
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    });

});