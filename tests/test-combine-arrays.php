<?php
require_once("../classes/bootstrap.php");

class TestCombineArrays extends PHPUnit_Framework_TestCase {
  private $array1 = [
    "alan"  => [
      "monday"  => 1,
      "tuesday" => 1,
    ],
    "noah"  => [
      "monday"  => 3,
      "tuesday" => 4,
    ],
  ];
  private $array2 = [
    "alan"      => [
      "monday"    => 1,
      "tuesday"   => 1,
      "wednesday" => 1,
    ],
    "isabella"  => [
      "monday"    => 1,
      "tuesday"   => 1,
    ],
  ];
  private $arrayCombined = [
    "alan"      => [
      "monday"    => 2,
      "tuesday"   => 2,
      "wednesday" => 1,
    ],
    "noah"      => [
      "monday"  => 3,
      "tuesday" => 4,
    ],
    "isabella"  => [
      "monday"    => 1,
      "tuesday"   => 1,
    ],
  ];

  public function setUp() {
    $this->ca = new CombineArrays($this->array1, $this->array2);
  }

  public function testConstruct() {
    $expectedClass = "CombineArrays";
    $this->assertInstanceOf($expectedClass, $this->ca);
  }

  public function testCombineArrays() {
    $this->ca = new CombineArrays($this->array1, $this->array2);
    $this->assertInternalType("array", $this->ca->getResult());
  }
}

?>
