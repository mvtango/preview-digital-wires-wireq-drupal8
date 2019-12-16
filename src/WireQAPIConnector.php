<?php


namespace Drupal\dpa_digital_wires;


class WireQAPIConnector {

  public function __construct() {

    $config = \Drupal::config('dpa_digital_wires.settings');
    $this->base_url = $config->get('wireq_base_url');
    $this->publishing_state = $config->get('publishing_state');
  }


  /**
   * Get entries, which makes them invisble for approximately 30s
   */
  public function fetchEntries() {
  }

  /**
   * Remove entry from the queue
   *
   * @param int $receipt
   */
  public function deleteEntry(int $receipt) {
  }
}
