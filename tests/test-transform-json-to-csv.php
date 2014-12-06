<?php
require_once("../classes/bootstrap.php");

class TestTransformJsonToCsv extends PHPUnit_Framework_TestCase {
	//$this->response = file_get_contents("sample-response.json");
	//$json_a=json_decode($response,true);

	public function setUp() {
		$this->notJson = "just some junk";
		$this->response = file_get_contents("sample-response.json");
		$this->tjtc = new TransformJsonToCsv($this->response);
		$this->tjtcJunk = new TransformJsonToCsv($this->notJson);
	}
	
	public function testConstruct() {
		$this->assertInstanceOf('TransformJsonToCsv', $this->tjtc);
	}
	
	public function testGetJsonReturnsJson() {
		$array = json_decode($this->tjtc->getJson());
		$junk = json_decode($this->tjtcJunk->getJson());
		$this->assertNotNull($array);
		$this->assertNull($junk);
	}
	
// 	public function testSumKeyValues() {
// 		$this->assertTrue();
// 	}
	
	
}

?>