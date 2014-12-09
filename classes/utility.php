<?php
require_once("../classes/bootstrap.php");

$csv = "";

$startDate = "2014-11-01";
$endDate = "2014-11-02";

$daj = new DownloadAnalyticsActivityJson($this->startDate, $this->endDate);
$daj->requestAnalyticsJson();
$analyticsJson = $daj->getAnalyticsJson();

$saj = new SummarizeAnalyticsActivityJson($analyticsJson);
$activityArray = $saj->getArray();

?>
