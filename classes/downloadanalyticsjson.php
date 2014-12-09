<?php

class DownloadAnalyticsJson {
  public function __construct($startDate, $endDate) {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->checkDates();
    $this->url = "http://api.dss.about.com:3000/about_com/v1/documents_activities?query=%7B%22updated.at%22%3A+%7B+%22%24gte%22%3A+%22" . $startDate . "%22%2C+%22%24lte%22%3A+%22" . $endDate . "%22+%7D+%7D";
  }

  public function getStartDate() {
    return $this->startDate;
  }

  public function getEndDate() {
    return $this->endDate;
  }

  public function requestAnalyticsJson() {
    $this->analyticsJson = file_get_contents($this->url);
  }

  public function getAnalyticsJson() {
    return $this->analyticsJson;
  }

  private function checkDates(){
    $startDateInstance = new DateTime($this->startDate);
    $endDateInstance = new DateTime($this->endDate);
    $this->startDate = $startDateInstance->format("Y-m-d");
    $this->endDate = $endDateInstance->format("Y-m-d");
    if ( $startDateInstance > $endDateInstance ) {
      $this->startDate = $endDateInstance->format("Y-m-d");
      $this->endDate = $startDateInstance->format("Y-m-d");
    }
  }
}
?>
