<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



$zeus['stylesheets'][] = 'css/hem.css';
$zeus['stylesheets'][] = 'css/breadcrumb.css';
$zeus['stylesheets'][] = 'css/filmer.css';



// Create instance of CMovieSearch
$movieSearch = new CMovieSearch($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = "Filmer";

$zeus['main'] = <<<EDO
{$movieSearch->getOverview()}

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

