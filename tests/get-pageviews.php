<?php
require_once("../classes/bootstrap.php");

$spj = new SummarizeAnalyticsPageviewsJson();

$urlsCsv = file_get_contents("urls.csv");
$urlsArray = explode(",\n", $urlsCsv);

$maxArrayLength = 10000;
$preserve_keys = false;
$urlsArrays = array_chunk($urlsArray , $maxArrayLength, $preserve_keys);


print_r($urlsArrays);

foreach ($urlsArrays as $urlsArray) {
	$dpj = new DownloadAnalyticsPageviewsJson($urlsArray);
	$dpj->requestAnalyticsJson();
	$analyticsJson = $dpj->getAnalyticsJson();
	$spj->summarizeJsonToArray($analyticsJson);
}

$pageviewsArray = $spj->getArray();
print_r($pageviewsArray);
?>