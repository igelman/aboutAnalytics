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
		$expected = $this->expectedResults();
		$key = "pvs";
		$sums = $this->tjtc->sumKeyValues($key);
		echo "sumKeyValues: " . print_r($sums,TRUE) . PHP_EOL;		
		foreach($expected as $url=>$expectedPvs) {
			$this->assertEquals($expectedPvs, $sums[$url]);
		}
 	}
 	
 	public function testGetCsv() {
 		$expectedCsv = "";
 		$expected = $this->expectedResults();
 		foreach($expected as $url=>$expectedPvs) {
 			$expectedCsv .= "$url, $expectedPvs" . PHP_EOL;
 		}
 		echo "expectedCsv: " . PHP_EOL . $expectedCsv . PHP_EOL;
 		$this->assertEquals($expectedCsv, $this->tjtc->getCsv());
 	}
	
	private function expectedResults() {
		$pages = json_decode($this->response, TRUE);
 		foreach($pages as $page) {
 			$expected[$page["_id"]["url"]] = $page["pvs"];
 		}
		return $expected;	
	}
	
}

?>