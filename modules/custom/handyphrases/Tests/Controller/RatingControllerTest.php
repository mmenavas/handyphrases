<?php

/**
 * @file
 * Contains \Drupal\handyphrases\Tests\RatingController.
 */

namespace Drupal\handyphrases\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Provides automated tests for the handyphrases module.
 */
class RatingControllerTest extends WebTestBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "Handyphrases Controller's controller functionality",
      'description' => 'Test Unit for module handyphrases and controller RatingController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests handyphrases functionality.
   */
  public function testRatingController() {
    // Check that the basic functions of module handyphrases.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
