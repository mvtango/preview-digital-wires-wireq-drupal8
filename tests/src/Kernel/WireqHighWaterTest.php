<?php

namespace Drupal\Tests\dpa_digital_wires\Kernel;

use Drupal\migrate\MigrateExecutable;

/**
 * Class WireqHighWaterTest
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 */
class WireqHighWaterTest extends WireqTestBase {

  public function testHighWater() {
    $migration = $this->getMigration( 'digital_wires_wireq' );
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path( 'module', 'wireq_high_water_test' );

    $file_source = $module_path . '/data/highwater_newest_first.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration($migration);
    $this->assertTrue($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));
    (new MigrateExecutable($migration))->rollback();
    $this->assertFalse($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));

    $file_source = $module_path . '/data/highwater_newest_last.json';
    $source_config['urls'] = $file_source;
    $this->executeMigration($migration);
    $this->assertTrue($this->nodeExists('Berlinale: Konfrontation mit der Vergangenheit - Version 2'));
  }

}
