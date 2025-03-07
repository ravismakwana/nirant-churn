/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/carousel/index.js":
/*!**********************************!*\
  !*** ./src/js/carousel/index.js ***!
  \**********************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  var SlickSlider = /*#__PURE__*/function () {
    function SlickSlider() {
      _classCallCheck(this, SlickSlider);

      this.initSlider();
    }
    /**
     * Initialize slick slider
     */


    _createClass(SlickSlider, [{
      key: "initSlider",
      value: function initSlider() {
        if ($('.gallery-slider').length) {
          document.addEventListener("DOMContentLoaded", function () {
            var sliders = document.querySelectorAll(".gallery-slider");
            sliders.forEach(function (slider) {
              var images = slider.querySelectorAll("img");
              images.forEach(function (img, index) {
                if (index === 0) {
                  // First image: eager loading
                  img.setAttribute("loading", "eager");
                } else {
                  // Other images: lazy loading
                  img.setAttribute("loading", "lazy"); // Move src to data-lazy

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
            arrows: false
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
            responsive: [{
              breakpoint: 992,
              settings: {
                arrows: false,
                slidesToShow: 4
              }
            }, {
              breakpoint: 768,
              settings: {
                arrows: false,
                slidesToShow: 3
              }
            }, {
              breakpoint: 480,
              settings: {
                arrows: false,
                slidesToShow: 2
              }
            }]
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
            responsive: [{
              breakpoint: 992,
              settings: {
                arrows: false,
                slidesToShow: 2
              }
            }, {
              breakpoint: 768,
              settings: {
                arrows: false,
                slidesToShow: 2
              }
            }, {
              breakpoint: 480,
              settings: {
                arrows: false,
                slidesToShow: 1
              }
            }]
          });
        }
      }
    }]);

    return SlickSlider;
  }();

  new SlickSlider();
})(jQuery);

/***/ }),

/***/ "./src/js/cart-remove-product/index.js":
/*!*********************************************!*\
  !*** ./src/js/cart-remove-product/index.js ***!
  \*********************************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  /**
   * CartRemoveProduct Class
   * Handles the removal of products from the cart with AJAX and updates the cart fragments.
   */
  var CartRemoveProduct = /*#__PURE__*/function () {
    function CartRemoveProduct() {
      _classCallCheck(this, CartRemoveProduct);

      this.init();
    }
    /**
     * Initialize the event listener
     */


    _createClass(CartRemoveProduct, [{
      key: "init",
      value: function init() {
        var _this = this;

        // Bind event to the remove button
        $(document).on('click', '.btn-remove', function (e) {
          return _this.removeProduct(e);
        });
      }
      /**
       * Handle product removal logic
       * @param {Event} e - The click event
       */

    }, {
      key: "removeProduct",
      value: function removeProduct(e) {
        e.preventDefault(); // Debugging: Check the target element

        console.log(e); // Ensure you're selecting the correct data attributes

        var $button = $(e.currentTarget);
        var productId = $button.data("product_id");
        var cartItemKey = $button.data("cart_item_key");
        var productContainer = $button.closest('.asgard_canvas_right_cart-main'); // Debugging: Check the values you're trying to get
        // console.log('Product ID:', productId);
        // console.log('Cart Item Key:', cartItemKey);

        if (!productId || !cartItemKey) {
          console.error('Product ID or Cart Item Key is missing!');
          return; // Exit if values are not found
        } // const productContainer = $(e.target).closest('.item');
        // Add loader


        this.addLoader(productContainer); // Send AJAX request to remove the product from the cart

        this.sendAjaxRequest(productId, cartItemKey, productContainer);
      }
      /**
       * Add a loader to the product container while waiting for the AJAX response
       * @param {jQuery} container - The product container element
       */

    }, {
      key: "addLoader",
      value: function addLoader(container) {
        container.block({
          message: null,
          overlayCSS: {
            cursor: 'none'
          }
        });
      }
      /**
       * Send an AJAX request to remove the product from the cart
       * @param {string} productId - The product ID
       * @param {string} cartItemKey - The cart item key
       * @param {jQuery} productContainer - The container element of the product being removed
       */

    }, {
      key: "sendAjaxRequest",
      value: function sendAjaxRequest(productId, cartItemKey, productContainer) {
        var _this2 = this;

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_object.ajax_url,
          data: {
            action: "product_remove",
            nonce: ajax_object.nonce,
            product_id: productId,
            cart_item_key: cartItemKey
          },
          success: function success(response) {
            return _this2.handleResponse(response, productContainer);
          }
        });
      }
      /**
       * Handle the AJAX response and update cart fragments
       * @param {Object} response - The response from the AJAX request
       * @param {jQuery} productContainer - The product container element
       */

    }, {
      key: "handleResponse",
      value: function handleResponse(response, productContainer) {
        if (!response || response.error) return;

        if (response.success) {
          $('.mini-cart-counter').replaceWith(response.data.fragments['.mini-cart-counter']);
          $('#offcanvasCartHeader').replaceWith(response.data.fragments['#offcanvasCartHeader']);
          $('#offcanvasCartBody').replaceWith(response.data.fragments['#offcanvasCartBody']);
          $('.right_cart-subtotal-right').replaceWith(response.data.fragments['.right_cart-subtotal-right']);

          if (window.wcBlocksRegistry && window.wc.wcBlocksDataStore) {
            window.wc.wcBlocksDataStore.dispatch("cart").invalidateResolution("getCartData");
          }
        } // Remove the loader after the operation is done


        productContainer.unblock();
      }
    }]);

    return CartRemoveProduct;
  }(); // Initialize the CartRemoveProduct class


  new CartRemoveProduct();
})(jQuery);

/***/ }),

/***/ "./src/js/dropdown-overlay/index.js":
/*!******************************************!*\
  !*** ./src/js/dropdown-overlay/index.js ***!
  \******************************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  /**
   * DropdownOverlay Class.
   */
  var DropdownWithOverlay = /*#__PURE__*/function () {
    function DropdownWithOverlay(dropdownId, overlayId) {
      _classCallCheck(this, DropdownWithOverlay);

      this.dropdown = document.getElementById(dropdownId);
      this.overlay = document.getElementById(overlayId); // Initialize Bootstrap event listeners

      this.init();
    }

    _createClass(DropdownWithOverlay, [{
      key: "init",
      value: function init() {
        var _this = this;

        // Listen for Bootstrap dropdown events
        this.dropdown.addEventListener("show.bs.dropdown", function () {
          return _this.showOverlay();
        });
        this.dropdown.addEventListener("hide.bs.dropdown", function () {
          return _this.hideOverlay();
        }); // Close dropdown when clicking on overlay

        this.overlay.addEventListener("click", function () {
          return _this.closeDropdown();
        });
      }
    }, {
      key: "showOverlay",
      value: function showOverlay() {
        this.overlay.classList.add("overlay-active"); // Add class instead of setting display
      }
    }, {
      key: "hideOverlay",
      value: function hideOverlay() {
        this.overlay.classList.remove("overlay-active"); // Remove class instead of setting display
      }
    }, {
      key: "closeDropdown",
      value: function closeDropdown() {
        var dropdownInstance = bootstrap.Dropdown.getInstance(this.dropdown);

        if (dropdownInstance) {
          dropdownInstance.hide();
        }
      }
    }]);

    return DropdownWithOverlay;
  }();

  new DropdownWithOverlay("userMenuDropdown", "dropdownOverlay");
})(jQuery);

/***/ }),

/***/ "./src/js/insta-reels/index.js":
/*!*************************************!*\
  !*** ./src/js/insta-reels/index.js ***!
  \*************************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  var InstReels = /*#__PURE__*/function () {
    function InstReels() {
      _classCallCheck(this, InstReels);

      this.$container = $(".instagram-reels-container");
      this.ajaxUrl = ajax_object.ajax_url;
      this.init();
    }

    _createClass(InstReels, [{
      key: "init",
      value: function init() {
        var _this = this;

        $(window).on("load", function () {
          return _this.fetchReels();
        });
      }
    }, {
      key: "fetchReels",
      value: function fetchReels() {
        var _this2 = this;

        $.ajax({
          url: this.ajaxUrl,
          type: "POST",
          data: {
            action: "fetch_instagram_reels"
          },
          beforeSend: function beforeSend() {
            return _this2.$container.html("<p>Loading Instagram Reels...</p>");
          },
          success: function success(response) {
            if (response.success) {
              _this2.$container.html(response.data.html);

              _this2.initPopup();
            } else {
              _this2.$container.html("<p>".concat(response.data.message, "</p>"));
            }
          },
          error: function error() {
            _this2.$container.html("<p>Failed to load Instagram Reels.</p>");
          }
        });
      }
    }, {
      key: "initPopup",
      value: function initPopup() {
        $(".popup-video").magnificPopup({
          type: "iframe",
          mainClass: "mfp-fade",
          removalDelay: 160,
          preloader: false,
          fixedContentPos: false
        });
      }
    }]);

    return InstReels;
  }();

  if (ajax_object.current_page === 'home') {
    new InstReels();
  }
})(jQuery);

/***/ }),

/***/ "./src/js/sticky-header/index.js":
/*!***************************************!*\
  !*** ./src/js/sticky-header/index.js ***!
  \***************************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  /**
   * CartRemoveProduct Class
   * Handles the removal of products from the cart with AJAX and updates the cart fragments.
   */
  var StickyNavbar = /*#__PURE__*/function () {
    function StickyNavbar(navSelector) {
      _classCallCheck(this, StickyNavbar);

      this.navbar = document.querySelector(navSelector);
      this.navbarHeight = this.navbar.offsetHeight;
      this.lastScrollY = window.scrollY;
      this.isSticky = false;
      this.init();
    }

    _createClass(StickyNavbar, [{
      key: "init",
      value: function init() {
        var _this = this;

        window.addEventListener('scroll', function () {
          return _this.handleScroll();
        });
      }
    }, {
      key: "handleScroll",
      value: function handleScroll() {
        var currentScrollY = window.scrollY;

        if (currentScrollY > this.navbarHeight && !this.isSticky) {
          this.makeSticky();
        } else if (currentScrollY <= this.navbarHeight && this.isSticky) {
          this.removeSticky();
        }

        this.lastScrollY = currentScrollY;
      }
    }, {
      key: "makeSticky",
      value: function makeSticky() {
        this.navbar.classList.add('active');
        this.isSticky = true;
      }
    }, {
      key: "removeSticky",
      value: function removeSticky() {
        this.navbar.classList.remove('active');
        this.isSticky = false;
      }
    }]);

    return StickyNavbar;
  }(); // Initialize the CartRemoveProduct class


  new StickyNavbar('.main-navbar');
})(jQuery);

/***/ }),

/***/ "./src/js/woo/index.js":
/*!*****************************!*\
  !*** ./src/js/woo/index.js ***!
  \*****************************/
/***/ (function() {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  var Woo = /*#__PURE__*/function () {
    function Woo() {
      _classCallCheck(this, Woo);

      this.init();
    }

    _createClass(Woo, [{
      key: "init",
      value: function init() {
        this.setInitialPrices();
        this.bindEvents();
        this.cleanupLayoutClasses();
      }
    }, {
      key: "setInitialPrices",
      value: function setInitialPrices() {
        var initialRegularPrice = $('.quantity-options button.active').data('regular-price');
        var initialPrice = $('.quantity-options button.active').data('price');
        $('.revert-price').text(initialRegularPrice ? '₹' + parseFloat(initialRegularPrice).toFixed(2) : '');

        if (initialRegularPrice == initialPrice) {
          $('#regular-price').hide();
        } else {
          $('#regular-price').show().html('<s>₹' + parseFloat(initialRegularPrice).toFixed(2) + '</s>');
        }
      }
    }, {
      key: "bindEvents",
      value: function bindEvents() {
        var _this = this;

        $('.quantity-options button').on('click', function (event) {
          return _this.handleOptionClick(event);
        });
        $(document.body).on('click', '.add_to_cart_button', function (event) {
          return _this.handleButtonClick(event);
        });
        $(document.body).on('added_to_cart', function (event, fragments, cart_hash, button) {
          return _this.handleItemAdded(event, button);
        });
      }
    }, {
      key: "handleOptionClick",
      value: function handleOptionClick(event) {
        var button = $(event.currentTarget);
        var variationId = button.data('variation-id');
        var price = button.data('price');
        var regularPrice = button.data('regular-price');
        var label = button.data('label');
        $('#selected-variation').val(variationId);
        $('#buy-now-variation').val(variationId);
        $('#sale-price').html('₹' + parseFloat(price).toFixed(2));

        if (regularPrice && regularPrice !== price) {
          $('#regular-price').show().html('<s>₹' + parseFloat(regularPrice).toFixed(2) + '</s>');
        } else {
          $('#regular-price').hide();
        }

        $('#selected-quantity').text(label);
        $('.revert-price').text(regularPrice ? '₹' + parseFloat(regularPrice).toFixed(2) : '');
        $('.quantity-options button').removeClass('active');
        button.addClass('active');
      }
    }, {
      key: "cleanupLayoutClasses",
      value: function cleanupLayoutClasses() {
        var classesToRemove = ['is-nowrap', 'is-layout-flex', 'wp-container-core-group-is-layout-2', 'wp-block-group-is-layout-flex', 'wp-container-core-group-is-layout-1', 'wp-block-columns-is-layout-flex', 'wp-container-core-columns-is-layout-1', 'is-layout-flow', 'wp-block-column-is-layout-flow', 'wp-container-core-columns-is-layout-2'];
        classesToRemove.forEach(function (className) {
          $('.' + className).removeClass(className);
        });
      }
    }, {
      key: "handleButtonClick",
      value: function handleButtonClick(event) {
        var $button = $(event.currentTarget);

        if (!$button.hasClass('loading')) {
          $button.addClass('loading');
          $button.data('original-text', $button.html()); // Save original button text

          $button.css({
            'min-width': $button.outerWidth(),
            // Prevent button width from shrinking
            'min-height': $button.outerHeight() // Prevent button height from shrinking

          });
          $button.html('<div class="d-flex justify-content-center align-items-center"><div class="spinner-border spinner-border-sm" role="status"></div></div>');
        }
      }
    }, {
      key: "handleItemAdded",
      value: function handleItemAdded(event, button) {
        var $button = $(button);
        $button.removeClass('loading');
        $button.html($button.data('original-text')); // Restore original button text

        $button.css({
          'min-width': '',
          // Reset button width
          'min-height': '' // Reset button height

        });
      }
    }]);

    return Woo;
  }();

  new Woo();
})(jQuery);

/***/ }),

/***/ "./src/sass/main.scss":
/*!****************************!*\
  !*** ./src/sass/main.scss ***!
  \****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _cart_remove_product__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./cart-remove-product */ "./src/js/cart-remove-product/index.js");
/* harmony import */ var _cart_remove_product__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_cart_remove_product__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _sticky_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./sticky-header */ "./src/js/sticky-header/index.js");
/* harmony import */ var _sticky_header__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_sticky_header__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _dropdown_overlay__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./dropdown-overlay */ "./src/js/dropdown-overlay/index.js");
/* harmony import */ var _dropdown_overlay__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_dropdown_overlay__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _carousel__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./carousel */ "./src/js/carousel/index.js");
/* harmony import */ var _carousel__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_carousel__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _insta_reels__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./insta-reels */ "./src/js/insta-reels/index.js");
/* harmony import */ var _insta_reels__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_insta_reels__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _woo__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./woo */ "./src/js/woo/index.js");
/* harmony import */ var _woo__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_woo__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _sass_main_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../sass/main.scss */ "./src/sass/main.scss");
// import './clock';
// import './cart-timer';





 // import './posts/loadmore';
// Styles

 // Images
// import '../img/PhotoFunia1.jpg';
}();
/******/ })()
;
//# sourceMappingURL=main.js.map