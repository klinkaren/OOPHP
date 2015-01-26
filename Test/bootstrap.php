<?php
/**
 * Autoloader for classes.
 */
function myAutoloader($class) {
	$path = "{$class}.php";
	if(is_file($path)) {
		include($path);
	}
}
spl_autoload_register('myAutoloader');