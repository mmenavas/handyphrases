(function ($, window, Drupal, drupalSettings) {

  'use strict';

  /**
   * Command to slide up content before removing it from the page.
   *
   * @param {Drupal.Ajax} [ajax]
   * @param {object} response
   * @param {string} response.selector
   * @param {string} response.votes
   * @param {object} [response.settings]
   * @param {number} [status]
   */
  Drupal.AjaxCommands.prototype.vote = function(ajax, response, status){
    // Get votes if sent, else use default of 0.
    var votes = response.votes ? response.votes : 0;
    // Retrieve settings (copying what core remove command does).
    var settings = response.settings || ajax.settings || drupalSettings;
    // Target all elements that match returned selector.
    $(response.selector).text(response.votes);
  }

})(jQuery, this, Drupal, drupalSettings);