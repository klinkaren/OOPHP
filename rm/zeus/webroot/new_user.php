<?php
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php');



// Create instance of CContent
$user = new CUser($zeus['database']);

// Log out
if(isset($_POST['logout'])) {
    $user->logout();
    header("Location:new_user.php");
} 

// Put everything in Zeus container.
$zeus['title'] = "Skapa medlem";

$zeus['main'] = <<<EDO
<h1>{$zeus['title']}</h1>
{$user->signup()}

EDO;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

