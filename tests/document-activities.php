<?php

	$activityJson = file_get_contents("documents_activities_short.json");
	$activityArray = json_decode($activityJson, TRUE);
	print_r($activityArray,FALSE);

?>