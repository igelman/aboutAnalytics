<?php
// http://www.czettner.com/blog/13/11/01/spl-autoloader-tutorial-juniors

require_once("aboutanalytics.php");



class Autoloader {
	public static function loader($class) {
		$filename = strtolower($class) . '.php';
		$file = "classes/" . $filename;
		if (!file_exists($file)) {
// 			echo "File '$file' does not exist" . PHP_EOL;
// 			echo "__FILE__ is " . __FILE__ . PHP_EOL;
// 			echo "__DIR__ is " . __DIR__ . PHP_EOL;
			return false;
		}
		include $file;
	}
	
	
}

?>