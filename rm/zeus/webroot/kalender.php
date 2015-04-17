<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



$zeus['stylesheets'][] = 'css/kalender.css';


// Create instance of CMovieSearch
$cal = new CCal();



// Put everything in Zeus container.
$zeus['title'] = "Kalender";

$zeus['main'] = $cal->view();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

