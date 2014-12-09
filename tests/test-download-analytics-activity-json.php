<?php
require_once("../classes/bootstrap.php");

class TestDownloadAnalyticsActivityJson extends PHPUnit_Framework_TestCase {

  public function setUp() {
    $this->startDate = "2014-11-01";
    $this->endDate = "2014-11-02";
    $this->earlyEndDate = "2013-01-01";
    $this->daj = new DownloadAnalyticsActivityJson($this->startDate, $this->endDate);
  }

  public function testConstruct() {
    $expectedClass = "DownloadAnalyticsActivityJson";
    $this->assertInstanceOf($expectedClass, $this->daj);
  }

  public function testEndDateGreaterThanStartDate() {
    $this->badDaj = new DownloadAnalyticsActivityJson($this->startDate, $this->earlyEndDate);
    $this->assertEquals($this->earlyEndDate, $this->badDaj->getStartDate());
    $this->assertEquals($this->startDate, $this->badDaj->getEndDate());
    $this->assertEquals($this->endDate, $this->daj->getEndDate());
    $this->assertEquals($this->startDate, $this->daj->getStartDate());
  }

  public function testGetAnalyticsJson() {
    $this->daj->requestAnalyticsJson();
    $this->analyticsJson = $this->daj->getAnalyticsJson();
    print_r($this->analyticsJson);
  }
}

?>
