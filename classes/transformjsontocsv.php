<?php

class TransformJsonToCsv {

  public function __construct($json) {
    $this->json = utf8_encode($json);
    if (!json_decode($this->json)) {
      echo "TransformJsonToCSV could not decode the json. " . json_last_error_msg() . PHP_EOL . $this->json . PHP_EOL . PHP_EOL;
    }
  }

  public function getJson() {
    return $this->json;
  }

  public function sumKeyValues($key) {
    $pages = json_decode($this->json);
    $sums = [];
    // foreach ($pages as $pageObject) {
    //   // not sure why I need to do this
    //   // but if I don't, the next forEach complains
    //   $sums[$pageObject->_id->url] = 0;
    // }
    foreach ($pages as $pageObject) {
      if (!array_key_exists ( $pageObject->_id->url , $sums )) {
        $sums[$pageObject->_id->url] = 0;
      }
      $sums[$pageObject->_id->url] += $pageObject->pvs;
    }
   return $sums;
  }
}

?>
