<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



$zeus['stylesheets'][] = 'css/om.css';

// Create instance of CContent
$info = new CPart($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = "Om oss";

$zeus['main'] = <<<EDO
{$info->getPart("Tjänsten")}
{$info->getPart("Företaget")}
EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

