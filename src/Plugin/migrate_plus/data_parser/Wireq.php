<?php

namespace Drupal\dpa_digital_wires\Plugin\migrate_plus\data_parser;

use Drupal\migrate_plus\DataParserPluginBase;
use Drupal\migrate_plus\Plugin\migrate_plus\data_parser\Json;

/**
* Provides a 'Wireq' data parser plugin.
*
* @DataParser(
*  id = "wireq"
*  title = @Translation("wireq")
* )
*/
class Wireq extends Json {

  protected function getSourceData($url) {
    $collection=[];
    do {
      $data= parent::getSourceData($url);
      $collection=array_push($data,$collection);
    }while(count($data)>0);
    return $collection;
  }

}
