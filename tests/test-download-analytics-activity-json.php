<?php
require_once("../classes/bootstrap.php");

class TestDownloadAnalyticsActivityJson extends PHPUnit_Framework_TestCase {

    private $urlsArray = [
      "compnetworking.about.com/od/routers/g/192_168_1_1_def.htm",
      "freebies.about.com/od/freefood/tp/veterans-day-free-meals.htm",
      "jobsearch.about.com/od/interviewquestionsanswers/a/interviewquest.htm",
      "homecooking.about.com/library/archive/blturkey7.htm",
      "jobsearch.about.com/od/resignationletters/a/resignationlet.htm",
      "jobsearch.about.com/od/interviewquestionsanswers/a/top-10-interview-questions.htm",
      "jobsearch.about.com/od/sampleresignationletters/a/resignsamples.htm",
      "freebies.about.com/od/freefood/tp/veterans-day-free-meals.01.htm",
      "southernfood.about.com/od/sidedishcasseroles/r/bl90911u.htm",
      "netforbeginners.about.com/od/peersharing/a/torrent_search.htm",
      "http://jobsearch.about.com/od/jobsearchglossary/g/coverletter.htm",
      "http://jobsearch.about.com/od/coverlettersamples/a/coverlettsample.htm",
    ];


    private $expectedApiUrl = 'http://api.dss.about.com:3000/webservers/v1/url_daily/aggregate?pipeline=[{%22$match%22:{%22on%22:{%22$regex%22:%22^2014-10%22},%22url%22:{%22$in%22:["compnetworking.about.com/od/routers/g/192_168_1_1_def.htm","freebies.about.com/od/freefood/tp/veterans-day-free-meals.htm","jobsearch.about.com/od/interviewquestionsanswers/a/interviewquest.htm","homecooking.about.com/library/archive/blturkey7.htm","jobsearch.about.com/od/resignationletters/a/resignationlet.htm","jobsearch.about.com/od/interviewquestionsanswers/a/top-10-interview-questions.htm","jobsearch.about.com/od/sampleresignationletters/a/resignsamples.htm","freebies.about.com/od/freefood/tp/veterans-day-free-meals.01.htm","southernfood.about.com/od/sidedishcasseroles/r/bl90911u.htm","netforbeginners.about.com/od/peersharing/a/torrent_search.htm","http://jobsearch.about.com/od/jobsearchglossary/g/coverletter.htm","http://jobsearch.about.com/od/coverlettersamples/a/coverlettsample.htm"]}}},{%22$group%22:%20{%22_id%22:%20{%22url%22:%20%22$url%22},%20%22pvs%22:%20{%22$sum%22:%20%22$pvs.total%22},%20%22pvsUS%22:%20{%22$sum%22:%20%22$pvs.US%22}}}]';


  public function setUp() {
    $this->startDate = "2014-11-01";
    $this->endDate = "2014-11-02";
    $this->earlyEndDate = "2013-01-01";
    $this->daj = new DownloadAnalyticsActivityJson($this->startDate, $this->endDate);

    $this->dpj = new DownloadAnalyticsPageviewsJson($this->urlsArray);
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
/*
    $this->daj->requestAnalyticsJson();
    echo "daj responseSize: " . $this->daj->getResponseSize() . PHP_EOL;
    $this->analyticsJson = $this->daj->getAnalyticsJson();
    $this->assertNotNull(json_decode($this->analyticsJson));
*/

    $this->dpj->requestAnalyticsJson();
    echo "dpj responseSize: " . $this->dpj->getResponseSize() . PHP_EOL;
    $this->dpjAnalyticsJson = $this->dpj->getAnalyticsJson();
    $this->assertNotNull(json_decode($this->dpjAnalyticsJson));
    print_r($this->dpjAnalyticsJson);
  }

  public function testDapjConstruct() {
    $expectedClass = "DownloadAnalyticsPageviewsJson";
    $this->assertInstanceOf($expectedClass, $this->dpj);
    $this->assertEquals($this->expectedApiUrl, $this->dpj->getUrl());
    echo "testDapjConstruct apiUrl: " . $this->dpj->getUrl() . PHP_EOL;
  }
  
/*
  public function testSplitArray() {
   	$maxLength = 5;
   	$this->urlsArrays = $this->dpj->splitArray($maxLength);
   	echo "splitArray: " . PHP_EOL . print_r($this->urlsArrays, TRUE) . PHP_EOL;
	foreach ($this->urlsArrays as $urlsArray) {
		$this->assertTrue(count($urlsArray) <= $maxLength);
	}
  }
*/
  
/*
  public function testComposeApiUrl() {
	$urlsArray = $this->urlsArray;
	$this->assertEquals($this->expectedApiUrl, $this->dpj->composeApiUrl($urlsArray));
  }
*/

//   public function testConvertArrayToString() {
//     $expectedString = 
//   }
}

?>
