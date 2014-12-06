<?php

class TransformJsonToCsv {

  public function __construct($json) {
    $this->json = $json;
  }

  public function getJson() {
    return $this->json;
  }
}

?>
