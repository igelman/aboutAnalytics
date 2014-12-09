<?php
require_once("../classes/bootstrap.php");

class TestSummarizeAnalyticsActivityJson extends PHPUnit_Framework_TestCase {

  public function setUp() {
    $activityJson = file_get_contents("documents_activities.json");
    $this->saj = new SummarizeAnalyticsActivityJson($activityJson);
  }

  public function testConstruct() {
    $expectedClass = "SummarizeAnalyticsActivityJson";
    $this->assertInstanceOf($expectedClass, $this->saj);
  }

  public function testGetCsv() {
    $this->assertTrue((boolean) $this->saj->getCsv());
    //echo print_r($this->saj->getCsv(), TRUE);
  }

  public function testGetArray() {
    $array = $this->saj->getArray();
    $this->assertInternalType("array", $array);
    print_r($array);
  }

}

?>
