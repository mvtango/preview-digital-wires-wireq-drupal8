<?php


namespace Drupal\Tests\dpa_digital_wires\Kernel;


use Drupal\node\Entity\Node;

/**
 * Class WireqStatusTest
 *
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 * @group dpa_digital_wires
 */
class WireqStatusTest extends WireqTestBase {

  public function testPublish() {
    $this->config('dpa_digital_wires.settings')->set('publishing_status','Publish')->save();
    $migration = $this->getMigration( 'digital_wires_wireq' );
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path( 'module', 'dpa_digital_wires' );

    $file_source = $module_path . '/tests/data/highwater_newest_first.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration($migration);
    $query = \Drupal::entityQuery('node');
    $result = $query
      ->execute();
    $this->assertEqual(count($result),1);
    $node_id=array_values($result)[0];

    $node = Node::load($node_id);
    $this->assertEqual($node->status->getValue()[0]['value'],1);
  }

  public function testDraft() {
    $this->config('dpa_digital_wires.settings')->set('publishing_status','Draft')->save();
    $migration = $this->getMigration( 'digital_wires_wireq' );
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path( 'module', 'dpa_digital_wires' );

    $file_source = $module_path . '/tests/data/highwater_newest_first.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration($migration);
    $query = \Drupal::entityQuery('node');
    $result = $query
      ->execute();
    $this->assertEqual(count($result),1);
    $node_id=array_values($result)[0];

    $node = Node::load($node_id);
    $this->assertEqual($node->status->getValue()[0]['value'],0);
  }
}
