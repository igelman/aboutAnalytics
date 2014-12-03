<?php
class Autoloader {
	public static function loader($class) {
		$filename = strtolower($class) . '.php';
		$file = $filename;
		if (!file_exists($file)) {
			return false;
		}
		include $file;
	}
	
	
}

?>