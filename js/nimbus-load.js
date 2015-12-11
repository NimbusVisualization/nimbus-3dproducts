/***
 * Nimbus
 *
 * Conditional loading of jQuery and Bootstrap scripts
 * 
 */

(function() {

  /**************************
   * Config
   * 
   */
  var config = {
    jquery:           '/s/nimbus/jquery.min.js',
    jqueryNoConflict: '/js/nimbus/jquery_noconflict.js',
    modal: {
      js:      '/js/nimbus/bootstrap-modal.js',
      css:     '/js/nimbus/bootstrap-modal.css'
    }
  };


  /**************************
   * Load dependencies & Nimbus
   *
   */

  /*
   * jQuery check
   */
  if (typeof jQuery == 'undefined') {
    async(config.jquery);
    async(config.jqueryNoConflict); // Enable noConflict
  }

  /* Make sure jQuery is loaded before loading rest of script */
  function checkJquery() {
    if (window.jQuery) {
      /*
       * Check Bootstrap modal
       */
      checkBootstrapModal();

      /*
       * Load Nimbus
       */
      loadNimbus();

    } else {
      window.setTimeout(checkJquery, 100);
    }
  }

  checkJquery();


  /**************************
   * Load Nimbus modal & controls
   *
   */
  function loadNimbus() {
    /*
     * Modal HTML
     *
     */
    var modalHtml = [];
    modalHtml.push('<div class="modal fade" id="nimbus-modal-target">');
      modalHtml.push('<div class="modal-dialog">');
        modalHtml.push('<div class="modal-content">');
          modalHtml.push('<div class="modal-header">');
            modalHtml.push('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
          modalHtml.push('</div>');
          modalHtml.push('<div class="modal-body">');
            modalHtml.push('<iframe src="" frameborder="0" width="100%"></iframe>');
          modalHtml.push('</div>');
        modalHtml.push('</div>');
      modalHtml.push('</div>');
    modalHtml.push('</div>');
    
    modalHtml = modalHtml.join('');

    jQuery(document).ready(function($) {
      /*
       * Append modal HTML inside body tag on ducument.ready
       * 
       */
      $('body').append(modalHtml);

      
      /*
       * Apply Bootstrap/Prototype patch
       * 
       */
      bootstrapModalPatch();


      /*
       * Modal open and close
       * 
       */

      /* 
       * Modal open
       * Grab trigger href and use it as iframe src
       */
      $('.nimbus-modal-trigger').on('click', function(e) {
        e.preventDefault();
        var $iframe = $(this).attr('href');

        $('#nimbus-modal-target').modal('show');
        $('#nimbus-modal-target').find('iframe').attr('src', $iframe);
      });

      /* 
       * Modal close
       * Reset the iframe on close
       */
      $('#nimbus-modal-target').on('hidden.bs.modal', function(e) {
        $('#nimbus-modal-target').find('iframe').attr('src', '');
      });
    });
  }


  /**************************
   * Check Bootstrap modal & load modal styles
   *
   */
  function checkBootstrapModal() {
    /* Add modal script */
    if (typeof(jQuery.fn.modal) == 'undefined') {
      async(config.modal.js);
    }

    /* Add Bootstrap modal styles */
    var modalStyles = document.createElement('link');
    
    modalStyles.rel  = 'stylesheet';
    modalStyles.type = 'text/css';
    modalStyles.href = config.modal.css;

    if (typeof modalStyles !== 'undefined')
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('link')[0]).appendChild(modalStyles);
  }


  /**************************
   * Helpers functions
   * 
   */

  /*
   * Provide callback to injected scripts
   */
  function async(u, c) {
    var d = document, t = 'script',
        o = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    o.src = u;
    if (c) { o.addEventListener('load', function (e) { c(null, e); }, false); }
    s.parentNode.insertBefore(o, s);
  }

  /*
   * A patch for Bootstrap to work with Prototype.js
   * http://jsfiddle.net/dgervalle/hhBc6/
   */
  function bootstrapModalPatch() {
    if (Prototype.BrowserFeatures.ElementExtensions) {
      var disablePrototypeJS = function (method, pluginsToDisable) {
        var handler = function (event) {
          event.target[method] = undefined;
          setTimeout(function () {
            delete event.target[method];
          }, 0);
        };
        pluginsToDisable.each(function (plugin) {
          jQuery(window).on(method + '.bs.' + plugin, handler);
        });
      },
      pluginsToDisable = ['modal'];
      disablePrototypeJS('show', pluginsToDisable);
      disablePrototypeJS('hide', pluginsToDisable);
    }
  }

})();