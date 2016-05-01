<?php

/**
 * @file
 * Contains \Drupal\handyphrases\VoteCountService.
 */

namespace Drupal\handyphrases;


/**
 * Class VoteCountService.
 *
 * @package Drupal\handyphrases
 */
class VoteCountService {

  /**
   * Calculate the voting score
   * 
   * @param $translation Node entity
   * @return int
   */
  public static function getVoteCount($node, $vote) {
    $count = 0;
    $field = $node->get('field_votes');

    foreach ($field->getValue() as $delta => $item) {
      if ($item['vote'] == $vote) {
        $count++;
      }
    }

    return $count;
  }
  
  public static function isVotingDisabled($node) {
    $isDisabled = FALSE;
    $user = \Drupal::currentUser();
    
    // Keep translation author from voting on his own translation
    if ($node->getOwnerId() == $user->id()) {
      return TRUE;
    }
      
    $field = $node->get('field_votes');
    
    foreach ($field->getValue() as $delta => $item) {
      if ($item['uid'] == $user->id()) {
        $isDisabled = TRUE;
        continue;
      }
    }
    
    return $isDisabled;

  }

}
