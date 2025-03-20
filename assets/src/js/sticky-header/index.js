(function ($) {
    class StickyNavbar {
        constructor(navSelector) {
            this.navbar = document.querySelector(navSelector);
            this.headerTopBar = document.querySelector('.header-top-bar-main');
            this.navbarHeight = 0;
            this.topBarHeight = 0;
            this.isSticky = false;
            this.init();
        }

        init() {
            if (this.navbar) {
                this.updateHeights();
                window.addEventListener('scroll', () => this.handleScroll());
                window.addEventListener('resize', () => this.updateHeights());
            }
            this.initSmoothScroll();
            this.handlePageLoadScroll(); // Ensure smooth scrolling after page load
        }
        

        handleScroll() {
            const currentScrollY = window.scrollY;
            const currentHeight = this.navbarHeight;
            if (currentScrollY > currentHeight && !this.isSticky) {
                this.makeSticky();
            } else if (currentScrollY <= this.navbarHeight && this.isSticky) {
                this.removeSticky();
            }
        }

        makeSticky() {
            this.navbar.classList.add('active');
            this.isSticky = true;
            this.updateHeights();
        }

        removeSticky() {
            this.navbar.classList.remove('active');
            this.isSticky = false;
            this.updateHeights();
        }

        updateHeights() {
            if (this.navbar) {
                this.navbarHeight = this.navbar.offsetHeight;
            }
            if (this.headerTopBar) {
                this.topBarHeight = this.headerTopBar.offsetHeight;
            }
        }

        getOffset() {
            return this.navbarHeight; // Always updated dynamically
        }

        initSmoothScroll() {
            document.querySelectorAll('a[href*="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => this.handleClick(e));
            });
        }        

        handleClick(e) {
            e.preventDefault();
            const href = e.currentTarget.getAttribute('href');
            const targetId = href.includes("#") ? href.substring(href.indexOf("#")) : null;
        
            if (targetId) {
                const targetElement = document.querySelector(targetId);
        
                if (targetElement) {
                    // Smooth scroll if the target element exists
                    this.updateHeights();
                    const currentHeight = this.navbarHeight;
                    const offset = this.getOffset();
                    let offsetValue = this.isSticky ? offset : offset + currentHeight - this.topBarHeight;
        
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - offsetValue;
        
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                } else {
                    // Store the target ID and redirect
                    sessionStorage.setItem("scrollTo", targetId);
                    window.location.href = `${window.location.origin}${targetId}`;
                }
            }
        }
        handlePageLoadScroll() {
            const targetId = sessionStorage.getItem("scrollTo");
            if (targetId) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    this.updateHeights();
                    const offset = this.getOffset();
                    let offsetValue = this.isSticky ? offset : offset + this.navbarHeight - this.topBarHeight;
        
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - offsetValue;
        
                    setTimeout(() => {
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }, 200); // Slight delay to ensure page is fully loaded
                }
                sessionStorage.removeItem("scrollTo"); // Clear storage after use
            }
        }                                
    }

    $(document).ready(() => {
        setTimeout(() => {
            new StickyNavbar('.main-navbar');
        }, 100);
    });
})(jQuery);