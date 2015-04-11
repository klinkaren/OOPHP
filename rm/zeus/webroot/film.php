<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



$zeus['stylesheets'][] = 'css/film.css';
$zeus['stylesheets'][] = 'css/breadcrumb.css';



// Create instance of CMovieSearch
$movie = new CMovie($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = $movie->getTitle();

$zeus['main'] = $movie->getPage();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

