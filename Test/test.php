<?php
// Start by including the class definition
include('simple_class.php');
 
// Create a object of the class
$obj = new SimpleClass();
 
// Use the class
echo '<p>';
$obj->DisplayVar();
echo '</p>';
 
// Change the state of the object and use it again
$obj->var = 'Hello World (should now be 2) = ';
echo '<p>';
$obj->DisplayVar();
echo '</p>';

for ($i = 0; $i < 10; $i++){
	$obj->var = 'For loop value (should now be '.($i+3).') = ';
	echo '<p>';
	$obj->DisplayVar();
	echo '</p>';
}