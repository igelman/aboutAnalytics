<?php

class AboutAnalytics {

	public function setPage($pageUrl) {
		$this->pageUrl = $pageUrl;
	}
	
	public function getPage() {
		return $this->pageUrl;
	}
	
	public function getApiUrl() {
		$this->apiUrl();
		return $this->apiUrl;
	}
	
	function apiUrl() {
		$service = "http://api.dss.about.com:3000/";
		$api = "webservers/v1/url_monthly";
		$query = "%7B%22on%22%3A+%222014-10%22%2C%22url%22%3A%22" . $this->pageUrl . "%22%7D&options=%7B%22limit%22%3A10%7D";
		
		$this->apiUrl = $service . $api . "?query=" . $query;
	}
	
	function curlApi() {
		$this->apiUrl();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		return curl_close($ch);
	}
}

// $inst = new AboutAnalytics(0);
// $inst->setPage("4wheeldrive.about.com/cs/jeepreviews/a/aa121102a.htm");
// echo $inst->getPage() . PHP_EOL;
// echo $inst->getApiUrl() . PHP_EOL;

?>