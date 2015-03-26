<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CMovieSearch
$ms = new CMovieSearch($zeus['database']);



// Get input data
$title = isset($_GET['title']) ? htmlentities($_GET['title']) : null;
$year1 = isset($_GET['year1']) && !empty($_GET['year1']) ? htmlentities($_GET['year1']) : null;
$year2 = isset($_GET['year2']) && !empty($_GET['year2']) ? htmlentities($_GET['year2']) : null;
$genre = isset($_GET['genre']) && !empty($_GET['genre']) ? htmlentities($_GET['genre']) : null;

//$res = $ms->GetQueryResultForSearch($title, $year1, $year2, $genre); 



$htmltbl = $ht->GetHTMLTable($res, $hits, $page, $orderby, $order, $ms); 




// Put everything in Zeus container.
$zeus['title'] = "Sök film";

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
{$ms->getSearchForm($title, $year1, $year2)} 
{$htmltbl}
EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

