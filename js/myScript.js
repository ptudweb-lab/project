$(document).ready(function () {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('#navbar').addClass('fixed-top');
        }
        if ($(window).scrollTop() < 101) {
            $('#navbar').removeClass('fixed-top');
        }
    });
});