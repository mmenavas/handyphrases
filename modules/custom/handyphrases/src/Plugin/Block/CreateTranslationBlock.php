<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Plugin\Block\CreateTranslationBlock.
 */

namespace Drupal\handyphrases\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'CreateTranslationBlock' block.
 *
 * @Block(
 *  id = "create_translation_block",
 *  admin_label = @Translation("Create Translation Block"),
 * )
 */
class CreateTranslationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('Drupal\handyphrases\Form\CreateTranslationForm');

    return $form;
  }
}
