<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "SimpleClass";
 
$zeus['main'] = <<<EOD
<h1>SimpleClass</h1>

// Create a object of the class
$obj = new CSimpleClass();
 
// Use the class
echo '<p>';
$obj->DisplayVar();
echo '</p>';
 
// Change the state of the object and use it again
$obj->var = 'Hello World (should now be 2) = ';
echo '<p>';
$obj->DisplayVar();
echo '</p>';


EOD;

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);


