(function ($, window, Drupal, drupalSettings) {

  'use strict';

  /**
   * Command to slide up content before removing it from the page.
   *
   * @param {Drupal.Ajax} [ajax]
   * @param {object} response
   * @param {string} response.selector
   * @param {string} response.op
   * @param {string} response.votes
   * @param {object} [response.settings]
   * @param {number} [status]
   */
  Drupal.AjaxCommands.prototype.vote = function(ajax, response, status){

    if (!response.votes)
      return;

    if (!response.op)
      return;

    // Vote count selector
    var votesSelector = response.selector + " .vote_type_" + response.op + " .vote__count";

    // Wrapper for button
    var buttonWrapperSelector = '.vote__button-wrapper';

    // Update vote count
    $(votesSelector).text(response.votes);
    $(buttonWrapperSelector).each(function (index) {
      var icon = $('a', this).html()
      // Replace anchor with plain icon
      $(this).html(icon);
    });

  }

})(jQuery, this, Drupal, drupalSettings);