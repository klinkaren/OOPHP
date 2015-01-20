<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Me-sidan";
 
$zeus['main'] = <<<EOD
<h1>ME</h1>
<p>Detta är en exempelsida som visar hur Zeus ser ut och fungerar.</p>
EOD;

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);