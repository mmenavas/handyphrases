<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Form\CreateTranslationForm.
 */

namespace Drupal\handyphrases\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\node\Entity\Node;

/**
 * Class CreateTranslationForm
 *
 * @package Drupal\handyphrases\Form
 */
class CreateTranslationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'handyphrases_translation_create_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['translation'] = array(
      '#type' => 'textfield',
      '#default_value' => '',
      '#required' => TRUE
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save')
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $node = \Drupal::routeMatch()->getParameter('node');
    $node_type = $node->getType();
    $nid = $node->id();
    $title = $form_state->getValue('translation');

    if ($title && $node_type == 'phrase') {

      $translation = Node::create(array(
        'title' => $title,
        'type' => 'translation',
        'status' => 1,
      ));
      $translation->save();

      if ($translation->id()) {
        $node->get('field_translations')->appendItem($translation->id());
        $node->save();
        drupal_set_message(t("Thanks for your contributing."), 'status');
      }

    }

  }

}
