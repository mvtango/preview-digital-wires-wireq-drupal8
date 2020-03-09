<?php


namespace Drupal\Tests\dpa_digital_wires\Kernel;


use Drupal\migrate\MigrateExecutable;
use Drupal\node\Entity\Node;
use Drupal\Tests\BrowserTestBase;

/**
 * Class WireqMediaDeduplicationTest
 *
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 * @group dpa_digital_wires
 */
class WireqMediaDeduplicationTest extends WireqTestBase {

  protected function setUp() {
    parent::setUp();
    $this->installConfig('dpa_digital_wires');
    $this->installConfig('wireq_high_water_test');
    $storage = \Drupal::entityTypeManager()->getStorage('user');
    // Insert a row for the anonymous user.
    $storage
      ->create([
        'uid' => 0,
        'status' => 0,
        'name' => '',
      ])
      ->save();
  }


  public function testUpdate() {
    $migration = $this->getMigration( 'digital_wires_wireq' );
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path( 'module', 'dpa_digital_wires' );

    $file_source = $module_path . '/tests/data/media_duplicates_step_1.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration($migration);
    //we should now have exactly one node.
    $query = \Drupal::entityQuery('node');
    $result = $query
      ->execute();
    $this->assertEqual(count($result),1);
    $node_id=array_values($result)[0];

    $query = \Drupal::entityQuery('media');
    $result = $query->execute();
    $this->assertEqual(count($result),1);


    $file_source = $module_path . '/tests/data/media_duplicates_step_2.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration($migration);
    $query = \Drupal::entityQuery('node');
    $result = $query
      ->execute();
    $this->assertEqual(count($result),1);
    $new_node_id=array_values($result)[0];
    $this->assertEqual($node_id,$new_node_id);
    $node = Node::load($new_node_id);
    $this->assertEqual($node->title->getValue()[0]['value'],"Berlinale: Konfrontation mit der Vergangenheit - Version 2");

    $query = \Drupal::entityQuery('media');
    $result = $query->execute();
    $this->assertEqual(count($result),1);

  }
}
