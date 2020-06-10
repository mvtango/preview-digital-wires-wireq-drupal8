<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate_plus\data_parser;

use Drupal\migrate_plus\DataParserPluginBase;
use Drupal\migrate_plus\Plugin\migrate_plus\data_parser\Json;

/**
* Provides a 'Wireq' data parser plugin.
*
* @DataParser(
*  id = "wireq",
*  title = @Translation("wireq")
* )
*/
class Wireq extends Json {

  protected $data;

  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->data=null;
  }


  protected function getSourceData($url) {
    if($this->data == null) {
      $this->data=[];
      do {
        $data = parent::getSourceData($url);
        if(count($data)>0) {
          array_push($this->data,$data);
        }
      }while(count($data)>0);
    }
    return $this->data;
  }

}
