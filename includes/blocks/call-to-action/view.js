/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./src/blocks/call-to-action/view.js ***!
  \*******************************************/
class CLABlocksCallToAction {
  constructor() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', this.DOMContentLoadedListener.bind(this));
    } else {
      this.DOMContentLoadedListener();
    }
  }
  DOMContentLoadedListener(event) {
    this.init();
  }
  init() {
    var allCTAs = document.querySelectorAll('.cla-blocks-call-to-action-container.has-link');
    allCTAs.forEach(CTA => {
      CTA.addEventListener('click', event => {
        window.location.assign(CTA.querySelector('.cla-blocks-call-to-action__link .wp-block-button__link').href);
      });
    });
  }
}
new CLABlocksCallToAction();
/******/ })()
;
//# sourceMappingURL=view.js.map