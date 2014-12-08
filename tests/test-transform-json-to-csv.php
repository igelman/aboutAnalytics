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
		$this->assertNotNull($array, "getJson returned" . print_r($array, TRUE) . PHP_EOL);
		$this->assertNull($junk);
	}
	
 	public function testSumKeyValues() {
 		$pages = json_decode($this->response, TRUE);
// 		echo print_r($pages, TRUE);
 		foreach($pages as $page) {
 			$result[$page["_id"]["url"]] = $page["pvs"];
 			$urls[] = $page["_id"]["url"];
 		}
// 		echo "testSumKeyValues " . print_r($result, TRUE) . PHP_EOL;
		$key = "pvs";
		$sums = $this->tjtc->sumKeyValues($key);
		echo "sumKeyValues returns sums: " . print_r($sums, TRUE) . PHP_EOL;
 		$this->assertEquals($result[$urls[0]], $sums[$urls[0]]);
 		$this->assertEquals($result[$urls[1]], $sums[$urls[1]]);
 	}
	
	
}

?>