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

  public function testGetUrl() {
    $expectedUrl = "http://api.dss.about.com:3000/about_com/v1/documents_activities?query=%7B%22updated.at%22%3A+%7B+%22%24gte%22%3A+%22" . $this->startDate . "%22%2C+%22%24lte%22%3A+%22" . $this->endDate . "%22+%7D+%7D";
    $this->assertEquals($expectedUrl, $this->daj->getUrl());
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
    echo "responseSize: " . $this->daj->getResponseSize() . PHP_EOL;
    $this->analyticsJson = $this->daj->getAnalyticsJson();
    $this->assertNotNull(json_decode($this->analyticsJson));
    //print_r($this->analyticsJson);
  }
}

?>
