(function ($) {
	class Woo {
		constructor() {
			this.init();
		}
   
		init() {
			this.setInitialPrices();
			this.bindEvents();
			this.cleanupLayoutClasses();
		}
   
		setInitialPrices() {
			const initialRegularPrice = $('.quantity-options button.active').data('regular-price');
			const initialPrice = $('.quantity-options button.active').data('price');
   
			$('.revert-price').text(initialRegularPrice ? '₹' + parseFloat(initialRegularPrice).toFixed(2) : '');
   
			if (initialRegularPrice == initialPrice) {
				$('#regular-price').hide();
			} else {
				$('#regular-price').show().html('<s>₹' + parseFloat(initialRegularPrice).toFixed(2) + '</s>');
			}
		}
   
		bindEvents() {
		   $('.quantity-options button').on('click', (event) => this.handleOptionClick(event));
		   $(document.body).on('click', '.add_to_cart_button', (event) => this.handleButtonClick(event));
		   $(document.body).on('added_to_cart', (event, fragments, cart_hash, button) => this.handleItemAdded(event, button));
		}
   
		handleOptionClick(event) {
			const button = $(event.currentTarget);
			const variationId = button.data('variation-id');
			const price = button.data('price');
			const regularPrice = button.data('regular-price');
			const label = button.data('label');
   
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
   
		cleanupLayoutClasses() {
			const classesToRemove = [
				'is-nowrap', 'is-layout-flex', 'wp-container-core-group-is-layout-2',
				'wp-block-group-is-layout-flex', 'wp-container-core-group-is-layout-1',
				'wp-block-columns-is-layout-flex', 'wp-container-core-columns-is-layout-1',
				'is-layout-flow', 'wp-block-column-is-layout-flow', 'wp-container-core-columns-is-layout-2'
			];
   
			classesToRemove.forEach(className => {
				$('.' + className).removeClass(className);
			});
		}
   
	   handleButtonClick(event) {
		   const $button = $(event.currentTarget);
   
		   if (!$button.hasClass('loading')) {
			   $button.addClass('loading');
			   $button.data('original-text', $button.html()); // Save original button text
			   $button.css({
				   'min-width': $button.outerWidth(), // Prevent button width from shrinking
				   'min-height': $button.outerHeight() // Prevent button height from shrinking
			   });
			   $button.html('<div class="d-flex justify-content-center align-items-center"><div class="spinner-border spinner-border-sm" role="status"></div></div>');
		   }
	   }
   
	   handleItemAdded(event, button) {
		   const $button = $(button);
   
		   $button.removeClass('loading');
		   $button.html($button.data('original-text')); // Restore original button text
		   $button.css({
			   'min-width': '', // Reset button width
			   'min-height': '' // Reset button height
		   });
	   }
	}
   
	new Woo();
   })(jQuery);