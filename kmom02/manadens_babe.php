<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Add style for csource
$zeus['stylesheets'][] = 'css/calendar.css';
$zeus['stylesheets'][] = 'css/diceGame.css';

// Create the object to display sourcecode
$calendar = new CBabeCal();

$zeus['title'] = "Månadens Babe";
$zeus['main'] = $calendar->view();

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);