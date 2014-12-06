<?php
require_once("../classes/bootstrap.php");

class TestArrayUtilities extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		$this->au = new ArrayUtilities();
	}
	
	public function testConstruct() {
		$this->assertInstanceOf('ArrayUtilities', $this->au);
	}
	
	public function testSumKeyValues() {
		$this->assertTrue();
	}
	
	
}

?>