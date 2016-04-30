<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Plugin\Field\FieldType\Vote.
 */

namespace Drupal\handyphrases\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;


/**
 * Plugin implementation of the 'vote' field type.
 *
 * @FieldType(
 *   id = "vote",
 *   label = @Translation("Vote"),
 *   description = @Translation("A compound fields to store vote metadata."),
 *   default_widget = "vote_widget",
 *   default_formatter = "vote_formatter"
 * )
 */
class Vote extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'vote' => array(
          'type' => 'int',
          'size' => 'tiny'
        ),
        'uid' => array(
          'type' => 'int',
          'unsigned' => TRUE,
        ),
        'timestamp' => array(
          'type' => 'int',
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // This is called very early by the user entity roles field. Prevent
    // early t() calls by using the TranslatableMarkup.
    $properties['vote'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Vote'))
      ->setRequired(TRUE);

    $properties['uid'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('User ID'))
      ->setRequired(TRUE);

    $properties['timestamp'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Timestamp'))
      ->setRequired(TRUE);
    
    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('uid')->getValue();
    return $value === NULL || $value === '';
  }

}
