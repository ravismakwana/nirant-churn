(function( $ ){
    class SlickSlider {
        constructor() {
            this.initSlider();
        }
        /**
         * Initialize slick slider
         */
        initSlider(){
            if ($('.gallery-slider').length) {
              document.addEventListener("DOMContentLoaded", function () {
                const sliders = document.querySelectorAll(".gallery-slider");
            
                sliders.forEach((slider) => {
                    const images = slider.querySelectorAll("img");
            
                    images.forEach((img, index) => {
                        if (index === 0) {
                            // First image: eager loading
                            img.setAttribute("loading", "eager");
                        } else {
                            // Other images: lazy loading
                            img.setAttribute("loading", "lazy");
            
                            // Move src to data-lazy
                            img.setAttribute("data-lazy", img.getAttribute("src"));
                            img.removeAttribute("src");
                        }
                    });
                });
            });
            
                $('.gallery-slider ').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: false,
                    lazyLoad: 'ondemand',
                    autoplaySpeed: 2000,
                    dots: true,
                    arrows: false,
                });
            }
            if ($('.certi-slider').length) {
                $('.certi-slider ').slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    lazyLoad: 'ondemand',
                    autoplaySpeed: 2000,
                    dots: true,
                    arrows: false,
                    infinite: true,
                    responsive: [
                        {
                          breakpoint: 992,
                          settings: {
                            arrows: false,
                            slidesToShow: 4
                          }
                        },
                        {
                          breakpoint: 768,
                          settings: {
                            arrows: false,
                            slidesToShow: 3
                          }
                        },
                        {
                          breakpoint: 480,
                          settings: {
                            arrows: false,
                            slidesToShow: 2
                          }
                        }
                      ]
                });
            }
            if ($('.testimonial-slider').length) {
                $('.testimonial-slider ').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: false,
                    lazyLoad: 'ondemand',
                    autoplaySpeed: 2000,
                    dots: true,
                    arrows: false,
                    infinite: true,
                    responsive: [
                        {
                          breakpoint: 992,
                          settings: {
                            arrows: false,
                            slidesToShow: 2
                          }
                        },
                        {
                          breakpoint: 768,
                          settings: {
                            arrows: false,
                            slidesToShow: 2
                          }
                        },
                        {
                          breakpoint: 480,
                          settings: {
                            arrows: false,
                            slidesToShow: 1
                          }
                        }
                      ]
                });
            }
        }
    }

    new SlickSlider();

})(jQuery)