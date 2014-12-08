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

  public function getCsv() {
    $this->csv = "";
    $this->sumKeyValues("pvs");
    foreach($this->sums as $url=>$pvs) {
      $this->csv .= "$url, $pvs" . PHP_EOL;
    }
    return $this->csv;
  }

  public function sumKeyValues($key) {
    $pages = json_decode($this->json);
    $this->sums = [];
    foreach ($pages as $pageObject) {
      if (!array_key_exists ( $pageObject->_id->url , $this->sums )) {
        // not sure why I need to do this
        // but I guess you can't use += to initialize & assign
        $this->sums[$pageObject->_id->url] = 0;
      }
      $this->sums[$pageObject->_id->url] += $pageObject->pvs;
    }
   return $this->sums;
  }
}

?>
