<?php


namespace Drupal\dpa_digital_wires;


class WireQAPIConnector {

  public function __construct(string $base_url = null) {
    if ( is_null($base_url) ) {
      $config = \Drupal::config( 'dpa_digital_wires.settings' );
      $this->base_url         = $config->get( 'wireq_base_url' );
      $this->publishing_state = $config->get( 'publishing_state' );
    } else {
      $this->base_url = $base_url;
    }
  }


  /**
   * Get entries, which makes them invisble for approximately 30s
   */
  public function fetchEntries() {
    $url = $this->base_url . 'entries.json';
    $response = \Drupal::httpClient()->get($url);
    return $response;
  }

  public function fetchEndpoint() {
    return $this->fetchEntries();
  }

  /**
   * Remove entry from the queue
   *
   * @param string $receipt
   */
  public function deleteEntry(string $receipt) {
    // receipt is the json field named '_wireq_receipt'
    $url = $this->base_url . '/entries/' . $receipt;
    $response = \Drupal::httpClient()->post($url);
  }
}
