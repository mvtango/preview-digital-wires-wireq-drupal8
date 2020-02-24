<?php

namespace Drupal\Tests\dpa_digital_wires\Kernel;

use Drupal\Tests\migrate\Kernel\MigrateTestBase;

/**
 * Class WireqHighWaterTest
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 */
class WireqHighWaterTest extends MigrateTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'user',
    'node',
    'field',
    'migrate',
    'migrate_plus',
    'dpa_digital_wires',
//    'wireq_high_water_test',
  ];


  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installSchema('node', 'node_access');
  }

  public function testHighWater() {
    $module_path = drupal_get_path('module', 'wireq_high_water_test');
    $file_source = $module_path . '/data/highwater_newest_first.json';

    $config = \Drupal::configFactory()->getEditable('dpa_digital_wires.settings');
    $config->set('wireq_base_url', $file_source);
    $config->save();

    $this->executeMigration('digital_wires_wireq');
    $this->assertTrue($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));

    //    $file_source = $module_path . '/data/highwater_newest_last.json';
  }


  /**
   * Checks if node with given title exists.
   *
   * taken from \Drupal\Tests\migrate\Kernel\HighWaterTest
   *
   * @param string $title
   *   Title of the node.
   *
   * @return bool
   */
  protected function nodeExists($title) {
    $query = \Drupal::entityQuery('node');
    $result = $query
      ->condition('title', $title)
      ->range(0, 1)
      ->execute();
    return !empty($result);
  }
}
