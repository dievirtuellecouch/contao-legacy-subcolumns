/* Disabled: swiper is a standalone bundle now; Subcolumns must not manage it. */
(function(){
  // Opt-in only: run only if a root has data-enable-subcolumns-swiper="1"
  function ready(fn){ if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn, {once:true}); }
  ready(function(){
    var roots = document.querySelectorAll('.ce-swiper-gallery[data-enable-subcolumns-swiper="1"]');
    if (!roots.length) return; // default: do nothing
    // Intentionally no implementation: left here for backward compatibility if ever re-enabled.
  });
})();
