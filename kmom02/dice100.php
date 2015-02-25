<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 

// Add style for csource
$zeus['stylesheets'][] = 'css/dice.css';
$zeus['stylesheets'][] = 'css/diceGame.css';

// Create the object to display sourcecode
$game = new CDiceGame();

$zeus['title'] = "Dice 100";
$zeus['main'] = $game->view();

// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);