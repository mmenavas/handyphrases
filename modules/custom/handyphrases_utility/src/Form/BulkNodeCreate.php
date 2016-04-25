<?php

/**
 * @file
 * Contains \Drupal\handyphrases_utility\Form\BulkNodeCreate.
 */

namespace Drupal\handyphrases_utility\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Symfony\Component\Yaml\Yaml;
use Drupal\node\Entity\Node;

/**
 * Class BulkNodeCreate.
 *
 * @package Drupal\handyphrases_utility\Form
 */
class BulkNodeCreate extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'handyphrases_utility_bulk_node_create';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $contentTypes = \Drupal::service('entity.manager')->getStorage('node_type')->loadMultiple();

    $contentTypesList = [];
    foreach ($contentTypes as $contentType) {
      $contentTypesList[$contentType->id()] = $contentType->label();
    }

    $form['node_titles'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Node Titles'),
      '#description' => $this->t('Enter a list of titles in YAML format. That means every line must start with a hyphen and a space followed by the title.'),
      '#default_value' => ''
    );
    $form['content_type'] = array(
      '#type' => 'select',
      '#title' => $this->t('Content Type'),
      '#description' => $this->t('Select the content type of the nodes you want to create'),
      '#options' => $contentTypesList,
      '#default_value' => 'meltmedia'
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Create Nodes')
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


    $titles_raw = $form_state->getValue('node_titles');
    $content_type = $form_state->getValue('content_type');

    if ($titles_raw) {
      $titles = Yaml::parse($titles_raw);
    }

    if (!empty($titles)) {
      foreach($titles as $title) {
        $node = Node::create(array(
          'title' => $title,
          'type' => $content_type,
          'uid' => '1',
          'status' => 1,
        ));

        $node->save();

        if ($node->getType() == $content_type) {
          drupal_set_message(t("%title node has been created.", array('%title' => $title)), 'status');
        }

      }
    }

  }

}
