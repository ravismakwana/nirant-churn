(function ($) {
    /**
     * StickyNavbar Class
     * Handles sticky navbar and smooth scrolling with correct offset.
     */
    class StickyNavbar {
        constructor(navSelector, headerSelector) {
            this.navbar = document.querySelector(navSelector);
            this.header = document.querySelector(headerSelector);
            this.navbarHeight = 0;
            this.isSticky = false;
            this.init();
        }

        init() {
            if (this.navbar) {
                this.updateNavbarHeight();
                window.addEventListener('scroll', () => this.handleScroll());
                window.addEventListener('resize', () => this.updateNavbarHeight()); // Recalculate on resize
            }
            this.initSmoothScroll();
        }

        handleScroll() {
            const currentScrollY = window.scrollY;

            if (currentScrollY > this.navbarHeight && !this.isSticky) {
                this.makeSticky();
            } else if (currentScrollY <= this.navbarHeight && this.isSticky) {
                this.removeSticky();
            }
        }

        makeSticky() {
            this.navbar.classList.add('active');
            this.isSticky = true;
            this.updateNavbarHeight(); // Recalculate height when sticky
        }

        removeSticky() {
            this.navbar.classList.remove('active');
            this.isSticky = false;
            this.updateNavbarHeight(); // Reset height when not sticky
        }

        updateNavbarHeight() {
            if (this.navbar) {
                this.navbarHeight = this.navbar.offsetHeight;
            }
        }

        getOffset() {
            let offset = 0;
            
            if (this.header) {
                offset = this.header.offsetHeight;
            }

            // If navbar is fixed or sticky, add its height
            const navbarStyles = window.getComputedStyle(this.navbar);
            if (navbarStyles.position === "fixed" || this.isSticky) {
                offset += this.navbarHeight;
            }

            return offset;
        }

        initSmoothScroll() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => this.handleClick(e));
            });
        }

        handleClick(e) {
            e.preventDefault();
            const targetId = e.currentTarget.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                setTimeout(() => {
                    const offset = this.getOffset();
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - offset;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }, 50); // Small delay to ensure correct height calculation
            }
        }
    }

    // Ensure script runs only after full page load
    $(document).ready(() => {
        setTimeout(() => {
            new StickyNavbar('.main-navbar', '.main-header'); // Uses .main-header height as offset
        }, 100);
    });

})(jQuery);
