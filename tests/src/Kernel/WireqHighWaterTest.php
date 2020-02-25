<?php

namespace Drupal\Tests\dpa_digital_wires\Kernel;

use Drupal\migrate\MigrateExecutable;
use Drupal\migrate\Plugin\MigrationInterface;
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


  public function testHighWater() {
    $migration = $this->getMigration('digital_wires_wireq');
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path('module', 'wireq_high_water_test');

    $file_source = $module_path . '/data/highwater_newest_first.json';
    $source_config['urls'] = $file_source;

    $migration->set('source', $source_config);
    $this->executeMigration($migration);
    $this->assertTrue($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));
    (new MigrateExecutable($migration))->rollback();
    $this->assertFalse($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));

    $file_source = $module_path . '/data/highwater_newest_last.json';
    $source_config['urls'] = $file_source;
    $this->executeMigration($migration);
    $this->assertTrue($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));
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
