<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
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

  /**
   * Save the new high water mark.
   *
   * @param int $high_water
   *   The high water timestamp.
   *
   * @throws \Exception
   */
  protected function saveHighWater( $high_water ) {
    $high_water_datetime  = new \DateTime( $high_water );
    $high_water_timestamp = $high_water_datetime->getTimestamp();
    $this->getHighWaterStorage()->set( $this->migration->id(), $high_water_timestamp );
  }

  /**
   * Check if the incoming data is newer than what we've previously imported.
   *
   * @param \Drupal\migrate\Row $row
   *   The row we're importing.
   *
   * @return bool
   *   TRUE if the highwater value in the row is greater than our current value.
   *
   * @throws \Exception
   */
  protected function aboveHighwater( Row $row ) {
    $row_date           = new \DateTime( $row->getSourceProperty( $this->highWaterProperty['name'] ) );
    $row_timestamp      = $row_date->getTimestamp();
    $previous_timestamp = $this->getHighWaterStorage()->get( $this->migration->id() );
    return $this->getHighWaterProperty() && $row_timestamp > $previous_timestamp;
  }

}
