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
  public static function getVoteCount($translation) {
    $count = 0;
    $field = $translation->get('field_votes');

    foreach ($field->getValue() as $delta => $item) {
      $count = $count + intval($item['vote']);
    }

    return $count;
  }

}
