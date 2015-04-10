<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CContent
$content = new CContent($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = "Allt innehåll";

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
{$content->viewAll()}

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

