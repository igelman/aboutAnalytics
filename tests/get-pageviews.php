<?php
	
	// $handle = fopen("inputfile.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
    }
} else {
    // error opening the file.
} 
fclose($handle);
require_once("../classes/bootstrap.php");

$spj = new SummarizeAnalyticsPageviewsJson();

$urlsCsv = file_get_contents("legacy-urls.csv");
$urlsArray = explode("\n", $urlsCsv);
//echo "urlsArray: " . print_r($urlsArray, TRUE) . PHP_EOL;

$maxArrayLength = 5000;
$preserve_keys = false;
$urlsArrays = array_chunk($urlsArray , $maxArrayLength, $preserve_keys);
// echo "urlsArrays: " . print_r($urlsArrays, TRUE);

//print_r($urlsArrays);

foreach ($urlsArrays as $urlsArray) {
	$dpj = new DownloadAnalyticsPageviewsJson($urlsArray);
// 	echo "API: " . $dpj->getUrl() . PHP_EOL;
	$dpj->requestAnalyticsJson();
	$analyticsJson = $dpj->getAnalyticsJson();
	$spj->summarizeJsonToArray($analyticsJson);
}

$pageviewsArray = $spj->getArray();
print_r($pageviewsArray);
?>