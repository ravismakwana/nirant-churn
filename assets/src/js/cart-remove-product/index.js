(function ($) {
    /**
     * CartRemoveProduct Class
     * Handles the removal of products from the cart with AJAX and updates the cart fragments.
     */
    class CartRemoveProduct {
        constructor() {
            this.init();
        }

        /**
         * Initialize the event listener
         */
        init() {
            // Bind event to the remove button
            $(document).on('click', '.btn-remove', (e) => this.removeProduct(e));
        }

        /**
         * Handle product removal logic
         * @param {Event} e - The click event
         */
        removeProduct(e) {
			e.preventDefault();

            // Debugging: Check the target element
            console.log(e);
			// Ensure you're selecting the correct data attributes
            const $button = $(e.currentTarget);
            const productId = $button.data("product_id");
            const cartItemKey = $button.data("cart_item_key");
			const productContainer = $button.closest('.asgard_canvas_right_cart-main');

            // Debugging: Check the values you're trying to get
            // console.log('Product ID:', productId);
            // console.log('Cart Item Key:', cartItemKey);
			
            if (!productId || !cartItemKey) {
                console.error('Product ID or Cart Item Key is missing!');
                return;  // Exit if values are not found
            }

            // const productContainer = $(e.target).closest('.item');

            // Add loader
            this.addLoader(productContainer);

            // Send AJAX request to remove the product from the cart
            this.sendAjaxRequest(productId, cartItemKey, productContainer);
        }

        /**
         * Add a loader to the product container while waiting for the AJAX response
         * @param {jQuery} container - The product container element
         */
        addLoader(container) {
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
        sendAjaxRequest(productId, cartItemKey, productContainer) {
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
                success: (response) => this.handleResponse(response, productContainer)
            });
        }

        /**
         * Handle the AJAX response and update cart fragments
         * @param {Object} response - The response from the AJAX request
         * @param {jQuery} productContainer - The product container element
         */
        handleResponse(response, productContainer) {
            if (!response || response.error) return;

            if (response.success) {
				$('.mini-cart-counter').replaceWith(response.data.fragments['.mini-cart-counter']);
				$('#offcanvasCartHeader').replaceWith(response.data.fragments['#offcanvasCartHeader']);
				$('#offcanvasCartBody').replaceWith(response.data.fragments['#offcanvasCartBody']);
				$('.right_cart-subtotal-right').replaceWith(response.data.fragments['.right_cart-subtotal-right']);
                if (window.wcBlocksRegistry && window.wc.wcBlocksDataStore) {
                    window.wc.wcBlocksDataStore.dispatch("cart").invalidateResolution("getCartData");
                }
			}
			// Remove the loader after the operation is done
            productContainer.unblock();
        }
    }

    // Initialize the CartRemoveProduct class
    new CartRemoveProduct();
})(jQuery);
