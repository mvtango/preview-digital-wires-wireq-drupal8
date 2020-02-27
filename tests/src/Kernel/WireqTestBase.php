<?php


namespace Drupal\Tests\dpa_digital_wires\Kernel;


use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\Tests\migrate\Kernel\MigrateTestBase;

/**
 * Class WireqTestBase
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 */
class WireqTestBase extends MigrateTestBase {

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
    'wireq_high_water_test',
  ];


  protected function setUp() {
    parent::setUp();
    $this->installConfig('wireq_high_water_test');

    $this->installEntitySchema('node');
    $this->installEntitySchema('user');
    $this->installSchema('node', 'node_access');
  }


  protected function prepareMigration( MigrationInterface $migration ) {
    $source_config = $migration->getSourceConfiguration();
    $source_config['data_fetcher_plugin'] = 'file';
    $source_config['plugin'] = 'wireq_test_source';
    $migration->set('source', $source_config);
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
