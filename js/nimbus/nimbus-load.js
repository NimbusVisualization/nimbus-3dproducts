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

  var base_url = '';
  var nimbus_uuid = null;

  if (nimbus_base_url) {
    base_url = nimbus_base_url;
  }

  var config = {
    jquery:           base_url + '/js/nimbus/jquery.min.js',
    jqueryNoConflict: base_url + '/js/nimbus/jquery_noconflict.js',
    uuid_gen:         base_url + '/js/nimbus/uuid.js',
    js_cookie:        base_url + '/js/nimbus/js_cookie.js',
    modal: {
      js:      base_url + '/js/nimbus/vanilla-modal.min.js',
      css:     base_url + '/js/nimbus/nimbus-modal.css'
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

  async(config.uuid_gen, function(){
    async(config.js_cookie, function(){
      var NimbusCookies = Cookies.noConflict();
      retrieved_cookie = NimbusCookies.get('nimbus_user');

      if (retrieved_cookie == null)
      {
        retrieved_cookie = uuid.v4();
        NimbusCookies.set('nimbus_user', retrieved_cookie); // TODO: add 'path' and 'expires' options to cookie
      }

      nimbus_uuid = retrieved_cookie;
    });
  });

  /* Make sure jQuery is loaded before loading rest of script */
  function checkJquery() {
    if (window.jQuery) {
      
      loadModalAssets();

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

    /* Write modal html */
    modalHtml.push('<div id="nimbus-modal-target" class="nimbus-modal">');
      modalHtml.push('<div class="nimbus-modal-inner modal-dialog">');
        modalHtml.push('<div class="nimbus-modal-content"></div>');
      modalHtml.push('</div>');
    modalHtml.push('</div>');
    modalHtml.push('<div id="nimbus-modal-1" style="display:none">');
      modalHtml.push('<a rel="modal:close" class="close">&times;</a>');
      modalHtml.push('<iframe id="nimbus-iframe" scrolling="no" frameborder="0" width="100%" height="100%"></iframe>');
    modalHtml.push('</div>');
    modalHtml.push('<div class="modal-backdrop fade" style="z-index: -1"></div>');

    modalHtml = modalHtml.join('');

    /*
     * Append modal HTML inside body tag
     *
     */
    jQuery('body').append(modalHtml);

    jQuery('.nimbus-modal-trigger').click(function(e) {
      e.preventDefault();
    });

    // Initialize modal
    // Instantiate Vanilla Modal
    const nimbus_modal = new vanillaModal.VanillaModal({
      modal: '.nimbus-modal',
      modalInner: '.nimbus-modal-inner',
      modalContent: '.nimbus-modal-content',
      onBeforeOpen : function(e) {
        jQuery('#nimbus-modal-1').css({ display: 'block' });
        jQuery('#nimbus-iframe').attr('src', jQuery('.nimbus-modal-trigger').data('url'));
        jQuery('#nimbus-modal-target').addClass('modal-open');
        jQuery('.modal-backdrop').addClass('in').css('z-index', 1040);
      },
      onClose : function(e) {
        jQuery('#nimbus-modal-1').css({ display: 'none' });
        jQuery('#nimbus-iframe').attr('src', '');
        jQuery('#nimbus-modal-target').removeClass('modal-open');
        jQuery('.modal-backdrop').removeClass('in').css('z-index', -1);
      }
    });
  }


  /**************************
   * Load modal script and stylesheet
   *
   */
  function loadModalAssets()
  {
    /* Load modal styles */
    var styles = document.createElement('link');

    styles.rel  = 'stylesheet';
    styles.type = 'text/css';
    styles.href = config.modal.css;

    if (typeof styles !== 'undefined')
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('link')[0]).appendChild(styles);

    /*
     * Load Vanilla Modal script
     *
     * https://github.com/thephuse/vanilla-modal
     */
    async(config.modal.js, loadNimbus);
  }

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

})();
