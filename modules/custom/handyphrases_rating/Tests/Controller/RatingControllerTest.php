<?php

/**
 * @file
 * Contains \Drupal\handyphrases_rating\Tests\RatingController.
 */

namespace Drupal\handyphrases_rating\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Provides automated tests for the handyphrases_rating module.
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
      'name' => "handyphrases_rating RatingController's controller functionality",
      'description' => 'Test Unit for module handyphrases_rating and controller RatingController.',
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
   * Tests handyphrases_rating functionality.
   */
  public function testRatingController() {
    // Check that the basic functions of module handyphrases_rating.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
