<?php
$dataFile = "urls.csv";
$messages = "";
$messagesSeparator = PHP_EOL . "----------" . PHP_EOL;
$logFile = "output.log";

require_once("../classes/bootstrap.php");

$urlsArray = [];
$handle = fopen($dataFile, "r");
$i = 0;
if ($handle) {
	while (($line = fgets($handle)) !== false && $i < 10000) {
		$urlsArray[] = $line;
		$i++;
	}
} else {/* error opening the file. */} 
fclose($handle);

$messages .= "$messagesSeparator urlsArray: " . PHP_EOL . print_r($urlsArray, TRUE);

$spj = new SummarizeAnalyticsPageviewsJson();

/*
$urlsCsv = file_get_contents("legacy-urls.csv");
$urlsArray = explode("\n", $urlsCsv);
//echo "urlsArray: " . print_r($urlsArray, TRUE) . PHP_EOL;
*/


$maxArrayLength = 3;
$preserve_keys = false;
$urlsArrays = array_chunk($urlsArray , $maxArrayLength, $preserve_keys);
$messages .= "$messagesSeparator urlsArrays: " . PHP_EOL . print_r($urlsArrays, TRUE);

foreach ($urlsArrays as $urlsArray) {
	$dpj = new DownloadAnalyticsPageviewsJson($urlsArray);
	$messages .= "$messagesSeparator API: " . PHP_EOL . $dpj->getUrl();

	$dpj->requestAnalyticsJson();
	$analyticsJson = $dpj->getAnalyticsJson();
	$messages .= "$messagesSeparator analyticsJson: " . PHP_EOL . print_r($analyticsJson, TRUE);
	$spj->summarizeJsonToArray($analyticsJson);
	$messages .= "$messagesSeparator temp pageviewsArray: " . PHP_EOL . print_r($spj->getArray(), TRUE);
}

$pageviewsArray = $spj->getArray();
$messages .= "$messagesSeparator pageviewsArray: " . PHP_EOL . print_r($pageviewsArray, TRUE);

file_put_contents($logFile, $messages);
?>