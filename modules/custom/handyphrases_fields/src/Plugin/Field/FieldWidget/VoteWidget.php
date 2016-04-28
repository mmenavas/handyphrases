<?php

/**
 * @file
 * Contains \Drupal\handyphrases_fields\Plugin\Field\FieldWidget\VoteWidget.
 */

namespace Drupal\handyphrases_fields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Plugin implementation of the 'Vote' widget.
 *
 * @FieldWidget(
 *   id = "vote_widget",
 *   label = @Translation("Vote"),
 *   field_types = {
 *     "vote"
 *   }
 * )
 */
class VoteWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $item = $items[$delta];

    $element['vote'] = array(
      '#type' => 'select',
      '#title' => $this->t('Vote'),
      '#default_value' => isset($item->vote) ? $item->vote : 1,
      '#options' => [
        '1' => 'upvote',
        '-1' => 'downvote',
      ],
    );

    $element['uid'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('User ID'),
      '#default_value' => isset($item->uid) ? $item->uid: '',
      '#maxlength' => 64,
    );

    $element['timestamp'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Date'),
      '#default_value' => isset($item->timestamp) ? $item->timestamp : '',
      '#maxlength' => 64,
    );

    return $element;
  }

}
