<?php
require_once("../classes/bootstrap.php");

class TestAboutAnalytics extends PHPUnit_Framework_TestCase {
	private $page = "http://google.com";
	public function setUp() {
		$this->aa = new AboutAnalytics();
	}
	
	public function testConstruct() {
		$this->assertInstanceOf('AboutAnalytics', $this->aa);
	}
	
	public function testSetPage() {
		$page = $this->page;
		$this->aa->setPage($page);
		$this->assertTrue($this->aa->getPage() == $page);
	}
	
	public function testGetApiUrl() {
		$page = $this->page;
		$this->aa->setPage($page);
		$apiUrl = $this->aa->getApiUrl();
		$this->assertTrue((boolean)stripos($apiUrl, $page), "pageUrl should be in apiUrl. page: " . $page . PHP_EOL. "apiUrl: " . $apiUrl . PHP_EOL);
		$this->assertTrue((boolean)stripos($apiUrl, "api.dss.about.com:3000"), "api should be in apiUrl. page: http://api.dss.about.com:3000/" . PHP_EOL. "apiUrl: " . $apiUrl . PHP_EOL);
	}
	
	public function testCurlApi() {
		$page = $this->page;
		$this->aa->setPage($page);
		print_r( $this->aa->curlApi() . PHP_EOL, FALSE);
	}
	
	
}

?>