<?php
require_once("../classes/bootstrap.php");

$saj = new SummarizeAnalyticsActivityJson();

$startDate  = new DateTime("2014-11-01");
$endDate    = new DateTime("2014-11-10");
$endDate    = $endDate->modify("+1 day"); // because otherwise we're stopping at 00:00 on $endDate
echo "Getting activity data from " . $startDate->format("Y-m-d") . " to " . $endDate->format("Y-m-d") . PHP_EOL;

$interval   = new DateInterval("P1D");
$dateRange  = new DatePeriod($startDate, $interval, $endDate);
foreach ($dateRange as $date) {
  echo PHP_EOL;
  $begin  = $date->format("Y-m-d");
  $end    = $date->modify("+1 day")->format("Y-m-d");
  $daj = new DownloadAnalyticsActivityJson($begin, $end);
  echo "Start Date: " . $daj->getStartDate() . PHP_EOL;
  echo "End Date: " . $daj->getEndDate() . PHP_EOL;
  $daj->requestAnalyticsJson();
  echo "API request: " . $daj->getUrl() . PHP_EOL;
  $analyticsJson = $daj->getAnalyticsJson();
  echo "responseSize: " . $daj->getResponseSize() . PHP_EOL;
  $saj->summarizeJsonToArray($analyticsJson);
}


$activityArray = $saj->getArray();
print_r($activityArray);
print_r($saj->getCsv());

?>
