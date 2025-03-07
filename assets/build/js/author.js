/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************!*\
  !*** ./src/js/author.js ***!
  \**************************/
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }

(function ($) {
  var Author = /*#__PURE__*/function () {
    function Author() {
      _classCallCheck(this, Author);

      this.authorProfileImgContainer = $('#author-profile-img span');
      this.authorFirstNameText = $('#author-firstname').text();
      this.authorLastNameText = $('#author-lastname').text();
      this.init();
    }

    _createClass(Author, [{
      key: "init",
      value: function init() {
        if (!this.authorProfileImgContainer.length) {
          return null;
        }

        var initials = this.authorFirstNameText.charAt(0) + this.authorLastNameText.charAt(0);
        initials = initials ? initials : 'A'; // Set the text.

        this.authorProfileImgContainer.text(initials);
      }
    }]);

    return Author;
  }();

  new Author();
})(jQuery);
/******/ })()
;
//# sourceMappingURL=author.js.map