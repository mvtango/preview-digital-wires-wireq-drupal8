<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\migrate\process\FormatDate;
use Drupal\migrate\Row;

/**
 * Class FormatDateExtended
 * @package Drupal\dpa_digital_wires\Plugin\migrate\process
 *
 * @MigrateProcessPlugin(
 *   id = "format_date_extended"
 * )
 *
 * Extends Drupal's migrate plugin 'format_date'.
 *
 * Allows to leave the 'from_timezone' empty and let php's DateTime class
 * to guess the provided timezone, because 'format_date' uses the system's
 * timezone and falls back to UTC if none is supplied.
 *
 *
 */
class FormatDateExtended extends FormatDate {

  public function transform( $value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property ) {

    if (empty($this->configuration['from_timezone'])) {
      $date = \DateTime::createFromFormat($this->configuration['from_format'], $value);
      $this->configuration['from_timezone'] = $date->getTimezone();
    }

    return parent::transform( $value, $migrate_executable, $row, $destination_property );
  }

}
