<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Create text filter
$filter = new CTextFilter();



// Get parameters 
$url     = isset($_GET['url']) ? $_GET['url'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;



// Get content
$sql = "
SELECT *
FROM Content
WHERE
  TYPE = 'page' AND
  url = ? AND
  published <= NOW();
";
$res = $db->ExecuteSelectQueryAndFetchAll($sql, array($url));

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll.');
}



// Sanitize content before using it
$title  = htmlentities($c->title, null, 'UTF-8');
$data   = $filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);



// Put everything in Zeus container.
$zeus['title'] = $title;

// Prepare editLink
$editLink = $acronym ? "<a href='edit.php?id={$c->id}'>Uppdatera sidan</a>" : null;

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
{$data}

{$editLink}

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
