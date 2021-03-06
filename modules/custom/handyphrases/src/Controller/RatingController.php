<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Controller\RatingController.
 */

namespace Drupal\handyphrases\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\handyphrases\Ajax\VoteCommand;
use Drupal\handyphrases\VoteCountService;

/**
 * Class RatingController.
 *
 * @package Drupal\handyphrases\Controller
 */
class RatingController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;
  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entity_type_manager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Upvote.
   *
   * @return string
   *   Return Hello string.
   */
  public function vote($nid, $op, $method = 'nojs') {

    $selector = ".translation_id_$nid";
    $votes = 0;

    if ($op == 'upvote') {
      $votes = $this->upvote($nid);
    }
    else if ($op = 'downvote') {
      $votes = $this->downvote($nid);
    }

    // Part of graceful degradation, check to see if request method was 'ajax'.
    if ($method == 'ajax') {
      // Create a new AjaxResponse object.
      $response = new AjaxResponse();
      // Create and add instance of custom SlideRemoveCommand.
      $response->addCommand(new VoteCommand($selector, $op, $votes));
      return $response;
    }
    // Non-ajax call to this callback.
    else {
      return [
        '#type' => 'markup',
        '#markup' => $this->t('Unable to perform vote.'),
      ];
    }

  }

  private function upvote($nid) {
    $node = $this->entity_type_manager->getStorage('node')->load($nid);
    
    if (VoteCountService::isVotingDisabled($node)) {
      // Keep user from voting for his own translation or from
      // voting twice for the same translation.
      return;
    }
    
    $user = \Drupal::currentUser();
    $node->get('field_votes')->appendItem([
      'vote' => 1,
      'uid' => $user->id(),
      'timestamp' => REQUEST_TIME,
    ]);
    $node->save();

    $count = VoteCountService::getVoteCount($node, 1);

    return $count;
  }

  private function downvote($nid) {
    $node = $this->entity_type_manager->getStorage('node')->load($nid);

    if (VoteCountService::isVotingDisabled($node)) {
      // Keep user from voting for his own translation or from
      // voting twice for the same translation.
      return;
    }
    
    $user = \Drupal::currentUser();
    $node->get('field_votes')->appendItem([
      'vote' => -1,
      'uid' => $user->id(),
      'timestamp' => REQUEST_TIME,
    ]);
    $node->save();

    $count = VoteCountService::getVoteCount($node, -1);

    return $count;
  }
}

