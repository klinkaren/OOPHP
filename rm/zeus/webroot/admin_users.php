<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');

$zeus['stylesheets'][] = 'css/admin.css';


// Checks if user is logged in and of type admin.
CUser::authenticatedAsAdmin() or die('Check: You must be logged in as admin to gain access to this page.');



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($zeus['database']);
// Create a user object
$users = new CUsers($db);






// Put everything in Zeus container.
$zeus['title'] = "Administrering";
$zeus['main'] = $users->getHtml(true);



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

