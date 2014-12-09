<?php
require_once("../classes/bootstrap.php");

class TestSummarizeAnalyticsActivityJson extends PHPUnit_Framework_TestCase {

  public function setUp() {
    $this->activityJson = file_get_contents("documents_activities.json");
    $this->activityJson_1 = file_get_contents("documents_activities_20141101_20141102.json");
    $this->activityJson_2 = file_get_contents("documents_activities_20141102_20141103.json");
    $this->saj = new SummarizeAnalyticsActivityJson();
    // $this->saj = new SummarizeAnalyticsActivityJson($activityJson);
  }

  public function testConstruct() {
    $expectedClass = "SummarizeAnalyticsActivityJson";
    $this->assertInstanceOf($expectedClass, $this->saj);
  }

  public function testSummarizeJsonToArray() {
    $this->saj->summarizeJsonToArray($this->activityJson_1);
    $array = $this->saj->getArray();
    $this->assertInternalType("array", $array);
    //echo print_r($array, TRUE);
  }

  // public function testGetCsv() {
  //   $this->saj->summarizeJsonToArray($this->activityJson_1);
  //   $this->assertTrue((boolean) $this->saj->getCsv());
  //   echo print_r($this->saj->getCsv(), TRUE);
  // }

  public function testCombineMultipleJsonFiles() {
    $this->saj->summarizeJsonToArray($this->activityJson_1);
    $this->saj->summarizeJsonToArray($this->activityJson_2);
    echo print_r($this->saj->getCsv(), TRUE);
  }

}

?>
