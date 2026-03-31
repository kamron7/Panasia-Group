$(document).ready(function () {
    $('#newsHomeCarousel').owlCarousel({
        items: 3,
        loop: true,
        dots: false,
        nav: true,
        margin: 30,
        autoplay: false,
        slideTransition: 'linear',
        autoplaySpeed: 3000,
        smartSpeed: 3000,
        autoplayHoverPause: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            767: {
                items: 2
            },
            991: {
                items: 3
            }
        }


    })
});