<?php
/**
 * @file
 * Contains \Drupal\handyphrases\Ajax\VoteCommand.php
 */
namespace Drupal\handyphrases\Ajax;

use Drupal\Core\Ajax\CommandInterface;

/**
 * An AJAX command for up voting Translation node.
 *
 * @ingroup ajax
 */
class VoteCommand implements CommandInterface {
  /**
   * A CSS selector string.
   *
   * If the command is a response to a request from an #ajax form element then
   * this value can be NULL.
   *
   * @var string
   */
  protected $selector;
  /**
   * Operation (upvote or downvote)
   *
   * @var string|integer
   */
  protected $op;
  /**
   * Number of votes
   *
   * @var string|integer
   */
  protected $votes;
  /**
   * Constructs an VoteCommand object.
   *
   * @param string $selector
   *   A CSS selector.
   * @param integer $votes
   *   The votes count.
   */
  public function __construct($selector = '', $op = '' , $votes = 0) {
    $this->selector = $selector;
    $this->op = $op;
    $this->votes = $votes;
  }
  /**
   * Implements Drupal\Core\Ajax\CommandInterface:render().
   */
  public function render() {
    // Render method must return an associative array.
    return array(
      // Must return element with key 'command'. Value is name of JavaScript
      // method to run.
      'command' => 'vote',
      // All other elements will be returned as part of the response argument.
      'selector' => $this->selector,
      'op' => $this->op,
      'votes' => $this->votes,
    );
  }
}