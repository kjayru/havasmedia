function aptf_popitup(url) {
    newwindow = window.open(url, 'name', 'height=400,width=650');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}

(function ($) {
    $(function () {
        //All the frontend js for the plugin 

        $('.aptf-tweets-slider-wrapper').each(function () {
            var controls = $(this).data('slideControls');
            var auto = $(this).data('autoSlide');
            var slide_duration = $(this).data('slideDuration');
            var adaptive_height = $(this).data('adaptive');
            var mode = $(this).data('mode');
            $(this).bxSlider({
                auto: auto,
                adaptiveHeight:adaptive_height,
                controls: controls,
                pause: slide_duration,
                pager: false,
                speed: 1500,
                slideMargin:10,
                mode:mode
            });
        });

//       $('.aptf-tweets-ticker-wrapper').each(function(){
//          var ticker_speed = $(this).attr('data-ticker-speed');
//          var mouse_pause = $(this).attr('data-mouse-pause');
//          $(this).bxSlider({
//              auto:true,
//              ticker:true,
//              speed:ticker_speed,
//              tickerHover:mouse_pause
//          });
//       });

    });//document.ready close
    $(window).load(function () {
        $('.aptf-pro-ticker-main-wrapper').each(function () {
            var ticker_speed = $(this).attr('data-ticker-speed');
            var mouse_pause = $(this).attr('data-mouse-pause');
            var up_id = $(this).parent().find('.aptf-ticker-up').attr('id');
            var down_id = $(this).parent().find('.aptf-ticker-down').attr('id');
            var direction = $(this).attr('data-direction');
            $(this).easyTicker({
                direction: direction,
                easing: 'swing',
                speed: 'slow',
                interval: ticker_speed,
                height: 'auto',
                visible: 3,
                mousePause: mouse_pause,
                controls: {
                    up: '#'+up_id,
                    down: '#'+down_id

                }
            });
        });
    });
}(jQuery));