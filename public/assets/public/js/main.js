$(".banner__carousel").owlCarousel({
    loop: true,
    items: 1,
    margin: 0,
    nav: true,
    dots: false,
    navText: ["<i class='icon-angle-left'></i>", "<i class='icon-angle-right'></i>"],
    autoplay: true,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',

});
$(".links__carousel").owlCarousel({
    loop: true,
    items: 3,
    margin: 24,
    nav: true,
    dots: false,
    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    autoplay: true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },

        768: {
            items:2,
        },

        992: {
            items:2,
        },

        1170:{
            items: 2,
            nav:true,
        },

        1280: {
            items: 3
        }
    }
});
$(".product__carousel").owlCarousel({
    loop: true,
    items: 4,
    margin: 24,
    nav: true,
    dots: false,
    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },

        768: {
            items:2,
        },

        992: {
            items:3,
        },

        1170:{
            items: 3,
            nav:true,
        },

        1280: {
            items: 3
        },
        1440: {
            items: 4
        }
    }
});