$(document).ready(function () {
    $(window).scroll(function () {
        var slenght = $(this).scrollTop();
        if ( slenght > 1) {
            $('#start-nav').css({
                'width': '100%',
                'height': '75px',
                'border-radius': '0',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'padding': '10px 30px',
            });
        } else {
            $('#start-nav').css({
                'width': '100%',
                'height': '92px',
                'position': 'relative',
                'top': '0',
                'left': '0',
                'border': '0',
                'background': '#fff',
                'padding': '29px 0',
            });
            $('#header').css({'z-index': '100000'});
        }
    });
});