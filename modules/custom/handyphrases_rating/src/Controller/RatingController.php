<?php

/**
 * @file
 * Contains \Drupal\handyphrases_rating\Controller\RatingController.
 */

namespace Drupal\handyphrases_rating\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\handyphrases_rating\Ajax\VoteCommand;

/**
 * Class RatingController.
 *
 * @package Drupal\handyphrases_rating\Controller
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

    $selector = "#translation-$nid-vote-count";
    $votes = 0;

    if ($op == 'upvote') {
      $votes = $this->upVote($nid);
    }
    else if ($op = 'downvote') {
      $votes = $this->downVote($nid);
    }

    // Part of graceful degradation, check to see if request method was 'ajax'.
    if ($method == 'ajax') {
      // Create a new AjaxResponse object.
      $response = new AjaxResponse();
      // Create and add instance of custom SlideRemoveCommand.
      $response->addCommand(new VoteCommand($selector, $votes));
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

  private function upVote($nid) {
    $node = $this->entity_type_manager->getStorage('node')->load($nid);
    $votes = isset($node->get('field_votes')->value) ? $node->get('field_votes')->value : 0;
    $node->set('field_votes', ++$votes);
    $node->save();

    return $votes;
  }

  private function downVote($nid) {
    $node = $this->entity_type_manager->getStorage('node')->load($nid);
    $votes = isset($node->get('field_votes')->value) ? $node->get('field_votes')->value : 0;
    $node->set('field_votes', --$votes);
    $node->save();

    return $votes;
  }
}

