<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CBlog
$blog = new CBlog($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = "Blogg";
$zeus['main'] = $blog->getPost();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
