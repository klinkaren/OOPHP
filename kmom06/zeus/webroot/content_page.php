<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CPage
$page = new CPage($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = $page->getTitle();
$zeus['main'] = $page->getPage();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
