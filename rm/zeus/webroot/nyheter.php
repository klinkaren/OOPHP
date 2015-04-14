<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');
$zeus['stylesheets'][] = 'css/blog.css';
$zeus['stylesheets'][] = 'css/breadcrumb.css';
$zeus['stylesheets'][] = 'css/nyheter.css';



// Create instance of CBlog
$blog = new CBlog($zeus['database']);



// Put everything in Zeus container.
$zeus['title'] = "Nyheter";
$zeus['main'] = $blog->getPost();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);
