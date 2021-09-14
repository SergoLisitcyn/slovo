$(document).ready(function() {

    function init_menu_slider() {
        $('.mobile__nav-top').slideUp(0);
        $('.mobile__menu-button').on('click', function () {
            $('.mobile__nav-top').slideToggle();
        });
    }

    init_menu_slider();
});