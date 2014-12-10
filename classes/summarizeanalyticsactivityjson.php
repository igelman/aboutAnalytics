<?php
class SummarizeAnalyticsActivityJson {

  public function __construct() {
    //$this->json = $json;
    $this->activities = [];
    //$this->summarizeJsonToArray();
    //$this->convertJsonToCsv();

  }

  public function summarizeJsonToArray($json) {
    $activityArray = json_decode($json);
    foreach($activityArray as $activity) {
      $host = $activity->host;
      $author = $activity->updated->by;
      $action = $activity->action;
      $template = $activity->template->acmeName;

      if (!array_key_exists ( $host , $this->activities )) {
        $this->activities[$host] = [];
      }
      if (!array_key_exists ( $author , $this->activities[$host] )) {
        $this->activities[$host][$author] = [];
      }
      if (!array_key_exists ( $action , $this->activities[$host][$author] )) {
        $this->activities[$host][$author][$action] = [];
      }
      if (!array_key_exists ( $template , $this->activities[$host][$author][$action] )) {
        $this->activities[$host][$author][$action][$template] = 0;
      }
      $this->activities[$host][$author][$action][$template]++;

    }
  }

  private function convertArrayToCsv() {
    $this->csv = "";
    foreach($this->activities as $host => $authors) {
      foreach($authors as $author => $actions) {
        foreach($actions as $action => $templates) {
          foreach($templates as $template => $count) {
            $this->csv .= "$host, $author, $action, $template, $count\n";
          }
        }
      }
    }
  }

  public function getArray() {
    return $this->activities;
  }

  public function getCsv() {
    $this->convertArrayToCsv();
    return $this->csv;
  }
}

class SummarizeAnalyticsPageviewsJson extends SummarizeAnalyticsActivityJson {
	
	public function __construct() {
		$this->pageviews = [];
	}
	
	public function summarizeJsonToArray($json) {
    	$pagesArray = json_decode($json);
	    foreach($pagesArray as $page) {
	      $url = $page->_id->url;
	      $pvs = (integer) $page->pvs;
	      if (!array_key_exists ( $url , $this->pageviews )) {
	        $this->pageviews[$url] = $pvs;
	      }
	    }
//	    echo "pageviews: " . print_r($this->pageviews, TRUE) . PHP_EOL;
	}
	
	public function getArray() {
		return $this->pageviews;
	}
	
	public function getCsv() {
		$this->convertArrayToCsv();
		return $this->csv;
	}

	
	public function convertArrayToCsv() {
		$this->csv = "";
		foreach ($this->pageviews as $url=>$pvs) {
			$this->csv .= "$url, $pvs\n";
		}
	}
}

/*

[
{"_id":
	{"url":"southernfood.about.com/od/sidedishcasseroles/r/bl90911u.htm"},
	"pvs":27649,
	"pvsUS":19299
}
]
*/


?>
