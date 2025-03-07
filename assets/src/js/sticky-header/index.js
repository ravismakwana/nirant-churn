(function ($) {
    /**
     * CartRemoveProduct Class
     * Handles the removal of products from the cart with AJAX and updates the cart fragments.
     */
    class StickyNavbar {
        constructor(navSelector) {
            this.navbar = document.querySelector(navSelector);
            this.navbarHeight = this.navbar.offsetHeight;
            this.lastScrollY = window.scrollY;
            this.isSticky = false;
            this.init();
        }
    
        init() {
            window.addEventListener('scroll', () => this.handleScroll());
        }
    
        handleScroll() {
            const currentScrollY = window.scrollY;
    
            if (currentScrollY > this.navbarHeight && !this.isSticky) {
                this.makeSticky();
            } else if (currentScrollY <= this.navbarHeight && this.isSticky) {
                this.removeSticky();
            }
    
            this.lastScrollY = currentScrollY;
        }
    
        makeSticky() {
            this.navbar.classList.add('active');
            this.isSticky = true;
        }
    
        removeSticky() {
            this.navbar.classList.remove('active');
            this.isSticky = false;
        }
    }

    // Initialize the CartRemoveProduct class
    new StickyNavbar('.main-navbar');
})(jQuery);
