<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Form\BulkTaxonomyTermCreateForm .
 */

namespace Drupal\handyphrases\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Symfony\Component\Yaml\Yaml;
use Drupal\taxonomy\Entity\Term;

/**
 * Class BulkTaxonomyTermCreateForm.
 *
 * @package Drupal\handyphrases\Form
 */
class BulkTaxonomyTermCreateForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'handyphrases_taxonomy_create_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $vocabularies = \Drupal::service('entity.manager')->getStorage('taxonomy_vocabulary')->loadMultiple();

    $vocabulariesList = [];
    foreach ($vocabularies as $vocabulary) {
      $vocabulariesList[$vocabulary->id()] = $vocabulary->label();
    }

    $form['terms'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Terms'),
      '#description' => $this->t('Enter a list of terms in YAML format. That means every line must start with a hyphen and a space followed by the term.'),
      '#default_value' => ''
    );
    $form['vocabulary'] = array(
      '#type' => 'select',
      '#title' => $this->t('Vocabulary'),
      '#description' => $this->t('Select the vocabularies of the terms you want to create'),
      '#options' => $vocabulariesList,
      '#default_value' => 'categories'
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Create Terms')
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

    $names_raw = $form_state->getValue('terms');
    $vocabulary = $form_state->getValue('vocabulary');

    if ($names_raw) {
      $names = Yaml::parse($names_raw);
    }

    if (!empty($names)) {
      foreach($names as $name) {
        $term = Term::create(array(
          'name' => $name,
          'vid' => $vocabulary,
        ));

        $term->save();

        if ($term->getVocabularyId() == $vocabulary) {
          drupal_set_message(t("%name term has been created.", array('%name' => $name)), 'status');
        }

      }
    }

  }

}
