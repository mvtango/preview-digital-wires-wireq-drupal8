<?php


namespace Drupal\Tests\dpa_digital_wires\Kernel;


use Drupal\Core\DependencyInjection\ServiceModifierInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\Tests\migrate\Kernel\MigrateTestBase;

/**
 * Class WireqTestBase
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 */
class WireqTestBase extends MigrateTestBase implements ServiceModifierInterface {

  /*
   * By default, Drupal does not allow http requests in kernel tests.
   * Via the ServiceModifierInterface it is possible to remove the middleware used in tests
   * which prevents the http requests from being made.
   * see https://www.drupal.org/project/drupal/issues/2571475 for more details
   */
  public function alter(ContainerBuilder $container) {
    $container->removeDefinition('test.http_client.middleware');
  }

  
  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'user',
    'node',
    'file',
    'field',
    'image',
    'media',
    'migrate',
    'migrate_plus',
    'migrate_file',
    'dpa_digital_wires',
    'wireq_high_water_test',
    'path',
    'datetime',
    'media_library',
    'text',
    'taxonomy',
    'menu_ui',
    'language',
    'views',
  ];


  protected function setUp() {
    parent::setUp();
    $this->installConfig('system');
    $this->installConfig('wireq_high_water_test');
    $this->installConfig('media');
    $this->installConfig('media_library');
    $this->installConfig('node');
    $this->installConfig('field');
    $this->installConfig('views');
    $this->installConfig('user');
    $this->installEntitySchema('node');
    $this->installEntitySchema('file');
    $this->installEntitySchema('media');
    $this->installEntitySchema('user');
    $this->installEntitySchema('path_alias');
    $this->installSchema('node', 'node_access');
    $this->installSchema('file','file_usage');
    $this->installSchema('dpa_digital_wires','dpa_digital_wires_attachments_lookup');
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
