<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_plus\Plugin\migrate\source\Url;

/**
 * Provides a 'WireqSource' migrate source.
 *
 * @MigrateSource(
 *  id = "wireq_source",
 *  source_module = "dpa_digital_wires"
 * )
 */
class WireqSource extends Url {

  public function __construct( array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration ) {
    parent::__construct( $configuration, $plugin_id, $plugin_definition, $migration );
  }
}
