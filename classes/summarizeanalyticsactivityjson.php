<?php
class SummarizeAnalyticsActivityJson {

  public function __construct($json) {
    $this->json = $json;
  }

  private function summarizeJson() {
    $activityArray = json_decode($this->json);
    $this->activities = [];
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

  private function convertJsonToCsv() {
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

  public function getCsv() {
    $this->summarizeJson();
    $this->convertJsonToCsv();
    return $this->csv;
  }

}
?>
