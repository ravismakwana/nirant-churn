(function( $ ){
    class InstReels {
        constructor() {
          this.$container = $(".instagram-reels-container");
          this.ajaxUrl = ajax_object.ajax_url;
          this.init();
        }

        init() {
            $(window).on("load", () => this.fetchReels());
        }

        fetchReels() {
          $.ajax({
              url: this.ajaxUrl,
              type: "POST",
              data: { action: "fetch_instagram_reels" },
              beforeSend: () => this.$container.html("<p>Loading Instagram Reels...</p>"),
              success: (response) => {
                  if (response.success) {
                      this.$container.html(response.data.html);
                      this.initPopup();
                  } else {
                      this.$container.html(`<p>${response.data.message}</p>`);
                  }
              },
              error: () => {
                  this.$container.html("<p>Failed to load Instagram Reels.</p>");
              }
          });
      }

      initPopup() {
          $(".popup-video").magnificPopup({
              type: "iframe",
              mainClass: "mfp-fade",
              removalDelay: 160,
              preloader: false,
              fixedContentPos: false
          });
      }

    }
    if(ajax_object.current_page === 'home'){
        new InstReels();
    }

})(jQuery)