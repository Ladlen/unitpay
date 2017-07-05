/**
 * @file
 * Loads content of blocks via AJAX just after page loading, updates Drupal.settings, reattaches behaviors.
 */

(function ($) {

Drupal.ajaxblocksSendRequest = function (request, delay) {
  if (delay) {
    setTimeout(function () { Drupal.ajaxblocksSendRequest(request, 0); }, delay);
    return;
  }
  $.ajax({
    url: ((typeof Drupal.settings.ajaxblocks_path !== 'undefined') ? Drupal.settings.ajaxblocks_path : (Drupal.settings.basePath + "ajaxblocks")),
    type: "GET",
    dataType: "json",
    data: request + '&nocache=1',
    cache: false,
    success: function (data) {
      // Replaces the placeholder divs by the actual block contents returned by the AJAX call,
      // executes the extra JavaScript code and attach behaviours if the apply to the blocks.
      Drupal.freezeHeight();
      for (var id in data) {
        Drupal.ajaxblocksSetBlockContent(id, data[id]);
      }
      Drupal.unfreezeHeight();
    }
  });
};

Drupal.ajaxblocksSetBlockContent = function (id, data) {
  if (data['delay']) {
    setTimeout(function () {data['delay'] = 0; Drupal.ajaxblocksSetBlockContent(id, data);}, data['delay']);
    return;
  }
  var wrapper = $('#block-' + id + '-ajax-content');
  if (!wrapper) {
    return;
  }
  var context = wrapper.parent();
  Drupal.detachBehaviors(context);
  if (!context) {
    return;
  }
  $('#block-' + id).addClass('ajaxblocks-loaded');
  context.html(data['content']);
  if (data['ajaxblocks_settings']) {
    $.extend(true, Drupal.settings, data['ajaxblocks_settings']);
  }
  Drupal.attachBehaviors(context);
};

$(document).ready(function () {
  if (typeof Drupal.settings.ajaxblocks !== 'undefined') {
    Drupal.ajaxblocksSendRequest(Drupal.settings.ajaxblocks, Drupal.settings.ajaxblocks_delay);
  }
});

$(window).load(function () {
  if (typeof Drupal.settings.ajaxblocks_late !== 'undefined') {
    Drupal.ajaxblocksSendRequest(Drupal.settings.ajaxblocks_late, Drupal.settings.ajaxblocks_late_delay);
  }
});

})(jQuery);
;
(function ($) {

Drupal.behaviors.qt_ui_tabs = {
  attach: function (context, settings) {

    $('.quicktabs-ui-wrapper').once('qt-ui-tabs-processed', function() {
      var id = $(this).attr('id');
      var qtKey = 'qt_' + id.substring(id.indexOf('-') +1);
      if (!settings.quicktabs[qtKey].history) {
        $(this).tabs();
      }
      else {
        $(this).tabs({event: 'change'});
        Drupal.quicktabsBbq($(this), 'ul.ui-tabs-nav a');
      }
    });

  }
}

})(jQuery);
;
