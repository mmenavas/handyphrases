<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Plugin\Field\FieldFormatter\TranslationsFormatter.
 */

namespace Drupal\handyphrases\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\handyphrases\VoteCountService;

/**
 * Plugin implementation of the 'translations_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "translations_formatter",
 *   label = @Translation("Translations Formatter"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class TranslationsFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    // Prepare render arrays
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $elements[$delta] = array(
        '#theme' => 'translation_item',
        '#nid' => $entity->id(),
        '#translation' => $entity->getTitle(),
        '#votes' => VoteCountService::getVoteCount($entity),
        '#timestamp' => $entity->getCreatedTime(),
        '#cache' => [
          'tags' => ['node:' . $entity->id()],
        ],
      );
    }

    // sort by Votes using anonymous function
    usort($elements, function($a, $b) {
      $diff = $b['#votes'] - $a['#votes'];
      if ($diff == 0) {
        $diff = $a['#timestamp'] - $b['#timestamp'];
      }
      return $diff;
    });
    
    return $elements;
  }

}
