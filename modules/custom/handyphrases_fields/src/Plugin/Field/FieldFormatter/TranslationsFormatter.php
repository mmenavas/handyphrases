<?php

/**
 * @file
 * Contains \Drupal\handyphrases_fields\Plugin\Field\FieldFormatter\TranslationsFormatter.
 */

namespace Drupal\handyphrases_fields\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;

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
        '#votes' => isset($entity->get('field_votes')->value) ? $entity->get('field_votes')->value : 0,
        '#timestamp' => $entity->getCreatedTime(),
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
