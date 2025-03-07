(function ($) {
    /**
     * Clock Class.
     */
	class CartCountdownTimer {
		constructor(durationInSeconds, timerSelector) {
		  this.duration = durationInSeconds;
		  this.timerElement = document.querySelector(timerSelector);
		  this.minutesElement = this.timerElement.querySelector('.minutes');
		  this.secondsElement = this.timerElement.querySelector('.seconds');
		  this.interval = null;
		}
	  
		startTimer() {
		  if (this.interval) clearInterval(this.interval);
	  
		  let remainingTime = this.duration;
	  
		  this.interval = setInterval(() => {
			const minutes = Math.floor(remainingTime / 60);
			const seconds = remainingTime % 60;
	  
			this.updateDisplay(minutes, seconds);
	  
			if (remainingTime <= 0) {
			  clearInterval(this.interval);
			  this.timerExpired();
			}
			remainingTime--;
		  }, 1000);
		}
	  
		updateDisplay(minutes, seconds) {
		  this.minutesElement.textContent = String(minutes).padStart(2, '0');
		  this.secondsElement.textContent = String(seconds).padStart(2, '0');
		}
	  
		timerExpired() {
		  alert('Your cart has expired! Please add items again to place your order.');
		  // Optionally clear the cart using WooCommerce AJAX
		  jQuery.post('/?wc-ajax=remove_cart_item', { cart_item_key: 'all' });
		}
	  }

    new CartCountdownTimer();
})(jQuery);
