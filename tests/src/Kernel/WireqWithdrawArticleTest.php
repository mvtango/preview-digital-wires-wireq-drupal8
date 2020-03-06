<?php


namespace Drupal\Tests\dpa_digital_wires\Kernel;

use Drupal\migrate\MigrateExecutable;

/**
 * Class WireqWithdrawArticleTest
 * @package Drupal\Tests\dpa_digital_wires\Kernel
 * @group dpa_digital_wires
 */
class WireqWithdrawArticleTest extends WireqTestBase {

  public function testArticleWithdrawal() {
    $migration = $this->getMigration( 'digital_wires_wireq' );
    $source_config = $migration->getSourceConfiguration();
    $module_path = drupal_get_path( 'module', 'dpa_digital_wires' );

    $file_source = $module_path . '/tests/data/pubstatus.json';
    $source_config['urls'] = $file_source;

    $migration->set( 'source', $source_config );
    $this->executeMigration( $migration );
    $this->assertTrue( $this->nodeExists( 'ACHTUNG! Zurückgezogen! - Artikel: canceled' ) );
  }

}
