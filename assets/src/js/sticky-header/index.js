(function ($) {
    /**
     * StickyNavbar Class
     * Handles sticky navbar and smooth scrolling with correct offset.
     */
    class StickyNavbar {
        constructor(navSelector) {
            this.navbar = document.querySelector(navSelector);
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
                this.navbarHeight = this.navbar.getBoundingClientRect().height; // More accurate
            }
        }

        getOffset() {
            let offset = this.navbarHeight; // Always use updated navbar height

            // If navbar is sticky, ensure we adjust for its height
            const navbarStyles = window.getComputedStyle(this.navbar);
            if (navbarStyles.position === "fixed" || this.isSticky) {
                offset = this.navbar.getBoundingClientRect().height;
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
                    this.updateNavbarHeight(); // Ensure correct height before scrolling
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
            new StickyNavbar('.main-navbar'); // Correctly initializes sticky navbar
        }, 100);
    });

})(jQuery);