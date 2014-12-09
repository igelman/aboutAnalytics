<?php
require_once("../classes/bootstrap.php");

$saj = new SummarizeAnalyticsActivityJson();

$startDate  = new DateTime("2014-11-01");
$endDate    = new DateTime("2014-11-10");
$endDate    = $endDate->modify("+1 day"); // because otherwise we're stopping at 00:00 on $endDate

$interval   = new DateInterval("P1D");
$dateRange  = new DatePeriod($startDate, $interval, $endDate);
foreach ($dateRange as $date) {
  $begin  = $date->format("Y-m-d");
  $end    = $date->modify("+1 day")->format("Y-m-d");
  $daj = new DownloadAnalyticsActivityJson($begin, $end);
  $daj->requestAnalyticsJson();
  $analyticsJson = $daj->getAnalyticsJson();
  $saj->summarizeJsonToArray($analyticsJson);
}


$activityArray = $saj->getArray();
print_r($activityArray);

?>
