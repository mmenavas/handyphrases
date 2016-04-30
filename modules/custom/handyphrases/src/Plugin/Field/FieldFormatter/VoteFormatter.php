<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Plugin\Field\FieldFormatter\VoteFormatter.
 */

namespace Drupal\handyphrases\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'vote_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "vote_formatter",
 *   label = @Translation("Vote formatter"),
 *   field_types = {
 *     "vote"
 *   }
 * )
 */
class VoteFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'vote',
        '#vote' => $item->vote,
        '#uid' => $item-uid, // TODO: Load user entity
        '#timestamp' => $item->timestamp, //TODO: Format timestamp
      );
    }

    return $elements;
  }

}
