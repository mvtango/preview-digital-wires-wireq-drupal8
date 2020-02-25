<?php

namespace Drupal\wireq_high_water_test\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_plus\Plugin\migrate\source\Url;

/**
 * Provides a 'WireqSource' test source, which doesn't read configuration
 *
 * @MigrateSource(
 *  id = "wireq_test_source",
 *  source_module = "dpa_digital_wires"
 * )
 */

class WireqTestSource extends \Drupal\dpa_digital_wires\Plugin\migrate\source\WireqSource {

  public function __construct( array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration ) {
      Url::__construct($configuration, $plugin_id, $plugin_definition, $migration);
  }
}
