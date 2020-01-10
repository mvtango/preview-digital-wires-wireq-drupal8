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

    // TODO: error handling
    $url = \Drupal::config('dpa_digital_wires.settings')->get('wireq_base_url');
    $configuration['urls'] = array($url . 'entries.json');

    parent::__construct( $configuration, $plugin_id, $plugin_definition, $migration );
  }

}
