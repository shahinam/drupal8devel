/**
 * @file
 * Assets Test behaviours.
 */

/**
 * We should have core/drupal set as dependency to attach any behaviors.
 *
 * Not sure about core/drupalSetting - everything seems to be ok even without it.
 * EDIT: got it, loaded with core/drupal.
 */
(function ($) {
  "use strict";

  /**
   * Add class to each element on click.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach.
   *   Attaches the behavior for list of items.
   */
  Drupal.behaviors.assetsTestList = {
    attach: function(context, settings) {
      var $listItem = $('.list-item');
      var append = settings.assets_test.append;
      $listItem.click(function() {
        var $this = $(this);
        $this.addClass('clicked');
        $this.append(append);
      });
    }
  };

})(jQuery);
