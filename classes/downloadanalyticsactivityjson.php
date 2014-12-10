<?php

class DownloadAnalyticsActivityJson {
  public function __construct($startDate, $endDate) {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->checkDates();
    $this->apiUrl = "http://api.dss.about.com:3000/about_com/v1/documents_activities?query=%7B%22updated.at%22%3A+%7B+%22%24gte%22%3A+%22" . $this->startDate . "%22%2C+%22%24lte%22%3A+%22" . $this->endDate . "%22+%7D+%7D";
  }

  public function getStartDate() {
    return $this->startDate;
  }

  public function getEndDate() {
    return $this->endDate;
  }

  public function getUrl() {
    return $this->apiUrl;
  }


/*
Refactor this to take $apiUrl as a parameter
(which is what the subclass needs to do)
instead of using a instance property.	
*/
  public function requestAnalyticsJson() {
    $this->analyticsJson = file_get_contents($this->apiUrl);
    $this->responseSize = strlen($this->analyticsJson);
  }

  public function getAnalyticsJson() {
    return $this->analyticsJson;
  }

  public function getResponseSize() {
    return $this->responseSize;
  }

  private function checkDates(){
    $startDateInstance = new DateTime($this->startDate);
    $endDateInstance = new DateTime($this->endDate);
    $this->startDate = $startDateInstance->format("Y-m-d");
    $this->endDate = $endDateInstance->format("Y-m-d");
    if ( $startDateInstance > $endDateInstance ) {
      $this->startDate = $endDateInstance->format("Y-m-d");
      $this->endDate = $startDateInstance->format("Y-m-d");
    }
  }
}

class DownloadAnalyticsPageviewsJson extends DownloadAnalyticsActivityJson {
  public function __construct($urlsArray) {
    $this->urlsArray = $urlsArray;
/*
    $this->urls = "";
    foreach ($urlsArray as $url) {
      $this->urls .= "\"$url\",";
    }
    $this->urls = rtrim($this->urls, ","); // strip that trailing comma
    $this->apiUrl = 'http://api.dss.about.com:3000/webservers/v1/url_daily/aggregate?pipeline=[{%22$match%22:{%22on%22:{%22$regex%22:%22^2014-10%22},%22url%22:{%22$in%22:[' . $this->urls . ']}}},{%22$group%22:%20{%22_id%22:%20{%22url%22:%20%22$url%22},%20%22pvs%22:%20{%22$sum%22:%20%22$pvs.total%22},%20%22pvsUS%22:%20{%22$sum%22:%20%22$pvs.US%22}}}]';
*/
  }
  
  public function splitArray($maxArrayLength) {
  	$this->maxArrayLength = $maxArrayLength;
  	$preserve_keys = false;
  	$this->urlsArrays = array_chunk($this->urlsArray , $this->maxArrayLength, $preserve_keys);
  	return $this->urlsArrays;
  }
  
/*
	Refactor the parent class's method 
	to use $apiUrl parameter instead of property.
	Then remove this function from the subclass.
*/
  public function requestAnalyticsJson($apiUrl) {
    $this->analyticsJson = file_get_contents($apiUrl);
    $this->responseSize = strlen($this->analyticsJson); 
  }
  
  public function composeApiUrl($urlsArray) {
	$urls = "";
	foreach ($urlsArray as $url) {
		$urls .= "\"$url\",";
	}
	$urls = rtrim($urls, ","); // strip the trailing comma
	
	return 'http://api.dss.about.com:3000/webservers/v1/url_daily/aggregate?pipeline=[{%22$match%22:{%22on%22:{%22$regex%22:%22^2014-10%22},%22url%22:{%22$in%22:[' . $urls . ']}}},{%22$group%22:%20{%22_id%22:%20{%22url%22:%20%22$url%22},%20%22pvs%22:%20{%22$sum%22:%20%22$pvs.total%22},%20%22pvsUS%22:%20{%22$sum%22:%20%22$pvs.US%22}}}]';
  }
}

/*
http://api.dss.about.com:3000/webservers/v1/url_daily/aggregate?pipeline=[{"$match":{"on":{"$regex":"^2014-10"},"url":{"$in":["jobsearch.about.com/od/jobsearchglossary/g/coverletter.htm","jobsearch.about.com/od/coverlettersamples/a/coverlettsample.htm"]}}},{"$group": {"_id": {"url": "$url"}, "pvs": {"$sum": "$pvs.total"}, "pvsUS": {"$sum": "$pvs.US"}}}]
*/
/*
[
{
_id: {
url: "jobsearch.about.com/od/jobsearchglossary/g/coverletter.htm"
},
pvs: 60738,
pvsUS: 28757
},
{
_id: {
url: "jobsearch.about.com/od/coverlettersamples/a/coverlettsample.htm"
},
pvs: 740348,
pvsUS: 365222
}
]
*/

?>
//http://api.dss.about.com:3000/webservers/v1/url_daily/aggregate?pipeline=[{'$match':{'on':{'$regex':'^2014-10'},'url':{'$in':["jobsearch.about.com/od/jobsearchglossary/g/coverletter.htm","jobsearch.about.com/od/coverlettersamples/a/coverlettsample.htm"]}}},{"$group": {"_id": {"url": "$url"}, "pvs": {"$sum": "$pvs.total"}, "pvsUS": {"$sum": "$pvs.US"}}}]
