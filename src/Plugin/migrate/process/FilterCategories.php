<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Provides a 'FilterCategories' migrate process plugin.
 *
 * @MigrateProcessPlugin(
 *  id = "dpa_filter_categories",
 *   handle_multiples=true
 * )
 */
class FilterCategories extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $return = [];
    if ($value) {
      foreach ( $value as $element ) {
        $type = $this->configuration['filter_type'];
        if ( $element['type'] == $type ) {
          $return[] = $element['name'];
        }
      }
    }
    return $return;
  }

  public function multiple() {
    return true;
  }


}
