<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);



// Create a user
$user = new CUser($db);



// Put everything in Zeus container.
$zeus['title'] = "Medlem";
$zeus['main'] = $user->getUserAsHtml();



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

