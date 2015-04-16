<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CContent
$content = new CContent($zeus['database']);
$movie = new CMovieSearch($zeus['database']);



// Checks if user is logged in and of type admin.
CUser::authenticatedAsAdmin() or die('Check: You must be logged in as admin to gain access to this page.');



// Put everything in Zeus container.
$zeus['title'] = "Administrering";
$zeus['main'] = $content->admin("post");


// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

