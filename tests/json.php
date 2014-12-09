<?php
/*
*
*/

//2346

  $activityJson = file_get_contents("documents_activities.json");
  $url = "http://api.dss.about.com:3000/about_com/v1/documents_activities?query=%7B%22updated.at%22%3A+%7B+%22%24gte%22%3A+%222014-11-01%22%2C+%22%24lte%22%3A+%222014-11-02%22+%7D+%7D";
  //$activityJson = file_get_contents($url);
  $activityArray = json_decode($activityJson);
  // print_r($activityArray);

  $activities = [];
  $crossSum = 0;
  foreach($activityArray as $activity) {

    $host = $activity->host;
    $author = $activity->updated->by;
    $action = $activity->action;
    $template = $activity->template->acmeName;


    if (!array_key_exists ( $host , $activities )) {
      $activities[$host] = [];
    }
    if (!array_key_exists ( $author , $activities[$host] )) {
      $activities[$host][$author] = [];
    }
    if (!array_key_exists ( $action , $activities[$host][$author] )) {
      $activities[$host][$author][$action] = [];
    }
    if (!array_key_exists ( $template , $activities[$host][$author][$action] )) {
      $activities[$host][$author][$action][$template] = 0;
    }
    $activities[$host][$author][$action][$template]++;

    $crossSum++;

  }

  $csv = "";

  foreach($activities as $host => $authors) {
    foreach($authors as $author => $actions) {
    	foreach($actions as $action => $templates) {
    		foreach($templates as $template => $count) {
    			$csv .= "$host, $author, $action, $template, $count\n";
    		}
    	}
    }
  }
  echo $csv;
/*
echo "activities: " . print_r($activities,TRUE) . PHP_EOL;
(
    [wills.about.com] => Array
        (
            [40412] => Array
                (
                    [update] => Array
                        (
                            [category] => 66
                            [list] => 1
                            [flexiblearticle ] => 2
                        )

                    [create] => Array
                        (
                            [category] => 1
                            [flexiblearticle ] => 1
                        )

                )

        )
)
*/

?>
