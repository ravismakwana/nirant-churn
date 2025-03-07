(function ($) {
    /**
     * DropdownOverlay Class.
     */
	class DropdownWithOverlay {
		constructor(dropdownId, overlayId) {
			this.dropdown = document.getElementById(dropdownId);
			this.overlay = document.getElementById(overlayId);
	
			// Initialize Bootstrap event listeners
			this.init();
		}
	
		init() {
			// Listen for Bootstrap dropdown events
			this.dropdown.addEventListener("show.bs.dropdown", () => this.showOverlay());
			this.dropdown.addEventListener("hide.bs.dropdown", () => this.hideOverlay());
	
			// Close dropdown when clicking on overlay
			this.overlay.addEventListener("click", () => this.closeDropdown());
		}
	
		showOverlay() {
			this.overlay.classList.add("overlay-active"); // Add class instead of setting display
		}
	
		hideOverlay() {
			this.overlay.classList.remove("overlay-active"); // Remove class instead of setting display
		}
	
		closeDropdown() {
			const dropdownInstance = bootstrap.Dropdown.getInstance(this.dropdown);
			if (dropdownInstance) {
				dropdownInstance.hide();
			}
		}
	}
	
    new DropdownWithOverlay("userMenuDropdown", "dropdownOverlay");
})(jQuery);
