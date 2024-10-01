jQuery(document).ready(function($) {
    // Check if Swiper is available
    if (typeof Swiper !== 'undefined') {
        var swiper = new Swiper('.swiper-container', {
            loop: jQuery('.swiper-container').attr('data-loop') == "true" ? true : false,
            spaceBetween: 30,
            autoplay: jQuery('.swiper-container').attr('data-autoplay') == "true" ? true : false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },  
            slidesPerView: jQuery('.swiper-container').attr('data-slides-to-show'),  
        });
    } else {
        console.error('Swiper is not defined');
    }
});