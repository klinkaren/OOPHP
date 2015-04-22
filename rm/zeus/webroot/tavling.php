<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');
$zeus['stylesheets'][] = 'css/breadcrumb.css';
$zeus['stylesheets'][] = 'css/dice.css';
$zeus['stylesheets'][] = 'css/diceGame.css';

CUser::authenticated() or die('Du måste vara inloggad för att tävla.');

// Create the object to display sourcecode
$game = new CDiceGame();



// Put everything in Zeus-container.
$zeus['title'] = "Tävling";
$zeus['main'] = $game->view();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
